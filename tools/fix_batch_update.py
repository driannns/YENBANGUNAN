#!/usr/bin/env python3
"""
Robust blog-image path updater using line-by-line processing.
This script reads the PHP seeder file line by line, identifies blog entries,
matches them to images, and updates image_path values.
"""

import json
import os
from difflib import SequenceMatcher
from pathlib import Path

# Configuration
SEEDER_FILE = '/Users/andriansaputra/Documents/duit/Web/YEN/database/seeders/Blog.php'
PARSED_FILE = '/Users/andriansaputra/Documents/duit/Web/YEN/parsed.json'
IMAGES_DIR = '/Users/andriansaputra/Documents/duit/Web/YEN/public/assets/blog'
SIMILARITY_THRESHOLD = 0.6

def get_image_files():
    """Get list of image files from the blog directory."""
    if not os.path.exists(IMAGES_DIR):
        print(f"ERROR: Images directory not found: {IMAGES_DIR}")
        return []
    
    images = []
    for f in os.listdir(IMAGES_DIR):
        if os.path.isfile(os.path.join(IMAGES_DIR, f)):
            images.append(f)
    return images

def find_best_image_match(blog_title, images):
    """Find best matching image for a blog title."""
    best_match = None
    best_ratio = 0
    
    for image in images:
        # Remove extension and common patterns for comparison
        title_clean = blog_title.lower().strip()
        image_clean = os.path.splitext(image)[0].lower()
        
        ratio = SequenceMatcher(None, title_clean, image_clean).ratio()
        
        if ratio > best_ratio:
            best_ratio = ratio
            best_match = image if ratio >= SIMILARITY_THRESHOLD else None
    
    return best_match, best_ratio

def extract_blog_title(line):
    """Extract blog title from a PHP line."""
    try:
        # Look for 'title' => '...'
        if "'title' => '" not in line:
            return None
        
        start = line.find("'title' => '") + len("'title' => '")
        end = line.find("'", start)
        if end == -1:
            return None
        
        title = line[start:end]
        return title
    except:
        return None

def process_seeder_file():
    """Process the seeder file and update image_path values."""
    
    print("Loading image list...")
    images = get_image_files()
    print(f"Found {len(images)} images")
    
    print(f"\nReading seeder file: {SEEDER_FILE}")
    with open(SEEDER_FILE, 'r', encoding='utf-8') as f:
        lines = f.readlines()
    
    print(f"Total lines: {len(lines)}")
    
    updated_lines = []
    updates_made = 0
    blogs_processed = 0
    unmatched_blogs = []
    
    for line_num, line in enumerate(lines, 1):
        # Check if this is a blog entry line (starts with spaces and '[')
        if line.strip().startswith('[') and "'title' => '" in line:
            blogs_processed += 1
            title = extract_blog_title(line)
            
            if title:
                # Find matching image
                image, ratio = find_best_image_match(title, images)
                
                if image and "'image_path' => null" in line:
                    # Update the line
                    old_line = line
                    new_line = line.replace("'image_path' => null", f"'image_path' => '/blog/{image}'")
                    updated_lines.append(new_line)
                    print(f"✓ Updated line {line_num}: {title[:50]}... -> {image}")
                    updates_made += 1
                elif not image:
                    # Track unmatched blogs
                    unmatched_blogs.append({
                        'line': line_num,
                        'title': title,
                        'index': blogs_processed - 1
                    })
                    updated_lines.append(line)
                else:
                    # Already has image_path set
                    updated_lines.append(line)
            else:
                updated_lines.append(line)
        else:
            updated_lines.append(line)
    
    print(f"\n" + "="*70)
    print(f"PROCESSING COMPLETE")
    print(f"="*70)
    print(f"Total blogs processed: {blogs_processed}")
    print(f"Updates made: {updates_made}")
    print(f"Unmatched blogs: {len(unmatched_blogs)}")
    
    if unmatched_blogs:
        print(f"\nUnmatched blogs:")
        for blog in unmatched_blogs[:10]:
            print(f"  - Index {blog['index']}: {blog['title'][:60]}")
        if len(unmatched_blogs) > 10:
            print(f"  ... and {len(unmatched_blogs) - 10} more")
    
    # Write updated file
    if updates_made > 0:
        print(f"\nWriting updated file...")
        with open(SEEDER_FILE, 'w', encoding='utf-8') as f:
            f.writelines(updated_lines)
        print(f"✓ File saved successfully!")
        
        # Verify
        import subprocess
        result = subprocess.run(
            f"grep -c \"'image_path' => '/blog/\" {SEEDER_FILE}",
            shell=True,
            capture_output=True,
            text=True
        )
        count = int(result.stdout.strip()) if result.stdout else 0
        print(f"\nVerification: {count} blogs have image_path set")
    else:
        print("No updates needed.")

if __name__ == '__main__':
    process_seeder_file()
