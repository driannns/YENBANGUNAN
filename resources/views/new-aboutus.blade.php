<!DOCTYPE html>
<html lang="id">

<head>
    @include('partials.analytics')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us — Yen Bangunan</title>
    <meta name="description" content="PT Yen Sejahtera — toko bangunan dan distributor kebutuhan pabrik terpercaya di Cikarang, Bekasi, dan Karawang sejak 2008.">
    <link rel="icon" href="{{ asset('assets/logo-crop.png') }}">

    {{-- Tipografi mengikuti total-prime.com (lihat catatan di new-home.blade.php) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500&family=Inter:wght@400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #060606;
            --bg-alt: #0a0a0a;
            --white: #fff;
            --white50: #ffffff80;
            --white35: #ffffff59;
            --white15: #ffffff26;
            --white5: #ffffff0d;
            --white2: #ffffff05;
            --prime: #e05534;
            --font-mono: 'Apercu Mono', 'IBM Plex Mono', ui-monospace, monospace;
            --font-text: 'Helvetica Now Text', 'Inter', 'Helvetica Neue', Arial, sans-serif;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            background-color: var(--bg);
            color: var(--white);
            font-family: var(--font-text);
            font-size: 16px;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        img { display: block; max-width: 100%; }
        a { color: inherit; text-decoration: none; }

        /* ===== Navbar (identik new-home) ===== */
        .navbar {
            position: fixed;
            inset: 0 0 auto;
            z-index: 999;
            padding: 0 3%;
            background-color: #0a0a0a80;
            -webkit-backdrop-filter: blur(20px);
            backdrop-filter: blur(20px);
        }

        .navbar .nav-inner {
            max-width: 1440px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 60px;
        }

        .navbar .logo { display: flex; align-items: center; height: 60px; padding-left: 10px; }
        .navbar .logo img { height: 18px; width: auto; }

        .nav-links { display: flex; align-items: center; }

        .nav-link {
            font-family: var(--font-mono);
            font-size: 14px;
            line-height: 20px;
            text-transform: uppercase;
            color: var(--white35);
            padding: 20px;
            display: inline-block;
            transition: color .2s;
        }

        .nav-link:hover, .nav-link.active { color: var(--white); }

        .menu-button {
            display: none;
            background: none;
            border: 0;
            color: var(--white);
            font-size: 24px;
            line-height: 1;
            cursor: pointer;
            padding: 18px;
        }

        .mobile-menu {
            display: flex;
            flex-direction: column;
            gap: 4px;
            max-height: 0;
            padding: 0;
            opacity: 0;
            overflow: hidden;
            transform: translateY(-8px);
            transition: max-height .3s ease, opacity .25s ease, transform .25s ease, padding .3s ease;
        }

        .mobile-menu.open {
            max-height: 320px;
            padding: 8px 0 16px;
            opacity: 1;
            transform: translateY(0);
        }

        .mobile-menu .nav-link { padding: 10px 4px; }

        @media (prefers-reduced-motion: reduce) {
            .mobile-menu { transition: none; }
        }

        /* ===== Hero teks — persis .hero-text referensi: pita full-bleed
           background var(--white2), konten center, margin-top 60px = tinggi navbar ===== */
        .about-hero {
            width: 100%;
            background-color: var(--white2);
            margin-top: 60px;
            padding: 20px 5% 40px;
            display: flex;
            justify-content: center;
        }

        .about-hero-inner { max-width: 800px; text-align: center; }

        /* .heading-product.h1.prime: mono 36px, oranye, uppercase, center */
        .page-title {
            font-family: var(--font-mono);
            font-size: 36px;
            font-weight: 400;
            line-height: 1.25em;
            text-transform: uppercase;
            color: var(--prime);
            margin-bottom: 14px;
        }

        /* .paragraph-product.product: Helvetica Now Text 16/24 white50, center */
        .page-sub {
            font-family: var(--font-text);
            font-size: 16px;
            line-height: 24px;
            color: var(--white50);
        }

        /* ===== Foto hero full-bleed + gradient fade-to-dark — persis
           .bg-hero + .gradient referensi (min-height 800px, sengaja tetap
           besar di semua device sesuai spesifikasi aslinya) ===== */
        .about-photo {
            position: relative;
            width: 100%;
            min-height: 800px;
            background-size: cover;
            background-position: 50% 35%;
        }

        .about-photo .fade {
            position: absolute;
            inset: 0;
            /* Referensi memakai stop 80% karena foto mereka sudah gelap dari
               awal (interior pabrik temaram). Foto kita terang (siang hari,
               beton + langit), jadi stop-nya dipercepat agar tetap gelap total
               pas menyentuh -700px overlap di bawah — mekanismenya sama persis,
               hanya dikalibrasi ulang untuk kecerahan foto yang berbeda. */
            background-image: linear-gradient(#0000 0%, #0a0a0a 42%, #0a0a0a 100%);
        }

        /* ===== Kolom info — persis .section-info: ditarik naik -700px agar
           konten "menyatu" ke bagian gelap ekor foto di atasnya. ===== */
        .about-overlap {
            position: relative;
            z-index: 2;
            margin-top: -700px;
            overflow: hidden;
        }

        .about-columns {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 5%;
        }

        /* .text-coloumn: Apercu Mono, white, lebar 80% dari kolomnya */
        .about-text-col p {
            font-family: var(--font-mono);
            font-size: 14px;
            line-height: 20px;
            color: var(--white);
            max-width: 80%;
            /* Jaga keterbacaan di bagian teks yang masih tumpang tindih
               dengan sisa foto (bukan sudah 100% gelap). */
            text-shadow: 0 1px 4px rgba(0, 0, 0, .6);
        }

        .about-text-col p + p { margin-top: 20px; }

        /* Info Jam Operasional & Lokasi — meniru pola OUR OFFICE/OUR FACTORY
           di footer referensi: label mono uppercase kecil + teks alamat. */
        .info-strip {
            max-width: 1100px;
            margin: 48px auto 0;
            padding: 32px 5% 0;
            border-top: 1px solid var(--white5);
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
        }

        .info-strip .item { display: flex; gap: 14px; align-items: flex-start; }
        .info-strip svg { width: 22px; height: 22px; flex: none; margin-top: 2px; color: var(--prime); }

        /* Item clickable (Lokasi) — hover memberi afordansi tanpa mengubah item lain */
        .info-strip a.item {
            border-radius: 10px;
            padding: 10px;
            margin: -10px;
            transition: background-color .2s, transform .2s;
        }

        .info-strip a.item:hover { background-color: var(--white5); transform: translateY(-2px); }
        .info-strip a.item:hover .text { color: var(--white); }

        .info-strip .label {
            font-family: var(--font-mono);
            font-size: 12px;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--prime);
            margin-bottom: 6px;
        }

        .info-strip .text {
            font-family: var(--font-text);
            font-size: 14px;
            line-height: 20px;
            color: var(--white50);
        }

        /* ===== Statistik ===== */
        .stats-grid {
            max-width: 1100px;
            margin: 56px auto 0;
            padding: 0 5%;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
        }

        .stat-card {
            background-color: var(--white2);
            border: 1px solid var(--white5);
            border-radius: 10px;
            padding: 24px 18px;
        }

        .stat-card .num { font-family: var(--font-mono); font-size: 32px; line-height: 1.25em; color: var(--white); }
        .stat-card .desc { font-family: var(--font-mono); font-size: 11px; letter-spacing: .06em; text-transform: uppercase; color: var(--white50); margin-top: 6px; }

        /* ===== "Why Choose" — persis slot .icon-grid referensi, tapi
           .icon-block.drive: bg var(--white2), radius 8, teks putih ===== */
        .why-section { position: relative; z-index: 3; max-width: 1100px; margin: 32px auto 0; padding: 24px 5% 0; text-align: center; }

        .why-section .page-title { margin-bottom: 10px; }
        .why-section .page-sub { max-width: 640px; margin: 0 auto; }

        .value-grid {
            max-width: 950px;
            margin: 40px auto 0;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            text-align: left;
        }

        .value-card {
            background-color: var(--white2);
            border: 1px solid var(--white5);
            border-radius: 8px;
            padding: 24px 20px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            transition: border-color .2s, background-color .2s, transform .2s;
        }

        .value-card:hover { border-color: var(--prime); background-color: var(--white5); transform: translateY(-2px); }
        .value-card svg { width: 30px; height: 30px; color: var(--prime); }

        .value-card .label {
            font-family: var(--font-mono);
            font-size: 12px;
            line-height: 16px;
            letter-spacing: .04em;
            text-transform: uppercase;
            color: var(--white);
        }

        .value-card .desc { font-family: var(--font-text); font-size: 13px; line-height: 19px; color: var(--white50); }

        /* ===== Marquee logo berjalan kontinu (Our Brands & Trusted By) —
           identik dengan new-home.blade.php agar konsisten site-wide. ===== */
        .brand-section { max-width: 1100px; margin: 90px auto 0; padding: 0 5%; }

        .brand-section .page-title { text-align: center; color: var(--white50); margin-bottom: 40px; }

        .marquee {
            overflow: hidden;
            background: #fff;
            border-radius: 8px;
            padding: 16px 0;
        }

        /* Varian gelap: logo SVG transparan langsung di atas latar web, tanpa panel putih */
        .marquee.dark { background: transparent; border-radius: 0; }

        .marquee-track {
            display: flex;
            align-items: center;
            width: max-content;
            animation: marqueeRun 45s linear infinite;
        }

        .marquee-track img { height: 46px; width: auto; margin-right: 56px; }

        .marquee.dark .marquee-track img { height: 88px; margin-right: 48px; transform: scale(1.5); }

        /* Vendor SVG lebih padat isinya (minim whitespace internal) — tanpa scale
           besar dan margin lebih lebar agar gap visualnya setara marquee Our Brands. */
        .marquee.dark.vendors .marquee-track img { height: 84px; margin-right: 64px; transform: none; }

        .marquee:hover .marquee-track { animation-play-state: paused; }

        @keyframes marqueeRun {
            to { transform: translateX(-50%); }
        }

        /* Logo dominan hitam: dibalik jadi putih agar tidak menyatu dengan latar gelap */
        .logo-inv { filter: invert(1); }
        .logo-inv-hue { filter: invert(1) hue-rotate(180deg); }

        @media (prefers-reduced-motion: reduce) {
            .marquee-track { animation: none; }
        }

        @media (max-width: 767px) {
            .marquee-track img { height: 36px; margin-right: 40px; }
            .marquee.dark .marquee-track img,
            .marquee.dark.vendors .marquee-track img { height: 56px; margin-right: 40px; }
        }

        /* ===== CTA Customer Service ===== */
        .about-cta { max-width: 640px; margin: 90px auto 0; padding: 0 0 90px; text-align: center; }

        .cta-contacts {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 24px;
        }
        .about-cta .page-sub { margin-bottom: 24px; }

        .button {
            font-family: var(--font-mono);
            font-size: 14px;
            font-weight: 500;
            line-height: 20px;
            text-transform: uppercase;
            color: var(--white);
            background-color: #1d1d1d;
            border: 1px solid var(--white15);
            border-radius: 8px;
            padding: 8px 28px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: border-color .2s, color .2s, background-color .2s;
        }

        .button svg { width: 20px; height: 20px; flex: none; }

        .button.prime { background-color: var(--prime); border-color: var(--prime); color: #fff; }
        .button.prime:hover { background-color: #c74628; }


        /* Reveal */
        body.reveal-ready .reveal:not(.in-view),
        body.reveal-ready .reveal-group>*:not(.in-view) { opacity: 0; transform: translateY(24px); }
        .reveal.in-view, .reveal-group>.in-view { animation: revealUp .55s ease-out; }
        @keyframes revealUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
        @media (prefers-reduced-motion: reduce) {
            body.reveal-ready .reveal:not(.in-view),
            body.reveal-ready .reveal-group>*:not(.in-view) { opacity: 1; transform: none; }
            .reveal.in-view, .reveal-group>.in-view { animation: none; }
        }

        /* ===== Floating WhatsApp — pojok kanan bawah, bouncing agar dinotice ===== */
        .whatsapp-float {
            position: fixed;
            right: calc(20px + env(safe-area-inset-right));
            bottom: calc(20px + env(safe-area-inset-bottom));
            z-index: 1000;
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #25D366;
            border-radius: 50%;
            box-shadow: 0 6px 20px rgba(0, 0, 0, .4);
            animation: waBounce 2.2s cubic-bezier(.28, .84, .42, 1) infinite;
            transition: transform .2s, background-color .2s;
        }

        .whatsapp-float:hover { background-color: #1ebd59; transform: scale(1.08); }
        .whatsapp-float svg { width: 28px; height: 28px; fill: #fff; }

        .whatsapp-float::before {
            content: '';
            position: absolute;
            inset: 0;
            z-index: -1;
            border-radius: 50%;
            background-color: rgba(37, 211, 102, .55);
            animation: waPulse 1.8s infinite;
        }

        @keyframes waBounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-14px); }
            60% { transform: translateY(-3px); }
        }

        @keyframes waPulse {
            0% { transform: scale(.9); opacity: 1; }
            100% { transform: scale(1.7); opacity: 0; }
        }

        @media (max-width: 767px) {
            .whatsapp-float { width: 48px; height: 48px; right: calc(14px + env(safe-area-inset-right)); bottom: calc(14px + env(safe-area-inset-bottom)); }
            .whatsapp-float svg { width: 24px; height: 24px; }
        }

        @media (prefers-reduced-motion: reduce) {
            .whatsapp-float { animation: none; }
            .whatsapp-float::before { animation: none; opacity: 0; }
        }

        /* ===== Responsive ===== */
        @media (max-width: 991px) {
            .nav-links .nav-link { display: none; }
            .menu-button { display: block; }
            .value-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 767px) {
            .page-title { font-size: 28px; }
            .about-text-col p { max-width: 100%; }
            .info-strip { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .about-cta { padding: 0 20px 90px; }
        }

        @media (max-width: 479px) {
            .value-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>
@include('partials.gtm-body')
    <a href="https://wa.link/3v66z0" target="_blank" rel="noopener" class="whatsapp-float" aria-label="Chat WhatsApp Yen Bangunan">
        <svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
        </svg>
    </a>

    @php
        // Daftar vendor — identik dengan new-home.blade.php agar konsisten site-wide.
        $vendors = [
            ['jababeka', ''], ['nissin', ''], ['elephant-gypsum', ''], ['meikarta', ''],
            ['lg', ''], ['lippo-malls', 'logo-inv-hue'], ['san-diego-hills', 'logo-inv-hue'],
            ['kalbio-global-medika', 'logo-inv-hue'], ['kalbe', 'logo-inv-hue'],
            ['bintang-toedjoe', ''], ['saka-farma', 'logo-inv-hue'], ['tempo-scan', ''],
        ];
    @endphp

    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-inner">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('assets/logo.png') }}" alt="Yen Bangunan">
            </a>
            <div class="nav-links">
                <a href="{{ route('home') }}" class="nav-link">Home</a>
                <a href="{{ route('product') }}" class="nav-link">Product</a>
                <a href="{{ route('about-us') }}" class="nav-link active">About</a>
                <a href="{{ route('gallery') }}" class="nav-link">Gallery</a>
                <a href="{{ route('blog') }}" class="nav-link">Blog</a>
                <button type="button" class="menu-button" id="menuButton" aria-label="Menu" aria-expanded="false">&#9776;</button>
            </div>
        </div>
        <div class="mobile-menu" id="mobileMenu">
            <a href="{{ route('home') }}" class="nav-link">Home</a>
            <a href="{{ route('product') }}" class="nav-link">Product</a>
            <a href="{{ route('about-us') }}" class="nav-link active">About</a>
            <a href="{{ route('gallery') }}" class="nav-link">Gallery</a>
            <a href="{{ route('blog') }}" class="nav-link">Blog</a>
        </div>
    </nav>

    <!-- Hero teks: persis .hero-text.about referensi -->
    <div class="about-hero reveal">
        <div class="about-hero-inner">
            <h1 class="page-title">About Us</h1>
        </div>
    </div>

    <!-- Foto full-bleed + gradient fade-to-dark: persis .bg-hero/.gradient referensi -->
    <div class="about-photo" style="background-image: url('{{ asset('assets/aboutus-wallpaper.jpg') }}')">
        <div class="fade"></div>
    </div>

    <!-- Kolom info yang "ditarik naik" ke ekor gelap foto: persis .section-info -700px -->
    <div class="about-overlap">
        <div class="about-columns reveal">
            <div class="about-text-col">
                <p>
                    PT Yen Sejahtera, berdiri sejak 2008 di Cikarang, memfokuskan diri pada perdagangan
                    material bangunan dan distribusi kebutuhan pabrik di Bekasi, Cikarang, dan Karawang.
                    Kami berkomitmen memberikan produk dan layanan terbaik, termasuk material bangunan,
                    listrik/elektronik, dan kebutuhan industri lainnya, dengan kepuasan pelanggan menjadi
                    prioritas utama.
                </p>
                <p>
                    Kami percaya pada solusi satu atap — menyediakan semua kebutuhan proyek dalam satu
                    tempat — serta membangun kemitraan yang kuat dengan pemasok dan mitra bisnis demi
                    pasokan produk yang konsisten.
                </p>
            </div>
        </div>

        <!-- Jam Operasional & Lokasi -->
        <div class="info-strip reveal-group">
            <div class="item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M12 7v5l3 3"/>
                </svg>
                <div>
                    <div class="label">Jam Operasional</div>
                    <div class="text">07:30 – 17:00 WIB<br>Setiap hari (Senin–Minggu)</div>
                </div>
            </div>
            <a href="https://share.google/h58GMBf1zUJg7OyqL" target="_blank" rel="noopener" class="item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 21s-7-6.4-7-11.5A7 7 0 0 1 19 9.5C19 14.6 12 21 12 21z"/>
                    <circle cx="12" cy="9.5" r="2.3"/>
                </svg>
                <div>
                    <div class="label">Lokasi</div>
                    <div class="text">Lippo Cikarang, Sukadami,<br>Cikarang Selatan, Kabupaten Bekasi, Jawa Barat 17530</div>
                </div>
            </a>
        </div>

        <!-- Statistik -->
        <div class="stats-grid reveal-group">
            <div class="stat-card">
                <div class="num" data-count-to="5000">0</div>
                <div class="desc">SKU Produk</div>
            </div>
            <div class="stat-card">
                <div class="num" data-count-to="700">0</div>
                <div class="desc">Projek</div>
            </div>
            <div class="stat-card">
                <div class="num" data-count-to="400">0</div>
                <div class="desc">Pelanggan</div>
            </div>
            <div class="stat-card">
                <div class="num" data-count-to="15">0</div>
                <div class="desc">Tahun Berpengalaman</div>
            </div>
        </div>
    </div>

    <!-- Why Choose Yen Bangunan: persis slot .icon-grid referensi -->
    <div class="why-section">
        <h1 class="page-title reveal">Why Choose Yen Bangunan?</h1>
        <p class="page-sub reveal">
            Yen Bangunan hadir sebagai one-stop solution terpercaya bagi kontraktor, pabrik, dan khususnya
            tim purchasing, dengan menyediakan kelengkapan kebutuhan serta harga kompetitif untuk memastikan
            efisiensi dan kemudahan dalam setiap pengadaan.
        </p>
        <div class="value-grid reveal-group">
            <div class="value-card">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 7h10v9H4zM14 10h3.5L20 13v3h-6"/>
                    <circle cx="7.5" cy="18" r="1.6"/><circle cx="16.5" cy="18" r="1.6"/>
                    <path d="M1 9h2M1 12h2"/>
                </svg>
                <div class="label">Free Delivery</div>
                <div class="desc">Layanan pengiriman gratis untuk area Cikarang, memastikan kemudahan dan efisiensi bagi setiap pelanggan.</div>
            </div>
            <div class="value-card">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M8 3h8v3H8z"/>
                    <rect x="6" y="5" width="12" height="16" rx="2"/>
                    <path d="M9 12h6M9 16h4"/>
                </svg>
                <div class="label">Request Order</div>
                <div class="desc">Menerima permintaan khusus untuk memenuhi kebutuhan pelanggan dalam satu tempat pengadaan.</div>
            </div>
            <div class="value-card">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="20" r="1.6"/><circle cx="17" cy="20" r="1.6"/>
                    <path d="M3 4h2l2.4 12h10.2L20 8H7"/>
                    <path d="M12 2v4m-2-2h4"/>
                </svg>
                <div class="label">All in One &amp; Competitive</div>
                <div class="desc">Semua kebutuhan material tersedia dalam satu tempat, dengan harga yang kompetitif.</div>
            </div>
            <div class="value-card">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 13a8 8 0 0 1 16 0"/>
                    <rect x="2.5" y="12" width="4" height="6" rx="1.5"/>
                    <rect x="17.5" y="12" width="4" height="6" rx="1.5"/>
                    <path d="M19.5 18v1a2 2 0 0 1-2 2h-3"/>
                    <rect x="12" y="20" width="3" height="2" rx="1"/>
                </svg>
                <div class="label">24 Hours Service</div>
                <div class="desc">Customer service 24 jam memastikan setiap kebutuhan pelanggan terpenuhi dengan cepat dan responsif.</div>
            </div>
        </div>
    </div>

    <!-- CTA Customer Service: 3 kontak sesuai halaman about-us existing -->
    <div class="about-cta reveal">
        <h1 class="page-title">Kebutuhan Proyek?</h1>
        <p class="page-sub">Konsultasi gratis dengan tim ahli Yen Bangunan. Chat WhatsApp, Gratis dan Cepat!</p>
        <div class="cta-contacts">
            <a href="https://wa.me/6281315147952?text=Hi%2C%20I%20got%20your%20WhatsApp%20information%20from%20your%20website." target="_blank" class="button prime">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path fill="rgb(255, 255, 255)" d="M476.9 161.1C435 119.1 379.2 96 319.9 96C197.5 96 97.9 195.6 97.9 318C97.9 357.1 108.1 395.3 127.5 429L96 544L213.7 513.1C246.1 530.8 282.6 540.1 319.8 540.1L319.9 540.1C442.2 540.1 544 440.5 544 318.1C544 258.8 518.8 203.1 476.9 161.1zM319.9 502.7C286.7 502.7 254.2 493.8 225.9 477L219.2 473L149.4 491.3L168 423.2L163.6 416.2C145.1 386.8 135.4 352.9 135.4 318C135.4 216.3 218.2 133.5 320 133.5C369.3 133.5 415.6 152.7 450.4 187.6C485.2 222.5 506.6 268.8 506.5 318.1C506.5 419.9 421.6 502.7 319.9 502.7zM421.1 364.5C415.6 361.7 388.3 348.3 383.2 346.5C378.1 344.6 374.4 343.7 370.7 349.3C367 354.9 356.4 367.3 353.1 371.1C349.9 374.8 346.6 375.3 341.1 372.5C308.5 356.2 287.1 343.4 265.6 306.5C259.9 296.7 271.3 297.4 281.9 276.2C283.7 272.5 282.8 269.3 281.4 266.5C280 263.7 268.9 236.4 264.3 225.3C259.8 214.5 255.2 216 251.8 215.8C248.6 215.6 244.9 215.6 241.2 215.6C237.5 215.6 231.5 217 226.4 222.5C221.3 228.1 207 241.5 207 268.8C207 296.1 226.9 322.5 229.6 326.2C232.4 329.9 268.7 385.9 324.4 410C359.6 425.2 373.4 426.5 391 423.9C401.7 422.3 423.8 410.5 428.4 397.5C433 384.5 433 373.4 431.6 371.1C430.3 368.6 426.6 367.2 421.1 364.5z"/></svg>
                Sales Project
            </a>
            <a href="https://wa.me/6281315147952?text=Hi%2C%20I%20got%20your%20WhatsApp%20information%20from%20your%20website." target="_blank" class="button prime">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path fill="rgb(255, 255, 255)" d="M476.9 161.1C435 119.1 379.2 96 319.9 96C197.5 96 97.9 195.6 97.9 318C97.9 357.1 108.1 395.3 127.5 429L96 544L213.7 513.1C246.1 530.8 282.6 540.1 319.8 540.1L319.9 540.1C442.2 540.1 544 440.5 544 318.1C544 258.8 518.8 203.1 476.9 161.1zM319.9 502.7C286.7 502.7 254.2 493.8 225.9 477L219.2 473L149.4 491.3L168 423.2L163.6 416.2C145.1 386.8 135.4 352.9 135.4 318C135.4 216.3 218.2 133.5 320 133.5C369.3 133.5 415.6 152.7 450.4 187.6C485.2 222.5 506.6 268.8 506.5 318.1C506.5 419.9 421.6 502.7 319.9 502.7zM421.1 364.5C415.6 361.7 388.3 348.3 383.2 346.5C378.1 344.6 374.4 343.7 370.7 349.3C367 354.9 356.4 367.3 353.1 371.1C349.9 374.8 346.6 375.3 341.1 372.5C308.5 356.2 287.1 343.4 265.6 306.5C259.9 296.7 271.3 297.4 281.9 276.2C283.7 272.5 282.8 269.3 281.4 266.5C280 263.7 268.9 236.4 264.3 225.3C259.8 214.5 255.2 216 251.8 215.8C248.6 215.6 244.9 215.6 241.2 215.6C237.5 215.6 231.5 217 226.4 222.5C221.3 228.1 207 241.5 207 268.8C207 296.1 226.9 322.5 229.6 326.2C232.4 329.9 268.7 385.9 324.4 410C359.6 425.2 373.4 426.5 391 423.9C401.7 422.3 423.8 410.5 428.4 397.5C433 384.5 433 373.4 431.6 371.1C430.3 368.6 426.6 367.2 421.1 364.5z"/></svg>
                Customer Service
            </a>
            <a href="https://wa.me/6285813601406?text=Hi%2C%20I%20got%20your%20WhatsApp%20information%20from%20your%20website." target="_blank" class="button prime">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path fill="rgb(255, 255, 255)" d="M476.9 161.1C435 119.1 379.2 96 319.9 96C197.5 96 97.9 195.6 97.9 318C97.9 357.1 108.1 395.3 127.5 429L96 544L213.7 513.1C246.1 530.8 282.6 540.1 319.8 540.1L319.9 540.1C442.2 540.1 544 440.5 544 318.1C544 258.8 518.8 203.1 476.9 161.1zM319.9 502.7C286.7 502.7 254.2 493.8 225.9 477L219.2 473L149.4 491.3L168 423.2L163.6 416.2C145.1 386.8 135.4 352.9 135.4 318C135.4 216.3 218.2 133.5 320 133.5C369.3 133.5 415.6 152.7 450.4 187.6C485.2 222.5 506.6 268.8 506.5 318.1C506.5 419.9 421.6 502.7 319.9 502.7zM421.1 364.5C415.6 361.7 388.3 348.3 383.2 346.5C378.1 344.6 374.4 343.7 370.7 349.3C367 354.9 356.4 367.3 353.1 371.1C349.9 374.8 346.6 375.3 341.1 372.5C308.5 356.2 287.1 343.4 265.6 306.5C259.9 296.7 271.3 297.4 281.9 276.2C283.7 272.5 282.8 269.3 281.4 266.5C280 263.7 268.9 236.4 264.3 225.3C259.8 214.5 255.2 216 251.8 215.8C248.6 215.6 244.9 215.6 241.2 215.6C237.5 215.6 231.5 217 226.4 222.5C221.3 228.1 207 241.5 207 268.8C207 296.1 226.9 322.5 229.6 326.2C232.4 329.9 268.7 385.9 324.4 410C359.6 425.2 373.4 426.5 391 423.9C401.7 422.3 423.8 410.5 428.4 397.5C433 384.5 433 373.4 431.6 371.1C430.3 368.6 426.6 367.2 421.1 364.5z"/></svg>
                Purchasing
            </a>
        </div>
    </div>

    <!-- Trusted By: marquee (konten "OUr clientS" di halaman about-us existing) -->
    <div class="brand-section" style="margin-bottom: 90px">
        <h1 class="page-title reveal">Trusted By</h1>
        <div class="marquee dark vendors reveal">
            <div class="marquee-track">
                {{-- dua salinan berurutan agar loop translateX(-50%) mulus tanpa celah --}}
                @for($i = 0; $i < 2; $i++)
                @foreach($vendors as [$vendor, $cls])
                <img src="{{ asset('assets/vendors/' . $vendor . '.svg') }}" alt="{{ ucwords(str_replace('-', ' ', $vendor)) }}" class="{{ $cls }}" loading="lazy">
                @endforeach
                @endfor
            </div>
        </div>
    </div>

    @include('partials.site-footer')

    <script>
        (function () {
            var btn = document.getElementById('menuButton');
            var menu = document.getElementById('mobileMenu');
            if (!btn || !menu) return;
            btn.addEventListener('click', function () {
                var open = menu.classList.toggle('open');
                btn.setAttribute('aria-expanded', open ? 'true' : 'false');
            });
        })();

        (function () {
            if (!('IntersectionObserver' in window)) return;
            document.body.classList.add('reveal-ready');
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (!entry.isIntersecting) return;
                    var el = entry.target;
                    if (el.classList.contains('reveal-group')) {
                        Array.prototype.forEach.call(el.children, function (child, i) {
                            setTimeout(function () { child.classList.add('in-view'); }, Math.min(i * 60, 500));
                        });
                    } else {
                        el.classList.add('in-view');
                    }
                    io.unobserve(el);
                });
            }, { threshold: 0.05, rootMargin: '0px 0px -20px 0px' });
            document.querySelectorAll('.reveal, .reveal-group').forEach(function (el) { io.observe(el); });
        })();

        (function () {
            var nums = document.querySelectorAll('.stat-card .num[data-count-to]');
            if (!nums.length) return;

            function animateCount(el) {
                var target = parseInt(el.getAttribute('data-count-to'), 10);
                if (!target) return;
                var duration = 3000;
                var start = null;
                function step(ts) {
                    if (!start) start = ts;
                    var progress = Math.min((ts - start) / duration, 1);
                    var eased = 1 - Math.pow(1 - progress, 3);
                    el.textContent = Math.round(target * eased).toLocaleString('id-ID') + '+';
                    if (progress < 1) requestAnimationFrame(step);
                }
                requestAnimationFrame(step);
            }

            if (!('IntersectionObserver' in window)) {
                nums.forEach(animateCount);
                return;
            }

            var counterIo = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (!entry.isIntersecting) return;
                    animateCount(entry.target);
                    counterIo.unobserve(entry.target);
                });
            }, { threshold: 0.4 });
            nums.forEach(function (el) { counterIo.observe(el); });
        })();
    </script>
</body>

</html>
