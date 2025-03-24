<nav x-data="{ scrolled: false }"
     @scroll.window="scrolled = (window.pageYOffset > 20)"
     :class="{ 'bg-dark/45 backdrop-blur-md shadow-xl border-b border-amber-300/20': scrolled }"
     class="fixed top-0 left-0 right-0 w-full transition-all duration-300 z-50">

     <!-- Contenedor para el contenido del nav -->
     <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <!-- Línea decorativa superior - visible solo cuando no hay scroll -->
        <div x-show="!scrolled"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-amber-400 to-transparent opacity-40">
        </div>

        <!-- Logo y branding -->
        <div class="flex items-center">
            <div class="text-2xl font-bold">
                <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="flex items-center">
                    <img src="{{ asset('assets/images/rb/logo-gold.png') }}" alt="ConfortHouse" class="w-48">
                </a>
            </div>
        </div>


        <!-- Menú de navegación para desktop con mejoras estéticas -->
        <div class="hidden lg:flex space-x-8 items-center">
            <!-- Buscador elegante -->
            <div class="relative">
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="flex items-center text-amber-300 opacity-80 hover:opacity-100 transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <span class="ml-2 font-luxury">{{ __('messages.search_button') }}</span>
                    </button>

                    <!-- Dropdown de búsqueda -->
                    <div x-show="open" @click.away="open = false"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        class="absolute top-10 right-0 bg-gray-900 bg-opacity-95 backdrop-blur-md border border-amber-300/20 rounded-sm p-4 w-72 luxury-dropdown"
                        style="display: none;">
                        <form id="searchForm" class="flex flex-col space-y-4">
                            <input type="text" placeholder="{{ __('messages.que_esta_bunscando') }}"
                                class="bg-transparent border-b border-amber-300/30 px-2 py-1 text-white focus:outline-none focus:border-amber-300/70 transition duration-300 font-luxury-sans text-sm">

                            <div class="grid grid-cols-2 gap-2 mt-2">
                                <select
                                    class="bg-gray-800 bg-opacity-50 border border-amber-300/20 rounded-sm px-2 py-1 text-amber-100 text-sm focus:outline-none focus:border-amber-300/70 font-luxury-sans">
                                    <option value="">{{ __('messages.tipo_de_propiedad') }}</option>
                                    <option value="villa">{{ __('messages.apartamento') }}</option>
                                    <option value="penthouse">{{ __('messages.finca') }}</option>
                                    <option value="mansion">{{ __('messages.casa') }}</option>
                                </select>

                                <select
                                    class="bg-gray-800 bg-opacity-50 border border-amber-300/20 rounded-sm px-2 py-1 text-amber-100 text-sm focus:outline-none focus:border-amber-300/70 font-luxury-sans">
                                    <option value="">{{ __('messages.ubicacion') }}</option>
                                    <option value="beach">{{ __('messages.lugar_a') }}</option>
                                    <option value="mountain">{{ __('messages.lugar_b') }}</option>
                                    <option value="city">{{ __('messages.lugar_c') }}</option>
                                </select>
                            </div>

                            <button type="submit"
                                class="bg-amber-300/80 hover:bg-amber-400 text-gray-900 px-4 py-2 rounded-sm text-sm font-medium transition duration-300 font-luxury-sans btn-luxury">
                                {{ __('messages.search_button') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div x-data="{ open: false }" class="relative group">
                <button @click="open = !open"
                    class="flex items-center text-white hover:text-amber-300 transition duration-300 menu-link font-luxury">
                    {{ __('messages.propiedades') }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-98"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    class="absolute z-10 mt-4 rounded-sm p-4 w-80 luxury-dropdown">

                    <!-- Propiedad destacada en menú -->
                    <div class="mb-4 featured-property">
                        <img src="{{ asset('assets/images/gallery/thumbnail/full_1/15.jpg') }}" alt="Propiedad destacada"
                            class="w-full h-32 object-cover rounded-sm"
                            onerror="this.src='https://via.placeholder.com/300x150?text=Propiedad+Destacada'">
                        <div class="property-label">
                            <p class="text-amber-300 text-xs font-luxury">Propiedad destacada</p>
                            <p class="text-white text-sm font-luxury-sans">Villa con vistas al mediterráneo</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-x-6 gap-y-3">
                        <a href="#"
                            class="text-amber-300 hover:text-amber-200 transition duration-300 font-luxury-sans text-sm flex items-center">
                            <span class="w-1 h-1 bg-amber-400 rounded-full mr-2"></span>
                            {{ __('messages.alquiler') }}
                        </a>
                        <a href="#"
                            class="text-amber-300 hover:text-amber-200 transition duration-300 font-luxury-sans text-sm flex items-center">
                            <span class="w-1 h-1 bg-amber-400 rounded-full mr-2"></span>
                            {{ __('messages.venta') }}
                        </a>
                        <a href="#"
                            class="text-amber-300 hover:text-amber-200 transition duration-300 font-luxury-sans text-sm flex items-center">
                            <span class="w-1 h-1 bg-amber-400 rounded-full mr-2"></span>
                            {{ __('messages.obra_nueva') }}
                        </a>
                        <a href="#"
                            class="text-amber-300 hover:text-amber-200 transition duration-300 font-luxury-sans text-sm flex items-center">
                            <span class="w-1 h-1 bg-amber-400 rounded-full mr-2"></span>
                            {{ __('messages.viviendas_de_lujo') }}
                        </a>
                    </div>

                    <!-- CTA para colección privada -->
                    <div class="mt-5 pt-4 border-t border-amber-300/20">
                        <a href="#"
                            class="text-amber-300 hover:text-amber-200 transition duration-300 flex items-center justify-between font-luxury">
                            <span>Colección exclusiva</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div x-data="{ open: false }" class="relative group">
                <button @click="open = !open"
                    class="flex items-center text-white hover:text-amber-300 transition duration-300 menu-link font-luxury">
                    {{ __('messages.servicios') }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-98"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    class="absolute z-10 mt-4 rounded-sm p-4 w-72 luxury-dropdown">

                    <!-- Servicios con iconos -->
                    <div class="grid grid-cols-1 gap-3">
                        <a href="#" class="flex items-center group">
                            <span
                                class="w-10 h-10 rounded-full bg-amber-300/10 flex items-center justify-center mr-3 group-hover:bg-amber-300/20 transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-300" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <div>
                                <p class="text-amber-300 font-luxury text-sm">{{ __('messages.serv_tasacion') }}</p>
                                <p class="text-gray-400 text-xs font-luxury-sans">Valoración profesional de su propiedad
                                </p>
                            </div>
                        </a>
                        <a href="#" class="flex items-center group">
                            <span
                                class="w-10 h-10 rounded-full bg-amber-300/10 flex items-center justify-center mr-3 group-hover:bg-amber-300/20 transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-300" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </span>
                            <div>
                                <p class="text-amber-300 font-luxury text-sm">{{ __('messages.serv_consultoria') }}</p>
                                <p class="text-gray-400 text-xs font-luxury-sans">Asesoramiento inmobiliario personalizado
                                </p>
                            </div>
                        </a>
                        <a href="#" class="flex items-center group">
                            <span
                                class="w-10 h-10 rounded-full bg-amber-300/10 flex items-center justify-center mr-3 group-hover:bg-amber-300/20 transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-300" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <div>
                                <p class="text-amber-300 font-luxury text-sm">{{ __('messages.serv_inversion') }}</p>
                                <p class="text-gray-400 text-xs font-luxury-sans">Oportunidades de inversión inmobiliaria
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <a href="#"
                class="text-white hover:text-amber-300 transition duration-300 menu-link font-luxury">{{ __('messages.about_us') }}</a>
            <a href="#"
                class="text-white hover:text-amber-300 transition duration-300 menu-link font-luxury">{{ __('messages.contacto') }}</a>

            <!-- Selector de idioma mejorado -->
            <div x-data="{ open: false }" class="relative group">
                <button @click="open = !open"
                    class="flex items-center text-white hover:text-amber-300 transition duration-300 menu-link font-luxury">
                    <img src="{{ asset('assets/images/flags/4x3/' . app()->getLocale() . '.svg') }}"
                        alt="{{ app()->getLocale() }}" class="w-5 h-4 mr-2">
                    <span class="text-sm">{{ strtoupper(app()->getLocale()) }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" x-cloac @click.away="open = false" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-98"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    class="absolute right-0 z-10 mt-4 rounded-sm p-3 w-48 luxury-dropdown">
                    <div class="flex flex-col space-y-2">
                        <a href="{{ route(Route::currentRouteName(), ['locale' => 'es'] + Route::current()->parameters()) }}"
                            class="flex justify-between items-center px-3 py-2 rounded-sm hover:bg-amber-300/10 transition duration-300">
                            <span class="text-amber-300 text-sm font-luxury-sans">{{ __('messages.lang_es') }}</span>
                            <img src="{{ asset('assets/images/flags/4x3/es.svg') }}" alt="Spanish" class="w-5 h-4">
                        </a>
                        <a href="{{ route(Route::currentRouteName(), ['locale' => 'en'] + Route::current()->parameters()) }}"
                            class="flex justify-between items-center px-3 py-2 rounded-sm hover:bg-amber-300/10 transition duration-300">
                            <span class="text-amber-300 text-sm font-luxury-sans">{{ __('messages.lang_en') }}</span>
                            <img src="{{ asset('assets/images/flags/4x3/en.svg') }}" alt="English" class="w-5 h-4">
                        </a>
                        <a href="{{ route(Route::currentRouteName(), ['locale' => 'fr'] + Route::current()->parameters()) }}"
                            class="flex justify-between items-center px-3 py-2 rounded-sm hover:bg-amber-300/10 transition duration-300">
                            <span class="text-amber-300 text-sm font-luxury-sans">{{ __('messages.lang_fr') }}</span>
                            <img src="{{ asset('assets/images/flags/4x3/fr.svg') }}" alt="French" class="w-5 h-4">
                        </a>
                        <a href="{{ route(Route::currentRouteName(), ['locale' => 'de'] + Route::current()->parameters()) }}"
                            class="flex justify-between items-center px-3 py-2 rounded-sm hover:bg-amber-300/10 transition duration-300">
                            <span class="text-amber-300 text-sm font-luxury-sans">{{ __('messages.lang_de') }}</span>
                            <img src="{{ asset('assets/images/flags/4x3/de.svg') }}" alt="German" class="w-5 h-4">
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contacto y CTA -->
        <div class="hidden lg:flex items-center space-x-4">
            <!-- Número de contacto exclusivo -->
            <div class="mr-2">
                <p class="text-amber-300 text-xs font-luxury-sans">{{ __('messages.atencion_exclusiva') }}</p>
                <p class="text-white font-luxury-sans">+34 900 123 456</p>
            </div>
            <!-- Botón de acceso -->
            <a href="#"
                class="border border-amber-300 px-5 py-2 text-amber-300 hover:bg-amber-300 hover:text-gray-900 transition duration-500 font-luxury text-sm btn-luxury">
            {{ __('messages.coleccion_privada') }}
            </a>
        </div>

        <!-- Botón de menú móvil -->
        <div class="lg:hidden relative z-20" x-data="{ open: false }">
            <button @click="open = !open"
                class="text-amber-300 hover:text-amber-200 focus:outline-none">
                <svg x-show="!open" class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4 6h16v2H4V6zm0 5h16v2H4v-2zm0 5h16v2H4v-2z"></path>
                </svg>
                <svg x-show="open" class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M18.278 16.864a1 1 0 01-1.414 1.414l-4.829-4.828-4.828 4.828a1 1 0 01-1.414-1.414l4.828-4.829-4.828-4.828a1 1 0 011.414-1.414l4.829 4.828 4.828-4.828a1 1 0 111.414 1.414l-4.828 4.829 4.828 4.828z">
                    </path>
                </svg>
            </button>

            <!-- Menú móvil desplegable mejorado -->
            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform -translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                class="absolute right-0 mt-4 w-64 bg-gray-900 bg-opacity-95 backdrop-blur-md border border-amber-300/20 rounded-sm shadow-2xl py-4 luxury-dropdown">

                <!-- Teléfono de contacto en móvil -->
                <div class="px-4 pb-4 mb-4 border-b border-amber-300/20">
                    <p class="text-amber-300 text-xs font-luxury-sans">Atención exclusiva</p>
                    <p class="text-white font-luxury text-sm">+34 900 123 456</p>
                </div>

                <!-- Buscador móvil -->
                <div class="px-4 pb-4 mb-4 border-b border-amber-300/20">
                    <form id="searchFormMobile" class="flex flex-col space-y-4">
                        <input type="text" placeholder="¿Qué está buscando?"
                            class="w-full bg-transparent border-b border-amber-300/30 px-2 py-1 text-white focus:outline-none focus:border-amber-300/70 transition duration-300 font-luxury-sans text-sm">

                        <div class="grid grid-cols-1 gap-2">
                            <select
                                class="w-full bg-gray-800 bg-opacity-50 border border-amber-300/20 rounded-sm px-2 py-1 text-amber-100 text-sm focus:outline-none focus:border-amber-300/70 font-luxury-sans">
                                <option value="">Tipo de propiedad</option>
                                <option value="villa">Villa</option>
                                <option value="penthouse">Ático</option>
                                <option value="mansion">Mansión</option>
                            </select>

                            <select
                                class="w-full bg-gray-800 bg-opacity-50 border border-amber-300/20 rounded-sm px-2 py-1 text-amber-100 text-sm focus:outline-none focus:border-amber-300/70 font-luxury-sans">
                                <option value="">Ubicación</option>
                                <option value="beach">Primera línea</option>
                                <option value="mountain">Montaña</option>
                                <option value="city">Centro ciudad</option>
                            </select>
                        </div>

                        <button type="submit"
                            class="w-full bg-amber-300/80 hover:bg-amber-400 text-gray-900 px-4 py-2 rounded-sm text-sm font-medium transition duration-300 font-luxury-sans btn-luxury">
                            Buscar propiedades
                        </button>
                    </form>
                </div>

                <!-- Menús del móvil con mejoras -->
                <div x-data="{ subMenu: false }" class="relative">
                    <button @click="subMenu = !subMenu"
                        class="w-full text-left px-4 py-3 text-amber-300 hover:bg-amber-300/10 flex justify-between items-center transition duration-300">
                        <span class="font-luxury">{{ __('messages.propiedades') }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path x-show="!subMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 9l-7 7-7-7" />
                            <path x-show="subMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M5 15l7-7 7 7" />
                        </svg>
                    </button>
                    <div x-show="subMenu" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        class="pl-8 pb-2 pt-1 bg-gray-800 bg-opacity-50">
                        <a href="#"
                            class="block px-4 py-2 text-white hover:text-amber-300 transition duration-300 font-luxury-sans">{{ __('messages.alquiler') }}</a>
                        <a href="#"
                            class="block px-4 py-2 text-white hover:text-amber-300 transition duration-300 font-luxury-sans">{{ __('messages.venta') }}</a>
                        <a href="#"
                            class="block px-4 py-2 text-white hover:text-amber-300 transition duration-300 font-luxury-sans">{{ __('messages.obra_nueva') }}</a>
                        <a href="#"
                            class="block px-4 py-2 text-white hover:text-amber-300 transition duration-300 font-luxury-sans">{{ __('messages.viviendas_de_lujo') }}</a>
                    </div>
                </div>

                <div x-data="{ subMenu: false }" class="relative">
                    <button @click="subMenu = !subMenu"
                        class="w-full text-left px-4 py-3 text-amber-300 hover:bg-amber-300/10 flex justify-between items-center transition duration-300">
                        <span class="font-luxury">{{ __('messages.servicios') }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path x-show="!subMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 9l-7 7-7-7" />
                            <path x-show="subMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M5 15l7-7 7 7" />
                        </svg>
                    </button>
                    <div x-show="subMenu" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        class="pl-8 pb-2 pt-1 bg-gray-800 bg-opacity-50">
                        <a href="#"
                            class="block px-4 py-2 text-white hover:text-amber-300 transition duration-300 font-luxury-sans">{{ __('messages.serv_tasacion') }}</a>
                        <a href="#"
                            class="block px-4 py-2 text-white hover:text-amber-300 transition duration-300 font-luxury-sans">{{ __('messages.serv_consultoria') }}</a>
                        <a href="#"
                            class="block px-4 py-2 text-white hover:text-amber-300 transition duration-300 font-luxury-sans">{{ __('messages.serv_inversion') }}</a>
                    </div>
                </div>

                <a href="#"
                    class="block px-4 py-3 text-amber-300 hover:bg-amber-300/10 transition duration-300 font-luxury">{{ __('messages.about_us') }}</a>
                <a href="#"
                    class="block px-4 py-3 text-amber-300 hover:bg-amber-300/10 transition duration-300 font-luxury">{{ __('messages.contacto') }}</a>

                <!-- Selector de idioma móvil -->
                <div x-data="{ subMenu: false }" class="relative">
                    <button @click="subMenu = !subMenu"
                        class="w-full text-left px-4 py-3 text-amber-300 hover:bg-amber-300/10 flex justify-between items-center transition duration-300">
                        <div class="flex items-center">
                            <img src="{{ asset('assets/images/flags/4x3/' . app()->getLocale() . '.svg') }}"
                                alt="{{ app()->getLocale() }}" class="w-5 h-4 mr-2">
                            <span class="font-luxury">{{ strtoupper(app()->getLocale()) }}</span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path x-show="!subMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 9l-7 7-7-7" />
                            <path x-show="subMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M5 15l7-7 7 7" />
                        </svg>
                    </button>
                    <div x-show="subMenu" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        class="pl-8 pb-2 pt-1 bg-gray-800 bg-opacity-50">
                        <a href="{{ route(Route::currentRouteName(), ['locale' => 'es'] + Route::current()->parameters()) }}"
                            class="flex items-center px-4 py-2 text-white hover:text-amber-300 transition duration-300 font-luxury-sans">
                            <img src="{{ asset('assets/images/flags/4x3/es.svg') }}" alt="Spanish"
                                class="w-5 h-4 mr-2">
                            {{ __('messages.lang_es') }}
                        </a>
                        <a href="{{ route(Route::currentRouteName(), ['locale' => 'en'] + Route::current()->parameters()) }}"
                            class="flex items-center px-4 py-2 text-white hover:text-amber-300 transition duration-300 font-luxury-sans">
                            <img src="{{ asset('assets/images/flags/4x3/en.svg') }}" alt="English"
                                class="w-5 h-4 mr-2">
                            {{ __('messages.lang_en') }}
                        </a>
                        <a href="{{ route(Route::currentRouteName(), ['locale' => 'fr'] + Route::current()->parameters()) }}"
                            class="flex items-center px-4 py-2 text-white hover:text-amber-300 transition duration-300 font-luxury-sans">
                            <img src="{{ asset('assets/images/flags/4x3/fr.svg') }}" alt="French"
                                class="w-5 h-4 mr-2">
                            {{ __('messages.lang_fr') }}
                        </a>
                        <a href="{{ route(Route::currentRouteName(), ['locale' => 'de'] + Route::current()->parameters()) }}"
                            class="flex items-center px-4 py-2 text-white hover:text-amber-300 transition duration-300 font-luxury-sans">
                            <img src="{{ asset('assets/images/flags/4x3/de.svg') }}" alt="German"
                                class="w-5 h-4 mr-2">
                            {{ __('messages.lang_de') }}
                        </a>
                    </div>
                </div>

                <!-- Botón CTA móvil -->
                <div class="px-4 pt-4 mt-4 border-t border-amber-300/20">
                    <a href="#"
                        class="block w-full text-center px-4 py-2 bg-amber-300 text-gray-900 rounded-sm hover:bg-amber-400 transition duration-300 font-luxury">
                        Colección Privada
                    </a>
                </div>
            </div>
        </div>

        <!-- Línea decorativa inferior - visible solo cuando no hay scroll -->
        <div x-show="!scrolled"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute bottom-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-amber-400 to-transparent opacity-40">
        </div>
    </div>
</nav>
<!-- Espaciador para compensar el nav fijo -->
<div class="h-20"></div>
