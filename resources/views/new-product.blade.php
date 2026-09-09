<!DOCTYPE html>
<html lang="id">

<head>
    @include('partials.analytics')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page['meta_title'] }}</title>
    <meta name="description" content="{{ $page['meta_description'] }}">
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

        /* Persis referensi: brand 60px flex + padding-left 10px (w-nav-brand);
           logo dikecilkan ke footprint logo referensi (±126px lebar natural). */
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

        /* ===== Bar kategori produk — persis .product-nav referensi ===== */
        .product-nav {
            display: flex;
            justify-content: center;
            gap: 10px;
            background-color: var(--white2);
            margin-top: 60px;
            padding: 10px;
            overflow: auto;
        }

        .nav-icon {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 4px;
            max-width: 80px;
            padding: 0 10px;
            color: var(--white50);
            flex: none;
            transition: color .2s;
        }

        .nav-icon:hover { color: var(--prime); }
        .nav-icon.current { color: var(--prime); }

        /* Ikon PNG di-treat monokrom seperti di new-home; saat aktif dibiarkan lebih terang */
        .nav-icon img {
            width: 48px;
            height: 48px;
            min-width: 48px;
            object-fit: contain;
            filter: grayscale(1) brightness(1.8);
            opacity: .7;
            transition: opacity .2s, filter .2s;
        }

        .nav-icon:hover img, .nav-icon.current img { opacity: 1; filter: grayscale(1) brightness(2.6); }

        .nav-text {
            text-align: center;
            font-family: var(--font-mono);
            font-size: 12px;
            line-height: 16px;
            text-transform: uppercase;
        }

        /* ===== Konten kategori — persis text-box.products referensi ===== */
        .product-content-area {
            max-width: 1200px;
            margin: 0 auto;
            padding: 56px 5% 0;
        }

        /* ===== Search bar produk — dikombinasikan dengan filter kategori ===== */
        .search-bar {
            display: flex;
            gap: 8px;
            width: 100%;
            margin-bottom: 28px;
        }

        .search-bar input[type="search"] {
            flex: 1;
            background-color: var(--white5);
            border: 1px solid var(--white15);
            border-radius: 8px;
            padding: 12px 16px;
            color: var(--white);
            font-family: var(--font-text);
            font-size: 14px;
            outline: none;
            transition: border-color .2s;
        }

        .search-bar input[type="search"]:focus { border-color: var(--prime); }
        .search-bar input[type="search"]::placeholder { color: var(--white35); }

        .search-bar button {
            background-color: var(--prime);
            color: #fff;
            border: 0;
            border-radius: 8px;
            padding: 0 22px;
            font-family: var(--font-mono);
            font-size: 13px;
            letter-spacing: .03em;
            text-transform: uppercase;
            cursor: pointer;
            transition: background-color .2s;
        }

        .search-bar button:hover { background-color: #c4482c; }

        .search-clear {
            display: inline-flex;
            align-items: center;
            font-family: var(--font-mono);
            font-size: 12px;
            color: var(--white50);
            padding: 0 4px;
            white-space: nowrap;
            transition: color .2s;
        }

        .search-clear:hover { color: var(--white); }

        /* .heading-product.h1.prime.product-page: mono 20px, putih, kiri */
        .cat-heading {
            font-family: var(--font-mono);
            font-size: 20px;
            font-weight: 400;
            line-height: 1.25em;
            text-transform: uppercase;
            color: var(--white);
            margin-bottom: 18px;
        }

        /* .rich-text-block: Helvetica Now Text 16px/24px white50 */
        .cat-copy {
            font-family: var(--font-text);
            font-size: 16px;
            line-height: 24px;
            color: var(--white50);
            max-width: 720px;
        }

        /* ===== List produk — kartu kotak putih ala .products-images referensi ===== */
        .products-grid {
            max-width: 1200px;
            margin: 40px auto 0;
            padding: 0 5%;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }

        /* Kartu produk gaya "blueprint teknis": bg gelap + grid halus + siku
           crosshair di sudut, ala referensi engineering/CAD panel. */
        .product-card {
            position: relative;
            background-color: #1a1a1a;
            background-image:
                linear-gradient(var(--white5) 1px, transparent 1px),
                linear-gradient(90deg, var(--white5) 1px, transparent 1px);
            background-size: 22px 22px;
            border: 1px solid var(--white15);
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: transform .2s, border-color .2s;
        }

        .product-card:hover { transform: translateY(-3px); border-color: var(--prime); }

        .product-card::before, .product-card::after {
            content: '';
            position: absolute;
            width: 12px;
            height: 12px;
            border: 1px solid var(--prime);
            opacity: .55;
            pointer-events: none;
        }

        .product-card::before { top: 10px; left: 10px; border-right: 0; border-bottom: 0; }
        .product-card::after { bottom: 10px; right: 10px; border-left: 0; border-top: 0; }

        .product-card .pc-cat {
            position: relative;
            z-index: 1;
            font-family: var(--font-mono);
            font-size: 11px;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--prime);
            padding: 14px 16px 0;
            min-height: 15px;
        }

        .product-card .img-wrap {
            position: relative;
            z-index: 1;
            aspect-ratio: 1 / 1;
            margin: 10px 16px 0;
            background-color: #fff;
            border-radius: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 16px;
        }

        .product-card .img-wrap img { width: 100%; height: 100%; object-fit: contain; }

        .product-card .pc-body {
            position: relative;
            z-index: 1;
            padding: 14px 16px 16px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .product-card .name {
            width: 100%;
            font-family: var(--font-mono);
            font-size: 13px;
            line-height: 1.4;
            font-weight: 500;
            text-transform: uppercase;
            color: var(--white);
        }

        .product-card .pc-divider { border-top: 1px solid var(--white15); }

        .product-card .pc-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: var(--font-mono);
            font-size: 11px;
            letter-spacing: .05em;
            text-transform: uppercase;
            color: var(--white50);
            transition: color .2s;
        }

        .product-card:hover .pc-footer { color: var(--prime); }

        .product-card .pc-footer .arrow {
            font-size: 20px;
            line-height: 1;
            color: var(--prime);
            transition: transform .2s;
        }

        .product-card:hover .pc-footer .arrow { transform: translateX(4px); }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
            margin: 48px 5% 0;
            font-family: var(--font-mono);
        }

        .pagination a, .pagination span {
            min-width: 40px;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 14px;
            text-align: center;
            display: inline-block;
        }

        .pagination a {
            color: var(--white50);
            background-color: var(--white2);
            border: 1px solid var(--white5);
            transition: color .2s, border-color .2s;
        }

        .pagination a:hover { color: var(--prime); border-color: var(--prime); }

        .pagination .active { background-color: var(--prime); color: #fff; }

        .pagination .dots { color: var(--white35); }


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

        /* Responsive */
        @media (max-width: 991px) {
            /* Referensi pakai collapse "medium": hamburger mulai 991px */
            .nav-links .nav-link { display: none; }
            .menu-button { display: block; }
            .products-grid { grid-template-columns: repeat(3, 1fr); }
        }

        @media (max-width: 767px) {
            .product-nav { justify-content: flex-start; }
            .products-grid { grid-template-columns: repeat(2, 1fr); }
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
@include('partials.gtm-body')
    <a href="https://wa.link/3v66z0" target="_blank" rel="noopener" class="whatsapp-float" aria-label="Chat WhatsApp Yen Bangunan">
        <svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
        </svg>
    </a>

    @php
        // Kategori produk — slug & ikon sama persis dengan new-home.
        // Label & copy per kategori diambil dari menu admin "Edit Halaman Produk"
        // (config/page_content_defaults.php sebagai fallback jika belum pernah diedit).
        $categories = collect($page['categories'])->map(fn ($c) => [$c['label'], $c['copy']])->all();
        $isValidKategori = $kategori && isset($categories[$kategori]);
    @endphp

    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-inner">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('assets/logo.png') }}" alt="Yen Bangunan">
            </a>
            <div class="nav-links">
                <a href="{{ route('home') }}" class="nav-link">Home</a>
                <a href="{{ route('product') }}" class="nav-link active">Product</a>
                <a href="{{ route('about-us') }}" class="nav-link">About</a>
                <a href="{{ route('gallery') }}" class="nav-link">Gallery</a>
                <a href="{{ route('blog') }}" class="nav-link">Blog</a>
                <button type="button" class="menu-button" id="menuButton" aria-label="Menu" aria-expanded="false">&#9776;</button>
            </div>
        </div>
        <div class="mobile-menu" id="mobileMenu">
            <a href="{{ route('home') }}" class="nav-link">Home</a>
            <a href="{{ route('product') }}" class="nav-link active">Product</a>
            <a href="{{ route('about-us') }}" class="nav-link">About</a>
            <a href="{{ route('gallery') }}" class="nav-link">Gallery</a>
            <a href="{{ route('blog') }}" class="nav-link">Blog</a>
        </div>
    </nav>

    <!-- Bar kategori (filter). Klik kategori aktif = kembali ke semua produk. -->
    <div class="product-nav">
        @foreach($categories as $slug => [$label, $copy])
        @php
            $catParams = $isValidKategori && $kategori === $slug ? [] : ['kategori' => $slug];
            if ($search !== '') { $catParams['search'] = $search; }
        @endphp
        <a href="{{ route('new-product', $catParams) }}"
            class="nav-icon {{ $kategori === $slug ? 'current' : '' }}">
            <img src="{{ asset('assets/product/' . $slug . '.png') }}" alt="{{ $label }}" loading="lazy">
            <div class="nav-text">{{ $label }}</div>
        </a>
        @endforeach
    </div>

    <!-- Copywriting kategori -->
    <div class="product-content-area reveal">
        <form action="{{ route('new-product') }}" method="GET" class="search-bar" role="search">
            @if($isValidKategori)
            <input type="hidden" name="kategori" value="{{ $kategori }}">
            @endif
            <input type="search" name="search" value="{{ $search }}" placeholder="Cari nama produk...">
            <button type="submit">Cari</button>
            @if($search !== '')
            <a href="{{ route('new-product', $isValidKategori ? ['kategori' => $kategori] : []) }}" class="search-clear">Reset</a>
            @endif
        </form>

        @if($isValidKategori)
        <h1 class="cat-heading">{{ $categories[$kategori][0] }}</h1>
        <p class="cat-copy">{{ $categories[$kategori][1] }}</p>
        @else
        <h1 class="cat-heading">{{ $page['heading'] }}</h1>
        <p class="cat-copy">{{ $page['subtitle'] }}</p>
        @endif
    </div>

    <!-- List blog product -->
    @if($products->isEmpty())
    <div class="product-content-area" style="padding-top: 24px">
        <p class="cat-copy">
            @if($search !== '')
            Produk dengan kata kunci "<strong>{{ $search }}</strong>" tidak ditemukan{{ $isValidKategori ? ' di kategori ini' : '' }}.
            Coba kata kunci lain atau
            @else
            Produk kategori ini belum tersedia di katalog online.
            @endif
            Hubungi kami via
            <a href="https://wa.me/6282123269622" target="_blank" style="color: var(--prime)">WhatsApp</a>
            untuk menanyakan stok dan harga.
        </p>
    </div>
    @endif
    <div class="products-grid reveal-group">
        @foreach($products as $product)
        @php
            $productName = html_entity_decode(preg_replace('/\s*[-\x{2013}]\s*Yen Bangunan Cikarang\s*$/iu', '', $product->title));
            $productCatLabel = null;
            if (!empty($product->category) && isset($categories[$product->category])) {
                $productCatLabel = $categories[$product->category][0];
            } elseif ($isValidKategori) {
                $productCatLabel = $categories[$kategori][0];
            }
            // Produk baru (dibuat lewat /admin) punya slug polos tanpa "/" dan
            // pakai URL pendek /{category}/{slug}. Produk lama (slug sudah berisi
            // path lengkap bertanggal) tetap dipakai apa adanya.
            $productUrl = str_contains($product->slug, '/')
                ? '/' . $product->slug
                : route('content.product.show', ['category' => $product->category, 'slug' => $product->slug]);
        @endphp
        <a href="{{ $productUrl }}" class="product-card">
            <div class="pc-cat">{{ $productCatLabel }}</div>
            <div class="img-wrap">
                @if($product->image_path)
                <img src="{{ asset('assets' . $product->image_path) }}" alt="{{ $productName }}" loading="lazy">
                @endif
            </div>
            <div class="pc-body">
                <div class="name">{{ $productName }}</div>
                <div class="pc-divider"></div>
                <div class="pc-footer">
                    <span>View Detail</span>
                    <span class="arrow">&rarr;</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    @if($products->hasPages())
    <nav class="pagination" aria-label="Navigasi halaman produk">
        @foreach($products->onEachSide(1)->linkCollection() as $link)
        @php $label = str_replace(['&laquo; Previous', 'Next &raquo;'], ['&laquo;', '&raquo;'], $link['label']); @endphp
        @if($link['url'] && !$link['active'])
        <a href="{{ $link['url'] }}">{!! $label !!}</a>
        @elseif($link['active'])
        <span class="active">{!! $label !!}</span>
        @else
        <span class="dots">{!! $label !!}</span>
        @endif
        @endforeach
    </nav>
    @endif

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
    </script>
</body>

</html>
