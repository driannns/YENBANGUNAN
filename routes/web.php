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
    // Orders History
    Route::get('/orders-history', [App\Http\Controllers\OrderController::class, 'index'])->name('orders-history');
    Route::get('/orders-history/create', [App\Http\Controllers\OrderController::class, 'create'])->name('orders-history.create');
    Route::post('/orders-history', [App\Http\Controllers\OrderController::class, 'store'])->name('orders-history.store');
    Route::get('/orders-history/{order}/edit', [App\Http\Controllers\OrderController::class, 'edit'])->name('orders-history.edit');
    Route::put('/orders-history/{order}', [App\Http\Controllers\OrderController::class, 'update'])->name('orders-history.update');
    Route::delete('/orders-history/{order}', [App\Http\Controllers\OrderController::class, 'destroy'])->name('orders-history.destroy');
    Route::post('/orders-history/{order}/approve', [App\Http\Controllers\OrderController::class, 'approve'])->name('orders-history.approve');
    Route::post('/orders-history/{order}/reject', [App\Http\Controllers\OrderController::class, 'reject'])->name('orders-history.reject');

    // Loyalty
    Route::get('/loyalty-formula', [App\Http\Controllers\LoyaltyController::class, 'formula'])->name('loyalty.formula');
    Route::get('/loyalty-log', [App\Http\Controllers\LoyaltyController::class, 'log'])->name('loyalty.log');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
