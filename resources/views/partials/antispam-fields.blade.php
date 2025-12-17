{{-- Campos AntiSpam - Honeypot + Token de tiempo --}}

{{-- Honeypot: campo oculto que los bots llenarán automáticamente --}}
<div style="position: absolute; left: -9999px; opacity: 0; height: 0; width: 0; overflow: hidden;" aria-hidden="true">
    <label for="website_url">Website</label>
    <input type="text" name="website_url" id="website_url" tabindex="-1" autocomplete="off" value="">
</div>

{{-- Token de tiempo: registra cuándo se cargó el formulario --}}
<input type="hidden" name="_form_token" value="{{ base64_encode(time()) }}">