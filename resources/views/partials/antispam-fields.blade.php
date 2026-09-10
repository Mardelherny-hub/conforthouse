{{-- Campos AntiSpam - Honeypot + Token de tiempo + reCAPTCHA v2 --}}

{{-- Honeypot: campo oculto que los bots llenarán automáticamente --}}
<div style="position: absolute; left: -9999px; opacity: 0; height: 0; width: 0; overflow: hidden;" aria-hidden="true">
    <label for="website_url">Website</label>
    <input type="text" name="website_url" id="website_url" tabindex="-1" autocomplete="off" value="">
</div>

{{-- Token de tiempo: registra cuándo se cargó el formulario --}}
@php($antispamTs = time())
<input type="hidden" name="_form_token" value="{{ base64_encode($antispamTs . '|' . hash_hmac('sha256', $antispamTs, config('app.key'))) }}">

{{-- reCAPTCHA v2: se renderiza explícitamente para soportar varios formularios en la misma página --}}
<div class="js-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>

@once
    <script>
        window.confortHouseRecaptchaOnload = function () {
            const renderRecaptchas = function () {
                document.querySelectorAll('.js-recaptcha').forEach(function (element) {
                    if (element.dataset.recaptchaRendered === 'true') {
                        return;
                    }

                    grecaptcha.render(element, {
                        sitekey: element.dataset.sitekey
                    });

                    element.dataset.recaptchaRendered = 'true';
                });
            };

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', renderRecaptchas, { once: true });
            } else {
                renderRecaptchas();
            }
        };
    </script>
    <script src="https://www.google.com/recaptcha/api.js?onload=confortHouseRecaptchaOnload&render=explicit" async defer></script>
@endonce
