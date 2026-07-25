#!/usr/bin/env python3
"""Generate the BlogPart* Laravel seeders from the WordPress WXR export.

Usage (from anywhere):
    python3 database/seeders/generator/gen_blog_seeders.py

Inputs, all living next to this script:
  - andrian064.wordpress.com.2026-07-13.000.xml  (the WordPress export)
  - full_url_map.json  (image URL -> local filename in public/assets/blog,
    for renamed variants and third-party images that were downloaded locally)

Output: database/seeders/BlogPart1..N.php plus Blog.php (the orchestrator).
Only published posts are exported. Featured image comes from _thumbnail_id,
falling back to the first content image we host locally.
"""
import xml.etree.ElementTree as ET
import os, re, json, html

HERE = os.path.dirname(os.path.abspath(__file__))
ROOT = os.path.abspath(os.path.join(HERE, '..', '..', '..'))
XML = os.path.join(HERE, 'andrian064.wordpress.com.2026-07-13.000.xml')
ASSET_DIR = os.path.join(ROOT, 'public', 'assets', 'blog')
OUT_DIR = os.path.join(ROOT, 'database', 'seeders')
PARTS = 10
URL_MAP = json.load(open(os.path.join(HERE, 'full_url_map.json')))

# Images whose sources are permanently gone (dead hosts, nothing archived).
# Their <img> tags are stripped from content instead of shipping broken links.
DEAD_URLS = [
    'https://hydeliving.s3.ap-southeast-3.amazonaws.com/uploads/1669030033005.webp',
    'https://sobatbangun.com/wp-content/uploads/2025/09/PORTOFOLIO-AVARA-KARYA-UTAMA-MITRA-KONTRAKTOR-SOBAT-BANGUN_85.jpg',
    'https://www.desain.id/blog/storage/uploads/contents/539/desain-rumah-ukuran-6x8-contoh.png',
]

NS = {
    'wp': 'http://wordpress.org/export/1.2/',
    'content': 'http://purl.org/rss/1.0/modules/content/',
    'dc': 'http://purl.org/dc/elements/1.1/',
}

assets = set(os.listdir(ASSET_DIR))
root = ET.parse(XML).getroot()

attachments = {}
raw_posts = []
for it in root.findall('.//item'):
    ptype = it.findtext('wp:post_type', default='', namespaces=NS)
    status = it.findtext('wp:status', default='', namespaces=NS)
    if ptype == 'attachment':
        pid = it.findtext('wp:post_id', default='', namespaces=NS)
        attachments[pid] = it.findtext('wp:attachment_url', default='', namespaces=NS)
    elif ptype == 'post' and status == 'publish':
        raw_posts.append(it)


def local_name(url):
    """Basename of a WP upload URL, if we have that file locally."""
    base = os.path.basename(html.unescape(url).split('?')[0])
    return base if base in assets else None


def resolve_url(url):
    """Local asset filename for an image URL, or None."""
    plain = html.unescape(url)
    if plain in URL_MAP:
        return URL_MAP[plain]
    return local_name(url)


def featured_image(item, localized_body):
    """Featured image: _thumbnail_id first, else the first localized content <img>."""
    for meta in item.findall('wp:postmeta', NS):
        if meta.findtext('wp:meta_key', default='', namespaces=NS) == '_thumbnail_id':
            tid = meta.findtext('wp:meta_value', default='', namespaces=NS)
            if tid in attachments:
                name = resolve_url(attachments[tid])
                if name:
                    return name
    for src in re.findall(r'<img[^>]+src="([^"]+)"', localized_body):
        if src.startswith('/assets/blog/'):
            return os.path.basename(src)
    return None


def localize(body):
    """Point image URLs at our own copies in public/assets/blog."""
    # dead-source images: drop the whole <img> tag
    for url in DEAD_URLS:
        for variant in (url, html.escape(url)):
            body = re.sub(r'<img[^>]*src="' + re.escape(variant) + r'"[^>]*/?>', '', body)
    # site's own wp-content uploads by filename
    def swap(m):
        name = local_name(m.group(0))
        return f'/assets/blog/{name}' if name else m.group(0)
    body = re.sub(r'https?://[^\s"\']+/wp-content/uploads/[^\s"\'>)]+', swap, body)
    # explicitly mapped URLs (renamed variants + downloaded third-party images)
    for url, name in URL_MAP.items():
        path = f'/assets/blog/{name}'
        body = body.replace(url, path).replace(html.escape(url), path)
    return body


def convert_captions(body):
    """[caption ...]<img/> text[/caption] -> <figure><img/><figcaption>text</figcaption></figure>."""
    def repl(m):
        attrs, inner = m.group(1), m.group(2)
        align = re.search(r'align="(\w+)"', attrs)
        cls = f' class="wp-caption {align.group(1)}"' if align else ' class="wp-caption"'
        img = re.match(r'\s*(<img[^>]*/?>|<a[^>]*>\s*<img[^>]*/?>\s*</a>)(.*)$', inner, re.S)
        if not img:
            return inner
        caption = img.group(2).strip()
        figcaption = f'<figcaption>{caption}</figcaption>' if caption else ''
        return f'<figure{cls}>{img.group(1)}{figcaption}</figure>'
    return re.sub(r'\[caption([^\]]*)\](.*?)\[/caption\]', repl, body, flags=re.S)


# Block-level tags that must not be wrapped in <p> (mirrors WordPress wpautop).
_BLOCK = (r'table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li'
          r'|pre|form|map|area|blockquote|address|style|p|h[1-6]|hr|fieldset|legend'
          r'|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary')


def wpautop(body):
    """Port of WordPress's implicit paragraph formation for classic-editor posts.

    WordPress turns blank lines into <p> boundaries at render time; this app's
    Blog model collapses newlines instead, so the paragraphs must be made
    explicit in the stored HTML. Gutenberg content already has explicit tags.
    """
    if '<!-- wp:' in body or not body.strip():
        return body
    t = body.replace('\r\n', '\n').replace('\r', '\n')
    # isolate block elements onto their own segments
    t = re.sub(r'(<(?:' + _BLOCK + r')(?:\s[^>]*)?>)', r'\n\n\1', t, flags=re.I)
    t = re.sub(r'(</(?:' + _BLOCK + r')>)', r'\1\n\n', t, flags=re.I)
    out = []
    for chunk in re.split(r'\n\s*\n', t):
        s = chunk.strip()
        if not s:
            continue
        if re.match(r'^</?(?:' + _BLOCK + r')(?:[\s/>]|$)', s, re.I):
            out.append(s)
        else:
            out.append('<p>' + re.sub(r'\n+', '<br />\n', s) + '</p>')
    return '\n'.join(out)


# Kategorisasi blog product ke 12 kategori situs (berdasarkan judul).
# Urutan penting: aturan pertama yang cocok menang.
CATEGORY_RULES = [
    ('atap', r'atap|genteng|spandek|asbes|seng\b|karpus|\bnok\b|polycarbonate|alderon|insulasi|fiber gelombang|talang'),
    ('besi-dan-baja', r'besi|hollow|baja ringan|canal c|kanal|cnp|unp|\bwf\b|wiremesh|wire mesh|bondek|plat |as drat|behel|slup'),
    ('hebel-dan-bata', r'hebel|bata\b|batako|semen|mortar|plesteran|acian|sikagrout|sikawall|pasir|drymix|gypsum|kayu|triplek'),
    ('pipa-dan-sanitasi', r'pipa|kran|keran|closet|kloset|wastafel|toren|tandon|elbow|\btee\b|sock|\bdop\b|floor drain|avur|selang|wavin|rucika'),
    ('lampu-dan-kelistrikan', r'lampu|kabel|mcb|saklar|stop kontak|steker|fitting|armatur|downlight|eterna|hannochs|listrik'),
    ('mesin', r'mesin|genset|pompa|dinamo|kompresor|vibrator|molen'),
    ('perkakas', r'kunci \w|obeng|\btang\b|palu|gergaji|meteran|waterpass|\bbor\b|gerinda|tekiro|\bryu\b|kape|cetok|roskam|linggis|pahat|sekop|cangkul|tangga'),
    ('paku-dan-baut', r'paku|baut|\bmur\b|sekrup|skrup|dynabolt|fischer|anchor|rivet'),
    ('safety', r'safety|helm|sepatu|kacamata|masker|rompi|harness'),
    ('keramik-dan-granit', r'keramik|granit'),
    ('cat', r'\bcat\b|waterproof|thinner|tinner|aquaproof|no drop|epoxy|plamir|dempul|meni\b|politur|pylox|sikatop'),
    ('consumable-industri', r'\blem\b|sealant|silicone|silikon|amplas|mata potong|mata gerinda|majun|isolasi|lakban|wd-?40|kuas'),
]


def categorize(title, body):
    """Kategori untuk blog product; None untuk artikel biasa."""
    if 'product-content' not in body:
        return None
    low = title.lower()
    for slug, pattern in CATEGORY_RULES:
        if re.search(pattern, low):
            return slug
    return None


def php_str(s):
    """PHP single-quoted string literal."""
    return "'" + s.replace('\\', '\\\\').replace("'", "\\'") + "'"


posts, no_image = [], 0
for it in raw_posts:
    link = it.findtext('link', default='')
    m = re.search(r'https?://[^/]+/(.+?)/?$', link)
    if not m:
        continue
    slug = m.group(1)
    body = localize(it.findtext('content:encoded', default='', namespaces=NS) or '')
    body = wpautop(convert_captions(body))
    body = re.sub(r'<p>(?:\s|&nbsp;)*</p>', '', body)
    img = featured_image(it, body)
    if not img:
        no_image += 1
    title = it.findtext('title', default='').strip()
    posts.append({
        'title': title,
        'slug': slug,
        'content': body,
        'image_path': f'/blog/{img}' if img else None,
        'category': categorize(title, body),
        'published_at': it.findtext('wp:post_date', default='', namespaces=NS),
    })

posts.sort(key=lambda p: p['published_at'])

size = -(-len(posts) // PARTS)
chunks = [posts[i:i + size] for i in range(0, len(posts), size)]

for idx, chunk in enumerate(chunks, start=1):
    rows = []
    for p in chunk:
        image = php_str(p['image_path']) if p['image_path'] else 'null'
        category = php_str(p['category']) if p['category'] else 'null'
        rows.append(
            "            [\n"
            f"                'title' => {php_str(p['title'])},\n"
            f"                'slug' => {php_str(p['slug'])},\n"
            f"                'content' => {php_str(p['content'])},\n"
            f"                'image_path' => {image},\n"
            f"                'category' => {category},\n"
            f"                'published_at' => {php_str(p['published_at'])},\n"
            "                'author_id' => 1,\n"
            "                'created_at' => now(),\n"
            "                'updated_at' => now(),\n"
            "            ],"
        )
    body = "\n".join(rows)
    php = f"""<?php

namespace Database\\Seeders;

use Illuminate\\Database\\Seeder;
use Illuminate\\Support\\Facades\\DB;

/**
 * Generated from the WordPress export by database/seeders/generator/gen_blog_seeders.py.
 * Part {idx} of {len(chunks)}. Do not edit by hand — regenerate instead.
 */
class BlogPart{idx} extends Seeder
{{
    public function run(): void
    {{
        $posts = [
{body}
        ];

        DB::table('blogs')->upsert(
            $posts,
            ['slug'],
            ['title', 'content', 'image_path', 'category', 'published_at', 'author_id', 'updated_at']
        );
    }}
}}
"""
    path = os.path.join(OUT_DIR, f'BlogPart{idx}.php')
    with open(path, 'w', encoding='utf-8') as f:
        f.write(php)
    print(f'{os.path.relpath(path, ROOT)}: {len(chunk)} posts, {os.path.getsize(path)/1024:.0f}KB')

calls = "\n".join(f"            BlogPart{i}::class," for i in range(1, len(chunks) + 1))
orchestrator = f"""<?php

namespace Database\\Seeders;

use Illuminate\\Database\\Seeder;

/**
 * Seeds every blog post exported from WordPress.
 *
 * The posts themselves live in the generated BlogPart* seeders; this one only
 * runs them in order. Regenerate them with
 * database/seeders/generator/gen_blog_seeders.py rather than editing by hand.
 */
class Blog extends Seeder
{{
    public function run(): void
    {{
        $this->call([
{calls}
        ]);
    }}
}}
"""
with open(os.path.join(OUT_DIR, 'Blog.php'), 'w', encoding='utf-8') as f:
    f.write(orchestrator)

print(f'\ntotal posts: {len(posts)} | without image: {no_image} | parts: {len(chunks)}')
