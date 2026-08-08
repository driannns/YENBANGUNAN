<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            // `image_path` tetap dipakai sebagai thumbnail di daftar blog/produk
            // (wajib diisi, tidak berubah). Kolom baru ini opsional, khusus untuk
            // gambar utama di halaman detail — kalau kosong, halaman detail
            // fallback ke `image_path` (lihat Blog::detailImagePath()).
            $table->string('detail_image_path')->nullable()->after('image_path');
        });

        // Backfill: semua baris yang sudah ada disamakan dulu (thumbnail == detail),
        // jadi tidak ada tampilan yang berubah untuk konten lama. Baru ke depannya,
        // lewat form admin, keduanya bisa diisi beda.
        DB::table('blogs')->update(['detail_image_path' => DB::raw('image_path')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('detail_image_path');
        });
    }
};
