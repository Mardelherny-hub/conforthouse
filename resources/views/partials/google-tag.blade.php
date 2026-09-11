@php
    $ga4MeasurementId = config('services.google_analytics.measurement_id');
    $cookieLabels = [
        'es' => [
            'accept' => 'Aceptar',
            'reject' => 'Rechazar',
            'settings' => 'Cookies',
            'message' => 'Usamos cookies de analítica y medición publicitaria para conocer el uso del sitio y medir el rendimiento de nuestras campañas. Puedes aceptarlas o rechazarlas.',
        ],
        'en' => [
            'accept' => 'Accept',
            'reject' => 'Reject',
            'settings' => 'Cookies',
            'message' => 'We use analytics and advertising measurement cookies to understand site usage and measure campaign performance. You can accept or reject these cookies.',
        ],
        'fr' => [
            'accept' => 'Accepter',
            'reject' => 'Refuser',
            'settings' => 'Cookies',
            'message' => 'Nous utilisons des cookies d’analyse et de mesure publicitaire pour comprendre l’utilisation du site et mesurer les performances de nos campagnes. Vous pouvez les accepter ou les refuser.',
        ],
        'de' => [
            'accept' => 'Akzeptieren',
            'reject' => 'Ablehnen',
            'settings' => 'Cookies',
            'message' => 'Wir verwenden Analyse- und Werbemessungs-Cookies, um die Nutzung der Website zu verstehen und die Leistung unserer Kampagnen zu messen. Sie können diese Cookies akzeptieren oder ablehnen.',
        ],
        'nl' => [
            'accept' => 'Accepteren',
            'reject' => 'Weigeren',
            'settings' => 'Cookies',
            'message' => 'We gebruiken cookies voor analyse en advertentiemeting om het gebruik van de website te begrijpen en de prestaties van onze campagnes te meten. U kunt deze cookies accepteren of weigeren.',
        ],
    ];
    $cookieLabel = $cookieLabels[app()->getLocale()] ?? $cookieLabels['es'];
@endphp

@if ($ga4MeasurementId)
    <script>
        (function () {
            const measurementId = @json($ga4MeasurementId);
            const storageKey = 'conforthouse_cookie_consent_v1';
            const labels = @json($cookieLabel);
            const copy = {
                title: @json(__('messages.cookies_policy')),
                message: labels.message,
                privacy: @json(__('messages.privacy_policy')),
                privacyUrl: @json(route('privacy', ['locale' => app()->getLocale()])),
            };

            let googleTagLoaded = false;
            let consentBanner = null;
            let settingsButton = null;

            function getStoredChoice() {
                try {
                    return window.localStorage.getItem(storageKey);
                } catch (error) {
                    return null;
                }
            }

            function setStoredChoice(choice) {
                try {
                    window.localStorage.setItem(storageKey, choice);
                } catch (error) {
                    // Si localStorage no está disponible, el banner volverá a mostrarse en la próxima página.
                }
            }

            function ensureGtag() {
                window.dataLayer = window.dataLayer || [];
                window.gtag = window.gtag || function () {
                    window.dataLayer.push(arguments);
                };
            }

            function loadGoogleTag() {
                if (googleTagLoaded) {
                    return;
                }

                ensureGtag();

                window.gtag('consent', 'default', {
                    analytics_storage: 'denied',
                    ad_storage: 'denied',
                    ad_user_data: 'denied',
                    ad_personalization: 'denied'
                });

                window.gtag('consent', 'update', {
                    analytics_storage: 'granted',
                    ad_storage: 'granted',
                    ad_user_data: 'granted',
                    ad_personalization: 'denied'
                });

                const script = document.createElement('script');
                script.async = true;
                script.src = 'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(measurementId);
                document.head.appendChild(script);

                window.gtag('js', new Date());
                window.gtag('config', measurementId);
                googleTagLoaded = true;
            }

            function revokeConsent() {
                if (!googleTagLoaded || typeof window.gtag !== 'function') {
                    return;
                }

                window.gtag('consent', 'update', {
                    analytics_storage: 'denied',
                    ad_storage: 'denied',
                    ad_user_data: 'denied',
                    ad_personalization: 'denied'
                });
            }

            window.trackLeadConversion = function () {
                if (getStoredChoice() !== 'accepted' || !googleTagLoaded || typeof window.gtag !== 'function') {
                    return;
                }

                window.gtag('event', 'generate_lead');
            };

            function closeBanner() {
                if (consentBanner) {
                    consentBanner.remove();
                    consentBanner = null;
                }
            }

            function renderSettingsButton() {
                if (settingsButton || getStoredChoice() === null) {
                    return;
                }

                settingsButton = document.createElement('button');
                settingsButton.type = 'button';
                settingsButton.textContent = labels.settings;
                settingsButton.setAttribute('aria-label', labels.settings);
                settingsButton.style.cssText = 'position:fixed;left:12px;bottom:12px;z-index:2147482999;border:1px solid #d6b36a;background:#fff;color:#262626;padding:7px 11px;border-radius:999px;font:13px Arial,sans-serif;box-shadow:0 2px 10px rgba(0,0,0,.15);cursor:pointer;';
                settingsButton.addEventListener('click', renderBanner);
                document.body.appendChild(settingsButton);
            }

            function renderBanner() {
                if (consentBanner) {
                    return;
                }

                consentBanner = document.createElement('div');
                consentBanner.setAttribute('role', 'dialog');
                consentBanner.setAttribute('aria-live', 'polite');
                consentBanner.style.cssText = 'position:fixed;left:0;right:0;bottom:0;z-index:2147483000;background:#171717;color:#fff;padding:18px 20px;box-shadow:0 -4px 24px rgba(0,0,0,.25);font:14px/1.5 Arial,sans-serif;';

                const wrapper = document.createElement('div');
                wrapper.style.cssText = 'max-width:1180px;margin:0 auto;display:flex;gap:18px;align-items:center;justify-content:space-between;flex-wrap:wrap;';

                const text = document.createElement('div');
                text.style.cssText = 'flex:1 1 620px;min-width:260px;';

                const title = document.createElement('strong');
                title.textContent = copy.title;
                title.style.cssText = 'display:block;font-size:16px;margin-bottom:4px;';

                const message = document.createElement('span');
                message.textContent = copy.message + ' ';

                const privacy = document.createElement('a');
                privacy.href = copy.privacyUrl;
                privacy.textContent = copy.privacy;
                privacy.style.cssText = 'color:#e3c57f;text-decoration:underline;';

                text.appendChild(title);
                text.appendChild(message);
                text.appendChild(privacy);

                const actions = document.createElement('div');
                actions.style.cssText = 'display:flex;gap:10px;flex-wrap:wrap;';

                const reject = document.createElement('button');
                reject.type = 'button';
                reject.textContent = labels.reject;
                reject.style.cssText = 'border:1px solid #d6b36a;background:transparent;color:#fff;padding:10px 18px;border-radius:4px;font-weight:600;cursor:pointer;';
                reject.addEventListener('click', function () {
                    const wasAccepted = getStoredChoice() === 'accepted';
                    setStoredChoice('rejected');
                    revokeConsent();
                    closeBanner();

                    if (wasAccepted) {
                        window.location.reload();
                        return;
                    }

                    renderSettingsButton();
                });

                const accept = document.createElement('button');
                accept.type = 'button';
                accept.textContent = labels.accept;
                accept.style.cssText = 'border:1px solid #d6b36a;background:#d6b36a;color:#171717;padding:10px 18px;border-radius:4px;font-weight:700;cursor:pointer;';
                accept.addEventListener('click', function () {
                    setStoredChoice('accepted');
                    loadGoogleTag();
                    closeBanner();
                    renderSettingsButton();
                });

                actions.appendChild(reject);
                actions.appendChild(accept);
                wrapper.appendChild(text);
                wrapper.appendChild(actions);
                consentBanner.appendChild(wrapper);
                document.body.appendChild(consentBanner);
            }

            function initializeConsent() {
                const choice = getStoredChoice();

                if (choice === 'accepted') {
                    loadGoogleTag();
                    renderSettingsButton();
                    return;
                }

                if (choice === 'rejected') {
                    renderSettingsButton();
                    return;
                }

                renderBanner();
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initializeConsent, { once: true });
            } else {
                initializeConsent();
            }
        })();
    </script>
@else
    <script>
        window.trackLeadConversion = function () {};
    </script>
@endif
