<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seeds every blog post exported from WordPress.
 *
 * The posts themselves live in the generated BlogPart* seeders; this one only
 * runs them in order. Regenerate them with
 * database/seeders/generator/gen_blog_seeders.py rather than editing by hand.
 */
class Blog extends Seeder
{
    public function run(): void
    {
        $this->call([
            BlogPart1::class,
            BlogPart2::class,
            BlogPart3::class,
            BlogPart4::class,
            BlogPart5::class,
            BlogPart6::class,
            BlogPart7::class,
            BlogPart8::class,
            BlogPart9::class,
            BlogPart10::class,
        ]);

        // BlogPart* dibuat dari export WordPress sebelum kolom `type` ada, jadi
        // tidak diisi di sana — backfill di sini supaya /blog dan /product tetap
        // kedeteksi setiap kali seeder ini dijalankan ulang (mis. migrate:fresh --seed).
        DB::table('blogs')->whereNull('type')->where('content', 'like', '%product-content%')->update(['type' => 'product']);
        DB::table('blogs')->whereNull('type')->update(['type' => 'article']);
    }
}
