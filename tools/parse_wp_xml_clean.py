#!/usr/bin/env python3
import re
import sys
import json
import argparse
from pathlib import Path
import html

parser = argparse.ArgumentParser(description='Parse WP XML and generate Laravel seeder (or dry-run).')
parser.add_argument('xml', nargs='?', help='Path to WP XML file')
parser.add_argument('--dry-run', action='store_true', help='Do not write seeder; print permalinks and stats')
parser.add_argument('--out-json', help='Write parsed posts to JSON file (for verification)')
parser.add_argument('--out-seeder', default='database/seeders/Blog.php', help='Path to write PHP seeder')
parser.add_argument('--test', action='store_true', help='Run self-tests and exit')
parser.add_argument('--trailing-slash', action='store_true', help='Include a trailing slash in generated permalinks')
args = parser.parse_args()

if args.test:
    # small self-test for permalink generation and idempotency
    sample_items = [
        {'post_name': 'jual-baja-cikarang-pusat-baja-konstruksi-lengkap-terpercaya', 'published_at': '2025-10-14 12:00:00', 'title': 'Jual Baja', 'content': '<p>hello</p>'},
        {'post_name': '2025/10/14/jual-baja-cikarang-pusat-baja-konstruksi-lengkap-terpercaya/', 'published_at': '2025-10-14 12:00:00', 'title': 'Jual Baja', 'content': '<p>hello</p>'},
        {'post_name': '', 'published_at': '2025-10-14 12:00:00', 'title': 'A Title With Ünicode', 'content': '<p>c</p>'},
    ]
    def slugify(s):
        s = (s or '').strip().lower()
        s = html.unescape(s)
        s = re.sub(r'[^a-z0-9\s-]', '', s)
        s = re.sub(r'[\s_]+', '-', s)
        s = re.sub(r'-{2,}', '-', s)
        s = s.strip('-')
        return s

    def build_permalink(post_name, title, published_at, trailing=False):
        # Extract date
        m = re.match(r"(\d{4})-(\d{2})-(\d{2})", published_at or '')
        if m:
            yyyy, mm, dd = m.group(1), m.group(2), m.group(3)
        else:
            yyyy, mm, dd = '0000', '00', '00'
        # Idempotent: strip leading date path if present (with or without trailing slash)
        pn = (post_name or '').strip()
        m2 = re.match(r'^(\d{4})/(\d{2})/(\d{2})/(.*?)/?$', pn)
        if m2:
            base = m2.group(4)
        else:
            base = pn or title
        base = slugify(base)
        if not base:
            base = 'post'
        if trailing:
            permalink = f"{yyyy}/{mm}/{dd}/{base}/"
        else:
            permalink = f"{yyyy}/{mm}/{dd}/{base}"
        return permalink

    seen = {}
    for p in sample_items:
        pl = build_permalink(p['post_name'], p['title'], p['published_at'], trailing=False)
        orig = pl
        count = 2
        while pl in seen:
            # append suffix (no trailing slash in this test)
            pl = orig + f"-{count}"
            count += 1
        seen[pl] = True
        print(pl)
    sys.exit(0)

if not args.xml:
    print('Usage: parse_wp_xml_clean.py path/to/file.xml [--dry-run] [--out-json file.json]')
    sys.exit(1)

xml_path = Path(args.xml)
text = xml_path.read_text(encoding='utf-8')

items = re.findall(r'<item>(.*?)</item>', text, flags=re.DOTALL)
posts = []

for item in items:
    if '<wp:post_type><![CDATA[post]]></wp:post_type>' not in item:
        continue

    # optional: only published
    # if '<wp:status><![CDATA[publish]]></wp:status>' not in item:
    #     continue

    # title
    m = re.search(r'<title>(.*?)</title>', item, flags=re.DOTALL)
    title = m.group(1).strip() if m else ''
    # strip CDATA wrapper
    if title.startswith('<![CDATA[') and title.endswith(']]>'):
        title = title[9:-3]
    title = html.unescape(title)

    # content
    m = re.search(r'<content:encoded><!\[CDATA\[(.*?)\]\]></content:encoded>', item, flags=re.DOTALL)
    content = m.group(1).strip() if m else ''

    # post_date
    m = re.search(r'<wp:post_date><!\[CDATA\[(.*?)\]\]></wp:post_date>', item)
    post_date = m.group(1).strip() if m else ''

    # post_name (slug)
    m = re.search(r'<wp:post_name><!\[CDATA\[(.*?)\]\]></wp:post_name>', item)
    post_name = m.group(1).strip() if m else ''
    # defensive: strip CDATA wrapper if present
    if post_name.startswith('<![CDATA[') and post_name.endswith(']]>'):
        post_name = post_name[9:-3]
    post_name = html.unescape(post_name)

    posts.append({'title': title, 'content': content, 'published_at': post_date, 'post_name': post_name})

print(f'Found {len(posts)} posts')

# generate permalink (YYYY/MM/DD/post-slug/) from wp:post_date + wp:post_name (or title)

def slugify(s):
    s = (s or '').strip().lower()
    s = html.unescape(s)
    # remove characters that are not a-z0-9, space or hyphen
    s = re.sub(r'[^a-z0-9\s-]', '', s)
    # replace spaces/underscores with hyphens
    s = re.sub(r'[\s_]+', '-', s)
    # collapse multiple hyphens
    s = re.sub(r'-{2,}', '-', s)
    s = s.strip('-')
    return s

seen = {}
out_posts = []
for idx, p in enumerate(posts, start=1):
    # date
    m = re.match(r"(\d{4})-(\d{2})-(\d{2})", p.get('published_at') or '')
    if m:
        yyyy, mm, dd = m.group(1), m.group(2), m.group(3)
    else:
        yyyy, mm, dd = '0000', '00', '00'

    # idempotent base slug: strip leading date path if present
    pn = (p.get('post_name') or '').strip()
    m2 = re.match(r'^(\d{4})/(\d{2})/(\d{2})/(.*?)/?$', pn)
    if m2:
        base = m2.group(4)
    else:
        base = pn or p.get('title') or f'post-{idx}'

    base = slugify(base)
    if not base:
        base = f'post-{idx}'

    # build permalink respecting trailing-slash flag
    if args.trailing_slash:
        permalink = f"{yyyy}/{mm}/{dd}/{base}/"
    else:
        permalink = f"{yyyy}/{mm}/{dd}/{base}"

    # ensure uniqueness
    orig = permalink
    count = 2
    while permalink in seen:
        # append suffix appropriately
        if args.trailing_slash:
            b = re.sub(r'^(\d{4}/\d{2}/\d{2}/)(.*?)/$', r'\2', orig)
            newbase = b + f"-{count}"
            permalink = f"{yyyy}/{mm}/{dd}/{newbase}/"
        else:
            b = re.sub(r'^(\d{4}/\d{2}/\d{2}/)(.*)$', r'\2', orig)
            newbase = b + f"-{count}"
            permalink = f"{yyyy}/{mm}/{dd}/{newbase}"
        count += 1

    # validate format
    if args.trailing_slash:
        if not re.match(r'^\d{4}/\d{2}/\d{2}/[a-z0-9-]+/$', permalink):
            print('WARNING: invalid permalink format for post', p.get('title')[:40], '->', permalink)
    else:
        if not re.match(r'^\d{4}/\d{2}/\d{2}/[a-z0-9-]+$', permalink):
            print('WARNING: invalid permalink format for post', p.get('title')[:40], '->', permalink)

    seen[permalink] = True
    p['slug'] = permalink
    out_posts.append(p)

if args.out_json:
    Path(args.out_json).write_text(json.dumps(out_posts, ensure_ascii=False, indent=2), encoding='utf-8')
    print('Wrote JSON to', args.out_json)

if args.dry_run:
    print('\nDry run: prepared permalinks (first 100)')
    for pl in list(seen.keys())[:100]:
        print(pl)
    print('\nTotal:', len(seen))
    sys.exit(0)

# Build PHP seeder

def php_escape(s):
    if s is None or s == '':
        return 'null'
    s = s.replace('\\', '\\\\')
    s = s.replace("'", "\\'")
    s = s.replace('\r', '')
    s = s.replace('\n', '\\n')
    return "'" + s + "'"

entries = []
for p in out_posts:
    title = php_escape(p['title'])
    slug = php_escape(p.get('slug'))
    content = php_escape(p['content'])
    published_at = php_escape(p['published_at']) if p['published_at'] else 'null'
    entries.append(f"[ 'title' => {title}, 'slug' => {slug}, 'content' => {content}, 'image_path' => null, 'published_at' => {published_at}, 'author_id' => null, 'created_at' => now(), 'updated_at' => now() ]")

arr = ',\n            '.join(entries)

seeder = f"<?php\n\nnamespace Database\\Seeders;\n\nuse Illuminate\\Database\\Seeder;\nuse Illuminate\\Support\\Facades\\DB;\n\nclass Blog extends Seeder\n{{\n    public function run(): void\n    {{\n        DB::table('blogs')->insert([\n            {arr}\n        ]);\n    }}\n}}\n"

out_path = Path(args.out_seeder)
out_path.write_text(seeder, encoding='utf-8')
print('Wrote', out_path)
