<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Confort House') }}</title>

    <link rel="alternate" hreflang="es" href="https://localhost:8000/es/" />
    <link rel="alternate" hreflang="en" href="https://localhost:8000/en/" />
    <link rel="alternate" hreflang="fr" href="https://localhost:8000/fr/" />
    <link rel="alternate" hreflang="de" href="https://localhost:8000/de/" />

    <!--    Favicons
    =============================================
    -->
    <link rel="icon" type="image/png"sizes="57x57" href="assets/images/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/images/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicons/favicon.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/images/favicons/favicon.png">
    <meta name="theme-color" content="#ffffff">

    <!-- Importación de fuentes y estilos base de lujo -->
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=Montserrat:wght@300;400&display=swap'"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans text-gray-900 antialiased bg-white">
    <!-- Header Navigation -->
    <!-- Navigation Bar -->
<nav class="bg-black border-b border-gray-200">
    <div class="w-full">
        <x-navigation />
    </div>
</nav>

<main class="flex-1">
    <!-- Main Content -->
    <main class="flex-1">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-neutral-900 text-neutral-300">
        <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="md:col-span-1">
                    <h3 class="text-white text-lg font-medium mb-4 font-luxury">Confort House</h3>
                    <p class="text-sm text-neutral-400 font-body">
                        {{ __('messages.footer_description') }}
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-white text-sm font-medium mb-4 font-body">{{ __('messages.quick_links') }}</h4>
                    <ul class="space-y-2 text-sm font-body">
                        <li><a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="hover:text-white transition-colors">{{ __('messages.inicio') }}</a></li>
                        <li><a href="{{ route('properties.index', ['locale' => app()->getLocale()]) }}" class="hover:text-white transition-colors">{{ __('messages.propiedades') }}</a></li>
                        <li><a href="{{ route('complexes.index', ['locale' => app()->getLocale()]) }}" class="hover:text-white transition-colors">{{ __('messages.complejos_residenciales') }}</a></li>
                        <li><a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" class="hover:text-white transition-colors">{{ __('messages.contacto') }}</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div>
                    <h4 class="text-white text-sm font-medium mb-4 font-body">{{ __('messages.servicios') }}</h4>
                    <ul class="space-y-2 text-sm font-body">
                        <li><a href="#" class="hover:text-white transition-colors">{{ __('messages.serv_valoracion') }}</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">{{ __('messages.serv_consultoria') }}</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">{{ __('messages.serv_inversion') }}</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-white text-sm font-medium mb-4 font-body">{{ __('messages.contacto') }}</h4>
                    <div class="space-y-2 text-sm font-body">
                        <p>info@conforthouse.com</p>
                        <p>+34 971 000 000</p>
                        <p>{{ __('messages.mallorca_location') }}</p>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-neutral-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <div class="text-sm text-neutral-500 font-body">
                    © {{ date('Y') }} Confort House. {{ __('messages.all_rights_reserved') }}
                </div>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="{{ route('privacy', ['locale' => app()->getLocale()]) }}" class="text-sm text-neutral-500 hover:text-white transition-colors font-body">
                        {{ __('messages.privacy_policy') }}
                    </a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>