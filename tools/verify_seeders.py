#!/usr/bin/env python3
"""
Verify that all posts parsed from a WP XML file are present in the database seeders.
Usage: tools/verify_seeders.py path/to/file.xml path/to/seeders_dir

This script will:
 - run parse_wp_xml_clean.py with --out-json to get canonical parsed posts
 - scan seeder files (*.php) in the provided seeders_dir and extract title/slug/published_at/content
 - compare parsed posts to seeder posts by title (normalized) and report missing or mismatched items
"""

import sys
import subprocess
import tempfile
import json
from pathlib import Path
import re
import html

if len(sys.argv) < 3:
    print('Usage: tools/verify_seeders.py path/to/file.xml path/to/seeders_dir')
    sys.exit(1)

xml_path = Path(sys.argv[1])
seeders_dir = Path(sys.argv[2])
if not xml_path.exists():
    print('XML file not found:', xml_path)
    sys.exit(1)
if not seeders_dir.exists():
    print('Seeders dir not found:', seeders_dir)
    sys.exit(1)

with tempfile.TemporaryDirectory() as td:
    out_json = Path(td) / 'parsed_posts.json'
    cmd = ['python3', 'tools/parse_wp_xml_clean.py', str(xml_path), '--out-json', str(out_json)]
    print('Running:', ' '.join(cmd))
    res = subprocess.run(cmd, capture_output=True, text=True)
    if res.returncode != 0:
        print('parse_wp_xml_clean.py failed:')
        print(res.stdout)
        print(res.stderr)
        sys.exit(1)
    print(res.stdout)

    parsed = json.loads(out_json.read_text(encoding='utf-8'))

# helper normalization

def normalize_title(t):
    t = (t or '').strip().lower()
    t = html.unescape(t)
    t = re.sub(r"[^a-z0-9\s-]", '', t)
    t = re.sub(r"[\s_]+", ' ', t)
    t = re.sub(r"\s+", ' ', t)
    return t

parsed_by_title = {normalize_title(p.get('title')): p for p in parsed}

# scan seeders
seeder_posts = []
php_files = list(seeders_dir.glob('*.php'))
pattern = re.compile(r"\[\s*'title'\s*=>\s*'(?P<title>(?:\\'|[^'])*)'\s*,\s*'slug'\s*=>\s*'(?P<slug>(?:\\'|[^'])*)'\s*,\s*'content'\s*=>\s*'(?P<content>(?:\\'|[^'])*)'", re.DOTALL)
for p in php_files:
    text = p.read_text(encoding='utf-8')
    for m in pattern.finditer(text):
        title = m.group('title').replace("\\'", "'")
        slug = m.group('slug').replace("\\'", "'")
        content = m.group('content').replace("\\'", "'")
        seeder_posts.append({'file': str(p), 'title': title, 'slug': slug, 'content_len': len(content)})

print('\nParsed posts:', len(parsed))
print('Seeder posts found (all seeders *.php):', len(seeder_posts))

missing = []
matched = []
for key, p in parsed_by_title.items():
    if key in [normalize_title(s['title']) for s in seeder_posts]:
        matched.append(p)
    else:
        missing.append(p)

print('\nMatched by title:', len(matched))
print('Missing in seeders:', len(missing))
if missing:
    print('\nExamples of missing posts (title -> published_at -> excerpt):')
    for m in missing[:20]:
        t = m.get('title')
        pa = m.get('published_at')
        excerpt = (m.get('content') or '')[:80].replace('\n', ' ')
        print('-', t[:80], '->', pa, '->', excerpt)

# Quick content-coverage check for matched items
print('\nSeeder content length summary (first 10 seeders):')
for s in seeder_posts[:10]:
    print('-', s['file'], 'title:', s['title'][:40], 'slug:', s['slug'][:40], 'content_len:', s['content_len'])

if missing:
    print('\nResult: NOT all WP posts appear to be present in your seeders. Suggest running parse_wp_xml_clean.py to regenerate, or investigate why some titles are absent.')
else:
    print('\nResult: All parsed posts were found in the seeders (title-matching).')
