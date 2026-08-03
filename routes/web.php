<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

// Halaman utama: didesain ulang di new-home, sekarang jadi halaman resmi di "/".
Route::get('/', function () {
    return view('new-home');
})->name('home');

Route::get('/new-home', function () {
    return view('new-home');
})->name('new-home');

Route::get('/new-product', [App\Http\Controllers\BlogController::class, 'newProducts'])->name('new-product');

Route::get('/new-gallery', function () {
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

    return view('new-gallery', compact('galleryImages'));
})->name('new-gallery');

Route::get('/new-blog', [App\Http\Controllers\BlogController::class, 'newBlog'])->name('new-blog');

Route::get('/new-aboutus', function () {
    return view('new-aboutus');
})->name('new-aboutus');

// Halaman lama: sekarang menampilkan desain baru (new-gallery/new-product/new-aboutus/new-blog).
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

    return view('new-gallery', compact('galleryImages'));
})->name('gallery');

Route::get('/product', [App\Http\Controllers\BlogController::class, 'newProducts'])->name('product');

Route::get('/about-us', function () {
    return view('new-aboutus');
})->name('about-us');

Route::get('/blog', [App\Http\Controllers\BlogController::class, 'newBlog'])->name('blog');
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

// Admin: pembuatan konten blog & produk. Middleware 'admin' = is_admin && !is_manager
// (lihat app/Http/Middleware/AdminMiddleware.php).
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\ContentController::class, 'dashboard'])->name('dashboard');
    Route::get('/blog/create', [App\Http\Controllers\Admin\ContentController::class, 'createBlog'])->name('blog.create');
    Route::post('/blog', [App\Http\Controllers\Admin\ContentController::class, 'storeBlog'])->name('blog.store');
    Route::get('/product/create', [App\Http\Controllers\Admin\ContentController::class, 'createProduct'])->name('product.create');
    Route::post('/product', [App\Http\Controllers\Admin\ContentController::class, 'storeProduct'])->name('product.store');

    // Daftar + edit/delete. Dibind lewat {blog:id} (bukan slug default model) karena
    // slug konten lama hasil import mengandung "/" (mis. "2026/05/03/xxx") yang tidak
    // bisa cocok dengan satu segmen URL {blog}.
    Route::get('/content', [App\Http\Controllers\Admin\ContentController::class, 'index'])->name('content.index');
    Route::get('/content/{blog:id}/edit', [App\Http\Controllers\Admin\ContentController::class, 'edit'])->name('content.edit');
    Route::put('/content/{blog:id}', [App\Http\Controllers\Admin\ContentController::class, 'update'])->name('content.update');
    Route::delete('/content/{blog:id}', [App\Http\Controllers\Admin\ContentController::class, 'destroy'])->name('content.destroy');

    // Edit teks template halaman listing Blog & Produk (judul, subjudul, meta
    // description, dan copy per kategori) — bukan konten per-artikel/produk.
    Route::get('/pages/blog', [App\Http\Controllers\Admin\PageSettingsController::class, 'editBlog'])->name('pages.blog.edit');
    Route::put('/pages/blog', [App\Http\Controllers\Admin\PageSettingsController::class, 'updateBlog'])->name('pages.blog.update');
    Route::get('/pages/product', [App\Http\Controllers\Admin\PageSettingsController::class, 'editProduct'])->name('pages.product.edit');
    Route::put('/pages/product', [App\Http\Controllers\Admin\PageSettingsController::class, 'updateProduct'])->name('pages.product.update');
});

require __DIR__.'/auth.php';

// ==========================================================================
// PERINGATAN: dua route di bawah ini HARUS TETAP jadi route PALING TERAKHIR
// di seluruh aplikasi (termasuk lebih akhir dari auth.php di atas). Keduanya
// wildcard generik untuk konten baru (dibuat lewat /admin) dengan URL pendek.
// Laravel mencocokkan route berurutan sesuai urutan registrasi — kalau ada
// route baru yang ditambahkan SETELAH baris ini, route itu tidak akan pernah
// tercapai karena keburu "ditelan" oleh wildcard {slug} di bawah.
// Tambahkan route baru SEBELUM blok ini, bukan sesudahnya.
// ==========================================================================

// Produk baru: /{category}/{slug} — dibatasi hanya kategori yang dikenal,
// supaya tidak bentrok dengan path lain yang kebetulan 2 segmen.
Route::get('/{category}/{slug}', [App\Http\Controllers\BlogController::class, 'showProduct'])
    ->where('category', implode('|', array_keys(config('product_categories'))))
    ->name('content.product.show');

// Artikel baru: /{slug} — aman karena semua route statis (login, admin, dashboard,
// dst) di atas sudah "mengklaim" duluan permintaan yang cocok dengan miliknya.
Route::get('/{slug}', [App\Http\Controllers\BlogController::class, 'showArticle'])
    ->name('content.blog.show');
