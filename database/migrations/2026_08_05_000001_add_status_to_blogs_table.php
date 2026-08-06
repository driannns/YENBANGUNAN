<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            // 'active' tampil di halaman publik (list & detail blog/produk), 'archived'
            // disembunyikan tapi tetap ada di panel admin supaya bisa diaktifkan lagi.
            $table->string('status')->default('active')->index()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
