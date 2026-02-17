#!/usr/bin/env python3
import json
from pathlib import Path

parsed = json.loads(Path('parsed.json').read_text(encoding='utf-8'))
posts = parsed

# Split into Blog.php (first 65) and BlogPart2.php (remaining 64)
blog_posts = posts[:65]
blog_part2_posts = posts[65:]

def generate_seeder(posts, filename, classname):
    lines = [
        '<?php',
        '',
        'namespace Database\\Seeders;',
        '',
        'use Illuminate\\Database\\Seeder;',
        'use Illuminate\\Support\\Facades\\DB;',
        '',
        f'class {classname} extends Seeder',
        '{',
        '    public function run(): void',
        '    {',
        '        $posts = [',
    ]
    
    for post in posts:
        title = post.get('title', '').replace("'", "\\'")
        slug = post.get('slug', '').replace("'", "\\'")
        content = post.get('content', '').replace("'", "\\'")
        image_path = post.get('image_path', '')
        if image_path:
            image_path = image_path.replace("'", "\\'")
        published_at = post.get('published_at', '')
        
        lines.append('            [')
        lines.append(f"                'title' => '{title}',")
        lines.append(f"                'slug' => '{slug}',")
        lines.append(f"                'content' => '{content}',")
        if image_path:
            lines.append(f"                'image_path' => '{image_path}',")
        else:
            lines.append(f"                'image_path' => null,")
        lines.append(f"                'published_at' => '{published_at}',")
        lines.append(f"                'author_id' => 1,")
        lines.append(f"                'created_at' => now(),")
        lines.append(f"                'updated_at' => now(),")
        lines.append('            ],')
    
    lines.extend([
        '        ];',
        '',
        '        DB::table(\'blogs\')->insert($posts);',
        '    }',
        '}',
    ])
    
    filepath = Path(f'database/seeders/{filename}')
    filepath.write_text('\n'.join(lines), encoding='utf-8')
    print(f'Generated {filename} with {len(posts)} posts')

generate_seeder(blog_posts, 'Blog.php', 'Blog')
generate_seeder(blog_part2_posts, 'BlogPart2.php', 'BlogPart2')
