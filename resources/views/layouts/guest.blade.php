<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ConfortHouse Living') }}</title>

    <!-- Hreflang links -->
    <link rel="alternate" hreflang="es" href="https://localhost:8000/es/" />
    <link rel="alternate" hreflang="en" href="https://localhost:8000/en/" />
    <link rel="alternate" hreflang="fr" href="https://localhost:8000/fr/" />
    <link rel="alternate" hreflang="de" href="https://localhost:8000/de/" />

    <!-- Favicons -->
    <link rel="icon" type="image/png" sizes="57x57" href="assets/images/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/images/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicons/favicon.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/images/favicons/favicon.png">
    <meta name="theme-color" content="#ffffff">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-body antialiased">

    <!-- Navigation -->
    <nav class="luxury-nav fixed w-full top-0 z-50 transition-all duration-300" 
         x-data="{ scrolled: false }"
         x-init="() => {
             const updateNavbar = () => {
                 scrolled = window.scrollY > 50;
             };
             window.addEventListener('scroll', updateNavbar);
             updateNavbar();
         }"
         :class="{ 'luxury-nav-scrolled': scrolled }">
        
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" 
                       class="luxury-logo">
                        ConfortHouse Living
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" 
                       class="nav-link-luxury {{ request()->routeIs('home') ? 'active' : '' }}">
                        {{ __('messages.inicio') }}
                    </a>
                    <a href="{{ route('properties.index', ['locale' => app()->getLocale()]) }}" 
                       class="nav-link-luxury {{ request()->routeIs('properties.*') ? 'active' : '' }}">
                        {{ __('messages.propiedades') }}
                    </a>
                    <a href="#servicios" class="nav-link-luxury">
                        {{ __('messages.servicios') }}
                    </a>
                    <a href="#contacto" class="nav-link-luxury">
                        {{ __('messages.contacto') }}
                    </a>
                    
                    <!-- Language Selector -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="nav-link-luxury flex items-center space-x-2">
                            <img src="{{ asset('assets/images/flags/4x3/' . app()->getLocale() . '.svg') }}"
                                 alt="{{ app()->getLocale() }}" 
                                 class="w-5 h-3">
                            <span>{{ strtoupper(app()->getLocale()) }}</span>
                            <svg class="w-4 h-4 transform transition-transform duration-200" 
                                 :class="{ 'rotate-180': open }">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" 
                                      stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             @click.away="open = false"
                             class="absolute right-0 mt-2 w-48 bg-black bg-opacity-95 backdrop-blur-lg rounded-lg shadow-luxury border border-gold-600 border-opacity-20">
                            
                            <a href="{{ route(Route::currentRouteName(), ['locale' => 'es'] + Route::current()->parameters()) }}"
                               class="flex items-center px-4 py-3 text-sm text-white hover:text-gold-400 hover:bg-gold-600 hover:bg-opacity-10 transition-colors duration-200">
                                <img src="{{ asset('assets/images/flags/4x3/es.svg') }}" 
                                     alt="Español" class="w-5 h-3 mr-3">
                                {{ __('messages.lang_es') }}
                            </a>
                            
                            <a href="{{ route(Route::currentRouteName(), ['locale' => 'en'] + Route::current()->parameters()) }}"
                               class="flex items-center px-4 py-3 text-sm text-white hover:text-gold-400 hover:bg-gold-600 hover:bg-opacity-10 transition-colors duration-200">
                                <img src="{{ asset('assets/images/flags/4x3/en.svg') }}" 
                                     alt="English" class="w-5 h-3 mr-3">
                                {{ __('messages.lang_en') }}
                            </a>
                            
                            <a href="{{ route(Route::currentRouteName(), ['locale' => 'fr'] + Route::current()->parameters()) }}"
                               class="flex items-center px-4 py-3 text-sm text-white hover:text-gold-400 hover:bg-gold-600 hover:bg-opacity-10 transition-colors duration-200">
                                <img src="{{ asset('assets/images/flags/4x3/fr.svg') }}" 
                                     alt="Français" class="w-5 h-3 mr-3">
                                {{ __('messages.lang_fr') }}
                            </a>
                            
                            <a href="{{ route(Route::currentRouteName(), ['locale' => 'de'] + Route::current()->parameters()) }}"
                               class="flex items-center px-4 py-3 text-sm text-white hover:text-gold-400 hover:bg-gold-600 hover:bg-opacity-10 transition-colors duration-200 rounded-b-lg">
                                <img src="{{ asset('assets/images/flags/4x3/de.svg') }}" 
                                     alt="Deutsch" class="w-5 h-3 mr-3">
                                {{ __('messages.lang_de') }}
                            </a>
                            <a href="{{ route(Route::currentRouteName(), ['locale' => 'nl'] + Route::current()->parameters()) }}"
                               class="flex items-center px-4 py-3 text-sm text-white hover:text-gold-400 hover:bg-gold-600 hover:bg-opacity-10 transition-colors duration-200 rounded-b-lg">
                                <img src="{{ asset('assets/images/flags/4x3/nl.svg') }}" 
                                     alt="Nederlands" class="w-5 h-3 mr-3">
                                {{ __('messages.lang_nl') }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button x-data x-on:click="$dispatch('toggle-mobile-menu')" 
                            class="text-white hover:text-gold-400 focus:outline-none focus:text-gold-400 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                  stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-data="{ mobileMenuOpen: false }"
                 x-on:toggle-mobile-menu.window="mobileMenuOpen = !mobileMenuOpen"
                 x-show="mobileMenuOpen"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                 class="md:hidden bg-black bg-opacity-95 backdrop-blur-lg border-t border-gold-600 border-opacity-20">
                
                <div class="px-4 py-6 space-y-4">
                    <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" 
                       class="block nav-link-luxury {{ request()->routeIs('home') ? 'active' : '' }}">
                        {{ __('messages.inicio') }}
                    </a>
                    <a href="{{ route('properties.index', ['locale' => app()->getLocale()]) }}" 
                       class="block nav-link-luxury {{ request()->routeIs('properties.*') ? 'active' : '' }}">
                        {{ __('messages.propiedades') }}
                    </a>
                    <a href="#servicios" class="block nav-link-luxury">
                        {{ __('messages.servicios') }}
                    </a>
                    <a href="#contacto" class="block nav-link-luxury">
                        {{ __('messages.contacto') }}
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero-luxury">
        <!-- Background Image -->
        <div class="hero-background animate-kenBurns"
             style="background-image: url('{{ $backgroundImage ?? asset('assets/images/slides/slide1.webp') }}');">
        </div>
        
        <!-- Overlay -->
        <div class="hero-overlay"></div>
        
        <!-- Hero Content -->
        <div class="hero-content">
            <h1 class="hero-title animate-fadeInUp">
                {{ __('messages.slide_title_1', [], app()->getLocale()) }}
            </h1>
            <p class="hero-subtitle animate-fadeInUp" style="animation-delay: 0.3s;">
                {{ __('messages.slide_subtitle_1', [], app()->getLocale()) }}
            </p>
            
            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8 animate-fadeInUp" 
                 style="animation-delay: 0.6s;">
                <a href="{{ route('properties.index', ['locale' => app()->getLocale()]) }}" 
                   class="btn-luxury-primary">
                    {{ __('messages.ver_propiedades') }}
                </a>
                <a href="#contacto" class="btn-luxury-secondary">
                    {{ __('messages.contactanos') }}
                </a>
            </div>
            
            <!-- Stats -->
            <div class="grid grid-cols-3 gap-8 mt-16 animate-fadeInUp" style="animation-delay: 0.9s;">
                <div class="text-center">
                    <div class="text-3xl font-luxury text-gold-400 mb-2">500+</div>
                    <div class="text-sm uppercase tracking-widest text-white text-opacity-70">
                        {{ __('messages.propiedades') }}
                    </div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-luxury text-gold-400 mb-2">12</div>
                    <div class="text-sm uppercase tracking-widest text-white text-opacity-70">
                        {{ __('messages.countries') }}
                    </div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-luxury text-gold-400 mb-2">98%</div>
                    <div class="text-sm uppercase tracking-widest text-white text-opacity-70">
                        {{ __('messages.satisfied_clients') }}
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    @include('layouts.footer_guest')

    <!-- Scroll to Top Button -->
    <div class="fixed bottom-6 right-6 z-50" 
         x-data="{ showScroll: false }"
         x-init="() => {
             const toggleScroll = () => {
                 showScroll = window.scrollY > 400;
             };
             window.addEventListener('scroll', toggleScroll);
         }">
        
        <button x-show="showScroll"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-75"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-75"
                @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
                class="w-12 h-12 bg-luxury-gradient text-white rounded-full shadow-luxury hover:shadow-gold focus:outline-none focus:ring-4 focus:ring-gold-600 focus:ring-opacity-50 transition-all duration-300 flex items-center justify-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" 
                      stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
            </svg>
        </button>
    </div>

    <!-- Search Modal Component -->
    <x-search-modal :operations="$operations ?? collect()" :property-types="$propertyTypes ?? collect()" />
</body>
</html>