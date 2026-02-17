import re
from pathlib import Path

ROOT = Path("/Users/andriansaputra/Documents/duit/Web/YEN")
BLOG_DIR = ROOT / "public" / "assets" / "blog"
SEEDERS = [
    ROOT / "database" / "seeders" / "Blog.php",
    ROOT / "database" / "seeders" / "BlogPart1.php",
]

IMAGE_EXTS = {".jpg", ".jpeg", ".png", ".webp"}

# Build image filename list
image_files = []
for path in BLOG_DIR.iterdir():
    if path.is_file() and path.suffix.lower() in IMAGE_EXTS:
        image_files.append(path.name)

# Map from stem to list of filenames
stem_to_files = {}
for name in image_files:
    stem = Path(name).stem
    stem_to_files.setdefault(stem, []).append(name)


def find_match_from_slug(slug_value: str):
    # slug format expected: YYYY/MM/DD/slug-text or maybe without date
    slug_value = (slug_value or "").strip()
    slug_text = re.sub(r"^\d{4}(?:[\/\-]\d{2}){2}[\/-]?", "", slug_value)

    if slug_text in stem_to_files:
        return sorted(stem_to_files[slug_text])[0]

    candidates = []
    for stem, files in stem_to_files.items():
        if slug_text and slug_text in stem:
            candidates.extend(files)

    if not candidates:
        return None

    def key_fn(fname: str):
        stem = Path(fname).stem
        return (len(stem), fname)

    return sorted(candidates, key=key_fn)[0]


unmatched = []
changes = []

for seeder in SEEDERS:
    content = seeder.read_text(encoding="utf-8")

    entries = re.findall(
        r"\['title'\s*=>\s*'([^']+)'[^\]]*?'slug'\s*=>\s*'([^']+)'",
        content,
        flags=re.DOTALL,
    )

    for title, slug in entries:
        match = find_match_from_slug(slug)
        if not match:
            unmatched.append((seeder.name, title))
            continue

        image_path = f"/blog/{match}"

        pattern = re.compile(
            r"(\['title'\s*=>\s*'" + re.escape(title) + r"'.*?'image_path'\s*=>\s*)(null)",
            re.DOTALL,
        )

        def _repl(m):
            return m.group(1) + "'" + image_path + "'"

        new_content, n = pattern.subn(_repl, content, count=1)
        if n:
            content = new_content
            changes.append((seeder.name, title, image_path))

    seeder.write_text(content, encoding="utf-8")

report_path = ROOT / "tools" / "blog_image_path_report.txt"
lines = []
lines.append("Updated image_path entries (slug match):\n")
for seeder_name, title, image_path in changes:
    lines.append(f"- {seeder_name}: {title} -> {image_path}\n")

lines.append("\nUnmatched titles (slug match):\n")
if unmatched:
    for seeder_name, title in unmatched:
        lines.append(f"- {seeder_name}: {title}\n")
else:
    lines.append("(none)\n")

report_path.write_text("".join(lines), encoding="utf-8")
print(f"Updated {len(changes)} entries. Unmatched: {len(unmatched)}. Report: {report_path}")
