<x-guest-layout>
    <!-- Category Section -->
    <section class="py-20 bg-gray-50 relative overflow-hidden">
        <!-- Elementos decorativos de fondo -->
        <div class="absolute -top-24 -right-24 w-64 h-64 rounded-full bg-amber-100 opacity-20 blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 w-80 h-80 rounded-full bg-amber-200 opacity-10 blur-3xl"></div>

        <div class="container mx-auto px-6 relative z-10">
            <!-- Encabezado de sección con elemento decorativo -->
            <div class="text-center mb-16">
                <div class="inline-block mb-4">
                    <div class="flex items-center justify-center">
                        <div class="h-[1px] w-12 bg-gradient-to-r from-transparent to-amber-300"></div>
                        <span
                            class="mx-4 text-amber-400 text-sm luxury-nav uppercase tracking-widest font-light">{{ __('messages.descubre') }}</span>
                        <div class="h-[1px] w-12 bg-gradient-to-l from-transparent to-amber-300"></div>
                    </div>
                </div>
                <h2 class="text-4xl font-luxury font-light mb-3 text-gray-900">{{ __('messages.nuestras') }} <span
                        class="text-amber-400">{{ __('messages.Categorías') }}</span> Premium</h2>
                <p class="text-gray-500 max-w-xl mx-auto luxury-nav">{{ __('messages.Explora') }}</p>
            </div>

            <!-- Grid de categorías con animación en hover -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Categoría 1: Homes -->
                <div
                    class="luxury-category group relative overflow-hidden rounded-sm h-96 cursor-pointer shadow-xl transform transition-all duration-500 hover:shadow-2xl hover:-translate-y-1">
                    <!-- Imagen con efecto de zoom en hover -->
                    <div class="absolute inset-0 overflow-hidden">
                        <img src="{{ asset('assets/images/home/cat_homes.jpg') }}" alt="Luxury Homes"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    </div>

                    <!-- Overlay con gradiente mejorado -->
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent opacity-70 transition-opacity duration-500 group-hover:opacity-90">
                    </div>

                    <!-- Elemento decorativo - línea en hover -->
                    <div
                        class="absolute bottom-0 left-0 right-0 h-0.5 bg-amber-300 transform scale-x-0 origin-left transition-transform duration-500 group-hover:scale-x-100">
                    </div>

                    <a href="{{ route('prop.index', ['locale' => app()->getLocale(), 'type_id' => 1]) }}" class="block absolute bottom-0 left-0 w-full p-8 transform transition-transform duration-500 group-hover:translate-y-0 z-10">
                        <div class="transition-all duration-500 transform group-hover:-translate-y-2">
                            <h3 class="text-2xl font-luxury text-white mb-1 group-hover:text-amber-300 transition-colors duration-300">
                                {{ __('messages.Residencias') }}</h3>
                            <p class="text-sm text-gray-300 transition-all duration-500 opacity-80 group-hover:opacity-100">
                                {{ __('messages.Explore') }} 2,548 {{ __('messages.propiedades') }}</p>
                        </div>
                        <div class="overflow-hidden h-0 opacity-0 transition-all duration-500 group-hover:h-16 group-hover:opacity-100 mt-3">
                            <p class="text-sm text-white/70 mb-4 justify-end">
                                {{ __('messages.Mansiones, penthouses y residencias exclusivas') }}

                                <span class="flex justify-end text-amber-300 text-xs uppercase tracking-widest luxury-nav">
                                    {{ __('messages.discover') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </p>
                        </div>
                    </a>
                </div>

                <!-- Categoría 2: Apartments -->
                <div
                    class="luxury-category group relative overflow-hidden rounded-sm h-96 cursor-pointer shadow-xl transform transition-all duration-500 hover:shadow-2xl hover:-translate-y-1">
                    <div class="absolute inset-0 overflow-hidden">
                        <img src="{{ asset('assets/images/home/cat_apartments.jpg') }}" alt="Luxury Apartments"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    </div>
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent opacity-70 transition-opacity duration-500 group-hover:opacity-90">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 right-0 h-0.5 bg-amber-300 transform scale-x-0 origin-left transition-transform duration-500 group-hover:scale-x-100">
                    </div>
                    <a href="{{ route('prop.index', ['locale' => app()->getLocale(), 'type_id' => 2]) }}" class="block absolute bottom-0 left-0 w-full p-8 transform transition-transform duration-500 group-hover:translate-y-0 z-10">
                        <div
                            class="absolute bottom-0 left-0 p-8 transform transition-transform duration-500 group-hover:translate-y-0">
                            <div class="transition-all duration-500 transform group-hover:-translate-y-2">
                                <h3
                                    class="text-2xl font-luxury text-white mb-1 group-hover:text-amber-300 transition-colors duration-300">
                                    {{ __('messages.Apartamentos') }}</h3>
                                <p
                                    class="text-sm text-gray-300 transition-all duration-500 opacity-80 group-hover:opacity-100">
                                    {{ __('messages.Explore') }} 1,873 {{ __('messages.propiedades') }}</p>
                            </div>
                            <div
                                class="overflow-hidden h-0 opacity-0 transition-all duration-500 group-hover:h-16 group-hover:opacity-100 mt-3">
                                <p class="text-sm text-white/70 mb-4">
                                    {{ __('messages.Apartamentos de lujo y áticos con vistas panorámicas') }}

                                    <span class="flex justify-end text-amber-300 text-xs uppercase tracking-widest luxury-nav">
                                        {{ __('messages.discover') }}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Categoría 3: Villas -->
                <div
                    class="luxury-category group relative overflow-hidden rounded-sm h-96 cursor-pointer shadow-xl transform transition-all duration-500 hover:shadow-2xl hover:-translate-y-1">
                    <div class="absolute inset-0 overflow-hidden">
                        <img src="{{ asset('assets/images/home/cat_villas.png') }}" alt="Luxury Villas"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    </div>
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent opacity-70 transition-opacity duration-500 group-hover:opacity-90">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 right-0 h-0.5 bg-amber-300 transform scale-x-0 origin-left transition-transform duration-500 group-hover:scale-x-100">
                    </div>

                    <a href="{{ route('prop.index', ['locale' => app()->getLocale(), 'type_id' => 1]) }}" class="block absolute bottom-0 left-0 w-full p-8 transform transition-transform duration-500 group-hover:translate-y-0 z-10">
                        <div class="transition-all duration-500 transform group-hover:-translate-y-2">
                            <h3 class="text-2xl font-luxury text-white mb-1 group-hover:text-amber-300 transition-colors duration-300">
                                {{ __('messages.Villas') }}</h3>
                            <p class="text-sm text-gray-300 transition-all duration-500 opacity-80 group-hover:opacity-100">
                                {{ __('messages.Explore') }} 964 {{ __('messages.propiedades') }}</p>
                        </div>
                        <div class="overflow-hidden h-0 opacity-0 transition-all duration-500 group-hover:h-16 group-hover:opacity-100 mt-3">
                            <p class="text-sm text-white/70 mb-4">
                                {{ __('messages.Villas exclusivas con amplios jardines y piscina privada') }}

                                <span class="flex justify-end text-amber-300 text-xs uppercase tracking-widest luxury-nav">
                                    {{ __('messages.discover') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </p>
                        </div>
                    </a>
                </div>

                <!-- Categoría 4: Estates -->
                <div
                    class="luxury-category group relative overflow-hidden rounded-sm h-96 cursor-pointer shadow-xl transform transition-all duration-500 hover:shadow-2xl hover:-translate-y-1">
                    <div class="absolute inset-0 overflow-hidden">
                        <img src="{{ asset('assets/images/home/cat_states.jpg') }}" alt="Luxury Estates"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    </div>
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent opacity-70 transition-opacity duration-500 group-hover:opacity-90">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 right-0 h-0.5 bg-amber-300 transform scale-x-0 origin-left transition-transform duration-500 group-hover:scale-x-100">
                    </div>
                    <a href="{{ route('prop.index', ['locale' => app()->getLocale(), 'type_id' => 1]) }}" class="block absolute bottom-0 left-0 w-full p-8 transform transition-transform duration-500 group-hover:translate-y-0 z-10">
                        <div class="transition-all duration-500 transform group-hover:-translate-y-2">
                            <h3 class="text-2xl font-luxury text-white mb-1 group-hover:text-amber-300 transition-colors duration-300">
                                {{ __('messages.Fincas') }}</h3>
                            <p class="text-sm text-gray-300 transition-all duration-500 opacity-80 group-hover:opacity-100">
                                {{ __('messages.Explore') }} 452 {{ __('messages.propiedades') }}</p>
                        </div>
                        <div class="overflow-hidden h-0 opacity-0 transition-all duration-500 group-hover:h-16 group-hover:opacity-100 mt-3">
                            <p class="text-sm text-white/70 mb-4">
                                {{ __('messages.Haciendas y fincas de lujo con amplios terrenos') }}
                                <span class="flex justify-end text-amber-300 text-xs uppercase tracking-widest luxury-nav">
                                    {{ __('messages.discover') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Botón Ver Todas las Categorías -->
            <div class="text-center mt-12">
                <a href="{{ route('prop.index', ['locale' => app()->getLocale()]) }}"
                    class="btn-luxury inline-block bg-transparent border border-amber-400 text-amber-500 hover:bg-amber-400 hover:text-gray-900 px-10 py-3 text-sm font-medium luxury-nav uppercase tracking-widest rounded-sm transition-all duration-500">
                    {{ __('messages.Ver todas las categorías') }}
                </a>
            </div>
        </div>
    </section>

    <!-- Sección de Propiedad Destacada -->
    @if($featuredProperty)
        <section class="py-16 bg-dark">
            <div class="container mx-auto px-6">
                <div
                    class="group relative overflow-hidden rounded-sm shadow-xl transform transition-all duration-500 hover:shadow-2xl">
                    <div class="flex flex-col md:flex-row">
                        <!-- Contenedor de imagen con efecto hover -->
                        <div class="md:w-1/2 h-96 md:h-auto relative overflow-hidden">
                            <img src="/storage/{{ $featuredProperty->images->first()->image_path }}" alt="{{ $featuredProperty->title }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            <!-- Overlay con gradiente para profundidad -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent opacity-70 transition-opacity duration-500 group-hover:opacity-90">
                            </div>
                        </div>

                        <!-- Contenido con diseño de lujo -->
                        <div class="md:w-1/2 p-8 md:p-12 bg-white dark:bg-gray-900 relative">
                            <!-- Línea decorativa inferior que aparece en hover -->
                            <div
                                class="absolute bottom-0 left-0 right-0 h-0.5 bg-amber-300 transform scale-x-0 origin-left transition-transform duration-500 group-hover:scale-x-100">
                            </div>

                            <div class="transform transition-transform duration-500 group-hover:-translate-y-2">
                                <span
                                    class="text-xs uppercase font-luxury tracking-widest bg-amber-100 dark:bg-transparent dark:text-amber-300 text-gray-800 px-3 py-1 rounded-sm mb-6 inline-block relative">
                                    {{ __('messages.Propiedad Destacada') }}
                                </span>

                                <h2
                                    class="text-3xl font-luxury font-light mb-2 dark:text-white group-hover:text-amber-300 transition-colors duration-300">
                                    {{ $featuredProperty->title }}
                                </h2>

                                <p class="text-gray-700 dark:text-gray-300 mb-2 font-medium">
                                    {{ $featuredProperty->address->province }} | {{ $featuredProperty->address->city }} | {{ $featuredProperty->address->district }}
                                </p>

                                <p
                                    class="leading-loose text-gray-600 dark:text-gray-400 mb-6 transition-all duration-500 opacity-90 group-hover:opacity-100">
                                    {!! substr(nl2br($featuredProperty->description), 0, 300) !!} ...
                                </p>

                                <div class="flex flex-wrap gap-4 mb-6">
                                    <div class="flex items-center mr-4">
                                        <i class="icon-size-fullscreen text-amber-500 mr-2"></i>
                                        <span class="text-gray-700 dark:text-gray-300">
                                            {{ $featuredProperty->built_area }}m²
                                        </span>
                                    </div>
                                    <div class="flex items-center mr-4">
                                        <i class="icon-home text-amber-500 mr-2"></i>
                                        <span class="text-gray-700 dark:text-gray-300">
                                            {{ $featuredProperty->rooms }} {{ __('messages.habitaciones') }}
                                        </span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="icon-drop text-amber-500 mr-2"></i>
                                        <span class="text-gray-700 dark:text-gray-300">
                                            {{ $featuredProperty->bathrooms }} {{ __('messages.banios') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Botones con aparición en hover -->
                            <div
                                class="overflow-hidden opacity-90 transition-all duration-500 group-hover:opacity-100 mt-8 flex space-x-4">
                                <a href="{{ route('prop.show', ['locale' => app()->getLocale(), 'id' => $featuredProperty->id]) }}"
                                    class="btn-luxury bg-amber-500 text-white px-6 py-3 rounded-sm font-luxury tracking-wider text-sm uppercase transition-all hover:bg-amber-600">
                                    {{ __('messages.Ver Detalles') }}
                                </a>
                                <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}"
                                    class="btn-luxury px-6 py-3 border border-gray-300 dark:border-amber-500/30 rounded-sm text-gray-600 dark:text-white font-luxury tracking-wider text-sm uppercase transition-all hover:border-amber-500 dark:hover:border-amber-500 dark:hover:bg-amber-900/20">
                                    {{ __('messages.Contactar') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif


    <!-- Trending Properties Section -->
    <section class="py-20 bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-6">
            <!-- Encabezado con estilo de lujo -->
            <div class="flex justify-between items-center mb-16 relative">
                <h2 class="text-3xl md:text-4xl font-luxury font-light dark-text dark:text-white">
                    {{ __('messages.Trending') }} <span class="text-amber-600 dark:text-amber-400">{{ __('messages.Propiedades') }}</span>
                </h2>
                <div class="absolute top-full left-0 w-24 h-px bg-amber-300 mt-4 opacity-70"></div>

                <a href="#"
                    class="group flex items-center text-sm text-amber-600 dark:text-amber-400 font-luxury tracking-wider hover:text-amber-800 dark:hover:text-amber-300 transition-colors duration-300">
                    View All Properties
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 ml-2 transform transition-transform duration-300 group-hover:translate-x-1"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>

            <!-- Grid de propiedades -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach ($properties as $property)

                    <!-- Property 1 -->
                    <div class="luxury-card group bg-white dark:bg-gray-800 rounded-sm overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-500 relative">
                        <div class="relative overflow-hidden">
                            <img src="/storage/{{ $property->images->first()->image_path }}" alt="Modern Hillside Villa"
                                class="w-full h-64 object-cover transition-transform duration-700 group-hover:scale-110">

                            <!-- Overlay con gradiente -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>

                            <!-- Etiqueta Featured con estilo de lujo -->
                            <div class="absolute top-4 left-4 bg-amber-100 dark:bg-amber-900/70 px-3 py-1 rounded-sm z-10">
                                @if ($property->is_featured == 1)
                                    <span
                                        class="text-xs font-luxury tracking-wider uppercase text-amber-800 dark:text-amber-200">Featured
                                    </span>
                                @else
                                    <span
                                        class="text-xs font-luxury tracking-wider uppercase text-green-800 dark:text-green-200">New
                                    </span>
                                @endif

                            </div>

                            <!-- Precio flotante que aparece en hover -->
                            <div
                                class="absolute bottom-4 left-4 opacity-0 group-hover:opacity-100 transition-all duration-500 transform translate-y-2 group-hover:translate-y-0 z-10">
                                <span
                                    class="text-white font-luxury text-lg bg-black/70 px-3 py-1 rounded-sm">€ {{ $property->price }}</span>
                            </div>
                        </div>

                        <div class="p-6 relative">
                            <!-- Línea decorativa que aparece en hover -->
                            <div
                                class="absolute bottom-0 left-0 right-0 h-0.5 bg-amber-300 transform scale-x-0 origin-left transition-transform duration-500 group-hover:scale-x-100">
                            </div>

                            <div class="flex justify-between items-center mb-3">
                                <span class="text-amber-600 dark:text-amber-400 font-luxury text-lg">€ {{ $property->price }}</span>
                                <span class="text-gray-600 dark:text-gray-400 text-sm font-luxury">{{ $property->address->district }} {{ $property->address->city }} {{ $property->address->province }} </span>
                            </div>

                            <h3
                                class="text-xl font-luxury font-medium mb-3 text-gray-800 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors duration-300">
                                {{ $property->title }}
                            </h3>

                            <div class="flex flex-wrap gap-4 mb-5">
                                <div class="flex items-center text-gray-600 dark:text-gray-400 text-sm">
                                    <i class="icon-home text-amber-500 mr-2"></i>
                                    <span>{{ $property->rooms }} {{ __('messages.habitaciones') }}</span>
                                </div>
                                <div class="flex items-center text-gray-600 dark:text-gray-400 text-sm">
                                    <i class="icon-drop text-amber-500 mr-2"></i>
                                    <span>{{ $property->bathrooms }} {{ __('messages.banios') }}</span>
                                </div>
                                <div class="flex items-center text-gray-600 dark:text-gray-400 text-sm">
                                    <i class="icon-size-fullscreen text-amber-500 mr-2"></i>
                                    <span>{{ $property->built_area }} m²</span>
                                </div>
                            </div>

                            <a href="{{ route('prop.show', ['locale' => app()->getLocale(), 'id' => $property->id]) }}"
                                class="inline-flex items-center text-sm text-amber-600 dark:text-amber-400 font-luxury tracking-wider group-hover:text-amber-800 dark:group-hover:text-amber-300 transition-colors duration-300">
                                {{ __('messages.Ver Detalles') }}
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 ml-2 opacity-0 transform -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>

                @endforeach
                </div>


            </div>
        </div>
    </section>
    <!--  Servicios Exclusivos -->
    <section class="py-20 bg-medium relative overflow-hidden">
        <!-- Elemento decorativo -->
        <div
            class="absolute -top-16 -right-16 w-64 h-64 bg-gradient-to-br from-amber-300/20 to-transparent rounded-full blur-3xl">
        </div>

        <div class="container mx-auto px-6">
            <div class="flex justify-between items-center mb-16">
                <div class="relative">
                    <h2 class="font-luxury text-4xl font-light dark-text">{!! __('messages.servicios_exclusivos') !!}</h2>

                    <div class="absolute -bottom-4 left-0 w-16 h-px bg-gradient-to-r from-text-amber-300 to-transparent"></div>
                </div>
                <a href="#"
                    class="text-sm text-amber-500 hover:underline group transition-all duration-300 flex items-center">
                    {{ __('messages.Ver Todos los Servicios') }}
                    <span
                        class="ml-2 transform group-hover:translate-x-1 transition-transform duration-300">&rarr;</span>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Servicio Principal -->
                <div class="luxury-card lg:col-span-2 relative overflow-hidden rounded-sm h-96 shadow-xl group">
                    <img src="{{ asset('assets/images/home/valuation.jpg') }}" alt="Servicios Exclusivos"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/70 to-transparent opacity-80">
                    </div>
                    <div class="absolute bottom-0 left-0 p-8">
                        <span
                            class="text-xs uppercase bg-amber-300 text-gray-800 px-4 py-1 rounded-sm font-luxury tracking-wider">{{ __('messages.Destacado') }}</span>
                        <h3 class="font-luxury text-3xl font-light mt-4 mb-3 text-white">
                            {{ __('messages.Property Valuation') }}</h3>
                        <p class="text-gray-200 mb-5 max-w-xl">{{ __('messages.We accurately value each property, offering a detailed and objective analysis of the luxury real estate market.') }} </p>
                        <div class="flex items-center">
                            <div
                                class="w-10 h-10 rounded-full overflow-hidden mr-4 flex items-center justify-center bg-e8d4b8/90">
                                <span class="icon-wallet text-gray-800"></span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-white font-luxury tracking-wider">{{ __('messages.Servicio Premium') }}
                                </p>
                                <p class="text-xs text-gray-300">{{ __('messages.Consulta disponibilidad') }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Overlay para efecto hover -->
                    <div
                        class="absolute inset-0 bg-e8d4b8/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                </div>

                <!-- Servicios Laterales -->
                <div class="h-96 flex flex-col">
                    <!-- Contenedor con altura fija y distribución equitativa -->
                    <div class="flex flex-col h-full justify-between">
                        <!-- Servicio Lateral 1 -->
                        <div
                            class="luxury-card flex bg-white rounded-sm overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 group flex-1">
                            <div class="w-1/3 flex items-center justify-center bg-gray-50 relative overflow-hidden">
                                <span
                                    class="icon-briefcase text-3xl text-gray-700 relative z-10 transition-transform duration-300 group-hover:scale-110"></span>
                                <!-- Overlay decorativo -->
                                <div
                                    class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-e8d4b8 to-transparent transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300">
                                </div>
                            </div>
                            <div class="w-2/3 p-4">
                                <span class="text-xs text-amber-500 font-luxury tracking-wider">{{ __('messages.Legales') }}</span>
                                <h4 class="text-md font-luxury font-semibold my-1 dark-text">{{ __('messages.R&B Servicio Jurídico Gratuito') }} </h4>
                                <p class="text-xs text-gray-500">{{ __('messages.Especializado en derecho inmobiliario') }}. </p>
                            </div>
                        </div>

                        <!-- Espacio entre cards -->
                        <div class="h-3"></div>

                        <!-- Servicio Lateral 2 -->
                        <div
                            class="luxury-card flex bg-white rounded-sm overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 group flex-1">
                            <div class="w-1/3 flex items-center justify-center bg-gray-50 relative overflow-hidden">
                                <span
                                    class="icon-puzzle text-3xl text-gray-700 relative z-10 transition-transform duration-300 group-hover:scale-110"></span>
                                <!-- Overlay decorativo -->
                                <div
                                    class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-e8d4b8 to-transparent transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300">
                                </div>
                            </div>
                            <div class="w-2/3 p-4">
                                <span class="text-xs text-amber-500 font-luxury tracking-wider">{{ __('messages.Estrategia') }}</span>
                                <h4 class="text-md font-luxury font-semibold my-1 dark-text">{{ __('messages.Personalized Consulting') }}
                                </h4>
                                <p class="text-xs text-gray-500">{{ __('messages.Adaptada a las necesidades de cada cliente en el mercado inmobiliario') }}. </p>
                            </div>
                        </div>

                        <!-- Espacio entre cards -->
                        <div class="h-3"></div>

                        <!-- Servicio Lateral 3 -->
                        <div
                            class="luxury-card flex bg-white rounded-sm overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 group flex-1">
                            <div class="w-1/3 flex items-center justify-center bg-gray-50 relative overflow-hidden">
                                <span
                                    class="icon-laptop text-3xl text-gray-700 relative z-10 transition-transform duration-300 group-hover:scale-110"></span>
                                <!-- Overlay decorativo -->
                                <div
                                    class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-e8d4b8 to-transparent transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300">
                                </div>
                            </div>
                            <div class="w-2/3 p-4">
                                <span class="text-xs text-amber-500 font-luxury tracking-wider">{{ __('messages.Tecnología') }}</span>
                                <h4 class="text-md font-luxury font-semibold my-1 dark-text">{{ __('messages.Property Management') }}</h4>
                                <p class="text-xs text-gray-500">{{ __('messages.Comprehensive administration and management services for properties') }}. </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
        <section class="py-24 podcast-banner relative overflow-hidden">
        <!-- Overlay decorativo -->
        <div class="absolute inset-0 bg-dark/60 backdrop-blur-sm"></div>

        <!-- Elementos decorativos con amber en lugar de cream -->
        <div class="absolute -left-24 top-1/3 w-48 h-48 rounded-full border border-amber-300/20 opacity-30"></div>
        <div class="absolute right-12 bottom-12 w-32 h-32 rounded-full border border-amber-300/30 opacity-20"></div>
        <div class="absolute right-24 top-24 w-16 h-16 rounded-full bg-amber-300/5"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-2xl relative">
                <!-- Línea decorativa vertical con amber -->
                <div class="absolute -left-8 top-0 bottom-0 w-px bg-gradient-to-b from-amber-300/80 via-amber-300/40 to-transparent">
                </div>

                <h2 class="font-luxury text-4xl font-light dark-text">{!! __('messages.servicios_exclusivos') !!}</h2>

                <p class="text-gray-200 mb-8 leading-relaxed">
                    {{ __('messages.cta_descripcion') }}.
                </p>

                <div class="flex flex-col sm:flex-row space-y-5 sm:space-y-0 sm:space-x-6 mt-10">
                    <!-- Botón principal con amber -->
                    <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" class="bg-amber-300 px-8 py-3 rounded-sm text-center font-luxury tracking-wider text-gray-900 hover:shadow-lg transition-all duration-300 group relative">
                        <span class="relative z-10">{{ __('messages.Solicitar Información') }}</span>
                    </a>

                    <!-- Botón secundario con amber -->
                    <a href="{{ route('services', ['locale' => app()->getLocale()]) }}" class="px-8 py-3 border border-amber-300/30 rounded-sm text-white hover:border-amber-300 transition-all duration-300 text-center font-luxury tracking-wider group overflow-hidden relative">
                        <span class="relative z-10 group-hover:text-gray-900 transition-colors duration-300">{{ __('messages.Ver Servicios') }}</span>
                        <div class="absolute inset-0 bg-amber-300/90 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left">
                        </div>
                    </a>
                </div>

                <!-- Elemento decorativo inferior con amber -->
                <div class="absolute -bottom-3 left-0 w-24 h-px bg-gradient-to-r from-amber-300 to-transparent"></div>
            </div>
        </div>
    </section>

    <!-- Sección de Contacto -->
    <section class="py-24 bg-light relative overflow-hidden">
        <!-- Elementos decorativos -->
        <div
            class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-bl from-amber-100/10 to-transparent rounded-full blur-3xl">
        </div>
        <div
            class="absolute bottom-24 left-12 w-64 h-64 bg-gradient-to-tr from-amber-200/5 to-transparent rounded-full blur-2xl">
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="relative text-center mb-20 inline-block mx-auto">
                <h2 class="font-luxury text-4xl font-light dark-text">
                    {!! __('messages.titulo_contacto') !!}
                </h2>

                <div
                    class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 w-24 h-px bg-gradient-to-r from-transparent via-amber-400 to-transparent">
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 max-w-6xl mx-auto">
                <!-- Formulario de Contacto -->
                <div
                    class="bg-white p-10 shadow-xl rounded-sm border-t border-amber-200 transition-all duration-300 hover:shadow-2xl">
                    <h3 class="font-luxury text-2xl font-medium mb-8 dark-text">{{ __('messages.Envíenos un mensaje') }}</h3>
                    <form>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div class="group">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-700">{{ __('messages.Nombre completo') }}</label>
                                <div class="relative">
                                    <input type="text" id="name"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-sm focus:outline-none focus:border-amber-500 transition-all duration-300"
                                        placeholder="{{ __('messages.Su nombre') }}">
                                    <div
                                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-amber-400 group-focus-within:w-full transition-all duration-300">
                                    </div>
                                </div>
                            </div>
                            <div class="group">
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-700">{{ __('messages.Correo electrónico') }}</label>
                                <div class="relative">
                                    <input type="email" id="email"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-sm focus:outline-none focus:border-amber-500 transition-all duration-300"
                                        placeholder="{{ __('messages.Su email') }}">
                                    <div
                                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-amber-400 group-focus-within:w-full transition-all duration-300">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-8 group">
                            <label for="phone"
                                class="block mb-2 text-sm font-medium text-gray-700">{{ __('messages.telefono') }}</label>
                            <div class="relative">
                                <input type="tel" id="phone"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-sm focus:outline-none focus:border-amber-500 transition-all duration-300"
                                    placeholder="{{ __('messages.Su teléfono') }}">
                                <div
                                    class="absolute bottom-0 left-0 w-0 h-0.5 bg-amber-400 group-focus-within:w-full transition-all duration-300">
                                </div>
                            </div>
                        </div>
                        <div class="mb-8 group">
                            <label for="subject" class="block mb-2 text-sm font-medium text-gray-700">{{ __('messages.Asunto') }}</label>
                            <div class="relative">
                                <input type="text" id="subject"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-sm focus:outline-none focus:border-amber-500 transition-all duration-300"
                                    placeholder="{{ __('messages.Su asunto') }}">
                                <div
                                    class="absolute bottom-0 left-0 w-0 h-0.5 bg-amber-400 group-focus-within:w-full transition-all duration-300">
                                </div>
                            </div>
                        </div>
                        <div class="mb-8 group">
                            <label for="message" class="block mb-2 text-sm font-medium text-gray-700">{{ __('messages.Mensaje') }}</label>
                            <div class="relative">
                                <textarea id="message" rows="4"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-sm focus:outline-none focus:border-amber-500 transition-all duration-300"
                                    placeholder="{{ __('messages.Su mensaje') }}"></textarea>
                                <div
                                    class="absolute bottom-0 left-0 w-0 h-0.5 bg-amber-400 group-focus-within:w-full transition-all duration-300">
                                </div>
                            </div>
                        </div>
                        <button type="submit"
                            class="btn-luxury bg-gradient-to-r from-[#a67c00] to-[#d4af37] text-white px-6 py-3 rounded-sm w-full transition duration-300 font-luxury tracking-wider shadow-md hover:shadow-lg">
                            {{ __('messages.Enviar Mensaje') }}</button>
                    </form>
                </div>

                <!-- Información de Contacto -->
                <div class="flex flex-col h-full">
                    <div
                        class="bg-white p-10 shadow-xl rounded-sm border-t border-amber-200 mb-8 transition-all duration-300 hover:shadow-2xl">
                        <h3 class="font-luxury text-2xl font-medium mb-8 dark-text">{{ __('messages.Información de contacto') }}</h3>
                        <div class="space-y-6">
                            <div class="flex items-start group hover:translate-x-1 transition-transform duration-300">
                                <div
                                    class="text-amber-600 text-xl mr-4 mt-1 w-8 h-8 flex items-center justify-center rounded-full bg-amber-50 group-hover:bg-amber-100 transition-colors duration-300">
                                    <i class="icon-location-pin"></i>
                                </div>
                                <div>
                                    <p class="font-medium dark-text font-luxury">{{ __('messages.Dirección') }}</p>
                                    <p class="text-gray-600">Avenida Diagonal 640, 08017 Barcelona, España</p>
                                </div>
                            </div>
                            <div class="flex items-start group hover:translate-x-1 transition-transform duration-300">
                                <div
                                    class="text-amber-600 text-xl mr-4 mt-1 w-8 h-8 flex items-center justify-center rounded-full bg-amber-50 group-hover:bg-amber-100 transition-colors duration-300">
                                    <i class="icon-envelope"></i>
                                </div>
                                <div>
                                    <p class="font-medium dark-text font-luxury">Email</p>
                                    <p class="text-gray-600">info@luxeproperties.com</p>
                                </div>
                            </div>
                            <div class="flex items-start group hover:translate-x-1 transition-transform duration-300">
                                <div
                                    class="text-amber-600 text-xl mr-4 mt-1 w-8 h-8 flex items-center justify-center rounded-full bg-amber-50 group-hover:bg-amber-100 transition-colors duration-300">
                                    <i class="icon-phone"></i>
                                </div>
                                <div>
                                    <p class="font-medium dark-text font-luxury">{{ __('messages.telefono') }}</p>
                                    <p class="text-gray-600">+34 932 000 000</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial -->
                    <div
                        class="testimonial-card p-10 shadow-xl rounded-sm flex-1 border-t border-amber-200 relative overflow-hidden group transition-all duration-300 hover:shadow-2xl">
                        <!-- Quotes decorativas -->
                        <div class="absolute top-4 left-4 text-6xl text-amber-100 opacity-50 font-serif">"</div>
                        <div
                            class="absolute bottom-4 right-4 text-6xl text-amber-100 opacity-50 font-serif transform rotate-180">
                            "</div>

                        <p class="text-lg italic mb-8 relative z-10 text-gray-700 leading-relaxed">"LUXE ha sido
                            nuestro aliado estratégico en la búsqueda de propiedades exclusivas. Su servicio
                            personalizado y su conocimiento del mercado son excepcionales."</p>

                        <div class="flex items-center relative z-10">
                            <div
                                class="w-16 h-16 rounded-full overflow-hidden mr-5 shadow-md border-2 border-amber-100 group-hover:border-amber-300 transition-colors duration-300">
                                <img src="{{ asset('assets/images/photography/image4.jpg') }}" alt="Cliente"
                                    class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="font-medium dark-text font-luxury text-lg">María González</p>
                                <p class="text-sm text-amber-700">Directora General, Inversiones Premium</p>
                            </div>
                        </div>

                        <!-- Decoración adicional -->
                        <div
                            class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-amber-200 via-amber-400 to-amber-200 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-guest-layout>
