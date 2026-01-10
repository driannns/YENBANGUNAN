<?php

namespace App\Http\Controllers;
use Illuminate\View\View;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function all(Request $request): View
    {
        return view('blog');
    }
}
