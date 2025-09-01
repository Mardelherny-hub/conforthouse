<x-public-layout>
    <!-- Category Section -->
    <section class="section-luxury bg-neutral-50 relative overflow-hidden">
        <!-- Elementos decorativos de fondo -->
        <div class="absolute -top-24 -right-24 w-64 h-64 rounded-full bg-gold-100 opacity-20 blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 w-80 h-80 rounded-full bg-champagne-200 opacity-10 blur-3xl"></div>

        <div class="container mx-auto px-6 relative z-10">
            <!-- Encabezado de sección -->
            <div class="text-center mb-16">
                <div class="inline-block mb-4">
                    <div class="flex items-center justify-center">
                        <div class="h-[1px] w-12 bg-gradient-to-r from-transparent to-gold-400"></div>
                        <span class="mx-4 text-gold-600 text-sm font-body uppercase tracking-widest font-light">
                            {{ __('messages.descubre') }}
                        </span>
                        <div class="h-[1px] w-12 bg-gradient-to-l from-transparent to-gold-400"></div>
                    </div>
                </div>
                <h2 class="section-title">
                    {{ __('messages.nuestras') }} 
                    <span class="text-gold-600">{{ __('messages.Categorías') }}</span> 
                    Premium
                </h2>
                <p class="section-subtitle">{{ __('messages.Explora') }}</p>
            </div>

            <!-- Grid de categorías -->
            <div class="property-grid">
                <!-- Categoría 1: Homes -->
                <div class="property-card group">
                    <div class="property-card-image">
                        <img src="{{ asset('assets/images/home/cat_homes.jpg') }}" alt="Luxury Homes">
                        <div class="property-card-badge">Premium</div>
                    </div>
                    
                    <div class="absolute bottom-0 left-0 right-0 p-8 bg-gradient-to-t from-black via-black/60 to-transparent">
                        <a href="{{ route('properties.index', ['locale' => app()->getLocale(), 'type_id' => 1]) }}"
                           class="block transform transition-all duration-500 group-hover:-translate-y-2">
                            <h3 class="text-2xl font-luxury text-white mb-2 group-hover:text-gold-400 transition-colors duration-300">
                                {{ __('messages.Residencias') }}
                            </h3>
                            <p class="text-sm text-neutral-300 transition-all duration-500 opacity-80 group-hover:opacity-100 mb-4">
                                {{ __('messages.Explore') }} 152 {{ __('messages.propiedades') }}
                            </p>
                            
                            <!-- Descripción expandible en hover -->
                            <div class="overflow-hidden h-0 opacity-0 transition-all duration-500 group-hover:h-16 group-hover:opacity-100">
                                <p class="text-sm text-white/70 mb-4">
                                    {{ __('messages.Mansiones, penthouses y residencias exclusivas') }}
                                </p>
                                <span class="flex justify-end text-gold-400 text-xs uppercase tracking-widest font-body items-center">
                                    {{ __('messages.discover') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Categoría 2: Apartments -->
                <div class="property-card group">
                    <div class="property-card-image">
                        <img src="{{ asset('assets/images/home/cat_apartments.jpg') }}" alt="Luxury Apartments">
                        <div class="property-card-badge">Premium</div>
                    </div>
                    
                    <div class="absolute bottom-0 left-0 right-0 p-8 bg-gradient-to-t from-black via-black/60 to-transparent">
                        <a href="{{ route('properties.index', ['locale' => app()->getLocale(), 'type_id' => 2]) }}"
                           class="block transform transition-all duration-500 group-hover:-translate-y-2">
                            <h3 class="text-2xl font-luxury text-white mb-2 group-hover:text-gold-400 transition-colors duration-300">
                                {{ __('messages.Apartamentos') }}
                            </h3>
                            <p class="text-sm text-neutral-300 transition-all duration-500 opacity-80 group-hover:opacity-100 mb-4">
                                {{ __('messages.Explore') }} 234 {{ __('messages.propiedades') }}
                            </p>
                            
                            <div class="overflow-hidden h-0 opacity-0 transition-all duration-500 group-hover:h-16 group-hover:opacity-100">
                                <p class="text-sm text-white/70 mb-4">
                                    {{ __('messages.Apartamentos de Lujo') }}
                                </p>
                                <span class="flex justify-end text-gold-400 text-xs uppercase tracking-widest font-body items-center">
                                    {{ __('messages.discover') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Categoría 3: Villas -->
                <div class="property-card group">
                    <div class="property-card-image">
                        <img src="{{ asset('assets/images/home/cat_villas.png') }}" alt="Luxury Villas">
                        <div class="property-card-badge">Premium</div>
                    </div>
                    
                    <div class="absolute bottom-0 left-0 right-0 p-8 bg-gradient-to-t from-black via-black/60 to-transparent">
                        <a href="{{ route('properties.index', ['locale' => app()->getLocale(), 'type_id' => 3]) }}"
                           class="block transform transition-all duration-500 group-hover:-translate-y-2">
                            <h3 class="text-2xl font-luxury text-white mb-2 group-hover:text-gold-400 transition-colors duration-300">
                                {{ __('messages.Villas') }}
                            </h3>
                            <p class="text-sm text-neutral-300 transition-all duration-500 opacity-80 group-hover:opacity-100 mb-4">
                                {{ __('messages.Explore') }} 87 {{ __('messages.propiedades') }}
                            </p>
                            
                            <div class="overflow-hidden h-0 opacity-0 transition-all duration-500 group-hover:h-16 group-hover:opacity-100">
                                <p class="text-sm text-white/70 mb-4">
                                    {{ __('messages.Villas exclusivas con amplios jardines y piscina privada') }}
                                </p>
                                <span class="flex justify-end text-gold-400 text-xs uppercase tracking-widest font-body items-center">
                                    {{ __('messages.discover') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Botón Ver Todas las Categorías -->
            <div class="text-center mt-16">
                <a href="{{ route('properties.index', ['locale' => app()->getLocale()]) }}" 
                   class="btn-luxury-secondary">
                    {{ __('messages.Ver todas las categorías') }}
                </a>
            </div>
        </div>
    </section>

    <!-- Sección de Propiedad Destacada -->
    @if ($featuredProperty)
        <section class="section-luxury bg-neutral-900">
            <div class="container mx-auto px-6">
                <div class="property-card group">
                    <div class="flex flex-col md:flex-row">
                        <!-- Contenedor de imagen -->
                        <div class="md:w-1/2 h-96 md:h-auto relative overflow-hidden">
                            <img src="/storage/{{ $featuredProperty->images->first()->image_path }}"
                                 alt="{{ $featuredProperty->title }}"
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent opacity-70 transition-opacity duration-500 group-hover:opacity-90"></div>
                        </div>

                        <!-- Contenido -->
                        <div class="md:w-1/2 p-8 md:p-12 bg-white relative">
                            <div class="transform transition-transform duration-500 group-hover:-translate-y-2">
                                <span class="property-card-badge mb-6 inline-block">
                                    {{ __('messages.Propiedad Destacada') }}
                                </span>

                                <h2 class="property-card-title text-3xl mb-4 group-hover:text-gold-600 transition-colors duration-300">
                                    {{ $featuredProperty->title }}
                                </h2>

                                <p class="property-card-location text-lg mb-4">
                                    {{ $featuredProperty->address->province }} |
                                    {{ $featuredProperty->address->city }} |
                                    {{ $featuredProperty->address->district }}
                                </p>

                                <p class="text-neutral-600 mb-6 leading-relaxed">
                                    {!! substr(nl2br($featuredProperty->description), 0, 300) !!} ...
                                </p>

                                <div class="property-card-features mb-8">
                                    <div class="property-feature">
                                        <svg class="w-5 h-5 text-gold-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                        </svg>
                                        <span>{{ $featuredProperty->built_area }}m²</span>
                                    </div>
                                    <div class="property-feature">
                                        <svg class="w-5 h-5 text-gold-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                        </svg>
                                        <span>{{ $featuredProperty->rooms }} {{ __('messages.habitaciones') }}</span>
                                    </div>
                                    <div class="property-feature">
                                        <svg class="w-5 h-5 text-gold-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732L14.146 12.8l-1.179 4.456a1 1 0 01-1.934 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732L9.854 7.2l1.179-4.456A1 1 0 0112 2z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>{{ $featuredProperty->bathrooms }} {{ __('messages.banios') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="flex space-x-4 mt-8">
                                <a href="{{ route('prop.show', ['locale' => app()->getLocale(), 'slug' => $featuredProperty->slug ?? '']) }}"
                                   class="btn-luxury-primary">
                                    {{ __('messages.Ver Detalles') }}
                                </a>
                                <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}"
                                   class="btn-luxury-secondary">
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
    <section class="section-luxury bg-neutral-50">
        <div class="container mx-auto px-6">
            <!-- Encabezado -->
            <div class="flex justify-between items-center mb-16">
                <div>
                    <h2 class="section-title text-left">
                        {{ __('messages.Trending') }} 
                        <span class="text-gold-600">{{ __('messages.Propiedades') }}</span>
                    </h2>
                </div>
                <a href="{{ route('properties.index', ['locale' => app()->getLocale()]) }}"
                   class="btn-luxury-secondary text-sm">
                    Ver Todas las Propiedades
                </a>
            </div>

            <!-- Grid de propiedades -->
            <div class="property-grid">
                @foreach ($properties as $property)
                    <div class="property-card">
                        <div class="property-card-image">
                            <img src="/storage/{{ $property->images->first()->image_path }}" 
                                 alt="{{ $property->title }}">
                            
                            @if ($property->is_featured == 1)
                                <div class="property-card-badge">Featured</div>
                            @else
                                <div class="property-card-badge bg-green-600">New</div>
                            @endif
                        </div>

                        <div class="property-card-content">
                            <div class="property-card-price">€{{ number_format($property->price) }}</div>
                            
                            <h3 class="property-card-title">{{ $property->title }}</h3>
                            
                            <div class="property-card-location">
                                <svg class="w-4 h-4 text-gold-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                {{ $property->address->city }}, {{ $property->address->province }}
                            </div>

                            <div class="property-card-features">
                                <div class="property-feature">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                    </svg>
                                    {{ $property->rooms }} hab.
                                </div>
                                <div class="property-feature">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732L14.146 12.8l-1.179 4.456a1 1 0 01-1.934 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732L9.854 7.2l1.179-4.456A1 1 0 0112 2z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $property->bathrooms }} baños
                                </div>
                                <div class="property-feature">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                    </svg>
                                    {{ $property->built_area }}m²
                                </div>
                            </div>

                            <a href="{{ route('prop.show', ['locale' => app()->getLocale(), 'slug' => $property->slug ?? '']) }}"
                               class="inline-flex items-center text-sm text-gold-600 font-body tracking-wider hover:text-gold-700 transition-colors duration-300 mt-4">
                                {{ __('messages.Ver Detalles') }}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2 transform transition-transform duration-300 group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Las demás secciones (servicios, CTA, contacto) las mantengo igual por ahora 
         para no hacer el archivo demasiado largo -->
    @include('partials.home-services')
    @include('partials.home-cta') 
    @include('partials.home-contact')
    @include('partials.floating-button')
</x-guest-layout>