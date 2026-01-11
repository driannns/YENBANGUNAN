#!/usr/bin/env python3
import re
import sys
from pathlib import Path
import html

if len(sys.argv) < 2:
    print('Usage: parse_wp_xml_clean.py path/to/file.xml')
    sys.exit(1)

xml_path = Path(sys.argv[1])
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

# generate slugs (from wp:post_name or sanitized title) and ensure uniqueness
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
for idx, p in enumerate(posts, start=1):
    base = slugify(p.get('post_name') or p.get('title') or f'post-{idx}')
    if not base:
        base = f'post-{idx}'
    slug = base
    count = 2
    while slug in seen:
        slug = f"{base}-{count}"
        count += 1
    seen[slug] = True
    p['slug'] = slug

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
for p in posts:
    title = php_escape(p['title'])
    slug = php_escape(p.get('slug'))
    content = php_escape(p['content'])
    published_at = php_escape(p['published_at']) if p['published_at'] else 'null'
    entries.append(f"[ 'title' => {title}, 'slug' => {slug}, 'content' => {content}, 'image_path' => null, 'published_at' => {published_at}, 'author_id' => null, 'created_at' => now(), 'updated_at' => now() ]")

arr = ',\n            '.join(entries)

seeder = f"<?php\n\nnamespace Database\\Seeders;\n\nuse Illuminate\\Database\\Seeder;\nuse Illuminate\\Support\\Facades\\DB;\n\nclass Blog extends Seeder\n{{\n    public function run(): void\n    {{\n        DB::table('blogs')->insert([\n            {arr}\n        ]);\n    }}\n}}\n"

out_path = Path('database/seeders/Blog.php')
out_path.write_text(seeder, encoding='utf-8')
print('Wrote', out_path)
