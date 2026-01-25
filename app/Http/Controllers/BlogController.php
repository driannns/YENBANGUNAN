<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function all(Request $request): View
    {
        $blogs = Blog::paginate(10);
        return view('blog', compact('blogs'));
    }

    public function show(string $year, string $month, string $day, string $slug): View
    {
        $fullSlug = sprintf('%s/%s/%s/%s', $year, $month, $day, $slug);
        $blog = Blog::where('slug', $fullSlug)->firstOrFail();
        return view('blog-detail', compact('blog'));
    }
}
