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
        return view('admin.dashboard');
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

        $blog = Blog::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'content' => $this->buildArticleContent($imagePath, $validated['title'], $validated['description']),
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

        $blog = Blog::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'content' => $this->buildProductContent($imagePath, $validated['title'], $validated['description']),
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
     */
    private function uniqueSlug(string $base): string
    {
        $slug = Str::slug($base);
        $original = $slug;
        $i = 2;

        while (Blog::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $i;
            $i++;
        }

        return $slug;
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
     * Deskripsi polos (textarea) -> paragraf HTML. Baris kosong ganda = paragraf baru.
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

    private function imageFigure(string $imagePath, string $alt): string
    {
        return '<figure class="wp-block-image size-full">'
            . '<img loading="lazy" src="' . asset('assets' . $imagePath) . '" alt="' . e($alt) . '" style="object-fit:cover" />'
            . '</figure>';
    }

    private function buildArticleContent(string $imagePath, string $title, string $description): string
    {
        return $this->imageFigure($imagePath, $title) . $this->descriptionToParagraphs($description);
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
            . $this->descriptionToParagraphs($description)
            . '</div>';
    }
}
