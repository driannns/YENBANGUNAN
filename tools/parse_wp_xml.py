#!/usr/bin/env python3
import re
import sys
from pathlib import Path

if len(sys.argv) < 2:
    print('Usage: parse_wp_xml.py path/to/file.xml')
    sys.exit(1)

xml_path = Path(sys.argv[1])
text = xml_path.read_text(encoding='utf-8')

items = re.findall(r'<item>(.*?)</item>', text, flags=re.DOTALL)
posts = []

for item in items:
    if '<wp:post_type><![CDATA[post]]></wp:post_type>' not in item:
        continue
    # optional: only published
    if '<wp:status><![CDATA[publish]]></wp:status>' not in item:
        # still include drafts? For now include all
        pass

    # title
    m = re.search(r'<title>(.*?)</title>', item, flags=re.DOTALL)
    title = m.group(1).strip() if m else ''

    # content
    m = re.search(r'<content:encoded><!\[CDATA\[(.*?)\]\]></content:encoded>', item, flags=re.DOTALL)
    content = m.group(1).strip() if m else ''

    # post_date
    m = re.search(r'<wp:post_date><!\[CDATA\[(.*?)\]\]></wp:post_date>', item)
    post_date = m.group(1).strip() if m else ''

    posts.append({'title': title, 'content': content, 'published_at': post_date})

print(f'Found {len(posts)} posts')

# Build PHP seeder
from datetime import datetime

def php_escape(s):
    if s is None:
        return 'null'
    s = s.replace('\\', '\\\\')
    s = s.replace("'", "\\'")
    s = s.replace('\r', '')
    s = s.replace('\n', '\\n')
    return "'" + s + "'"

entries = []
for p in posts:
    title = php_escape(p['title'])
    content = php_escape(p['content'])
    published_at = php_escape(p['published_at']) if p['published_at'] else 'null'
    entries.append(f"[ 'title' => {title}, 'content' => {content}, 'image_path' => null, 'published_at' => {published_at}, 'author_id' => null, 'created_at' => now(), 'updated_at' => now() ]")

chunks = []
# Put all in one big insert
arr = ',\n            '.join(entries)

seeder = f"<?php\n\nnamespace Database\\Seeders;\n\nuse Illuminate\\Database\\Seeder;\nuse Illuminate\\Support\\Facades\\DB;\n\nclass BlogSeeder extends Seeder\n{{\n    public function run(): void\n    {{\n        DB::table('blogs')->insert([\n            {arr}\n        ]);\n    }}\n}}\n"

out_path = Path('database/seeders/BlogSeeder.php')
out_path.write_text(seeder, encoding='utf-8')
print('Wrote', out_path)
