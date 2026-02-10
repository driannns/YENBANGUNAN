<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $galleryDir = public_path('assets/galery');
    $galleryImages = [];
            if (File::exists($galleryDir)) {
        $galleryImages = collect(File::files($galleryDir))
            ->filter(function ($file) {
                return in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp']);
            })
            ->sortBy(function ($file) {
                return $file->getFilename();
            })
            ->values()
            ->map(function ($file) {
                return asset('assets/galery/' . $file->getFilename());
            })
            ->take(15)
            ->all();
    }
    // dd( $galleryImages);
    return view('welcome', compact('galleryImages'));
})->name('home');

Route::get('/gallery', function () {
    $galleryDir = public_path('assets/galery');
    $galleryImages = [];
    if (File::exists($galleryDir)) {
        $galleryImages = collect(File::files($galleryDir))
            ->filter(function ($file) {
                return in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp']);
            })
            ->sortBy(function ($file) {
                return $file->getFilename();
            })
            ->values()
            ->map(function ($file) {
                return asset('assets/galery/' . $file->getFilename());
            })
            ->all();
    }

    return view('gallery', compact('galleryImages'));
})->name('gallery');

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

Route::get('/promotion-program', [App\Http\Controllers\LoyaltyController::class, 'promotionProgram'])->name('loyalty.promotion-program');


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
    Route::post('/orders-history/{order}/void-approve', [App\Http\Controllers\OrderController::class, 'voidApprove'])->name('orders-history.void-approve');
    Route::post('/orders-history/{order}/void-reject', [App\Http\Controllers\OrderController::class, 'voidReject'])->name('orders-history.void-reject');

    // Loyalty
    Route::get('/loyalty-formula', [App\Http\Controllers\LoyaltyController::class, 'formula'])->name('loyalty.formula');
    Route::get('/loyalty-log', [App\Http\Controllers\LoyaltyController::class, 'log'])->name('loyalty.log');
    // Route::get('/redeem-points', [App\Http\Controllers\LoyaltyController::class, 'redeem'])->name('loyalty.redeem');
    Route::post('/redeem-points', [App\Http\Controllers\LoyaltyController::class, 'processRedeem'])->name('loyalty.redeem.process');
    Route::post('/redeem/{id}/approve', [App\Http\Controllers\LoyaltyController::class, 'approveRedeem'])->name('loyalty.redeem.approve');
    Route::post('/redeem/{id}/reject', [App\Http\Controllers\LoyaltyController::class, 'rejectRedeem'])->name('loyalty.redeem.reject');
    Route::post('/redeem/{id}/cancel', [App\Http\Controllers\LoyaltyController::class, 'cancelRedeem'])->name('loyalty.redeem.cancel');
    Route::post('/redeem-items', [App\Http\Controllers\LoyaltyController::class, 'storeRedeemItem'])->name('redeem-items.store');
    Route::put('/redeem-items/{redeemItem}', [App\Http\Controllers\LoyaltyController::class, 'updateRedeemItem'])->name('redeem-items.update');
    Route::delete('/redeem-items/{redeemItem}', [App\Http\Controllers\LoyaltyController::class, 'destroyRedeemItem'])->name('redeem-items.destroy');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
