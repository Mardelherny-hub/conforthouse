{{--
    ============================================================
    Banner de descarga de App - Conforthouse Living
    ============================================================
    Partial autocontenido. Para activarlo, incluir en el layout
    principal una sola vez (idealmente al final del <body>):

        @include('partials.app-download-banner')

    Características:
    - Solo se muestra en dispositivos móviles (iOS / Android).
      En escritorio se usa la tarjeta flotante con QR.
    - Persistencia con localStorage: 7 días tras cerrar
    - Animación slide-up con Alpine.js
    - Estética alineada a la paleta Conforthouse Living
    - Sin dependencias de controladores ni middlewares
    - Empuja el widget Chat Bob hacia arriba mientras está visible,
      restaurando su posición original al cerrarse
    ============================================================
--}}


<div
    x-data="appDownloadBanner()"
    x-init="init()"
    x-show="visible"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-full"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-full"
    role="dialog"
    aria-label="Descargar app Conforthouse Living"
    class="cf-app-banner"
>
    <div class="cf-app-banner__inner">
        {{-- Logo --}}
        {{-- <div class="cf-app-banner__logo">
            <img
                src="{{ asset('assets/images/logo/Recurso-13.png') }}"
                alt="Conforthouse Living"
                loading="lazy"
            >
        </div> --}}

        {{-- Textos --}}
        <div class="cf-app-banner__text">
            <p class="cf-app-banner__title">{{ __('messages.app_banner_title') }}</p>
            <p class="cf-app-banner__subtitle">{{ __('messages.app_banner_subtitle') }}</p>
        </div>

        {{-- Botón descargar --}}
        <a
            href="https://app.conforthouseliving.com"
            target="_blank"
            rel="noopener noreferrer"
            class="cf-app-banner__cta"
        >
            {{ __('messages.app_banner_cta') }}
        </a>

        {{-- Botón cerrar --}}
        <button
            type="button"
            @click="dismiss()"
            class="cf-app-banner__close"
            aria-label="Cerrar"
        >
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>
</div>

{{-- ============================================================
     Estilos del banner (scoped por prefijo cf-app-banner__)
     ============================================================ --}}
<style>
    .cf-app-banner {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 40;
        background: #ffffff;
        border-top: 1px solid rgba(0, 0, 0, 0.08);
        box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.08);
        font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .cf-app-banner__title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.25rem;        /* serif suele necesitar +tamaño que sans */
        font-weight: 600;
        color: #111827;
        margin: 0 0 2px 0;
        letter-spacing: 0.01em;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .cf-app-banner__inner {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        max-width: 100%;
    }

    .cf-app-banner__logo {
        flex-shrink: 0;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cf-app-banner__logo img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .cf-app-banner__text {
        flex: 1;
        min-width: 0;
        line-height: 1.3;
    }

    .cf-app-banner__title {
        font-size: 0.875rem;
        font-weight: 600;
        color: #111827;
        margin: 0 0 2px 0;
        letter-spacing: 0.01em;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .cf-app-banner__subtitle {
        font-size: 0.75rem;
        font-weight: 400;
        color: #6b7280;
        margin: 0;
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .cf-app-banner__cta {
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #B8731A;
        color: #ffffff;
        font-size: 0.8125rem;
        font-weight: 500;
        padding: 0.5rem 0.95rem;
        border-radius: 4px;
        text-decoration: none;
        letter-spacing: 0.02em;
        transition: background 0.2s ease, transform 0.2s ease;
        white-space: nowrap;
    }

    .cf-app-banner__cta:hover,
    .cf-app-banner__cta:focus {
        background: #a0621a;
        color: #ffffff;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .cf-app-banner__close {
        flex-shrink: 0;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        border: none;
        color: #9ca3af;
        cursor: pointer;
        padding: 0;
        border-radius: 50%;
        transition: color 0.2s ease, background 0.2s ease;
    }

    .cf-app-banner__close:hover {
        color: #374151;
        background: rgba(0, 0, 0, 0.04);
    }

    /* Pantallas muy pequeñas: ajustes de espacio */
    @media (max-width: 360px) {
        .cf-app-banner__inner {
            gap: 0.5rem;
            padding: 0.625rem 0.75rem;
        }

        .cf-app-banner__logo {
            width: 38px;
            height: 38px;
        }

        .cf-app-banner__cta {
            padding: 0.45rem 0.75rem;
            font-size: 0.75rem;
        }
    }
</style>

{{-- ============================================================
     Lógica Alpine.js
     ============================================================ --}}
<script>
    function appDownloadBanner() {
        return {
            visible: false,

            // Offset original del Chat Bob (definido en app.blade.php).
            // Se conserva para restaurarlo al cerrar el banner.
            chatbobOriginalOffset: '56px',

            // Altura aproximada del banner. Se usa para empujar a Bob.
            // Si se ajusta el padding/tipografía del banner, revisar este valor.
            bannerHeight: 15,

            init() {
                // 1) No mostrar si no es dispositivo móvil.
                //    En escritorio se muestra la tarjeta flotante con QR
                //    (partials/app-float-card.blade.php)
                if (!this.isMobile()) {
                    return;
                }
                // 2) No mostrar si fue cerrado y no expiró el plazo
                if (this.isDismissed()) {
                    return;
                }
                // 3) Pequeño delay para no aparecer en el primer paint
                setTimeout(() => {
                    this.visible = true;
                    this.pushChatbobUp();
                }, 600);
            },

            isMobile() {
                // Combinación de matchMedia + User-Agent para mayor robustez
                const ua = navigator.userAgent || navigator.vendor || window.opera || '';
                const uaIsMobile = /android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(ua);
                const widthIsMobile = window.matchMedia && window.matchMedia('(max-width: 768px)').matches;
                return uaIsMobile || widthIsMobile;
            },
            isDismissed() {
                try {
                    const until = localStorage.getItem('cf_app_banner_dismissed_until');
                    if (!until) return false;
                    return Date.now() < parseInt(until, 10);
                } catch (e) {
                    return false;
                }
            },

            dismiss() {
                this.visible = false;
                this.restoreChatbobOffset();
                try {
                    const sevenDaysMs = 7 * 24 * 60 * 60 * 1000;
                    localStorage.setItem(
                        'cf_app_banner_dismissed_until',
                        String(Date.now() + sevenDaysMs)
                    );
                } catch (e) {
                    // Si localStorage no está disponible, simplemente no persistimos
                }
            },

            // Empuja el botón de BotHub hacia arriba aplicando inline style.
            // Reintenta hasta que el widget esté en el DOM (script async).
            pushChatbobUp() {
                let attempts = 0;
                const targetBottom = (parseInt(this.chatbobOriginalOffset, 10) + this.bannerHeight) + 'px';
                const tryPush = () => {
                    const bob = document.querySelector('.bothub-button');
                    if (bob) {
                        bob.style.setProperty('bottom', targetBottom, 'important');
                        return;
                    }
                    if (++attempts < 10) setTimeout(tryPush, 300);
                };
                tryPush();
            },

            // Restaura el offset original del botón de BotHub
            restoreChatbobOffset() {
                const bob = document.querySelector('.bothub-button');
                if (bob) bob.style.removeProperty('bottom');
            }
        }
    }
</script>