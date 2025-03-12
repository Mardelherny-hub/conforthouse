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
    <link rel="icon" type="image/png"sizes="57x57" href="{{ asset('assets/images/favicons/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/images/favicons/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicons/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/images/favicons/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicons/favicon.png') }}">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('assets/images/favicons/favicon.png') }}">
    <meta name="theme-color" content="#ffffff">


        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles para la galería de imágenes -->
        <style>
            .property-main-image img {
                width: 100%;
                height: 350px;
                object-fit: cover;
            }

            .property-thumbnails .thumbnail-img {
                height: 70px;
                object-fit: cover;
                cursor: pointer;
                transition: all 0.3s;
                margin-top: 2em;
            }

            .property-thumbnails .thumbnail-img:hover {
                opacity: 0.8;
            }
        </style>

        <!-- CSS Links -->
        <link href="{{ asset('assets/lib/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Volkhov:400i" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
        <link href="{{ asset('assets/lib/animate.css/animate.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/lib/components-font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/lib/et-line-font/et-line-font.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/lib/flexslider/flexslider.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/lib/owl.carousel/dist/assets/owl.carousel.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/lib/owl.carousel/dist/assets/owl.theme.default.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/lib/magnific-popup/dist/magnific-popup.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/lib/simple-text-rotator/simpletextrotator.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
        <link id="color-scheme" href="{{ asset('assets/css/colors/default.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />


    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-100" data-spy="scroll" data-target=".onpage-navigation" data-offset="60">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="page-loader">
                <div class="loader">Loading...</div>
            </div>

            @include('layouts.nav_public')

            <!-- Page Content -->
            <main>

                {{ $slot }}

                @include('layouts.footer_guest')

                <div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div>
            </main>



        </div>

        <!-- JavaScript Links -->
        <script src="{{ asset('assets/lib/jquery/dist/jquery.js') }}"></script>
        <script src="{{ asset('assets/lib/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/lib/wow/dist/wow.js') }}"></script>
        <script src="{{ asset('assets/lib/jquery.mb.ytplayer/dist/jquery.mb.YTPlayer.js') }}"></script>
        <script src="{{ asset('assets/lib/isotope/dist/isotope.pkgd.js') }}"></script>
        <script src="{{ asset('assets/lib/imagesloaded/imagesloaded.pkgd.js') }}"></script>
        <script src="{{ asset('assets/lib/flexslider/jquery.flexslider.js') }}"></script>
        <script src="{{ asset('assets/lib/owl.carousel/dist/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('assets/lib/smoothscroll.js') }}"></script>
        <script src="{{ asset('assets/lib/magnific-popup/dist/jquery.magnific-popup.js') }}"></script>
        <script src="{{ asset('assets/lib/simple-text-rotator/jquery.simple-text-rotator.min.js') }}"></script>
        <script async="" defer="" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDK2Axt8xiFYMBMDwwG1XzBQvEbYpzCvFU"></script>
        <script src="{{ asset('assets/js/plugins.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
        <script>
            Fancybox.bind("[data-fancybox]", {
                // Opciones personalizadas
                loop: true,
                thumbs: {
                    autoStart: true,
                }
            });
        </script>
    </body>
</html>
