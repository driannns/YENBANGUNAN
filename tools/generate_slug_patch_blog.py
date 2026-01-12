#!/usr/bin/env python3
import json, pathlib, difflib

P_PRE = pathlib.Path('tools/slug_replacements_preview_blog.json')
P_SEED = pathlib.Path('database/seeders/Blog.php')
P_PATCH = pathlib.Path('tools/slug_replacements_preview_blog.patch')

if not P_PRE.exists():
    print('preview file missing:', P_PRE)
    raise SystemExit(1)
if not P_SEED.exists():
    print('seeder missing:', P_SEED)
    raise SystemExit(1)

repls = json.loads(P_PRE.read_text(encoding='utf-8'))
text = P_SEED.read_text(encoding='utf-8')
newtext = text
for r in repls:
    old = r['old']
    new = r['new']
    # replace exact occurrence of the slug in the slug field only
    # pattern "'slug' => 'old'" -> "'slug' => 'new'"
    newtext = newtext.replace("'slug' => '" + old + "'", "'slug' => '" + new + "'")

# write patch
orig_lines = text.splitlines(keepends=True)
new_lines = newtext.splitlines(keepends=True)
patch = ''.join(difflib.unified_diff(orig_lines, new_lines, fromfile=str(P_SEED), tofile=str(P_SEED) + '.patched', n=3))
P_PATCH.write_text(patch, encoding='utf-8')
print('wrote patch to', P_PATCH)
print('\nPatch sample:')
print('\n'.join(patch.splitlines()[:200]))
