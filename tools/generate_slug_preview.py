#!/usr/bin/env python3
import json, re, html, pathlib, sys

P_PARSED = pathlib.Path('tools/parsed_preview.json')
P_SEED = pathlib.Path('database/seeders/BlogPart1.php')
P_OUT = pathlib.Path('tools/slug_replacements_preview.json')

if not P_PARSED.exists():
    print('Parsed JSON missing:', P_PARSED, file=sys.stderr); sys.exit(1)
if not P_SEED.exists():
    print('Seeder file missing:', P_SEED, file=sys.stderr); sys.exit(1)

parsed = json.loads(P_PARSED.read_text(encoding='utf-8'))

def norm(t):
    t = (t or '').strip().lower()
    t = html.unescape(t)
    t = re.sub(r'[^a-z0-9\s-]', '', t)
    t = re.sub(r'[\s_]+', ' ', t)
    t = re.sub(r'\s+', ' ', t)
    return t

parsed_map = {norm(p.get('title')): p.get('slug') for p in parsed}
text = P_SEED.read_text(encoding='utf-8')
pattern = re.compile(r"\[\s*'title'\s*=>\s*'(?P<title>(?:\\'|[^'])*)'\s*,\s*'slug'\s*=>\s*'(?P<slug>(?:\\'|[^'])*)'", re.DOTALL)

repls = []
for m in pattern.finditer(text):
    title = m.group('title').replace("\\'", "'")
    oldslug = m.group('slug').replace("\\'", "'")
    key = norm(title)
    newslug = parsed_map.get(key)
    if newslug and newslug != oldslug:
        repls.append({'title': title, 'file': str(P_SEED), 'old': oldslug, 'new': newslug})

P_OUT.write_text(json.dumps(repls, ensure_ascii=False, indent=2), encoding='utf-8')
print('wrote', len(repls), 'replacements to', P_OUT)
if repls:
    print('\nSample:')
    for r in repls[:20]:
        print('-', r['title'][:60], '->', r['old'], '=>', r['new'])
