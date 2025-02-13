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


        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

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
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-100">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">            
            <div class="page-loader">
                <div class="loader">Loading...</div>
            </div>

            @include('layouts.nav_guest')

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <section class="home-section home-parallax home-fade home-full-height" id="home">
                    <div class="hero-slider">
                    <ul class="slides">
                        <li class="bg-dark-30 bg-dark" style="background-image:url(assets/images/section-8.jpg);">
                        <div class="titan-caption">
                            <div class="caption-content">
                            <div class="font-alt mb-30 titan-title-size-1">{{ __('messages.welcome') }}</div>
                            <div class="font-alt mb-40 titan-title-size-4">{{ __('messages.hero1')}}</div><a class="section-scroll btn btn-border-w btn-round" href="#about">{{ __('messages.more')}}</a>
                            </div>
                        </div>
                        </li>
                        <li class="bg-dark-30 bg-dark" style="background-image:url(assets/images/section-9.jpg);">
                        <div class="titan-caption">
                            <div class="caption-content">
                            <div class="font-alt mb-30 titan-title-size-2">{{ __('messages.hero2')}}
                            </div><a class="btn btn-border-w btn-round" href="about">{{ __('messages.more')}}</a>
                            </div>
                        </div>
                        </li>
                        <li class="bg-dark-30 bg-dark" style="background-image:url(assets/images/section-10.jpg);">
                        <div class="titan-caption">
                            <div class="caption-content">
                            <div class="font-alt mb-30 titan-title-size-1">{{ __('messages.hero3')}}</div>
                            <div class="font-alt mb-40 titan-title-size-3">{{ __('messages.hero4')}}</div><a class="section-scroll btn btn-border-w btn-round" href="#about">{{ __('messages.more')}}</a>
                            </div>
                        </div>
                        </li>
                    </ul>
                    </div>
                
                <!-- Page Content -->
                    <main>                       

                        {{ $slot }}
                    
                        @include('layouts.footer_guest')

                        <div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div>
                    </main>
                </section>
            </div>
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
    </body>
</html>
