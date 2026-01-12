#!/usr/bin/env python3
import json
import re
from pathlib import Path
from difflib import unified_diff

preview = Path('tools/slug_replacements_preview.json')
if not preview.exists():
    print('Preview JSON not found:', preview)
    raise SystemExit(1)

mappings = json.loads(preview.read_text())
files = {}
for entry in mappings:
    files.setdefault(entry['file'], []).append(entry)

patches = []
for file, entries in files.items():
    p = Path(file)
    if not p.exists():
        print('Target file missing:', file)
        continue

    orig_text = p.read_text()
    new_text = orig_text
    changed = 0
    for e in entries:
        old = e['old']
        new = e['new']
        old_snippet = "'slug' => '{}'".format(old)
        new_snippet = "'slug' => '{}'".format(new)
        if old_snippet in new_text:
            new_text = new_text.replace(old_snippet, new_snippet)
            changed += 1
        else:
            print(f"Warning: did not find slug '{old}' in {file}")

    if changed > 0:
        diff = '\n'.join(unified_diff(orig_text.splitlines(), new_text.splitlines(), fromfile=file, tofile=file + '.patched', lineterm=''))
        patches.append((file, changed, diff))
        p.write_text(new_text)
        print(f'Applied {changed} replacements to {file}')
    else:
        print(f'No changes for {file}')

# Write combined patch
if patches:
    out = Path('tools/applied_slug_replacements.patch')
    with out.open('w') as fh:
        for file, changed, diff in patches:
            fh.write(diff)
            fh.write('\n')
    print('Wrote patch to tools/applied_slug_replacements.patch')
else:
    print('No patches written')
