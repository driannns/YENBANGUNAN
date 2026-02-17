#!/usr/bin/env python3
"""
Batch replace image_path values in PHP seeder
"""
import json
import os
import re
from difflib import SequenceMatcher

# Load blogs from parsed.json
with open('parsed.json') as f:
    parsed_blogs = json.load(f)

# Read the full PHP seeder file
with open('database/seeders/Blog.php') as f:
    seeder_content = f.read()

# Get image matches
image_dir = 'public/assets/blog/'
images = [f for f in os.listdir(image_dir) if os.path.isfile(os.path.join(image_dir, f))]

def filename_to_slug(filename):
    name = os.path.splitext(filename)[0]
    return name.lower()

def similarity(a, b):
    return SequenceMatcher(None, a.lower(), b.lower()).ratio()

# Build matches
matches = {}
for idx, blog in enumerate(parsed_blogs[:77]):
    title = blog['title']
    best_match = None
    best_score = 0.6
    
    for image in images:
        img_slug = filename_to_slug(image)
        score = similarity(title, img_slug)
        if score > best_score:
            best_score = score
            best_match = image
    
    if best_match:
        matches[idx] = f'/blog/{best_match}'

# Extract all blog entries
blog_pattern = r"\['title' => '[^']*'.*?'updated_at' => now\(\)\],"
blog_entries = list(re.finditer(blog_pattern, seeder_content, re.DOTALL))

print(f"Found {len(blog_entries)} blog entries in seeder")
print(f"Have matches for {len(matches)} blogs")

# Perform replacements
updated_count = 0
for idx, entry_match in enumerate(blog_entries):
    if idx not in matches:
        continue
    
    old_text = entry_match.group(0)
    
    # Check if already has image_path set (skip if it does)
    if "'image_path' => '/blog/" in old_text:
        continue
    
    # Replace 'image_path' => null with actual path
    new_text = old_text.replace(
        "'image_path' => null,",
        f"'image_path' => '{matches[idx]}',"
    )
    
    if new_text != old_text:
        seeder_content = seeder_content[:entry_match.start()] + new_text + seeder_content[entry_match.end():]
        updated_count += 1
        print(f"Updated index {idx}")

print(f"\nTotal updated: {updated_count}")

# Write back
if updated_count > 0:
    with open('database/seeders/Blog.php', 'w') as f:
        f.write(seeder_content)
    print("File saved successfully!")
