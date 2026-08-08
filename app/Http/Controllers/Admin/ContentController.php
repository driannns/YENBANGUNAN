<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function dashboard(): View
    {
        return view('admin.dashboard', [
            'articleCount' => Blog::where('type', 'article')->count(),
            'productCount' => Blog::where('type', 'product')->count(),
        ]);
    }

    /**
     * Daftar semua blog & produk (konten lama hasil import maupun baru dari admin),
     * dengan filter opsional ?type=article|product.
     */
    public function index(Request $request): View
    {
        $type = $request->query('type');
        $type = in_array($type, ['article', 'product'], true) ? $type : null;
        $status = $request->query('status');
        $status = in_array($status, ['active', 'archived'], true) ? $status : null;
        $search = trim((string) $request->query('search'));

        $items = Blog::query()
            ->when($type, fn ($q) => $q->where('type', $type))
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($search !== '', fn ($q) => $q->where('title', 'like', '%' . $search . '%'))
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.content-index', [
            'items' => $items,
            'type' => $type,
            'status' => $status,
            'search' => $search,
        ]);
    }

    public function edit(Blog $blog): View
    {
        $view = $blog->type === 'product' ? 'admin.product-edit' : 'admin.blog-edit';

        // Sebagian konten lama hasil import WordPress punya `description` string
        // kosong ('') alih-alih null (post yang bodinya cuma gambar tanpa teks
        // sama sekali) — null-coalesce saja tidak menangkap ini, jadi editor
        // kebuka kosong padahal harusnya fallback ke `content`. `isDescriptionBlank()`
        // sengaja tidak menganggap description berisi <img> sebagai kosong, supaya
        // deskripsi yang sengaja cuma berisi gambar tidak ketiban timpa oleh fallback.
        $description = $blog->description;
        if ($description === null || $this->isDescriptionBlank($description)) {
            $description = trim(strip_tags($blog->content));
        }
        // Deskripsi lama (sebelum pakai editor rich text) tersimpan sebagai plain text —
        // ubah jadi paragraf HTML dulu supaya baris/paragraf tetap kebaca saat dibuka di editor.
        $currentDescription = $description !== strip_tags($description)
            ? $description
            : $this->descriptionToParagraphs($description);

        return view($view, [
            'blog' => $blog,
            'categories' => config('product_categories'),
            'legacyUrl' => str_contains($blog->slug, '/'),
            'currentDescription' => $currentDescription,
        ]);
    }

    public function update(Request $request, Blog $blog): RedirectResponse
    {
        $isProduct = $blog->type === 'product';
        $legacyUrl = str_contains($blog->slug, '/');

        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'detail_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
        if (!$legacyUrl) {
            $rules['slug'] = ['nullable', 'string', 'max:255'];
        }
        if ($isProduct) {
            $rules['category'] = ['required', Rule::in(array_keys(config('product_categories')))];
        }

        $validated = $request->validate($rules);

        // URL lama (hasil import WordPress, mengandung "/") tidak boleh berubah —
        // supaya link yang sudah dibagikan/terindeks tidak 404.
        $slug = $legacyUrl
            ? $blog->slug
            : $this->uniqueSlug(($validated['slug'] ?? '') ?: $validated['title'], $blog->id);

        $imagePath = $blog->image_path;
        if ($request->hasFile('image')) {
            $oldImagePath = $blog->image_path;
            $imagePath = $this->storeImage($request->file('image'), $slug);
            $this->deleteImageIfOrphaned($oldImagePath, $blog->id);
        }

        $detailImagePath = $blog->detail_image_path;
        if ($request->hasFile('detail_image')) {
            $oldDetailImagePath = $blog->detail_image_path;
            $detailImagePath = $this->storeImage($request->file('detail_image'), $slug . '-detail');
            $this->deleteImageIfOrphaned($oldDetailImagePath, $blog->id);
        }

        $description = $this->sanitizeDescriptionHtml($validated['description']);
        $contentImagePath = $detailImagePath ?: $imagePath;
        $content = $isProduct
            ? $this->buildProductContent($contentImagePath, $validated['title'], $description)
            : $this->buildArticleContent($contentImagePath, $validated['title'], $description);

        $blog->update([
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $description,
            'content' => $content,
            'image_path' => $imagePath,
            'detail_image_path' => $detailImagePath,
            'category' => $isProduct ? $validated['category'] : null,
        ]);

        return redirect($blog->publicUrl())->with('status', '"' . $blog->title . '" berhasil diperbarui.');
    }

    public function destroy(Blog $blog): RedirectResponse
    {
        $title = $blog->title;
        $imagePath = $blog->image_path;
        $detailImagePath = $blog->detail_image_path;

        $blog->delete();

        $this->deleteImageIfOrphaned($imagePath, null);
        if ($detailImagePath !== $imagePath) {
            $this->deleteImageIfOrphaned($detailImagePath, null);
        }

        return redirect()
            ->route('admin.content.index')
            ->with('status', 'Konten "' . $title . '" berhasil dihapus.');
    }

    /**
     * Toggle status active <-> archived. Konten archived tidak lagi tampil di
     * halaman publik (list & detail blog/produk) tapi tetap ada di panel admin.
     */
    public function toggleStatus(Blog $blog): RedirectResponse
    {
        $blog->update(['status' => $blog->status === 'active' ? 'archived' : 'active']);

        $message = $blog->status === 'active'
            ? '"' . $blog->title . '" diaktifkan kembali.'
            : '"' . $blog->title . '" diarsipkan.';

        return redirect()->back()->with('status', $message);
    }

    public function createBlog(): View
    {
        return view('admin.blog-create');
    }

    public function storeBlog(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'slug' => ['nullable', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'detail_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $slug = $this->uniqueSlug(($validated['slug'] ?? '') ?: $validated['title']);
        $imagePath = $this->storeImage($request->file('image'), $slug);
        $detailImagePath = $request->hasFile('detail_image')
            ? $this->storeImage($request->file('detail_image'), $slug . '-detail')
            : null;
        $description = $this->sanitizeDescriptionHtml($validated['description']);

        $blog = Blog::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'content' => $this->buildArticleContent($detailImagePath ?: $imagePath, $validated['title'], $description),
            'description' => $description,
            'image_path' => $imagePath,
            'detail_image_path' => $detailImagePath,
            'category' => null,
            'type' => 'article',
            'published_at' => now(),
            'author_id' => auth()->id(),
        ]);

        return redirect($blog->publicUrl())->with('status', 'Artikel "' . $blog->title . '" berhasil dibuat.');
    }

    public function createProduct(): View
    {
        return view('admin.product-create', ['categories' => config('product_categories')]);
    }

    public function storeProduct(Request $request): RedirectResponse
    {
        $categories = config('product_categories');

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category' => ['required', Rule::in(array_keys($categories))],
            'slug' => ['nullable', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $slug = $this->uniqueSlug(($validated['slug'] ?? '') ?: $validated['title']);
        $imagePath = $this->storeImage($request->file('image'), $slug);
        $description = $this->sanitizeDescriptionHtml($validated['description']);

        $blog = Blog::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'content' => $this->buildProductContent($imagePath, $validated['title'], $description),
            'description' => $description,
            'image_path' => $imagePath,
            'category' => $validated['category'],
            'type' => 'product',
            'published_at' => now(),
            'author_id' => auth()->id(),
        ]);

        return redirect($blog->publicUrl())->with('status', 'Produk "' . $blog->title . '" berhasil dibuat.');
    }

    /**
     * Upload gambar yang disisipkan di tengah deskripsi lewat editor Quill.
     * Dipanggil via AJAX oleh tombol "image" di toolbar; hasilnya URL untuk
     * disisipkan editor sebagai <img>, bukan disimpan sebagai base64.
     */
    public function uploadEditorImage(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
        ]);

        $imagePath = $this->storeImage($validated['image'], 'content-' . Str::random(8));

        return response()->json(['url' => asset('assets' . $imagePath)]);
    }

    /**
     * Slugify dan pastikan unik (kolom slug punya unique constraint di DB).
     * $excludeId dipakai saat update supaya baris itu sendiri tidak dianggap tabrakan.
     */
    private function uniqueSlug(string $base, ?int $excludeId = null): string
    {
        $slug = Str::slug($base);
        $original = $slug;
        $i = 2;

        while (Blog::where('slug', $slug)->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))->exists()) {
            $slug = $original . '-' . $i;
            $i++;
        }

        return $slug;
    }

    /**
     * Hapus file gambar lama dari disk kalau sudah tidak dirujuk baris manapun
     * (dipanggil setelah update dengan gambar baru, atau setelah delete).
     */
    private function deleteImageIfOrphaned(?string $imagePath, ?int $excludeId): void
    {
        if (!$imagePath) {
            return;
        }

        $stillUsed = Blog::where(fn ($q) => $q->where('image_path', $imagePath)->orWhere('detail_image_path', $imagePath))
            ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
            ->exists();

        if ($stillUsed) {
            return;
        }

        $fullPath = $this->assetsRoot() . $imagePath;
        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }

    /**
     * Folder fisik tempat asset (gambar produk/blog & gambar dalam deskripsi)
     * disimpan — lihat config/filesystems.php ('legacy_assets_path') untuk
     * cara override-nya lewat .env tanpa ubah kode. URL yang dihasilkan
     * asset() tidak berubah — cuma lokasi tulisnya.
     */
    private function assetsRoot(): string
    {
        return rtrim(config('filesystems.legacy_assets_path'), '/');
    }

    /**
     * Simpan file ke {assetsRoot()}/blog, mengikuti konvensi yang sudah
     * dipakai konten hasil import WordPress (tanpa storage:link).
     */
    private function storeImage(UploadedFile $file, string $slug): string
    {
        // Slug konten lama (hasil import WordPress) berisi "/" (mis. "2025/06/24/
        // judul-artikel") — kalau dipakai apa adanya di sini, UploadedFile::move()
        // diam-diam membuang prefix sebelum "/" terakhir saat benar-benar menyimpan
        // filenya (lihat Symfony File::getName()), tapi path yang KITA kembalikan &
        // simpan ke `image_path` tetap yang belum dipotong itu — jadi menunjuk ke
        // file yang tidak pernah ada. basename() di sini menyamakan keduanya.
        $safeSlug = basename($slug);
        $extension = strtolower($file->extension() ?: 'jpg');
        $filename = $safeSlug . '-' . time() . '.' . $extension;

        $file->move($this->assetsRoot() . '/blog', $filename);

        return '/blog/' . $filename;
    }

    /**
     * True kalau description tidak punya teks maupun gambar sama sekali (mis. '',
     * '<p></p>', '<h1></h1>') — dipakai di edit() untuk memutuskan kapan fallback
     * ke `content`. <img> sengaja dianggap "berisi" walau tidak ada teks, supaya
     * deskripsi yang sengaja cuma berisi gambar tidak dianggap kosong.
     */
    private function isDescriptionBlank(string $description): bool
    {
        return trim(strip_tags($description)) === '' && !str_contains($description, '<img');
    }

    /**
     * Deskripsi polos (dari data lama sebelum pakai editor rich text) -> paragraf HTML.
     * Baris kosong ganda = paragraf baru. Dipakai untuk mengisi editor saat edit konten lama.
     */
    private function descriptionToParagraphs(string $description): string
    {
        $paragraphs = preg_split('/\r?\n\s*\r?\n/', trim($description)) ?: [];

        return collect($paragraphs)
            ->map(fn ($p) => trim($p))
            ->filter()
            ->map(fn ($p) => '<p>' . nl2br(e($p)) . '</p>')
            ->implode('');
    }

    /**
     * Batasi HTML hasil editor Quill ke tag yang bisa dihasilkan toolbar lengkapnya
     * saja (font/size/heading 1-6/bold-italic-underline-strike/color/script/quote/
     * code/list-indent/align-direction/link-image-video), buang sisanya (script, dst).
     */
    private function sanitizeDescriptionHtml(string $html): string
    {
        // Buang tag berbahaya (script, style, object, embed) BESERTA isinya dulu.
        // <iframe> ditangani terpisah di bawah (whitelist domain video), bukan
        // dibuang total di sini, karena toolbar Quill sekarang punya tombol video.
        $html = preg_replace('#<(script|style|object|embed)\b[^>]*>.*?</\1>#is', '', $html) ?? $html;
        $html = $this->sanitizeVideoEmbeds($html);

        $allowedTags = '<div><p><br><strong><b><em><i><u><s><del><sub><sup><a><span>'
            . '<ul><ol><li><blockquote><pre><code><h1><h2><h3><h4><h5><h6><img><iframe>';
        $html = strip_tags($html, $allowedTags);

        // strip_tags tidak membuang atribut pada tag yang diizinkan — buang event
        // handler (onerror, onclick, dst) dan skema javascript:/vbscript: di href/src
        // supaya <img>/<a>/<iframe> tidak jadi celah XSS.
        $html = preg_replace('/\s+on\w+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html) ?? $html;
        $html = preg_replace('/\b(href|src)(\s*=\s*)("|\')\s*(?:javascript|vbscript):[^"\']*\3/i', '$1$2$3$3', $html) ?? $html;
        // style cuma dipakai toolbar warna teks/background Quill — batasi ke dua
        // properti itu saja dengan nilai warna yang aman, buang sisanya (mis. CSS
        // yang coba nge-load url() eksternal).
        $html = $this->sanitizeStyleAttributes($html);

        return trim($html);
    }

    /**
     * <iframe> hasil tombol "video" Quill hanya diizinkan kalau src-nya domain
     * embed YouTube/Vimeo yang dikenal — dibangun ulang dari nol dengan atribut
     * minimal (bukan sekadar difilter) supaya atribut liar apa pun di tag aslinya
     * tidak ikut lolos. Selain itu, dibuang total.
     */
    private function sanitizeVideoEmbeds(string $html): string
    {
        return preg_replace_callback(
            '#<iframe\b[^>]*\bsrc\s*=\s*(["\'])(.*?)\1[^>]*>.*?</iframe>#is',
            function (array $m): string {
                $src = $m[2];
                $isAllowed = preg_match(
                    '#^https://(www\.)?(youtube\.com/embed/|youtube-nocookie\.com/embed/|player\.vimeo\.com/video/)#i',
                    $src
                );

                return $isAllowed
                    ? '<iframe class="ql-video" frameborder="0" allowfullscreen src="' . e($src) . '"></iframe>'
                    : '';
            },
            $html
        ) ?? $html;
    }

    /**
     * Batasi atribut style ke `color`/`background-color` dengan nilai hex/rgb()/nama
     * warna saja (persis yang dihasilkan color picker Quill) — properti CSS lain
     * dibuang semuanya.
     */
    private function sanitizeStyleAttributes(string $html): string
    {
        return preg_replace_callback('/\sstyle\s*=\s*"([^"]*)"/i', function (array $m): string {
            $safeDeclarations = [];

            foreach (explode(';', $m[1]) as $declaration) {
                if (preg_match(
                    '/^\s*(color|background-color)\s*:\s*(#[0-9a-f]{3,8}|rgb\(\s*\d{1,3}\s*,\s*\d{1,3}\s*,\s*\d{1,3}\s*\)|[a-z]+)\s*$/i',
                    $declaration,
                    $dm
                )) {
                    $safeDeclarations[] = $dm[1] . ': ' . $dm[2];
                }
            }

            return $safeDeclarations ? ' style="' . e(implode('; ', $safeDeclarations)) . '"' : '';
        }, $html) ?? $html;
    }

    private function imageFigure(string $imagePath, string $alt): string
    {
        return '<figure class="wp-block-image size-full">'
            . '<img loading="lazy" src="' . asset('assets' . $imagePath) . '" alt="' . e($alt) . '" style="object-fit:cover" />'
            . '</figure>';
    }

    private function buildArticleContent(string $imagePath, string $title, string $description): string
    {
        return $this->imageFigure($imagePath, $title) . $description;
    }

    /**
     * Struktur di sini SENGAJA disamakan persis (class demi class) dengan hasil
     * export Gutenberg produk lama (lihat mis. database/seeders/BlogPart6.php) —
     * bukan cuma "mirip". `.wp-block-group.is-layout-flex` itulah yang bikin
     * gambar & blok teks tampil sebelahan (flex row); tanpa class itu keduanya
     * cuma numpuk vertikal biasa. Konten dibangun ulang dari nol tiap kali produk
     * disimpan (create maupun update) supaya produk lama yang diedit lewat admin
     * ikut "diperbaiki" ke struktur standar ini juga, bukan cuma yang baru dibuat.
     */
    private function buildProductContent(string $imagePath, string $title, string $description): string
    {
        $waMessage = rawurlencode('Halo min Yen Bangunan, boleh saya tanya-tanya dulu seputar stok dan harga barangnya?');

        // style inline background/color di sini sengaja dipertahankan (bukan cuma
        // andalkan class .whatsapp-block__button) — tanpa ini teks tombol ikut
        // warna var(--prime) sama seperti background-nya, jadi teksnya tak kebaca.
        $whatsappBlock = '<div class="wp-block-jetpack-send-a-message whatsapp-product-desktop">'
            . '<div class="wp-block-jetpack-whatsapp-button whatsapp-button-desktop is-color-dark">'
            . '<a class="whatsapp-block__button" href="https://api.whatsapp.com/send?phone=6281315147952&amp;text=' . $waMessage . '" style="background-color:#25D366;color:#fff" target="_blank" rel="noopener noreferrer">Pesan Melalui Whatsapp</a>'
            . '</div></div>';

        return '<div class="wp-block-group alignwide product-content is-nowrap is-layout-flex wp-block-group-is-layout-flex">'
            . $this->imageFigure($imagePath, $title)
            . '<div class="wp-block-group has-global-padding is-layout-constrained wp-block-group-is-layout-constrained">'
            . $whatsappBlock
            . '<h2 class="wp-block-heading has-large-font-size">' . e($title) . '</h2>'
            . '<hr class="wp-block-separator has-css-opacity has-text-color has-primary-color has-alpha-channel-opacity has-primary-background-color is-style-wide" />'
            . '<h2 class="wp-block-heading has-medium-font-size">Deskripsi Produk</h2>'
            . $description
            . '</div></div>';
    }
}
