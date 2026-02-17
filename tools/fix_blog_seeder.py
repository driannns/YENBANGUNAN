from __future__ import annotations

import re
from pathlib import Path

PATH = Path("database/seeders/Blog.php")

text = PATH.read_text(encoding="utf-8")

replacements = {
    "author_id' => nul['title' =>": "author_id' => null, 'created_at' => now(), 'updated_at' => now()],\n            ['title' =>",
    "created_a['title' =>": "created_at' => now(), 'updated_at' => now()],\n            ['title' =>",
    "author_id' =['title' =>": "author_id' => null, 'created_at' => now(), 'updated_at' => now()],\n            ['title' =>",
    ", 'au['title' =>": ", 'author_id' => null, 'created_at' => now(), 'updated_at' => now()],\n            ['title' =>",
    ", 'aut['title' =>": ", 'author_id' => null, 'created_at' => now(), 'updated_at' => now()],\n            ['title' =>",
    ", 'a['title' =>": ", 'author_id' => null, 'created_at' => now(), 'updated_at' => now()],\n            ['title' =>",
    ", 'author['title' =>": ", 'author_id' => null, 'created_at' => now(), 'updated_at' => now()],\n            ['title' =>",
}

for src, dst in replacements.items():
    if src in text:
        text = text.replace(src, dst)

text = re.sub(
    r"published_at' => '([0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2})', \['title' =>",
    r"published_at' => '\\1', 'author_id' => null, 'created_at' => now(), 'updated_at' => now()],\n            ['title' =>",
    text,
)

text = text.replace(
    "vertical-ali['title' =>",
    "vertical-align: inherit">Kesimpulan</span></span></span></span></span></span></span></span></span></span></h2>', 'image_path' => '/blog/toko-baut-cikarang-terlengkap.jpg', 'published_at' => '2025-10-01 00:00:00', 'author_id' => null, 'created_at' => now(), 'updated_at' => now()],\n            ['title' =>",
)

text = re.sub(r"\],tama.*$", "],", text, flags=re.MULTILINE)

PATH.write_text(text, encoding="utf-8")
