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
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=Montserrat:wght@300;400&display=swap"
        rel="stylesheet">


    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans text-gray-900 antialiased bg-gray-100">

    <!-- Header Navigation -->
    <header class="relative w-full h-[400px] sm:h-[500px] lg:h-[800px] bg-cover bg-center flex items-end ">

        <!-- Estructura principal del header con menú y contenido hero -->
        <div class="relative w-full h-full flex flex-col z-30">
            <!-- Menú de navegación -->
            <!-- Container para el nav que ocupa todo el ancho -->
            <div class="absolute top-0 left-0 right-0 z-50">
                <x-navigation />
            </div>

        <!-- Carrusel de imágenes -->
       
        <div x-data="carousel()" x-init="init()" class="relative w-full h-full" @keydown.arrow-right="currentSlide = (currentSlide + 1) % slides.length" @keydown.arrow-left="currentSlide = (currentSlide - 1 + slides.length) % slides.length" tabindex="0" aria-roledescription="carousel">
            
            <!-- Slide 1 -->
            <div x-show="currentSlide === 0" 
                :aria-hidden="currentSlide !== 0"
                x-transition:enter="transition-opacity duration-1000"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-1000"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-cover bg-center brightness-110 contrast-105"
                style="background-image: url('{{ asset('assets/images/home/hero.webp') }}')">
            </div>
            
            <!-- Slide 2 -->
            <div x-show="currentSlide === 1" 
                x-transition:enter="transition-opacity duration-1000"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-1000"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-cover bg-center brightness-110 contrast-105"
                style="background-image: url('{{ asset('assets/images/home/hero-2.webp') }}')">
            </div>
            
            <!-- Slide 3 -->
            <div x-show="currentSlide === 2" 
                x-transition:enter="transition-opacity duration-1000"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-1000"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-cover bg-center brightness-110 contrast-105"
                style="background-image: url('{{ asset('assets/images/home/hero-3.webp') }}')">
            </div>
            
            <!-- Slide 4 -->
            <div x-show="currentSlide === 3" 
                x-transition:enter="transition-opacity duration-1000"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-1000"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-cover bg-center brightness-110 contrast-105"
                style="background-image: url('{{ asset('assets/images/home/hero-4.webp') }}')">
            </div>

            <!-- Slide 5 -->
            <div x-show="currentSlide === 4" 
                x-transition:enter="transition-opacity duration-1000"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-1000"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-cover bg-center brightness-110 contrast-105"
                style="background-image: url('{{ asset('assets/images/home/hero-5.webp') }}')">
            </div>

            <!-- Slide 6 -->
            <div x-show="currentSlide === 5" 
                x-transition:enter="transition-opacity duration-1000"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-1000"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-cover bg-center brightness-110 contrast-105"
                style="background-image: url('{{ asset('assets/images/home/hero-6.webp') }}')">
            </div>

            <!-- Slide 7 -->
            <div x-show="currentSlide === 6" 
                x-transition:enter="transition-opacity duration-1000"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-1000"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-cover bg-center brightness-110 contrast-105"
                style="background-image: url('{{ asset('assets/images/home/hero-7.webp') }}')">
            </div>
            
            <!-- Overlay mínimo para legibilidad -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent"></div>
            
            <!-- Indicadores del carrusel -->
            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-3 z-40">
                <template x-for="(slide, index) in slides" :key="index">
                    <button
                        @click="goToSlide(index)"
                        :aria-current="currentSlide === index"
                        :aria-label="`Ir al slide ${index + 1}`"
                        :class="currentSlide === index ? 'bg-white w-8' : 'bg-white/40 w-6'"
                        class="h-1 rounded-full transition-all duration-300 hover:bg-white/70">
                    </button>
                </template>
            </div>
        </div>

    </header>


    <!-- Page Content -->
    <main>

        {{ $slot }}

        @include('layouts.footer_guest')

        <div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div>
        {{-- flotaing button partials--}}
        @include('partials.floating-button')
        
        
    </main>
    

    <!-- Antes de </body> -->
    <x-search-modal :operations="$operations ?? collect()" :property-types="$propertyTypes ?? collect()" />

    <!-- JavaScript Links -->
      <script>
   function carousel() {
    return {
        currentSlide: 0,
        slides: [0, 1, 2, 3, 4, 5, 6,],
        intervalId: null,
        isTransitioning: false,
        
        init() {
            this.startAutoSlide();
        },
        
        startAutoSlide() {
            this.intervalId = setInterval(() => {
                if (!this.isTransitioning) {
                    this.nextSlide();
                }
            }, 6000);
        },
        
        stopAutoSlide() {
            if (this.intervalId) {
                clearInterval(this.intervalId);
                this.intervalId = null;
            }
        },
        
        nextSlide() {
            this.isTransitioning = true;
            this.currentSlide = (this.currentSlide + 1) % this.slides.length;
            
            // Resetear el flag después de que termine la transición
            setTimeout(() => {
                this.isTransitioning = false;
            }, 1000); // Duración de la transición
        },
        
        goToSlide(index) {
            if (!this.isTransitioning && index !== this.currentSlide) {
                this.isTransitioning = true;
                this.currentSlide = index;
                
                // Reiniciar el temporizador automático
                this.stopAutoSlide();
                
                setTimeout(() => {
                    this.isTransitioning = false;
                    this.startAutoSlide();
                }, 1000);
            }
        }
    }
}
    </script>
</body>

</html>
