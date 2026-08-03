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
            // Deskripsi mentah (plain text, textarea admin) sebelum dirender jadi
            // HTML di kolom `content`. Null untuk konten lama (import WordPress) —
            // form edit admin fallback ke strip_tags(content) untuk baris itu.
            $table->text('description')->nullable()->after('content');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};
