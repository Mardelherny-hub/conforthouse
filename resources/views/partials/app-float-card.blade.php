{{--
    ============================================================
    Tarjeta flotante de descarga de App - Conforthouse Living
    ============================================================
    Partial autocontenido. Para activarlo, incluir en el layout
    principal una sola vez (idealmente al final del <body>):
        @include('partials.app-float-card')
    Características:
    - Solo se muestra en escritorio (>= 769px). El QR requiere
      escanearse desde otro dispositivo.
    - Persistencia con localStorage: 7 días tras cerrar
      (clave propia, independiente del banner móvil)
    - Animación fade + slide con Alpine.js
    - Reutiliza las claves de traducción del banner
    - Sin dependencias de controladores ni middlewares
    ============================================================
--}}
<div
    x-data="appFloatCard()"
    x-init="init()"
    x-show="visible"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-x-8"
    x-transition:enter-end="opacity-100 translate-x-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-x-0"
    x-transition:leave-end="opacity-0 translate-x-8"
    role="dialog"
    aria-label="Descargar app Conforthouse Living"
    class="cf-app-card"
>
    {{-- Botón cerrar --}}
    <button
        type="button"
        @click="dismiss()"
        class="cf-app-card__close"
        aria-label="Cerrar"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </button>

    {{-- Logo --}}
    <div class="cf-app-card__logo">
        <img
            src="{{ asset('assets/images/logo/conforthouse-logo.png') }}"
            alt="Conforthouse Living"
            loading="lazy"
        >
    </div>

    {{-- Textos 
    <p class="cf-app-card__title">{{ __('messages.app_banner_title') }}</p>--}}

    {{-- QR --}}
    <div class="cf-app-card__qr">
        <img
            src="{{ asset('assets/images/qr/app-qr.png') }}"
            alt="{{ __('messages.app_banner_cta') }}"
            loading="lazy"
        >
    </div>

    <p class="cf-app-card__subtitle">{{ __('messages.app_banner_subtitle') }}</p>
</div>

{{-- ============================================================
     Estilos de la tarjeta (scoped por prefijo cf-app-card__)
     ============================================================ --}}
<style>
    .cf-app-card {
        position: fixed;
        top: 110px;
        right: 24px;
        z-index: 40;
        width: 230px;
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.08);
        border-radius: 6px;
        box-shadow: 0 6px 28px rgba(0, 0, 0, 0.14);
        padding: 1.25rem 1.1rem 1.1rem;
        text-align: center;
        font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, sans-serif;
    }
    .cf-app-card__close {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 24px;
        height: 24px;
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
    .cf-app-card__close:hover {
        color: #374151;
        background: rgba(0, 0, 0, 0.05);
    }
    .cf-app-card__logo {
        height: 42px;
        margin: 0 auto 1.15rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .cf-app-card__logo img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
    }
    .cf-app-card__title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.15rem;
        font-weight: 600;
        color: #111827;
        line-height: 1.25;
        letter-spacing: 0.01em;
        margin: 0 0 0.9rem 0;
    }
    .cf-app-card__qr {
        width: 130px;
        margin: 0 auto 0.85rem;
        padding: 6px;
        border: 1px solid rgba(0, 0, 0, 0.07);
        border-radius: 4px;
        background: #ffffff;
    }
    .cf-app-card__qr img {
        display: block;
        width: 100%;
        height: auto;
    }
    .cf-app-card__subtitle {
        font-size: 0.7rem;
        font-weight: 400;
        color: #6b7280;
        line-height: 1.45;
        margin: 0;
    }
    /* Refuerzo: nunca visible en móvil/tablet */
    @media (max-width: 768px) {
        .cf-app-card {
            display: none !important;
        }
    }
</style>

{{-- ============================================================
     Lógica Alpine.js
     ============================================================ --}}
<script>
    function appFloatCard() {
        return {
            visible: false,
            init() {
                // 1) Solo escritorio: el QR se escanea desde otro dispositivo
                if (!this.isDesktop()) {
                    return;
                }
                // 2) No mostrar si fue cerrada y no expiró el plazo
                if (this.isDismissed()) {
                    return;
                }
                // 3) Pequeño delay para no aparecer en el primer paint
                setTimeout(() => {
                    this.visible = true;
                }, 900);
            },
            isDesktop() {
                return window.matchMedia && window.matchMedia('(min-width: 769px)').matches;
            },
            isDismissed() {
                try {
                    const until = localStorage.getItem('cf_app_card_dismissed_until');
                    if (!until) return false;
                    return Date.now() < parseInt(until, 10);
                } catch (e) {
                    return false;
                }
            },
            dismiss() {
                this.visible = false;
                try {
                    const sevenDaysMs = 7 * 24 * 60 * 60 * 1000;
                    localStorage.setItem(
                        'cf_app_card_dismissed_until',
                        String(Date.now() + sevenDaysMs)
                    );
                } catch (e) {
                    // Si localStorage no está disponible, simplemente no persistimos
                }
            }
        }
    }
</script>