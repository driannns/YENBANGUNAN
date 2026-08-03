<?php

// Isi default halaman Blog & Produk (dipakai kalau admin belum pernah mengubahnya
// lewat menu "Edit Halaman"). Override tersimpan di tabel page_settings.

return [
    'blog' => [
        'meta_title' => 'Blog — Yen Bangunan',
        'meta_description' => 'Tips, panduan, dan informasi seputar material bangunan dan konstruksi dari Yen Bangunan Cikarang.',
        'heading' => 'Blog',
        'subtitle' => 'Tips, panduan, dan informasi terbaru seputar material bangunan dan dunia konstruksi dari Yen Bangunan.',
    ],

    'product' => [
        'meta_title' => 'Produk — Yen Bangunan',
        'meta_description' => 'Katalog produk Yen Bangunan: material bangunan dan kebutuhan industri di Cikarang.',
        'heading' => 'Semua Produk',
        'subtitle' => 'Lebih dari 5.000 SKU material bangunan dan kebutuhan industri dalam satu tempat — dari besi, semen, dan cat hingga perkakas serta consumable pabrik. Pilih kategori di atas untuk menelusuri produk sesuai kebutuhan proyek Anda.',
        'categories' => [
            'besi-dan-baja' => ['label' => 'Besi & Baja', 'copy' => 'Besi beton, hollow, siku, hingga baja ringan untuk kebutuhan struktural proyek Anda. Stok lengkap berbagai ukuran dengan kualitas SNI dan harga kompetitif.'],
            'hebel-dan-bata' => ['label' => 'Konstruksi', 'copy' => 'Bata ringan (hebel), bata merah, semen, mortar, dan material dinding & bangunan lainnya. Pilihan tepat untuk konstruksi cepat, rapi, dan efisien.'],
            'atap' => ['label' => 'Atap', 'copy' => 'Genteng, spandek, asbes, hingga aksesori atap. Lindungi bangunan Anda dengan material atap berkualitas dan tahan cuaca.'],
            'pipa-dan-sanitasi' => ['label' => 'Pipa & Sanitasi', 'copy' => 'Pipa PVC berbagai ukuran, fitting, kran, hingga perlengkapan sanitasi. Solusi lengkap instalasi air bersih dan pembuangan.'],
            'lampu-dan-kelistrikan' => ['label' => 'Lampu & Kelistrikan', 'copy' => 'Lampu, kabel, MCB, saklar, dan kebutuhan kelistrikan dari merek terpercaya. Aman untuk rumah maupun instalasi industri.'],
            'mesin' => ['label' => 'Mesin', 'copy' => 'Mesin dan peralatan pendukung proyek serta industri. Andal untuk pemakaian berat dengan layanan konsultasi pemilihan mesin.'],
            'perkakas' => ['label' => 'Perkakas', 'copy' => 'Perkakas tangan dan power tools dari brand ternama seperti Tekiro, Bosch, dan RYU. Lengkap untuk tukang profesional maupun kebutuhan rumahan.'],
            'paku-dan-baut' => ['label' => 'Paku & Baut', 'copy' => 'Paku, baut, mur, sekrup, dan fastener lainnya dalam berbagai ukuran. Tersedia satuan hingga partai besar.'],
            'consumable-industri' => ['label' => 'Consumable Industry', 'copy' => 'Material habis pakai kebutuhan pabrik dan industri: abrasive, lem, sealant, thinner, dan banyak lagi. Pasokan rutin siap mendukung produksi Anda.'],
            'safety' => ['label' => 'Safety Industry', 'copy' => 'Perlengkapan keselamatan kerja: helm proyek, sarung tangan, sepatu safety, hingga APD lengkap sesuai standar industri.'],
            'keramik-dan-granit' => ['label' => 'Keramik & Granit', 'copy' => 'Keramik dan granit berbagai motif dan ukuran untuk lantai maupun dinding. Percantik hunian dan bangunan komersial Anda.'],
            'cat' => ['label' => 'Cat', 'copy' => 'Cat tembok, cat kayu & besi, waterproofing, hingga thinner dari Nippon Paint, Dulux, Sika, dan merek terpercaya lainnya.'],
        ],
    ],
];
