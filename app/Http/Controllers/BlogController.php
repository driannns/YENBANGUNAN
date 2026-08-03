<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Blog;
use App\Models\PageSetting;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function all(Request $request): View
    {
        // Articles only — product pages have their own menu (see products()).
        $blogs = Blog::where('type', 'article')
            ->orderBy('published_at', 'desc')
            ->paginate(12)
            ->withQueryString();
        return view('blog', compact('blogs'));
    }

    public function newBlog(): View
    {
        // Sama seperti all(): artikel saja, produk dikecualikan.
        $blogs = Blog::where('type', 'article')
            ->orderBy('published_at', 'desc')
            ->paginate(12)
            ->withQueryString();
        $page = PageSetting::resolvePage('blog');
        return view('new-blog', compact('blogs', 'page'));
    }

    public function products(): View
    {
        $products = Blog::where('type', 'product')
            ->orderBy('title')
            ->paginate(24)
            ->withQueryString();
        return view('product', compact('products'));
    }

    public function newProducts(Request $request): View
    {
        $kategori = $request->query('kategori');
        $search = trim((string) $request->query('search'));

        $query = Blog::where('type', 'product');

        if ($kategori) {
            $query->where('category', $kategori);
        }

        if ($search !== '') {
            $query->where('title', 'like', '%' . $search . '%');
        }

        $products = $query->orderBy('title')->paginate(24)->withQueryString();
        $page = PageSetting::resolvePage('product');

        return view('new-product', compact('products', 'kategori', 'search', 'page'));
    }

    /**
     * Konten lama (WordPress import): URL bertanggal /{year}/{month}/{day}/{slug}.
     */
    public function show(string $year, string $month, string $day, string $slug): View
    {
        $fullSlug = sprintf('%s/%s/%s/%s', $year, $month, $day, $slug);
        $blog = Blog::where('slug', $fullSlug)->firstOrFail();
        return view('blog-detail', compact('blog'));
    }

    /**
     * Produk baru (dibuat lewat /admin): URL pendek /{category}/{slug}.
     */
    public function showProduct(string $category, string $slug): View
    {
        $blog = Blog::where('category', $category)
            ->where('slug', $slug)
            ->where('type', 'product')
            ->firstOrFail();
        return view('blog-detail', compact('blog'));
    }

    /**
     * Artikel baru (dibuat lewat /admin): URL pendek /{slug}.
     */
    public function showArticle(string $slug): View
    {
        $blog = Blog::where('slug', $slug)
            ->where('type', 'article')
            ->firstOrFail();
        return view('blog-detail', compact('blog'));
    }
}
