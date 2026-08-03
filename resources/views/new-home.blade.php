<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Yen Bangunan — One-Stop Solution untuk Konstruksi</title>
    <meta name="description" content="Toko bangunan dan material terlengkap di Cikarang. Lebih dari 5.000 SKU, gratis ongkir, layanan 24 jam.">
    <link rel="icon" href="{{ asset('assets/logo-crop.png') }}">

    {{-- Tipografi mengikuti total-prime.com: Apercu Mono + Helvetica Now Text.
         Keduanya font komersial, jadi dipakai lewat stack dengan fallback bebas
         yang paling mendekati (IBM Plex Mono & Inter). Ukuran font disamakan persis. --}}
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

        img, video { display: block; max-width: 100%; }
        a { color: inherit; text-decoration: none; }

        /* ===== Skala tipografi (persis total-prime.com) ===== */
        .h1 {
            font-family: var(--font-mono);
            font-size: 36px;
            font-weight: 400;
            line-height: 1.25em;
            text-transform: uppercase;
            margin-bottom: 18px;
        }

        .p-large {
            font-family: var(--font-mono);
            font-size: 24px;
            line-height: 1.35em;
            color: var(--white50);
        }

        .p-normal {
            font-family: var(--font-mono);
            font-size: 16px;
            color: var(--white50);
        }

        /* .page-title/.page-sub: identik dengan new-aboutus, dipakai di section "Kebutuhan Proyek?" */
        .page-title {
            font-family: var(--font-mono);
            font-size: 36px;
            font-weight: 400;
            line-height: 1.25em;
            text-transform: uppercase;
            color: var(--prime);
            margin-bottom: 14px;
        }

        .page-sub {
            font-family: var(--font-text);
            font-size: 16px;
            line-height: 24px;
            color: var(--white50);
        }

        .p-text { font-family: var(--font-text); font-size: 16px; color: var(--white50); }

        .caption {
            font-family: var(--font-mono);
            font-size: 12px;
            line-height: 16px;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--prime);
            display: block;
            margin-bottom: 14px;
        }

        .learn {
            font-family: var(--font-mono);
            font-size: 10px;
            line-height: 14px;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--prime);
            display: inline-block;
            margin-top: 24px;
            border-bottom: 1px solid transparent;
            transition: border-color .2s;
        }

        .learn:hover { border-color: var(--prime); }

        /* ===== Navbar (mengikuti referensi: fixed, blur, link mono tanpa CTA) ===== */
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

        /* Persis referensi: brand 60px flex + padding-left 10px (w-nav-brand);
           logo dikecilkan ke footprint logo referensi (±126px lebar natural). */
        .navbar .logo { display: flex; align-items: center; height: 60px; padding-left: 10px; }
        .navbar .logo img { height: 18px; width: auto; }

        .nav-links { display: flex; align-items: center; }

        /* Persis referensi: Apercu Mono, 14px/20px (base Webflow),
           padding 20px per link sebagai spacing, tanpa letter-spacing. */
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

        .button:hover { border-color: var(--prime); color: var(--prime); }

        .button.prime { background-color: var(--prime); border-color: var(--prime); color: #fff; }
        .button.prime:hover { background-color: #c74628; color: #fff; }

        .cta-contacts {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 24px;
        }

        /* ===== Sections ===== */
        .section {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 100px 5% 100px;
        }

        .text-box { max-width: 650px; position: relative; }

        .container { width: 100%; max-width: 1200px; margin: 0 auto; }

        /* ===== Hero slider (mengikuti referensi: kotak rounded di bawah navbar,
           grid 2 kolom #0a0a0a, autoplay, panah + dots) ===== */
        .header-home {
            margin-top: 60px;
            padding: 12px 3%;
        }

        .hero-slider {
            max-width: 1440px;
            margin: 0 auto;
            position: relative;
        }

        .hero-slider .mask {
            overflow: hidden;
            border-radius: 8px;
        }

        .hero-slider .track {
            display: flex;
            transition: transform .5s ease;
        }

        .hero-slider .slide { flex: 0 0 100%; min-width: 100%; }

        .hero-grid {
            position: relative;
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 0;
            background-color: transparent;
            min-height: 560px;
        }

        .spline-scene { position: absolute; inset: 0; }

        .spline-scene iframe {
            display: block;
            width: 100%;
            height: 100%;
            border: 0;
        }

        .text-box-500 {
            position: relative;
            z-index: 2;
            max-width: 500px;
            margin: 40px;
            pointer-events: none;
        }

        .text-box-500 a, .text-box-500 .button { pointer-events: auto; }

        .hero-brands {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 26px 30px;
            align-items: center;
            margin: 48px 40px;
        }

        /* scale() memperbesar tampilan logo untuk mengompensasi whitespace bawaan
           di dalam file SVG; bleed-nya (~11px) tetap lebih kecil dari gap grid. */
        .hero-brands img { width: 100%; max-height: 62px; object-fit: contain; transform: scale(1.6); }

        .hero-brands-collage { position: relative; z-index: 2; margin: 48px 40px; }
        .hero-brands-collage img { display: block; width: 100%; height: auto; object-fit: contain; }

        /* Logo dominan hitam: dibalik jadi putih agar tidak menyatu dengan latar gelap */
        .logo-inv { filter: invert(1); }
        /* Invert + hue-rotate: kotak putihnya jadi hitam (menyatu latar), warna logo kembali */
        .logo-inv-hue { filter: invert(1) hue-rotate(180deg); }

        /* Panah + dots slider */
        .slider-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 5;
            background: none;
            border: 0;
            color: var(--white50);
            font-size: 30px;
            line-height: 1;
            padding: 14px;
            cursor: pointer;
            transition: color .2s;
        }

        .slider-arrow:hover { color: var(--white); }

        .slider-arrow.prev { left: 6px; }
        .slider-arrow.next { right: 6px; }

        .slide-nav {
            position: absolute;
            bottom: 14px;
            left: 0;
            right: 0;
            z-index: 5;
            display: flex;
            justify-content: center;
            gap: 6px;
        }

        .slide-dot {
            width: 1em;
            height: 1em;
            border-radius: 2px;
            border: 0;
            padding: 0;
            background-color: #fff6;
            cursor: pointer;
            transition: background-color .15s;
        }

        .slide-dot.active { background-color: #fff; }

        /* Section about — persis section-info di total-prime.com/about:
           teks Apercu Mono 14px/20px putih (inherit body Webflow) lebar 80%,
           mengecil ke 12px/16px di mobile (.paragraph-3), foto 80% mix-blend screen. */
        .about-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: flex-start;
        }

        .about-info .about-text {
            width: 80%;
            margin: 0 auto 40px;
            font-family: var(--font-mono);
            font-size: 14px;
            line-height: 20px;
            color: var(--white);
        }

        .about-info .about-img { display: flex; justify-content: center; }

        .about-info .about-img img { width: 80%; mix-blend-mode: screen; }

        /* Marquee logo berjalan kontinu (Our Brands & Trusted By) */
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


        @media (prefers-reduced-motion: reduce) {
            .marquee-track { animation: none; }
        }

        /* Grid kategori clickable (pengganti copywriting "Sedang Membangun?") */
        .cat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }

        .cat-card {
            background-color: var(--white2);
            border: 1px solid var(--white5);
            border-radius: 10px;
            padding: 18px 16px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
            transition: border-color .2s, background-color .2s, transform .2s;
        }

        .cat-card:hover {
            border-color: var(--prime);
            background-color: var(--white5);
            transform: translateY(-2px);
        }

        .cat-card img {
            width: 36px;
            height: 36px;
            object-fit: contain;
            filter: grayscale(1) brightness(2);
            opacity: .85;
        }

        .cat-card .label {
            font-family: var(--font-mono);
            font-size: 12px;
            line-height: 1.5;
            text-transform: uppercase;
            color: var(--white);
            margin-top: auto;
        }

        /* Grid layanan 2x2 (kartu clickable, ikon SVG inline) */
        .svc-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }

        .svc-card {
            background-color: var(--white2);
            border: 1px solid var(--white5);
            border-radius: 10px;
            padding: 26px 22px;
            min-height: 190px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 20px;
        }

        .svc-card svg {
            width: 44px;
            height: 44px;
            color: var(--white50);
        }

        .svc-card .label {
            font-family: var(--font-mono);
            font-size: 16px;
            line-height: 1.5;
            text-transform: uppercase;
            color: var(--white50);
        }

        /* Feature dua kolom */
        .feature {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            align-items: center;
        }

        .feature .media {
            border-radius: 12px;
            overflow: hidden;
            background-color: var(--white2);
        }

        .feature .media img { width: 100%; height: 100%; max-height: 520px; object-fit: cover; }


        /* Grid kartu (produk / layanan) — gap 8px seperti referensi */
        .grid {
            display: grid;
            gap: 8px;
        }

        .grid.services { grid-template-columns: repeat(4, 1fr); }











        /* Trusted by: marquee klien satu baris (perilaku sama dengan Our Brands) */

        /* ===== Reveal (fade + slide-up halus) ===== */
        body.reveal-ready .reveal:not(.in-view),
        body.reveal-ready .reveal-group>*:not(.in-view) { opacity: 0; transform: translateY(24px); }

        .reveal.in-view, .reveal-group>.in-view { animation: revealUp .6s ease-out; }

        @keyframes revealUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (prefers-reduced-motion: reduce) {
            body.reveal-ready .reveal:not(.in-view),
            body.reveal-ready .reveal-group>*:not(.in-view) { opacity: 1; transform: none; }
            .reveal.in-view, .reveal-group>.in-view { animation: none; }
        }

        /* ===== Responsive ===== */
        @media (max-width: 991px) {
            /* Referensi pakai collapse "medium": hamburger mulai 991px */
            .nav-links .nav-link { display: none; }
            .menu-button { display: block; }
            .hero-grid { grid-template-columns: 1fr; min-height: 520px; }
            .hero-brands { margin-top: 0; }
            .hero-brands-collage { margin-top: 0; }
            .marquee-track img { height: 36px; margin-right: 40px; }
        }

        @media (max-width: 767px) {
            /* Interaksi 3D dimatikan di layar sentuh: script-nya mencegah
               scroll saat disentuh, pengunjung bisa terjebak di tengah halaman. */
            .spline-scene iframe { pointer-events: none; }
            .text-box-500 { margin: 28px 22px; }
            .hero-brands { margin: 0 22px 48px; }
            .hero-brands-collage { margin: 0 22px 48px; }
            .slider-arrow { display: none; }
            .h1 { font-size: 28px; }
            .p-large { font-size: 20px; }
            .feature { grid-template-columns: 1fr; }
            .about-info { grid-template-columns: 1fr; }
            .about-info .about-text { font-size: 12px; line-height: 16px; }
            .section { padding: 70px 6%; }
        }

        @media (max-width: 479px) {
            .cat-grid { grid-template-columns: repeat(2, 1fr); }
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

        /* Cincin pulse lembut di belakang tombol, ikut menarik perhatian */
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
            .whatsapp-float {
                width: 48px;
                height: 48px;
                right: calc(14px + env(safe-area-inset-right));
                bottom: calc(14px + env(safe-area-inset-bottom));
            }

            .whatsapp-float svg { width: 24px; height: 24px; }
        }

        @media (prefers-reduced-motion: reduce) {
            .whatsapp-float { animation: none; }
            .whatsapp-float::before { animation: none; opacity: 0; }
        }
    </style>
</head>

<body>
    <a href="https://wa.link/3v66z0" target="_blank" rel="noopener" class="whatsapp-float" aria-label="Chat WhatsApp Yen Bangunan">
        <svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
        </svg>
    </a>

    @php
        // Daftar brand (SVG di public/assets/brand). Kelas kedua: treatment untuk logo
        // dominan hitam agar terlihat di latar gelap.
        $brands = [
            ['tekiro', 'logo-inv-hue'], ['rexco', ''], ['indocement', ''], ['broco', ''],
            ['nippon-paint', ''], ['dekson', ''], ['jakarta-cement', ''], ['penguin', 'logo-inv'],
            ['american-standard', 'logo-inv'], ['titanium', ''], ['sika', ''], ['semen-gresik', ''],
            ['ryu', ''], ['onda', ''], ['bosch', ''], ['asia-tile', ''],
            ['semen-garuda', ''], ['bital', ''], ['gys', ''], ['dulux', ''],
            ['in-lite', ''], ['hannochs', ''], ['infiniti', ''], ['kansai-paint', ''],
        ];

        // Klien/vendor untuk Trusted By (SVG di public/assets/vendors).
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
                <a href="{{ route('home') }}" class="nav-link active">Home</a>
                <a href="{{ route('product') }}" class="nav-link">Product</a>
                <a href="{{ route('about-us') }}" class="nav-link">About</a>
                <a href="{{ route('gallery') }}" class="nav-link">Gallery</a>
                <a href="{{ route('blog') }}" class="nav-link">Blog</a>
                <button type="button" class="menu-button" id="menuButton" aria-label="Menu" aria-expanded="false">&#9776;</button>
            </div>
        </div>
        <div class="mobile-menu" id="mobileMenu">
            <a href="{{ route('home') }}" class="nav-link active">Home</a>
            <a href="{{ route('product') }}" class="nav-link">Product</a>
            <a href="{{ route('about-us') }}" class="nav-link">About</a>
            <a href="{{ route('gallery') }}" class="nav-link">Gallery</a>
            <a href="{{ route('blog') }}" class="nav-link">Blog</a>
        </div>
    </nav>

    <!-- Hero slider -->
    <header class="header-home">
        <div class="hero-slider" id="heroSlider">
            <div class="mask">
                <div class="track" id="heroTrack">
                    <!-- Slide 1: copywriting + 3D -->
                    <div class="slide">
                        <div class="hero-grid">
                            <div class="spline-scene">
                                <iframe src="{{ asset('3d-yen.html') }}" title="Yen Bangunan 3D" loading="eager"></iframe>
                            </div>
                            <div class="text-box-500">
                                <h1 class="h1">One-Stop Construction Distributor</h1>
                                <p class="p-normal" style="margin-bottom: 24px">
                                    Yen Bangunan &mdash; toko bangunan Cikarang &amp; toko material Cikarang.
                                    Telah dipercaya sejak 2008 oleh proyek, konstruksi, dan industri di Cikarang Selatan.
                                </p>
                                <a href="{{ route('new-product') }}" class="button">Explore Product</a>
                            </div>
                        </div>
                    </div>
                    <!-- Slide 2: authorized distributor + list brand -->
                    <div class="slide">
                        <div class="hero-grid">
                            <div class="text-box-500">
                                <h1 class="h1">We Are Authorized Distributor for Top Brands</h1>
                            </div>
                            <div class="hero-brands-collage">
                                <img src="{{ asset('assets/vendors/Untitled design.png') }}" alt="Authorized distributor untuk brand-brand terpercaya" loading="lazy">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="slider-arrow prev" id="heroPrev" aria-label="Slide sebelumnya">&#8249;</button>
            <button type="button" class="slider-arrow next" id="heroNext" aria-label="Slide berikutnya">&#8250;</button>
            <div class="slide-nav" id="heroDots"></div>
        </div>
    </header>

    <!-- Our Brands: marquee -->
    <section class="section" style="padding-top: 60px; padding-bottom: 0">
        <div class="container">
            {{-- Judul center, warna white50 — styling sama dengan Trusted By --}}
            <div class="text-box reveal" style="margin: 0 auto 40px; text-align: center">
                <h1 class="h1" style="color: var(--white50); margin-bottom: 0">Our Brands</h1>
            </div>
            <div class="marquee dark reveal">
                <div class="marquee-track">
                    {{-- dua salinan berurutan agar loop translateX(-50%) mulus tanpa celah --}}
                    @for($i = 0; $i < 2; $i++)
                    @foreach($brands as [$brand, $cls])
                    <img src="{{ asset('assets/brand/' . $brand . '.svg') }}" alt="{{ ucwords(str_replace('-', ' ', $brand)) }}" class="{{ $cls }}" loading="lazy">
                    @endforeach
                    @endfor
                </div>
            </div>
        </div>
    </section>

    <!-- Feature 1: kategori produk clickable + ilustrasi -->
    <section class="section">
        <div class="container">
            <div class="reveal" style="margin-bottom: 32px">
                <h1 class="h1" style="margin-bottom: 0">Our Products</h1>
            </div>
            <div class="feature reveal">
                <div class="cat-grid">
                    @foreach([
                        ['besi-dan-baja', 'Besi & Baja'],
                        ['hebel-dan-bata', 'Konstruksi'],
                        ['atap', 'Atap'],
                        ['pipa-dan-sanitasi', 'Pipa & Sanitasi'],
                        ['lampu-dan-kelistrikan', 'Lampu'],
                        ['mesin', 'Mesin'],
                        ['perkakas', 'Perkakas'],
                        ['paku-dan-baut', 'Paku & Baut'],
                        ['consumable-industri', 'Consumable Industry'],
                        ['safety', 'Safety Industry'],
                        ['keramik-dan-granit', 'Keramik & Granit'],
                        ['cat', 'Cat'],
                    ] as [$slug, $label])
                    <a href="{{ route('new-product') }}?kategori={{ $slug }}" class="cat-card">
                        <img src="{{ asset('assets/product/' . $slug . '.png') }}" alt="{{ $label }}" loading="lazy">
                        <div class="label">{{ $label }}</div>
                    </a>
                    @endforeach
                </div>
                <div class="media" style="background: #000">
                    <img src="{{ asset('assets/blog/home-asset.png') }}" alt="Material konstruksi Yen Bangunan" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- Layanan (kartu non-clickable, hover animasi saja) + ilustrasi -->
    <section class="section" style="padding-top: 0">
        <div class="container">
            <div class="reveal" style="margin-bottom: 32px">
                <h1 class="h1" style="margin-bottom: 0">Our Services</h1>
            </div>
            <div class="feature reveal">
                <div class="svc-grid">
                    <div class="svc-card">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="20" r="1.6"/><circle cx="17" cy="20" r="1.6"/>
                            <path d="M3 4h2l2.4 12h10.2L20 8H7"/>
                            <path d="M12 2v4m-2-2h4"/>
                        </svg>
                        <div class="label">One Stop<br>Solution</div>
                    </div>
                    <div class="svc-card">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 7h10v9H4zM14 10h3.5L20 13v3h-6"/>
                            <circle cx="7.5" cy="18" r="1.6"/><circle cx="16.5" cy="18" r="1.6"/>
                            <path d="M1 9h2M1 12h2"/>
                        </svg>
                        <div class="label">Gratis<br>Ongkir</div>
                    </div>
                    <div class="svc-card">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="5" width="18" height="14" rx="2"/>
                            <circle cx="9" cy="11" r="2"/>
                            <path d="M6.5 15.5c.5-1.4 1.5-2 2.5-2s2 .6 2.5 2"/>
                            <path d="m16 9 .8 1.6 1.7.3-1.2 1.2.3 1.7-1.6-.8-1.6.8.3-1.7-1.2-1.2 1.7-.3z"/>
                        </svg>
                        <div class="label">Loyalty<br>Membership</div>
                    </div>
                    <div class="svc-card">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 13a8 8 0 0 1 16 0"/>
                            <rect x="2.5" y="12" width="4" height="6" rx="1.5"/>
                            <rect x="17.5" y="12" width="4" height="6" rx="1.5"/>
                            <path d="M19.5 18v1a2 2 0 0 1-2 2h-3"/>
                            <rect x="12" y="20" width="3" height="2" rx="1"/>
                        </svg>
                        <div class="label">Konsultasi<br>Gratis</div>
                    </div>
                </div>
                <div class="media" style="background: #000">
                    <img src="{{ asset('assets/blog/services-asset.png') }}" alt="Layanan konstruksi Yen Bangunan" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- Trusted By -->
    <section class="section" style="padding-top: 0">
        <div class="container">
            {{-- Judul center, warna white50 — persis .heading.h1.portfolio di referensi --}}
            <div class="text-box reveal" style="margin: 0 auto 40px; text-align: center">
                <h1 class="h1" style="color: var(--white50); margin-bottom: 0">Trusted By</h1>
            </div>
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
    </section>

    <!-- Tentang perusahaan (styling persis section about total-prime.com) -->
    <section class="section" style="padding-top: 0">
        <div class="container">
            <div class="about-info reveal">
                <div class="about-text">
                    <strong style="font-weight: 400">
                        PT Yen Sejahtera, berdiri sejak 2008 di Cikarang, memfokuskan diri pada perdagangan
                        material bangunan dan distribusi kebutuhan pabrik di Bekasi, Cikarang, dan Karawang.
                        Kami berkomitmen memberikan produk dan layanan terbaik, termasuk material bangunan,
                        listrik/elektronik, dan kebutuhan industri lainnya, dengan kepuasan pelanggan menjadi
                        prioritas utama.
                    </strong>
                    <div style="margin-top: 28px">
                        <a href="{{ route('new-aboutus') }}" class="button">Find Out More</a>
                    </div>
                </div>
                <div class="about-img">
                    <img src="{{ asset('assets/aboutus-wallpaper.jpg') }}" alt="Gedung Yen Bangunan Cikarang" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="section" style="padding-top: 20px">
        <div class="text-box reveal" style="max-width: 640px; margin: 0 auto; text-align: center">
            <h1 class="page-title">Kebutuhan Proyek?</h1>
            <p class="page-sub" style="margin-bottom: 24px">Konsultasi gratis dengan tim ahli Yen Bangunan. Chat WhatsApp, Gratis dan Cepat!</p>
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
    </section>

    @include('partials.site-footer')

    <script>
        // Hero slider: autoplay 8 detik (sama seperti referensi), panah, dan dots.
        (function () {
            var track = document.getElementById('heroTrack');
            if (!track) return;
            var slides = track.children.length;
            var dotsWrap = document.getElementById('heroDots');
            var current = 0;
            var timer;

            var dots = [];
            for (var i = 0; i < slides; i++) {
                var d = document.createElement('button');
                d.type = 'button';
                d.className = 'slide-dot' + (i === 0 ? ' active' : '');
                d.setAttribute('aria-label', 'Ke slide ' + (i + 1));
                (function (idx) {
                    d.addEventListener('click', function () { go(idx); restart(); });
                })(i);
                dotsWrap.appendChild(d);
                dots.push(d);
            }

            function go(i) {
                current = (i + slides) % slides;
                track.style.transform = 'translateX(-' + (current * 100) + '%)';
                dots.forEach(function (d, j) { d.classList.toggle('active', j === current); });
            }

            function restart() {
                clearInterval(timer);
                timer = setInterval(function () { go(current + 1); }, 8000);
            }

            document.getElementById('heroPrev').addEventListener('click', function () { go(current - 1); restart(); });
            document.getElementById('heroNext').addEventListener('click', function () { go(current + 1); restart(); });

            var slider = document.getElementById('heroSlider');
            slider.addEventListener('mouseenter', function () { clearInterval(timer); });
            slider.addEventListener('mouseleave', restart);

            restart();
        })();

        // Hamburger menu mobile
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
                            setTimeout(function () { child.classList.add('in-view'); }, Math.min(i * 70, 600));
                        });
                    } else {
                        el.classList.add('in-view');
                    }
                    io.unobserve(el);
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -30px 0px' });
            document.querySelectorAll('.reveal, .reveal-group').forEach(function (el) { io.observe(el); });
        })();
    </script>
</body>

</html>
