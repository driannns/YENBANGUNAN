<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kategori produk (slug, mis. "besi-dan-baja") untuk blog product.
     * Null untuk artikel biasa. Diisi oleh seeder hasil generator.
     */
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('category')->nullable()->index()->after('image_path');
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
