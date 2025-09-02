@props(['operations' => collect()])

<nav class="james-nav fixed w-full top-0 z-50 transition-all duration-500 ease-out" 
     x-data="{ scrolled: false, mobileOpen: false, propertiesOpen: false, langOpen: false }"
     x-init="() => {
         const updateNavbar = () => {
             scrolled = window.scrollY > 10;
         };
         window.addEventListener('scroll', updateNavbar);
         updateNavbar();
     }"
     :class="scrolled ? 'bg-white/98 backdrop-blur-xl shadow-lg james-nav-scrolled' : 'bg-gradient-to-b from-black/60 to-transparent'">
    
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex items-center justify-between" :class="scrolled ? 'h-16' : 'h-20'">
            
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" 
                   class="james-logo flex items-center group transition-all duration-300">
                   <img src="{{ asset('assets/images/logo/conforthouse-logo-0-40.webp') }}" 
                        :style="scrolled ? 'height: 28px;' : 'height: 32px;'"
                        class="transition-all duration-500 ease-out brightness-110 group-hover:brightness-125"
                        alt="Conforthouse Living">
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-8 xl:space-x-10">
                
                <!-- Home -->
                <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" 
                   class="james-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    {{ __('messages.inicio') }}
                </a>

                <!-- Properties Dropdown -->
                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button class="james-nav-link flex items-center space-x-1 group">
                        <span>{{ __('messages.propiedades') }}</span>
                        <svg class="w-3 h-3 transition-transform duration-200" 
                             :class="{ 'rotate-180': open }" 
                             viewBox="0 0 12 12" fill="currentColor">
                            <path d="M6 8L10 4H2L6 8Z"/>
                        </svg>
                    </button>
                    
                    <!-- James Edition Style Dropdown -->
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 w-64
                                bg-white shadow-xl rounded-none border-0
                                overflow-hidden">
                        
                        <div class="py-2">
                            <!-- All Properties Link -->
                            <a href="{{ route('properties.index', ['locale' => app()->getLocale()]) }}" 
                               class="james-dropdown-item">
                                {{ __('messages.todas_propiedades') }}
                            </a>
                            
                            <div class="h-px bg-gray-100 my-1"></div>
                            
                            <!-- Operations -->
                            @if($operations->count() > 0)
                                @foreach($operations as $operation)
                                    <a href="{{ route('properties.index', ['locale' => app()->getLocale(), 'operation_id' => $operation->id]) }}" 
                                       class="james-dropdown-item">
                                        {{ $operation->name }}
                                    </a>
                                @endforeach
                            @else
                                @foreach(['alquiler', 'venta', 'obra_nueva', 'viviendas_de_lujo'] as $type)
                                    <a href="#" class="james-dropdown-item">
                                        {{ __('messages.' . $type) }}
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Other Navigation Links -->
                <a href="#servicios" class="james-nav-link">{{ __('messages.servicios') }}</a>
                <a href="#nosotros" class="james-nav-link">{{ __('messages.about_us') }}</a>
                <a href="#contacto" class="james-nav-link">{{ __('messages.contacto') }}</a>
            </div>

            <!-- Right Side Actions -->
            <div class="hidden lg:flex items-center space-x-6">
                
                <!-- Language Selector -->
                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button class="james-lang-btn flex items-center space-x-2">
                        <img src="{{ asset('assets/images/flags/4x3/' . app()->getLocale() . '.svg') }}"
                             alt="{{ app()->getLocale() }}" 
                             class="w-4 h-3 rounded-sm">
                        <span class="text-xs font-medium tracking-wide">{{ strtoupper(app()->getLocale()) }}</span>
                        <svg class="w-3 h-3 transition-transform duration-200" 
                             :class="{ 'rotate-180': open }" 
                             viewBox="0 0 12 12" fill="currentColor">
                            <path d="M6 8L10 4H2L6 8Z"/>
                        </svg>
                    </button>
                    
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute right-0 top-full mt-2 w-40
                                bg-white shadow-xl rounded-none border-0">
                        
                        <div class="py-2">
                            @foreach([
                                'es' => ['flag' => 'es', 'name' => 'lang_es', 'alt' => 'Español'],
                                'en' => ['flag' => 'en', 'name' => 'lang_en', 'alt' => 'English'], 
                                'fr' => ['flag' => 'fr', 'name' => 'lang_fr', 'alt' => 'Français'],
                                'de' => ['flag' => 'de', 'name' => 'lang_de', 'alt' => 'Deutsch']
                            ] as $locale => $lang)
                                <a href="{{ route(Route::currentRouteName(), ['locale' => $locale] + Route::current()->parameters()) }}"
                                   class="flex items-center px-4 py-2 text-sm hover:bg-gray-50
                                          {{ app()->getLocale() == $locale ? 'text-gray-900 bg-gray-50' : 'text-gray-700' }}
                                          transition-colors duration-150">
                                    <img src="{{ asset('assets/images/flags/4x3/' . $lang['flag'] . '.svg') }}" 
                                         alt="{{ $lang['alt'] }}" class="w-4 h-3 mr-3 rounded-sm">
                                    <span>{{ __('messages.' . $lang['name']) }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Search Button -->
                <!-- En navigation.blade.php, dentro del menú desktop -->
                <button @click="$dispatch('open-search')" class="james-search-btn font-body">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Search
                </button>

                <!-- Sell With Us Button (James Edition Style) 
                <a href="#" class="james-cta-btn">
                    Sell With Us
                </a>-->

                <!-- Login Button -->
                <a href="#" class="james-login-btn">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Log in
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <div class="lg:hidden">
                <button @click="mobileOpen = !mobileOpen" 
                        class="james-mobile-btn">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2">
                        <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" 
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" 
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform -translate-y-4"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-4"
             class="lg:hidden bg-white shadow-xl border-t border-gray-100">
            
            <div class="px-4 py-6 space-y-4">
                
                <!-- Mobile Navigation Links -->
                <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" 
                   class="james-mobile-link {{ request()->routeIs('home') ? 'text-gray-900' : '' }}">
                    {{ __('messages.inicio') }}
                </a>

                <!-- Mobile Properties -->
                <div x-data="{ open: false }">
                    <button @click="open = !open" 
                            class="james-mobile-link flex items-center justify-between w-full">
                        <span>{{ __('messages.propiedades') }}</span>
                        <svg class="w-4 h-4 transition-transform duration-200" 
                             :class="{ 'rotate-180': open }" 
                             viewBox="0 0 12 12" fill="currentColor">
                            <path d="M6 8L10 4H2L6 8Z"/>
                        </svg>
                    </button>
                    
                    <div x-show="open" x-collapse class="mt-2 ml-4 space-y-2">
                        <a href="{{ route('properties.index', ['locale' => app()->getLocale()]) }}" 
                           class="james-mobile-sublink">
                            {{ __('messages.todas_propiedades') }}
                        </a>
                        
                        @if($operations->count() > 0)
                            @foreach($operations as $operation)
                                <a href="{{ route('properties.index', ['locale' => app()->getLocale(), 'operation_id' => $operation->id]) }}" 
                                   class="james-mobile-sublink">
                                    {{ $operation->name }}
                                </a>
                            @endforeach
                        @else
                            @foreach(['alquiler', 'venta', 'obra_nueva', 'viviendas_de_lujo'] as $type)
                                <a href="#" class="james-mobile-sublink">
                                    {{ __('messages.' . $type) }}
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>

                <a href="#servicios" class="james-mobile-link">{{ __('messages.servicios') }}</a>
                <a href="#nosotros" class="james-mobile-link">{{ __('messages.about_us') }}</a>
                <a href="#contacto" class="james-mobile-link">{{ __('messages.contacto') }}</a>

                <!-- Mobile Actions -->
                 <div class="pt-4 mt-6 border-t border-gray-100 space-y-3">
                    <button x-data x-on:click="$dispatch('open-search')" 
                            class="james-mobile-search-btn">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <span>{{ __('messages.buscar') }}</span>
                    </button>
                    
                {{--    <a href="#" class="james-mobile-cta-btn">
                        Sell With Ussss
                    </a>{{-- --}} --}}
                </div> 
            </div>
        </div>
    </div>
</nav>