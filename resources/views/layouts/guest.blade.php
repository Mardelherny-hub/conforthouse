<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="alternate" hreflang="es" href="https://localhost:8000/es/" />
        <link rel="alternate" hreflang="en" href="https://localhost:8000/en/" />
        <link rel="alternate" hreflang="fr" href="https://localhost:8000/fr/" />
        <link rel="alternate" hreflang="de" href="https://localhost:8000/de/" />


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
            <div>
                {{--<a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>--}}
            </div>

            <nav class="navbar navbar-custom navbar-fixed-top navbar-transparent" role="navigation">
                <div class="container">
                    <div class="navbar-header">
                        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#custom-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="index.html">Conforthouse Living</a>
                    </div>
                    <div class="collapse navbar-collapse" id="custom-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a class="dropdown-toggle" href="#" data-toggle="dropdown">Propiedades</a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Residenciales</a></li>
                                    <li><a href="#">Comerciales</a></li>
                                    <li><a href="#">Exclusivas</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" href="#" data-toggle="dropdown">Servicios</a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Tasación</a></li>
                                    <li><a href="#">Consultoría</a></li>
                                    <li><a href="#">Inversión</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Nosotros</a></li>
                            <li><a href="#">Contacto</a></li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" href="#" data-toggle="dropdown">{{ __('messages.sel_lang') }}</a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('home', ['locale' => 'es']) }}">{{ 'lang' }}</a></li>
                                    <li><a href="{{ route('home', ['locale' => 'en']) }}">{{ 'lang' }}</a></li>
                                    <li><a href="{{ route('home', ['locale' => 'fr']) }}">{{ 'lang' }}</a></li>
                                    <li><a href="{{ route('home', ['locale' => 'de']) }}">{{ 'lang' }}</a></li>
                                    
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <main>
                    <!-- Content from index.html goes here -->
                    <section class="home-section bg-dark-30" id="home" data-background="assets/images/real_state/real_state_header_bg.avif">
                        <div class="video-player" data-property="{videoURL:'https://youtu.be/jE06tF25230?si=0CxTmcuqFaz7QvUr', containment:'.home-section', startAt:30, mute:true, autoPlay:true, loop:true, opacity:1, showControls:false, showYTLogo:false, vol:0}"></div>
                        <div class="video-controls-box">
                            <div class="container">
                                <div class="video-controls">
                                    <a class="fa fa-volume-up" id="video-volume" href="#">&nbsp;</a>
                                    <a class="fa fa-pause" id="video-play" href="#">&nbsp;</a>
                                </div>
                            </div>
                        </div>
                        <div class="titan-caption">
                            <div class="caption-content">
                                <div class="font-alt mb-30 titan-title-size-1">Bienvenidos a</div>
                                <div class="font-alt mb-40 titan-title-size-4">Conforthouse Living</div>
                                <p class="lead mb-5">Descubre propiedades de lujo más allá de lo convencional</p>
                                <a class="section-scroll btn btn-border-w btn-round" href="#about">Explora Propiedades</a>
                            </div>
                        </div>
                    </section>
                    <!-- Additional sections from index.html -->
                     <div class="module-small bg-dark">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="widget">
                                        <h5 class="widget-title font-alt">Sobre Conforthouse Living</h5>
                                        <p>Conforthouse Living es una agencia inmobiliaria especializada en bienes raíces de
                                            lujo. Contamos con oficinas en las principales ciudades de España y ofrecemos una
                                            amplia cartera de propiedades exclusivas, incluyendo casas, apartamentos y fincas.
                                        </p>
                                        <p>Teléfono: +34 234 567 89 10</p>Fax: +34 234 567 89 10
                                        <p>Correo electrónico: <a
                                                href="mailto:info@conforthouseliving.com">info@conforthouseliving.com</a></p>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="widget">
                                        <h5 class="widget-title font-alt">Comentarios Recientes</h5>
                                        <ul class="icon-list">
                                            <li>Ana en <a href="#">Compra de Villa en Marbella</a></li>
                                            <li>Carlos en <a href="#">Venta de Penthouse en Madrid</a></li>
                                            <li>Juan en <a href="#">Inversión en Propiedad en Ibiza</a></li>
                                            <li>Laura en <a href="#">Apartamento de Lujo en Barcelona</a></li>
                                            <li>Pedro en <a href="#">Finca Exclusiva en la Costa Brava</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="widget">
                                        <h5 class="widget-title font-alt">Categorías de Propiedades</h5>
                                        <ul class="icon-list">
                                            <li><a href="#">Casas de Lujo - 7</a></li>
                                            <li><a href="#">Apartamentos Exclusivos - 3</a></li>
                                            <li><a href="#">Fincas de Alto Valor - 12</a></li>
                                            <li><a href="#">Inversiones Inmobiliarias - 1</a></li>
                                            <li><a href="#">Propiedades en la Costa - 16</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="widget">
                                        <h5 class="widget-title font-alt">Propiedades Populares</h5>
                                        <ul class="widget-posts">
                                            <li class="clearfix">
                                                <div class="widget-posts-image"><a href="#"><img src="assets/images/rp-1.jpg"
                                                            alt="Miniatura de la Propiedad" /></a></div>
                                                <div class="widget-posts-body">
                                                    <div class="widget-posts-title"><a href="#">Villa en Marbella con Vista al
                                                            Mar</a></div>
                                                    <div class="widget-posts-meta">23 enero</div>
                                                </div>
                                            </li>
                                            <li class="clearfix">
                                                <div class="widget-posts-image"><a href="#"><img src="assets/images/rp-2.jpg"
                                                            alt="Miniatura de la Propiedad" /></a></div>
                                                <div class="widget-posts-body">
                                                    <div class="widget-posts-title"><a href="#">Apartamento de Lujo en el
                                                            Corazón de Madrid</a></div>
                                                    <div class="widget-posts-meta">15 febrero</div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="divider-d">
                    <footer class="footer bg-dark">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="copyright font-alt">&copy; 2024&nbsp;<a href="index.html">Conforthouse Living</a>,
                                        Todos los Derechos Reservados</p>
                                </div>
                                <div class="col-sm-6">
                                    <div class="footer-social-links">
                                        <a href="#"><i class="fa fa-facebook"></i></a>
                                        <a href="#"><i class="fa fa-twitter"></i></a>
                                        <a href="#"><i class="fa fa-instagram"></i></a>
                                        <a href="#"><i class="fa fa-linkedin"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </footer>
                    <div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div>
                </main>
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
