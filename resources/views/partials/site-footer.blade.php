{{--
    Footer global untuk semua halaman "new-*" (new-home, new-product, new-aboutus,
    new-gallery, new-blog) dan blog-detail. Sertakan dengan @include('partials.site-footer')
    tepat sebelum </body>. Butuh variabel CSS --white/--white35/--white5/--font-mono
    yang sudah didefinisikan di :root masing-masing halaman.
--}}
<style>
    .footer {
        width: 100%;
        background-color: #000;
        padding: 48px 3% 24px;
        margin-top: 90px;
    }

    .footer-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr;
        gap: 32px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .footer-text { font-family: var(--font-mono); font-size: 12px; line-height: 18px; color: var(--white35); }
    .footer-text a:hover { color: var(--white); }

    .footer .logo img { height: 30px; width: auto; margin-bottom: 16px; }

    .footer-head { font-family: var(--font-mono); font-size: 12px; letter-spacing: .1em; text-transform: uppercase; color: var(--white50); margin-bottom: 12px; }

    .footer-links { display: flex; flex-direction: column; gap: 8px; }

    .copyright {
        max-width: 1200px;
        margin: 36px auto 0;
        padding-top: 18px;
        border-top: 1px solid var(--white5);
        display: flex;
        justify-content: space-between;
        gap: 12px;
    }

    @media (max-width: 900px) {
        .footer-grid { grid-template-columns: 1fr 1fr; }
        .footer-grid > div:first-child { grid-column: 1 / -1; }
    }

    @media (max-width: 600px) {
        .footer { padding: 40px 6% 20px; }
        .footer-grid { grid-template-columns: 1fr; gap: 28px; }
        .footer-grid > div:first-child { grid-column: auto; }
        .copyright { flex-direction: column; align-items: flex-start; gap: 6px; text-align: left; }
    }
</style>

<!-- Footer -->
<footer class="footer">
    <div class="footer-grid">
        <div>
            <div class="logo"><img src="{{ asset('assets/logo.png') }}" alt="Yen Bangunan"></div>
            <p class="footer-text">
                Lippo Cikarang Sukadami, Cikarang Selatan,<br>
                Kabupaten Bekasi, Jawa Barat, 17530
            </p>
            <p class="footer-text" style="margin-top: 10px">WhatsApp: +62 8131-5147-952</p>
        </div>
        <div>
            <div class="footer-head">Menu</div>
            <div class="footer-links">
                <a href="{{ route('home') }}" class="footer-text">Home</a>
                <a href="{{ route('product') }}" class="footer-text">Product</a>
                <a href="{{ route('about-us') }}" class="footer-text">About Us</a>
                <a href="{{ route('gallery') }}" class="footer-text">Gallery</a>
                <a href="{{ route('blog') }}" class="footer-text">Blog</a>
            </div>
        </div>
        <div>
            <div class="footer-head">FOLLOW US</div>
            <div class="footer-links">
                <a href="https://www.instagram.com/yenbangunan" target="_blank" class="footer-text">Instagram — @yenbangunan</a>
                <a href="https://www.tiktok.com/@yenbangunancikarang" target="_blank" class="footer-text">TikTok — @yenbangunancikarang</a>
            </div>
        </div>
    </div>
    <div class="copyright">
        <span class="footer-text">&copy; {{ date('Y') }} Yen Bangunan. All rights reserved.</span>
        <span class="footer-text">Cikarang, Indonesia</span>
    </div>
</footer>
