<?php

// Kategori produk (slug => label). Dipakai oleh form admin (dropdown kategori),
// validasi Rule::in(), dan constraint route /{category}/{slug}. Daftar slug ini
// harus tetap sinkron dengan $categories di resources/views/new-product.blade.php
// (yang punya copywriting tambahan per kategori, jadi tidak dipakai langsung di sini).
return [
    'besi-dan-baja' => 'Besi & Baja',
    'hebel-dan-bata' => 'Konstruksi',
    'atap' => 'Atap',
    'pipa-dan-sanitasi' => 'Pipa & Sanitasi',
    'lampu-dan-kelistrikan' => 'Lampu & Kelistrikan',
    'mesin' => 'Mesin',
    'perkakas' => 'Perkakas',
    'paku-dan-baut' => 'Paku & Baut',
    'consumable-industri' => 'Consumable Industry',
    'safety' => 'Safety Industry',
    'keramik-dan-granit' => 'Keramik & Granit',
    'cat' => 'Cat',
];
