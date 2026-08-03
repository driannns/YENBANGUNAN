<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageSettingsController extends Controller
{
    public function editBlog(): View
    {
        return view('admin.page-blog-edit', [
            'page' => PageSetting::resolvePage('blog'),
        ]);
    }

    public function updateBlog(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'meta_title' => ['required', 'string', 'max:255'],
            'meta_description' => ['required', 'string', 'max:500'],
            'heading' => ['required', 'string', 'max:255'],
            'subtitle' => ['required', 'string', 'max:2000'],
        ]);

        foreach ($validated as $field => $value) {
            PageSetting::set("blog.{$field}", $value);
        }

        return redirect()
            ->route('admin.pages.blog.edit')
            ->with('status', 'Halaman Blog berhasil diperbarui.');
    }

    public function editProduct(): View
    {
        return view('admin.page-product-edit', [
            'page' => PageSetting::resolvePage('product'),
        ]);
    }

    public function updateProduct(Request $request): RedirectResponse
    {
        $categorySlugs = array_keys(config('page_content_defaults.product.categories'));

        $validated = $request->validate([
            'meta_title' => ['required', 'string', 'max:255'],
            'meta_description' => ['required', 'string', 'max:500'],
            'heading' => ['required', 'string', 'max:255'],
            'subtitle' => ['required', 'string', 'max:2000'],
            'categories' => ['required', 'array'],
            'categories.*.label' => ['required', 'string', 'max:255'],
            'categories.*.copy' => ['required', 'string', 'max:2000'],
        ]);

        foreach (['meta_title', 'meta_description', 'heading', 'subtitle'] as $field) {
            PageSetting::set("product.{$field}", $validated[$field]);
        }

        foreach ($categorySlugs as $slug) {
            if (!isset($validated['categories'][$slug])) {
                continue;
            }
            PageSetting::set("product.category.{$slug}.label", $validated['categories'][$slug]['label']);
            PageSetting::set("product.category.{$slug}.copy", $validated['categories'][$slug]['copy']);
        }

        return redirect()
            ->route('admin.pages.product.edit')
            ->with('status', 'Halaman Produk berhasil diperbarui.');
    }
}
