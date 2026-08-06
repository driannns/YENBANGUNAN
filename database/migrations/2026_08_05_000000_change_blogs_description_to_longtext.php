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
            // Editor Quill mengizinkan gambar disisipkan di tengah deskripsi —
            // `text` (limit ~64KB) terlalu kecil begitu ada beberapa <img> di dalamnya.
            $table->longText('description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
        });
    }
};
