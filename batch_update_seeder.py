#!/usr/bin/env python3
"""
Batch update blog image paths in PHP seeder
"""
import json
import os
import re
from difflib import SequenceMatcher

# Load blogs from parsed.json
with open('parsed.json') as f:
    parsed_blogs = json.load(f)

# Read the PHP seeder file
with open('database/seeders/Blog.php') as f:
    seeder_lines = f.readlines()

# Get image matches
image_dir = 'public/assets/blog/'
images = [f for f in os.listdir(image_dir) if os.path.isfile(os.path.join(image_dir, f))]

def filename_to_slug(filename):
    name = os.path.splitext(filename)[0]
    return name.lower()

def similarity(a, b):
    return SequenceMatcher(None, a.lower(), b.lower()).ratio()

# Build index of already-updated entries (image_path already set)
updated_indices = set()

# Create  mapping of blog index to image path
matches = {}
for idx, blog in enumerate(parsed_blogs[:77]):  # Only the 77 in seeder
    if idx >= len(seeder_lines):
        break
    
    # Skip if already updated
    line = seeder_lines[idx + 5]  # Account for file header
    if "'image_path' => '/blog/" in line:
        updated_indices.add(idx)
        # Extract the existing image path
        match = re.search(r"'image_path' => '(/blog/[^']*)'", line)
        if match:
            matches[idx] = match.group(1)
        continue
    
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

print(f"Already updated: {len(updated_indices)} entries")
print(f"Found matches for: {len(matches)} entries")
print(f"Remaining to match: {77 - len(matches)}")

# Show summary
print("\nMatches summary:")
for idx in sorted(matches.keys())[:10]:
    blog_title = parsed_blogs[idx]['title'][:50] if idx < len(parsed_blogs) else "N/A"
    print(f"  Index {idx}: {matches[idx]}")
