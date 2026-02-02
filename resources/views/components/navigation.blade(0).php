@props(['operations' => collect()])

<nav class="luxury-nav fixed w-full top-0 z-50 transition-all duration-300" 
     x-data="{ scrolled: false, mobileOpen: false }"
     x-init="() => {
         const updateNavbar = () => {
             scrolled = window.scrollY > 50;
         };
         window.addEventListener('scroll', updateNavbar);
         updateNavbar();
     }"
     :class="{ 'luxury-nav-scrolled': scrolled }">
    
    <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12">
        <div class="flex items-center justify-between h-20">
            
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" 
                   class="luxury-logo">
                   <img src="{{ asset('assets/images/logo/conforthouse-logo-1.png') }}" style= "height: 40px;" >
                    {{-- ConfortHouse Living --}}
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-8">
                
                <!-- Home -->
                <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" 
                   class="nav-link-luxury {{ request()->routeIs('home') ? 'active' : '' }}">
                    {{ __('messages.inicio') }}
                </a>

                <!-- Properties Dropdown -->
                <div class="relative group">
                    <button class="nav-link-luxury flex items-center space-x-1 group-hover:text-gold-400">
                        <span>{{ __('messages.propiedades') }}</span>
                        <svg class="w-4 h-4 transform group-hover:rotate-180 transition-transform duration-300">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" 
                                  stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 w-64 
                                bg-black bg-opacity-95 backdrop-blur-lg rounded-lg shadow-luxury 
                                border border-gold-600 border-opacity-20 
                                opacity-0 invisible group-hover:opacity-100 group-hover:visible 
                                transition-all duration-300 ease-out">
                        
                        <div class="py-4 px-2">
                            <!-- All Properties Link -->
                            <a href="{{ route('properties.index', ['locale' => app()->getLocale()]) }}" 
                               class="block px-4 py-3 text-sm text-white hover:text-gold-400 
                                      hover:bg-gold-600 hover:bg-opacity-10 rounded-md 
                                      transition-all duration-200 font-medium">
                                {{ __('messages.todas_propiedades') }}
                            </a>
                            
                            <div class="my-2 mx-4 h-px bg-gradient-to-r from-transparent via-gold-600 via-opacity-30 to-transparent"></div>
                            
                            <!-- Operations -->
                            @if($operations->count() > 0)
                                @foreach($operations as $operation)
                                    <a href="{{ route('properties.index', ['locale' => app()->getLocale(), 'operation_id' => $operation->id]) }}" 
                                       class="block px-4 py-3 text-sm text-neutral-300 hover:text-gold-400 
                                              hover:bg-gold-600 hover:bg-opacity-10 rounded-md 
                                              transition-all duration-200">
                                        {{ $operation->name }}
                                    </a>
                                @endforeach
                            @else
                                <a href="#" class="block px-4 py-3 text-sm text-neutral-300 hover:text-gold-400 
                                                 hover:bg-gold-600 hover:bg-opacity-10 rounded-md 
                                                 transition-all duration-200">
                                    {{ __('messages.alquiler') }}
                                </a>
                                <a href="#" class="block px-4 py-3 text-sm text-neutral-300 hover:text-gold-400 
                                                 hover:bg-gold-600 hover:bg-opacity-10 rounded-md 
                                                 transition-all duration-200">
                                    {{ __('messages.venta') }}
                                </a>
                                <a href="#" class="block px-4 py-3 text-sm text-neutral-300 hover:text-gold-400 
                                                 hover:bg-gold-600 hover:bg-opacity-10 rounded-md 
                                                 transition-all duration-200">
                                    {{ __('messages.obra_nueva') }}
                                </a>
                                <a href="#" class="block px-4 py-3 text-sm text-neutral-300 hover:text-gold-400 
                                                 hover:bg-gold-600 hover:bg-opacity-10 rounded-md 
                                                 transition-all duration-200">
                                    {{ __('messages.viviendas_de_lujo') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Services -->
                <a href="{{ route('services', ['locale' => app()->getLocale()]) }}" class="nav-link-luxury">
                    {{ __('messages.servicios') }}
                </a>

                <!-- About -->
                <a href="#nosotros" class="nav-link-luxury">
                    {{ __('messages.about_us') }}
                </a>

                <!-- Contact -->
                <a href="#contacto" class="nav-link-luxury">
                    {{ __('messages.contacto') }}
                </a>
                
                <!-- Language Selector -->
                <div class="relative group">
                    <button class="nav-link-luxury flex items-center space-x-2">
                        <img src="{{ asset('assets/images/flags/4x3/' . app()->getLocale() . '.svg') }}"
                             alt="{{ app()->getLocale() }}" 
                             class="w-5 h-3">
                        <span>{{ strtoupper(app()->getLocale()) }}</span>
                        <svg class="w-4 h-4 transform group-hover:rotate-180 transition-transform duration-300">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" 
                                  stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    
                    <div class="absolute right-0 top-full mt-2 w-48 
                                bg-black bg-opacity-95 backdrop-blur-lg rounded-lg shadow-luxury 
                                border border-gold-600 border-opacity-20 
                                opacity-0 invisible group-hover:opacity-100 group-hover:visible 
                                transition-all duration-300 ease-out">
                        
                        <div class="py-2">
                            <a href="{{ route(Route::currentRouteName(), ['locale' => 'es'] + Route::current()->parameters()) }}"
                               class="flex items-center px-4 py-3 text-sm text-white hover:text-gold-400 
                                      hover:bg-gold-600 hover:bg-opacity-10 transition-all duration-200 
                                      {{ app()->getLocale() == 'es' ? 'text-gold-400 bg-gold-600 bg-opacity-10' : '' }}">
                                <img src="{{ asset('assets/images/flags/4x3/es.svg') }}" 
                                     alt="Español" class="w-5 h-3 mr-3">
                                {{ __('messages.lang_es') }}
                            </a>
                            
                            <a href="{{ route(Route::currentRouteName(), ['locale' => 'en'] + Route::current()->parameters()) }}"
                               class="flex items-center px-4 py-3 text-sm text-white hover:text-gold-400 
                                      hover:bg-gold-600 hover:bg-opacity-10 transition-all duration-200
                                      {{ app()->getLocale() == 'en' ? 'text-gold-400 bg-gold-600 bg-opacity-10' : '' }}">
                                <img src="{{ asset('assets/images/flags/4x3/en.svg') }}" 
                                     alt="English" class="w-5 h-3 mr-3">
                                {{ __('messages.lang_en') }}
                            </a>
                            
                            <a href="{{ route(Route::currentRouteName(), ['locale' => 'fr'] + Route::current()->parameters()) }}"
                               class="flex items-center px-4 py-3 text-sm text-white hover:text-gold-400 
                                      hover:bg-gold-600 hover:bg-opacity-10 transition-all duration-200
                                      {{ app()->getLocale() == 'fr' ? 'text-gold-400 bg-gold-600 bg-opacity-10' : '' }}">
                                <img src="{{ asset('assets/images/flags/4x3/fr.svg') }}" 
                                     alt="Français" class="w-5 h-3 mr-3">
                                {{ __('messages.lang_fr') }}
                            </a>
                            
                            <a href="{{ route(Route::currentRouteName(), ['locale' => 'de'] + Route::current()->parameters()) }}"
                               class="flex items-center px-4 py-3 text-sm text-white hover:text-gold-400 
                                      hover:bg-gold-600 hover:bg-opacity-10 transition-all duration-200 rounded-b-lg
                                      {{ app()->getLocale() == 'de' ? 'text-gold-400 bg-gold-600 bg-opacity-10' : '' }}">
                                <img src="{{ asset('assets/images/flags/4x3/de.svg') }}" 
                                     alt="Deutsch" class="w-5 h-3 mr-3">
                                {{ __('messages.lang_de') }}
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Search Button -->
                <button x-data x-on:click="$dispatch('open-search')" 
                        class="nav-link-luxury flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                              stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <span class="hidden xl:inline">{{ __('messages.buscar') }}</span>
                </button>
            </div>

            <!-- Mobile Menu Button -->
            <div class="lg:hidden">
                <button @click="mobileOpen = !mobileOpen" 
                        class="text-white hover:text-gold-400 focus:outline-none focus:text-gold-400 
                               transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor">
                        <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" 
                              stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" 
                              stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
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
             class="lg:hidden bg-black bg-opacity-95 backdrop-blur-lg border-t border-gold-600 border-opacity-20">
            
            <div class="px-4 py-6 space-y-6">
                
                <!-- Mobile Home -->
                <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" 
                   class="block text-white hover:text-gold-400 font-medium text-lg transition-colors duration-200
                          {{ request()->routeIs('home') ? 'text-gold-400' : '' }}">
                    {{ __('messages.inicio') }}
                </a>

                <!-- Mobile Properties -->
                <div x-data="{ open: false }">
                    <button @click="open = !open" 
                            class="flex items-center justify-between w-full text-white hover:text-gold-400 
                                   font-medium text-lg transition-colors duration-200">
                        <span>{{ __('messages.propiedades') }}</span>
                        <svg class="w-5 h-5 transform transition-transform duration-200" 
                             :class="{ 'rotate-180': open }">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" 
                                  stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    
                    <div x-show="open" x-collapse class="mt-4 ml-4 space-y-3">
                        <a href="{{ route('properties.index', ['locale' => app()->getLocale()]) }}" 
                           class="block text-neutral-300 hover:text-gold-400 transition-colors duration-200">
                            {{ __('messages.todas_propiedades') }}
                        </a>
                        
                        @if($operations->count() > 0)
                            @foreach($operations as $operation)
                                <a href="{{ route('properties.index', ['locale' => app()->getLocale(), 'operation_id' => $operation->id]) }}" 
                                   class="block text-neutral-300 hover:text-gold-400 transition-colors duration-200">
                                    {{ $operation->name }}
                                </a>
                            @endforeach
                        @else
                            <a href="#" class="block text-neutral-300 hover:text-gold-400 transition-colors duration-200">
                                {{ __('messages.alquiler') }}
                            </a>
                            <a href="#" class="block text-neutral-300 hover:text-gold-400 transition-colors duration-200">
                                {{ __('messages.venta') }}
                            </a>
                            <a href="#" class="block text-neutral-300 hover:text-gold-400 transition-colors duration-200">
                                {{ __('messages.obra_nueva') }}
                            </a>
                            <a href="#" class="block text-neutral-300 hover:text-gold-400 transition-colors duration-200">
                                {{ __('messages.viviendas_de_lujo') }}
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Mobile Services -->
                <a href="{{ route('services', ['locale' => app()->getLocale()]) }}" 
                   class="block text-white hover:text-gold-400 font-medium text-lg transition-colors duration-200">
                    {{ __('messages.servicios') }}
                </a>

                <!-- Mobile About -->
                <a href="{{ route('about', ['locale' => app()->getLocale()]) }}" 
                   class="block text-white hover:text-gold-400 font-medium text-lg transition-colors duration-200">
                    {{ __('messages.about_us') }}
                </a>

                <!-- Mobile Contact -->
                <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" 
                   class="block text-white hover:text-gold-400 font-medium text-lg transition-colors duration-200">
                    {{ __('messages.contacto') }}
                </a>

                <!-- Mobile Language Selector -->
                <div x-data="{ open: false }" class="border-t border-gold-600 border-opacity-20 pt-4">
                    <button @click="open = !open" 
                            class="flex items-center justify-between w-full text-white hover:text-gold-400 
                                   font-medium text-lg transition-colors duration-200">
                        <div class="flex items-center space-x-3">
                            <img src="{{ asset('assets/images/flags/4x3/' . app()->getLocale() . '.svg') }}"
                                 alt="{{ app()->getLocale() }}" 
                                 class="w-5 h-3">
                            <span>{{ __('messages.sel_lang') }}</span>
                        </div>
                        <svg class="w-5 h-5 transform transition-transform duration-200" 
                             :class="{ 'rotate-180': open }">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" 
                                  stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    
                    <div x-show="open" x-collapse class="mt-4 ml-4 space-y-3">
                        <a href="{{ route(Route::currentRouteName(), ['locale' => 'es'] + Route::current()->parameters()) }}"
                           class="flex items-center space-x-3 text-neutral-300 hover:text-gold-400 
                                  transition-colors duration-200
                                  {{ app()->getLocale() == 'es' ? 'text-gold-400' : '' }}">
                            <img src="{{ asset('assets/images/flags/4x3/es.svg') }}" 
                                 alt="Español" class="w-5 h-3">
                            <span>{{ __('messages.lang_es') }}</span>
                        </a>
                        
                        <a href="{{ route(Route::currentRouteName(), ['locale' => 'en'] + Route::current()->parameters()) }}"
                           class="flex items-center space-x-3 text-neutral-300 hover:text-gold-400 
                                  transition-colors duration-200
                                  {{ app()->getLocale() == 'en' ? 'text-gold-400' : '' }}">
                            <img src="{{ asset('assets/images/flags/4x3/en.svg') }}" 
                                 alt="English" class="w-5 h-3">
                            <span>{{ __('messages.lang_en') }}</span>
                        </a>
                        
                        <a href="{{ route(Route::currentRouteName(), ['locale' => 'fr'] + Route::current()->parameters()) }}"
                           class="flex items-center space-x-3 text-neutral-300 hover:text-gold-400 
                                  transition-colors duration-200
                                  {{ app()->getLocale() == 'fr' ? 'text-gold-400' : '' }}">
                            <img src="{{ asset('assets/images/flags/4x3/fr.svg') }}" 
                                 alt="Français" class="w-5 h-3">
                            <span>{{ __('messages.lang_fr') }}</span>
                        </a>
                        
                        <a href="{{ route(Route::currentRouteName(), ['locale' => 'de'] + Route::current()->parameters()) }}"
                           class="flex items-center space-x-3 text-neutral-300 hover:text-gold-400 
                                  transition-colors duration-200
                                  {{ app()->getLocale() == 'de' ? 'text-gold-400' : '' }}">
                            <img src="{{ asset('assets/images/flags/4x3/de.svg') }}" 
                                 alt="Deutsch" class="w-5 h-3">
                            <span>{{ __('messages.lang_de') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>