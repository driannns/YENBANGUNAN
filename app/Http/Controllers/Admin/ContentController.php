<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
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

        $items = Blog::query()
            ->when($type, fn ($q) => $q->where('type', $type))
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.content-index', [
            'items' => $items,
            'type' => $type,
        ]);
    }

    public function edit(Blog $blog): View
    {
        $view = $blog->type === 'product' ? 'admin.product-edit' : 'admin.blog-edit';

        $description = $blog->description ?? trim(strip_tags($blog->content));
        // Deskripsi lama (sebelum pakai Trix) tersimpan sebagai plain text —
        // ubah jadi paragraf HTML dulu supaya baris/paragraf tetap kebaca saat dibuka di Trix.
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

        $description = $this->sanitizeDescriptionHtml($validated['description']);
        $content = $isProduct
            ? $this->buildProductContent($imagePath, $validated['title'], $description)
            : $this->buildArticleContent($imagePath, $validated['title'], $description);

        $blog->update([
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $description,
            'content' => $content,
            'image_path' => $imagePath,
            'category' => $isProduct ? $validated['category'] : null,
        ]);

        $redirect = $isProduct
            ? route('content.product.show', ['category' => $blog->category, 'slug' => $blog->slug])
            : route('content.blog.show', ['slug' => $blog->slug]);

        return redirect($redirect)->with('status', '"' . $blog->title . '" berhasil diperbarui.');
    }

    public function destroy(Blog $blog): RedirectResponse
    {
        $title = $blog->title;
        $imagePath = $blog->image_path;

        $blog->delete();

        $this->deleteImageIfOrphaned($imagePath, null);

        return redirect()
            ->route('admin.content.index')
            ->with('status', 'Konten "' . $title . '" berhasil dihapus.');
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
        ]);

        $slug = $this->uniqueSlug(($validated['slug'] ?? '') ?: $validated['title']);
        $imagePath = $this->storeImage($request->file('image'), $slug);
        $description = $this->sanitizeDescriptionHtml($validated['description']);

        $blog = Blog::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'content' => $this->buildArticleContent($imagePath, $validated['title'], $description),
            'description' => $description,
            'image_path' => $imagePath,
            'category' => null,
            'type' => 'article',
            'published_at' => now(),
            'author_id' => auth()->id(),
        ]);

        return redirect()
            ->route('content.blog.show', ['slug' => $blog->slug])
            ->with('status', 'Artikel "' . $blog->title . '" berhasil dibuat.');
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

        return redirect()
            ->route('content.product.show', ['category' => $blog->category, 'slug' => $blog->slug])
            ->with('status', 'Produk "' . $blog->title . '" berhasil dibuat.');
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

        $stillUsed = Blog::where('image_path', $imagePath)
            ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
            ->exists();

        if ($stillUsed) {
            return;
        }

        $fullPath = public_path('assets' . $imagePath);
        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }

    /**
     * Simpan file langsung ke public/assets/blog, mengikuti konvensi yang
     * sudah dipakai konten hasil import WordPress (tanpa storage:link).
     */
    private function storeImage(UploadedFile $file, string $slug): string
    {
        $extension = strtolower($file->extension() ?: 'jpg');
        $filename = $slug . '-' . time() . '.' . $extension;

        $file->move(public_path('assets/blog'), $filename);

        return '/blog/' . $filename;
    }

    /**
     * Deskripsi polos (dari data lama sebelum pakai Trix) -> paragraf HTML.
     * Baris kosong ganda = paragraf baru. Dipakai untuk mengisi Trix saat edit konten lama.
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
     * Batasi HTML hasil Trix ke tag yang bisa dihasilkan toolbar-nya saja
     * (bold/italic/strike/link/heading/quote/code/list), buang sisanya (script, dst).
     */
    private function sanitizeDescriptionHtml(string $html): string
    {
        // Buang seluruh tag berbahaya (script, style, dst) BESERTA isinya dulu,
        // baru batasi sisanya ke tag yang bisa dihasilkan toolbar Trix.
        $html = preg_replace('#<(script|style|iframe|object|embed)\b[^>]*>.*?</\1>#is', '', $html) ?? $html;

        return trim(strip_tags($html, '<div><p><br><strong><em><del><a><ul><ol><li><blockquote><pre><h1>'));
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

    private function buildProductContent(string $imagePath, string $title, string $description): string
    {
        $waMessage = rawurlencode('Halo min Yen Bangunan, boleh saya tanya-tanya dulu seputar stok dan harga barangnya?');

        $whatsappBlock = '<div class="wp-block-jetpack-send-a-message whatsapp-product-desktop">'
            . '<div class="wp-block-jetpack-whatsapp-button whatsapp-button-desktop is-color-dark">'
            . '<a class="whatsapp-block__button" href="https://api.whatsapp.com/send?phone=6281315147952&amp;text=' . $waMessage . '" target="_blank" rel="noopener noreferrer">Pesan Melalui Whatsapp</a>'
            . '</div></div>';

        return '<div class="wp-block-group alignwide product-content">'
            . $this->imageFigure($imagePath, $title)
            . $whatsappBlock
            . '<h2 class="wp-block-heading has-medium-font-size">Deskripsi Produk</h2>'
            . $description
            . '</div>';
    }
}
