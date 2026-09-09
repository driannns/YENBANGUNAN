{{-- Popup member: tampil setiap kali halaman home dibuka. --}}
<div class="member-popup" id="memberPopup" role="dialog" aria-modal="true" aria-label="Jadi Member Yen Bangunan" hidden>
    <div class="member-popup__backdrop" data-close></div>
    <div class="member-popup__dialog">
        <button type="button" class="member-popup__close" aria-label="Tutup" data-close>&times;</button>
        <img class="member-popup__art" src="{{ asset('assets/member-popup.svg') }}" alt="Jadi Member Yen Bangunan - nikmati keuntungan eksklusif dan raih hadiah menarik">
        <a class="member-popup__cta" href="https://wa.link/3v66z0" target="_blank" rel="noopener">Daftar Member Sekarang</a>
    </div>
</div>

<style>
    .member-popup {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        opacity: 0;
        transition: opacity .25s ease;
    }

    /* `hidden` attribute harus benar-benar melepas elemen dari layar.
       Tanpa ini, `display: flex` di atas menang atas UA style [hidden],
       sehingga overlay tetap menutupi & memblokir semua klik walau opacity 0. */
    .member-popup[hidden] {
        display: none;
    }

    /* Selama animasi fade-out (is-open sudah lepas, hidden belum di-set),
       overlay jangan menangkap klik. */
    .member-popup:not(.is-open) {
        pointer-events: none;
    }

    .member-popup.is-open {
        opacity: 1;
    }

    .member-popup__backdrop {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, .72);
        backdrop-filter: blur(4px);
    }

    .member-popup__dialog {
        position: relative;
        width: min(440px, 100%);
        transform: translateY(16px) scale(.96);
        transition: transform .3s cubic-bezier(.2, .8, .3, 1);
    }

    .member-popup__art {
        display: block;
        width: 100%;
        height: auto;
        border-radius: 26px;
        /* shadow neon orange yen */
        box-shadow:
            0 0 0 1px rgba(224, 85, 52, .55),
            0 0 22px rgba(224, 85, 52, .55),
            0 0 60px rgba(224, 85, 52, .45),
            0 0 120px rgba(224, 85, 52, .30);
        animation: member-popup-neon 2.4s ease-in-out infinite alternate;
    }

    .member-popup.is-open .member-popup__dialog {
        transform: translateY(0) scale(1);
    }

    @keyframes member-popup-neon {
        from {
            box-shadow:
                0 0 0 1px rgba(224, 85, 52, .45),
                0 0 18px rgba(224, 85, 52, .45),
                0 0 45px rgba(224, 85, 52, .35),
                0 0 90px rgba(224, 85, 52, .22);
        }
        to {
            box-shadow:
                0 0 0 1px rgba(224, 85, 52, .7),
                0 0 30px rgba(224, 85, 52, .7),
                0 0 75px rgba(224, 85, 52, .55),
                0 0 150px rgba(224, 85, 52, .4);
        }
    }

    .member-popup__close {
        position: absolute;
        top: -14px;
        right: -14px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 1px solid rgba(224, 85, 52, .6);
        background: #0c0c0e;
        color: #fff;
        font-size: 24px;
        line-height: 1;
        cursor: pointer;
        box-shadow: 0 0 16px rgba(224, 85, 52, .6);
        transition: transform .2s ease, background .2s ease;
    }

    .member-popup__close:hover {
        transform: rotate(90deg);
        background: #e05534;
    }

    .member-popup__cta {
        display: block;
        margin-top: 14px;
        padding: 13px 26px;
        border-radius: 999px;
        background: #e05534;
        color: #fff;
        font-weight: 700;
        font-size: 14px;
        letter-spacing: .3px;
        text-align: center;
        text-decoration: none;
        box-shadow: 0 0 24px rgba(224, 85, 52, .7);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .member-popup__cta:hover {
        transform: translateY(-2px);
        box-shadow: 0 0 36px rgba(224, 85, 52, .9);
    }

    @media (prefers-reduced-motion: reduce) {
        .member-popup__art {
            animation: none;
        }
    }
</style>

<script>
    (function() {
        var popup = document.getElementById('memberPopup');
        if (!popup) return;

        function open() {
            popup.hidden = false;
            document.body.style.overflow = 'hidden';
            requestAnimationFrame(function() {
                popup.classList.add('is-open');
            });
        }

        function close() {
            popup.classList.remove('is-open');
            document.body.style.overflow = '';
            setTimeout(function() {
                popup.hidden = true;
            }, 300);
        }

        popup.querySelectorAll('[data-close]').forEach(function(el) {
            el.addEventListener('click', close);
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !popup.hidden) close();
        });

        // Tampil setiap kali halaman home dibuka.
        setTimeout(open, 600);
    })();
</script>
