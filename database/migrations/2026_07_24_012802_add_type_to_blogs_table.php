<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kolom type ('article'|'product') menggantikan deteksi string
     * "product-content" di dalam content. Backfill dari marker lama
     * supaya data existing tetap konsisten dengan query baru.
     */
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('type')->nullable()->index()->after('category');
        });

        DB::table('blogs')->where('content', 'like', '%product-content%')->update(['type' => 'product']);
        DB::table('blogs')->where('content', 'not like', '%product-content%')->update(['type' => 'article']);
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
