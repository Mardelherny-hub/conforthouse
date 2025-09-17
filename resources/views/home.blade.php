<x-public-layout>

   <!-- Category Section -->
    <section class="py-16 bg-gray-50">
    <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12 lg:px-8">
        <div class="james-section-header">
                    <h2 class="james-section-title font-luxury mr-4">{{ __('messages.nuestras_categorias_premium') }}</h2>
                    <a href="{{ route('properties.index', ['locale' => app()->getLocale()]) }}"
                    class="james-view-all font-body">{{ __('messages.explora_seleccion_propiedades') }}</a>
                </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        <!-- Residencias -->
        <a href="{{ route('properties.index', ['locale' => app()->getLocale(), 'complexes' => 'true']) }}" class="category-card">
            <img src="{{ asset('assets/images/home/cat_homes.webp') }}" alt="Residencias" class="category-card__img">
            <div class="category-card__overlay"></div>
            
            <div class="category-card__content">
            <h3 class="category-card__title font-luxury">{{ __('messages.residencias') }}</h3>
            <span class="category-card__cta font-body">
                {{ __('messages.ver_propiedades') }}
                <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </span>
            </div>
        </a>

        <!-- Apartamentos -->
        <a href="{{ route('properties.index', ['locale' => app()->getLocale(), 'type_id' => 2]) }}" class="category-card">
            <img src="{{ asset('assets/images/home/cat_apartments.jpg') }}" alt="Apartamentos" class="category-card__img">
            <div class="category-card__overlay"></div>
            
            <div class="category-card__content">
            <h3 class="category-card__title font-luxury">{{ __('messages.apartamentos') }}</h3>
            <span class="category-card__cta font-body">
                {{ __('messages.ver_propiedades') }}
                <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </span>
            </div>
        </a>

        <!-- Villas -->
        <a href="{{ route('properties.index', ['locale' => app()->getLocale(), 'type_id' => 3]) }}" class="category-card">
            <img src="{{ asset('assets/images/home/cat_villas.png') }}" alt="Villas" class="category-card__img">
            <div class="category-card__overlay"></div>
            <div class="category-card__content">
            <h3 class="category-card__title font-luxury">{{ __('messages.villas') }}</h3>
            <span class="category-card__cta font-body">
                {{ __('messages.ver_propiedades') }}
                <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </span>
            </div>
        </a>

        </div>
    </div>
    </section>

    <!-- Featured Property with Map - Optimized Layout -->
    @if ($featuredProperty)
        <section class="bg-white py-8 lg:py-12">
            <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 lg:gap-8 min-h-[500px]">
                    
                    <!-- Left Column - Featured Property (3/5 width) -->
                    <div class="lg:col-span-2 bg-white shadow-lg overflow-hidden">
                        
                        <!-- Property Image -->
                        <div class="relative h-64 lg:h-80 overflow-hidden">
                            @if($featuredProperty->images && $featuredProperty->images->first())
                                @php
                                    $image = $featuredProperty->images->first();
                                    $imageSrc = str_starts_with($image->image_path, 'http') 
                                        ? $image->image_path 
                                        : '/storage/' . $image->image_path;
                                @endphp
                                <img src="{{ $imageSrc }}" 
                                    alt="{{ $featuredProperty->title }}"
                                    class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                            @else
                                <img src="{{ asset('assets/images/home/trend-2.png') }}" 
                                    alt="{{ $featuredProperty->title }}"
                                    class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                            @endif
                            
                            <!-- Featured Badge -->
                            <div class="james-property-badge featured">
                                {{ __('messages.featured') }}
                            </div>
                            
                            <!-- Price Badge -->
                            <div class="property-card-badge text-xl">
                                €{{ number_format($featuredProperty->price) }}
                            </div>
                        </div>
                        
                        <!-- Property Details -->
                        <div class="p-6 lg:p-8">
                            <!-- Location -->
                            <div class="flex items-center text-gray-500 text-sm mb-3">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                {{ $featuredProperty->address->city ?? '' }}, {{ $featuredProperty->address->province ?? '' }}
                            </div>
                            
                            <!-- Title -->
                            <h2 class="james-property-title">
                                {{ $featuredProperty->title }}
                            </h2>                        
                            
                            
                            <!-- Description -->
                            <p class="james-property-content mb-6 ">
                                {{ Str::limit(strip_tags($featuredProperty->description), 180) }}
                            </p>

                            <!-- Specifications -->
                            <div class="james-property-specs font-body mb-6">
                                {{ $featuredProperty->built_area }}m² • {{ $featuredProperty->rooms }} hab • {{ $featuredProperty->bathrooms }} baños
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row gap-4 mb-6 sm:mb-0 sm:justify-between sm:items-center">
                                <a href="{{ route('prop.show', ['locale' => app()->getLocale(), 'slug' => $featuredProperty->slug ?? '']) }}"
                                class="james-btn-primary">
                                    {{ __('messages.Ver Detalles') }}
                                </a>
                                
                                <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}"
                                class="james-btn-secondary">
                                    {{ __('messages.Contactar') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Google Maps (2/5 width) -->
                    <div class="lg:col-span-3">
                        <div class="bg-white shadow-lg overflow-hidden h-full min-h-[500px] sticky top-6">
                            <!-- Map Header -->
                            <div class="bg-gradient-champagne  text-center p-4">
                                <h3 class="category-card__title flex items-center" style="color: #262626d0;">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                    {{ __('messages.ubicacion') }}
                                    
                                </h3>
                            </div>
                            
                            <!-- Map Container -->
                            <div class="relative flex-1">
                                <div id="properties-map" class="w-full h-96 lg:h-[calc(100%-4rem)]"></div>
                                
                                <!-- Loading State -->
                                <div id="map-loading" class="absolute inset-0 bg-gray-100 flex items-center justify-center">
                                    <div class="text-center">
                                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto mb-2"></div>
                                        <p class="text-gray-500 text-sm">Cargando mapa...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>

        <!-- Enhanced Google Maps Script -->
        <script>
            let map;
            let markers = [];
            let mapLoaded = false;

            function initMap() {
                // Hide loading state
                const loadingElement = document.getElementById('map-loading');
                if (loadingElement) {
                    loadingElement.style.display = 'none';
                }

                // Coordenadas del centro de España como fallback
                const spainCenter = { lat: 40.4637, lng: -3.7492 };
                
                // Obtener coordenadas de la propiedad destacada
                @if($featuredProperty->address && $featuredProperty->address->latitude && $featuredProperty->address->longitude)
                    const featuredPropertyCoords = {
                        lat: {{ $featuredProperty->address->latitude }},
                        lng: {{ $featuredProperty->address->longitude }}
                    };
                @else
                    const featuredPropertyCoords = spainCenter;
                @endif

                // Inicializar el mapa con estilo personalizado
                map = new google.maps.Map(document.getElementById("properties-map"), {
                    zoom: 13,
                    center: featuredPropertyCoords,
                    mapTypeControl: false,
                    streetViewControl: false,
                    fullscreenControl: false,
                    styles: [
                        {
                            "featureType": "poi",
                            "elementType": "labels",
                            "stylers": [{ "visibility": "off" }]
                        },
                        {
                            "featureType": "transit",
                            "elementType": "labels",
                            "stylers": [{ "visibility": "off" }]
                        },
                        {
                            "featureType": "road",
                            "elementType": "labels.icon",
                            "stylers": [{ "visibility": "off" }]
                        }
                    ]
                });

                // Añadir marcador de la propiedad destacada
                @if($featuredProperty->address && $featuredProperty->address->latitude && $featuredProperty->address->longitude)
                    const featuredMarker = new google.maps.Marker({
                        position: featuredPropertyCoords,
                        map: map,
                        title: "{{ addslashes($featuredProperty->title) }}",
                        icon: {
                            path: "M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z",
                            fillColor: '#EF4444',
                            fillOpacity: 1,
                            strokeColor: '#FFFFFF',
                            strokeWeight: 2,
                            scale: 1.5,
                            anchor: new google.maps.Point(12, 24)
                        },
                        animation: google.maps.Animation.DROP
                    });

                    // Info window mejorada
                    const infoWindow = new google.maps.InfoWindow({
                        content: `
                            <div class="p-3 max-w-xs">
                                <div class="flex items-start justify-between mb-2">
                                    <h3 class="font-bold text-base text-gray-900 leading-tight">{{ addslashes($featuredProperty->title) }}</h3>
                                    <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full ml-2 flex-shrink-0">Destacada</span>
                                </div>
                                <p class="text-sm text-gray-600 mb-2 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $featuredProperty->address->city ?? '' }}, {{ $featuredProperty->address->province ?? '' }}
                                </p>
                                <div class="border-t pt-2">
                                    <p class="text-lg font-bold text-blue-600 mb-2">
                                        €{{ number_format($featuredProperty->price) }}
                                    </p>
                                    <div class="flex text-xs text-gray-500 space-x-3">
                                        <span>{{ $featuredProperty->built_area }}m²</span>
                                        <span>{{ $featuredProperty->rooms }} hab.</span>
                                        <span>{{ $featuredProperty->bathrooms }} baños</span>
                                    </div>
                                </div>
                            </div>
                        `
                    });

                    featuredMarker.addListener('click', () => {
                        infoWindow.open(map, featuredMarker);
                    });
                    
                    // Auto-open info window after a delay
                    setTimeout(() => {
                        infoWindow.open(map, featuredMarker);
                    }, 1500);
                @endif

                mapLoaded = true;
            }

            // Error handling for map loading
            function handleMapError() {
                const mapContainer = document.getElementById('properties-map');
                const loadingElement = document.getElementById('map-loading');
                
                if (mapContainer && loadingElement) {
                    loadingElement.innerHTML = `
                        <div class="text-center">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-gray-500 text-sm">Error al cargar el mapa</p>
                            <button onclick="location.reload()" class="mt-2 text-blue-600 text-sm hover:underline">
                                Intentar de nuevo
                            </button>
                        </div>
                    `;
                }
            }

            // Initialize map when page loads
            window.addEventListener('load', function() {
                if (typeof google !== 'undefined' && google.maps) {
                    initMap();
                } else {
                    setTimeout(() => {
                        if (!mapLoaded) handleMapError();
                    }, 5000);
                }
            });
        </script>

        <!-- Google Maps API with error handling -->
        <script async defer 
            src="https://maps.googleapis.com/maps/api/js?key=TU_API_KEY_AQUI&callback=initMap&loading=async"
            onerror="handleMapError()">
        </script>
    @endif

    <!-- Properties Grid -->
    <section class="james-properties">
        <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12">
            
            <div class="james-section-header">
                <h2 class="james-section-title font-luxury mr-4">{{ __('messages.recent_listings') }}</h2>
                <a href="{{ route('properties.index', ['locale' => app()->getLocale()]) }}"
                   class="james-view-all font-body">{{ __('messages.view_all_properties') }}</a>
            </div>
            
            <div class="james-properties-grid">
                @forelse ($properties as $property)
                    <a href="{{ route('prop.show', ['locale' => app()->getLocale(), 'slug' => $property->slug ?? '']) }}" class="james-property-card block">
                        <div class="james-property-card">
                            <div class="james-property-image">                            
                                @if($property->images && $property->images->first())
                                    @php
                                        $image = $property->images->first();
                                        $imageSrc = str_starts_with($image->image_path, 'http') 
                                            ? $image->image_path 
                                            : '/storage/' . $image->image_path;
                                    @endphp
                                    <img src="{{ $imageSrc }}" alt="{{ $property->title }}">
                                @else
                                    <img src="{{ asset('assets/images/properties/placeholder.webp') }}" 
                                        alt="{{ $property->title }}">
                                @endif
                                
                                @if ($property->is_featured == 1)
                                    <div class="james-property-badge featured font-body">{{ __('messages.featured') }}</div>
                                @else
                                    <div class="james-property-badge new font-body">{{ __('messages.new') }}</div>
                                @endif
                            </div>

                            <div class="james-property-content">
                                <h3 class="james-property-title font-luxury">{{ Str::limit($property->title, 45) }}</h3>
                                <div class="james-property-price font-body">€{{ number_format($property->price) }}</div>
                                <div class="james-property-specs font-body">
                                    {{ $property->built_area }}m² • {{ $property->rooms }} hab • {{ $property->bathrooms }} baños
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 font-body">{{ __('messages.no_properties_found') }}</p>
                    </div>
                @endforelse
            </div>
            
        </div>
    </section>

    <!-- Services Section -->
    <section class="james-services" id="servicios">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center lg:mx-6 xl:mx-8 2xl:mx-12">
    
            <!-- Columna 1: Título y CTA -->
            <div class="james-services-intro">
                <h2 class="james-services-title font-luxury">{{ __('messages.premium_services') }}</h2>
                <p class="james-services-description font-body mb-6">
                    {{ __('messages.services_description') }}
                </p>
                <a href="{{ route('services', ['locale' => app()->getLocale()]) }}" class="james-btn-outline font-body">{{ __('messages.learn_more') }}</a>
            </div>
            
            <!-- Columna 2: Lista de servicios -->
            <div class="james-services-list space-y-6">
                <div class="james-service-item">
                    <h4 class="james-service-title font-body">{{ __('messages.property_valuation') }}</h4>
                    <p class="james-service-description font-body">{{ __('messages.property_valuation_desc') }}</p>
                </div>
                <div class="james-service-item">
                    <h4 class="james-service-title font-body">{{ __('messages.investment_consulting') }}</h4>
                    <p class="james-service-description font-body">{{ __('messages.investment_consulting_desc') }}</p>
                </div>
                <div class="james-service-item">
                    <h4 class="james-service-title font-body">{{ __('messages.property_management') }}</h4>
                    <p class="james-service-description font-body">{{ __('messages.property_management_desc') }}</p>
                </div>
            </div>
            
            <!-- Columna 3: Imagen -->
            <div class="james-services-image">
                <img src="{{ asset('assets/images/home/servicios-exclusivos.png') }}"
                    alt="Premium Services"
                    class="w-full h-full object-cover">
            </div>
            
        </div>
    </section>

    <!-- Contact CTA -->
    <section class="james-cta" id="contacto">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="james-cta-title font-luxury">{{ __('messages.ready_find_dream_property') }}</h2>
            <p class="james-cta-description font-body">
                {{ __('messages.connect_luxury_experts') }}
            </p>
            
            <div class="james-cta-actions">
                <a href="{{ route('properties.index', ['locale' => app()->getLocale()]) }}"
                   class="james-btn-primary font-body">
                    {{ __('messages.browse_properties') }}
                </a>
                
                <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" 
                   class="james-btn-outline font-body">
                    {{ __('messages.contact_us') }}
                </a>
            </div>
        </div>
    </section>

    @include('partials.floating-button')
</x-public-layout>