<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/product', function () {
    return view('product');
})->name('product');

Route::get('/about-us', function () {
    return view('about-us');
})->name('about-us');

Route::get('/blog', [App\Http\Controllers\BlogController::class, 'all'])->name('blog');
Route::get('/{year}/{month}/{day}/{slug}', [App\Http\Controllers\BlogController::class, 'show'])
    ->where(['year' => '\\d{4}', 'month' => '\\d{2}', 'day' => '\\d{2}', 'slug' => '[^/]+'])
    ->name('blog.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
