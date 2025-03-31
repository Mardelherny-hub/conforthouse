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

<body class="font-sans text-gray-900 antialiased bg-gray-100">

    <!-- Header Navigation -->
    <header class="relative hero-section min-h-[80vh] flex flex-col">
        <!-- Carrusel de imágenes de fondo mejorado -->
        <div x-data="{
            activeSlide: 0,
            slides: [{
                    image: '{{ asset('assets/images/slides/slide1.webp') }}',
                    title: '{{ __('messages.slide_title_1') }}',
                    subtitle: '{{ __('messages.slide_subtitle_1') }}'
                },
                {
                    image: '{{ asset('assets/images/slides/slide2.jpg') }}',
                    title: '{{ __('messages.slide_title_2') }}',
                    subtitle: '{{ __('messages.slide_subtitle_2') }}'
                },
                {
                    image: '{{ asset('assets/images/slides/slide3.webp') }}',
                    title: '{{ __('messages.slide_title_3') }}',
                    subtitle: '{{ __('messages.slide_subtitle_3') }}'
                }
            ],
            loop() {
                setInterval(() => { this.activeSlide = (this.activeSlide + 1) % this.slides.length }, 7000);
            }
        }" x-init="loop()" class="absolute inset-0 w-full h-full overflow-hidden">

            <!-- Overlay con gradiente para mejorar legibilidad y estética -->
            <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/50 to-black/70 z-10"></div>

            <!-- Elemento decorativo - línea dorada superior -->
            <div
                class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-amber-300 to-transparent z-20 opacity-70">
            </div>

            <!-- Slides del carrusel con efecto Ken Burns -->
            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="activeSlide === index" x-transition:enter="transition ease-out duration-2000"
                    x-transition:enter-start="opacity-0 transform scale-105"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-1000" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="absolute inset-0 w-full h-full bg-cover bg-center transform transition-transform duration-10000 ease-out animate-kenburns">
                    <div class="w-full h-full"
                        :style="`background-image: url('${slide.image}'); background-size: cover; background-position: center;`">
                    </div>
                </div>
            </template>

            <!-- Indicadores del carrusel estilizados -->
            <div class="absolute bottom-10 left-0 right-0 z-20 flex justify-center space-x-3">
                <template x-for="(slide, index) in slides" :key="index">
                    <button @click="activeSlide = index"
                        :class="{
                            'w-10 bg-amber-300': activeSlide ===
                                index,
                            'w-3 bg-white/50 hover:bg-white/70': activeSlide !== index
                        }"
                        class="h-3 rounded-full focus:outline-none transition-all duration-500 ease-in-out"></button>
                </template>
            </div>
            <!-- Flechas de navegación con estilo de lujo - ocultas en móvil -->
            <div class="hidden sm:flex absolute inset-y-0 left-0 z-20 items-center">
                <button @click="activeSlide = (activeSlide - 1 + slides.length) % slides.length"
                    class="ml-6 w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center
               bg-black/30 backdrop-blur-sm border border-white/10
               hover:bg-amber-900/40 hover:border-amber-300/30 text-white
               focus:outline-none transform transition duration-300 hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
            </div>

            <div class="hidden sm:flex absolute inset-y-0 right-0 z-20 items-center">
                <button @click="activeSlide = (activeSlide + 1) % slides.length"
                    class="mr-6 w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center
               bg-black/30 backdrop-blur-sm border border-white/10
               hover:bg-amber-900/40 hover:border-amber-300/30 text-white
               focus:outline-none transform transition duration-300 hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Estructura principal del header con menú y contenido hero -->
        <div class="relative w-full h-full flex flex-col z-30">
            <!-- Menú de navegación -->
            <!-- Container para el nav que ocupa todo el ancho -->
            <div class="absolute top-0 left-0 right-0 z-50">
                <x-navigation />
            </div>

            <!-- Hero Content con animaciones elegantes -->
            <div class="container mx-auto px-6 flex flex-col justify-center items-center flex-grow text-center pt-20">
                <div class="max-w-5xl mx-auto">
                    <!-- Elemento decorativo arriba del título -->
                    <div class="mb-6 opacity-80">
                        <div class="inline-block">
                            <div class="flex items-center justify-center">
                                <div class="h-[1px] w-16 bg-gradient-to-r from-transparent to-amber-300"></div>
                                <div class="mx-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-6 h-6 text-amber-300">
                                        <path
                                            d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z" />
                                        <path
                                            d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198c.03-.028.061-.056.091-.086L12 5.43z" />
                                    </svg>
                                </div>
                                <div class="h-[1px] w-16 bg-gradient-to-l from-transparent to-amber-300"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Títulos con animación y fuente de lujo -->
                    <div x-data="{ activeSlide: 0 }" x-init="setInterval(() => { activeSlide = (activeSlide + 1) % 3 }, 7000)"
                        class="mb-8 relative h-[160px] sm:h-[200px] md:h-[240px] lg:h-[300px] xl:h-[360px]">
                        <template
                            x-for="(slide, index) in [
                                { title: '<span class=\'font-luxury font-light\'>{{ __('messages.hero_title_1') }} <span class=\'text-amber-300\'>{{ __('messages.hero_highlight_1') }}</span></span>' },
                                { title: '<span class=\'font-luxury font-light\'>{{ __('messages.hero_title_2') }} <span class=\'text-amber-300\'>{{ __('messages.hero_highlight_2') }}</span></span>' },
                                { title: '<span class=\'font-luxury font-light\'>{{ __('messages.hero_title_3') }} <span class=\'text-amber-300\'>{{ __('messages.hero_highlight_3') }}</span></span>' }
                            ]"
                            :key="index">
                            <h1 x-show="activeSlide === index" x-transition:enter="transition ease-out duration-500"
                                x-transition:enter-start="opacity-0 transform translate-y-4"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                x-transition:leave="transition ease-in duration-500"
                                x-transition:leave-start="opacity-100 transform translate-y-0"
                                x-transition:leave-end="opacity-0 transform -translate-y-4" x-html="slide.title"
                                class="absolute inset-x-0 text-4xl sm:text-4xl md:text-6xl lg:text-7xl xl:text-7xl tracking-wide leading-tight text-white px-4 sm:px-0">
                            </h1>
                        </template>
                    </div>

                    <!-- Botones estilizados con efecto lujoso -->
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center px-4 sm:px-6 mb-6 sm:mb-8">
                        <a href="#"
                            class="btn-luxury bg-amber-300 hover:bg-amber-400
                                   px-4 sm:px-6 md:px-10
                                   py-2 sm:py-3
                                   text-xs sm:text-sm md:text-base
                                   luxury-nav font-medium rounded-sm text-gray-900
                                   transition-all duration-500
                                   w-full sm:w-auto text-center
                                   shadow-lg hover:shadow-xl">
                            {{ __('messages.explore_properties') }}
                        </a>
                        <a href="#"
                            class="btn-luxury bg-transparent
                                   border border-white/70 hover:border-amber-300
                                   hover:text-amber-300
                                   px-4 sm:px-6 md:px-10
                                   py-2 sm:py-3
                                   text-xs sm:text-sm md:text-base
                                   luxury-nav font-medium rounded-sm text-white
                                   transition-all duration-500
                                   w-full sm:w-auto text-center
                                   backdrop-blur-sm">
                            {{ __('messages.contact_now') }}
                        </a>
                    </div>

                    <!-- Estadísticas destacadas - ocultas en móvil -->
                    <div
                        class="hidden sm:grid sm:grid-cols-3 mt-16 pt-10
                                                gap-8 md:gap-16 animate-fadeIn">
                        <div class="text-center">
                            <p class="text-amber-300 font-luxury text-4xl mb-1">150+</p>
                            <p class="text-white/70 text-sm uppercase tracking-widest luxury-nav">
                                {{ __('messages.exclusive_properties') }}
                            </p>
                        </div>
                        <div class="text-center">
                            <p class="text-amber-300 font-luxury text-4xl mb-1">12</p>
                            <p class="text-white/70 text-sm uppercase tracking-widest luxury-nav">
                                {{ __('messages.countries') }}
                            </p>
                        </div>
                        <div class="text-center">
                            <p class="text-amber-300 font-luxury text-4xl mb-1">98%</p>
                            <p class="text-white/70 text-sm uppercase tracking-widest luxury-nav">
                                {{ __('messages.satisfied_clients') }}
                            </p>
                        </div>
                    </div>

                    <!-- Flecha de scroll hacia abajo - ajustada para mejor visibilidad -->
                    <div class="fixed bottom-4 left-1/2 transform -translate-x-1/2 z-20 animate-bounce sm:hidden ">
                        <a href="#properties"
                            class="flex flex-col items-center text-white/70 hover:text-amber-300
                                                  transition duration-300 bg-black/30 p-3 rounded-full
                                                  backdrop-blur-sm">
                            <span class="text-[10px] uppercase tracking-widest mb-1 luxury-nav">
                                {{ __('messages.discover') }}
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
    </header>


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
</body>

</html>
