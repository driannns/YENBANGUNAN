<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Ulangi backfill kolom `type` (lihat 2026_07_24_012802_add_type_to_blogs_table).
     * Perlu dijalankan lagi karena database sempat di-restore dari dump yang
     * dibuat sebelum kolom `type` terisi, sehingga semua baris balik jadi NULL
     * dan halaman /blog & /product jadi kosong (query-nya filter by type).
     */
    public function up(): void
    {
        DB::table('blogs')->whereNull('type')->where('content', 'like', '%product-content%')->update(['type' => 'product']);
        DB::table('blogs')->whereNull('type')->update(['type' => 'article']);
    }

    public function down(): void
    {
        // Tidak ada rollback yang aman — bukan perubahan skema, cuma backfill data.
    }
};
