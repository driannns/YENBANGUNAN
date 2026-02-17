#!/usr/bin/env python3
import json
import os
from difflib import SequenceMatcher

with open('parsed.json') as f:
    blogs = json.load(f)

image_dir = 'public/assets/blog/'
images = [f for f in os.listdir(image_dir) if os.path.isfile(os.path.join(image_dir, f))]

def filename_to_slug(filename):
    name = os.path.splitext(filename)[0]
    return name.lower()

def similarity(a, b):
    return SequenceMatcher(None, a.lower(), b.lower()).ratio()

matches = {}
for idx, blog in enumerate(blogs):
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
        matches[idx] = {'title': title, 'image': best_match, 'image_path': f'/blog/{best_match}', 'score': best_score}

# Print results
for idx in sorted(matches.keys()):
    print(f"{idx}|{matches[idx]['title']}|{matches[idx]['image']}")
