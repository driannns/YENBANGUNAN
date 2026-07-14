<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Seeds every blog post exported from WordPress.
 *
 * The posts themselves live in the generated BlogPart* seeders; this one only
 * runs them in order. Regenerate those parts from the export rather than
 * editing them by hand.
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
    }
}
