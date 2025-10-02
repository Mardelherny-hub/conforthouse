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
        <a href="{{ route('complexes.index', ['locale' => app()->getLocale()]) }}" class="category-card">
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
        <a href="{{ route('properties.index', ['locale' => app()->getLocale(), 'type_id' => 1]) }}" class="category-card">
            <img src="{{ asset('assets/images/home/cat_villas.png') }}" alt="{{ __('messages.villas') }}" class="category-card__img">
            <div class="category-card__overlay"></div>
            <div class="category-card__content">
            <h3 class="category-card__title font-luxury">{{ __('messages.Villas') }}</h3>
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
                            <div class="bg-gradient-champagne text-center p-4">
                                <h3 class="category-card__title flex items-center justify-center" style="color: #262626d0;">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                    {{ __('messages.ubicacion') }}
                                </h3>
                            </div>
                            
                            <!-- Map Container -->
                            <div class="relative" style="height: calc(100% - 4rem);">
                                <div id="properties-map" class="w-full h-full" style="min-height: 450px;"></div>
                                
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
                        let infoWindows = [];
                        let mapLoaded = false;

                        function initMap() {
                            console.log('Iniciando mapa...');
                            
                            const loadingElement = document.getElementById('map-loading');
                            if (loadingElement) {
                                loadingElement.style.display = 'none';
                            }

                            const mapContainer = document.getElementById('properties-map');
                            if (!mapContainer) {
                                console.error('No se encontró el contenedor del mapa');
                                return;
                            }

                            // Centro de España para vista general
                            const spainCenter = { lat: 40.4637, lng: -3.7492 };
                            
                            // Inicializar el mapa con zoom apropiado para España
                            map = new google.maps.Map(mapContainer, {
                                zoom: 6,
                                center: spainCenter,
                                mapTypeControl: false,
                                streetViewControl: false,
                                fullscreenControl: true,
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
                                    }
                                ]
                            });

                            console.log('Mapa inicializado');

                            // Array para bounds (ajustar vista del mapa)
                            const bounds = new google.maps.LatLngBounds();
                            let hasValidCoordinates = false;

                            // URL base para las propiedades
                            const baseUrl = "{{ route('prop.show', ['locale' => app()->getLocale(), 'slug' => 'SLUG_PLACEHOLDER']) }}";

                            // Array de propiedades con coordenadas válidas
                            const propertiesData = [
                                @foreach($properties as $property)
                                    @if($property->address && $property->address->latitude && $property->address->longitude)
                                    {
                                        id: {{ $property->id }},
                                        lat: parseFloat({{ $property->address->latitude }}),
                                        lng: parseFloat({{ $property->address->longitude }}),
                                        title: {!! json_encode($property->title) !!},
                                        price: "{{ number_format($property->price, 0, ',', '.') }} €",
                                        city: "{{ $property->address->city ?? '' }}",
                                        province: "{{ $property->address->province ?? '' }}",
                                        rooms: {{ $property->rooms ?? 0 }},
                                        bathrooms: {{ $property->bathrooms ?? 0 }},
                                        area: {{ $property->main_built_area ?? 0 }},
                                        slug: "{{ $property->slug }}",
                                        isFeatured: {{ $property->is_featured ? 'true' : 'false' }},
                                        @if($property->images && $property->images->first())
                                        image: "{{ str_starts_with($property->images->first()->image_path, 'http') ? $property->images->first()->image_path : asset('storage/' . $property->images->first()->image_path) }}"
                                        @else
                                        image: "{{ asset('images/no-image.jpg') }}"
                                        @endif
                                    },
                                    @endif
                                @endforeach
                            ];

                            console.log(`Total propiedades con coordenadas: ${propertiesData.length}`);

                            // Crear marcadores para cada propiedad
                            propertiesData.forEach((property, index) => {
                                if (!property.lat || !property.lng || isNaN(property.lat) || isNaN(property.lng)) {
                                    console.warn(`Propiedad ${property.id} tiene coordenadas inválidas`);
                                    return;
                                }

                                const position = { lat: property.lat, lng: property.lng };
                                
                                // Añadir al bounds
                                bounds.extend(position);
                                hasValidCoordinates = true;

                                // Crear marcador con icono personalizado
                                const marker = new google.maps.Marker({
                                    position: position,
                                    map: map,
                                    title: property.title,
                                    icon: {
                                        path: "M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z",
                                        fillColor: property.isFeatured ? '#EF4444' : '#3B82F6',
                                        fillOpacity: 1,
                                        strokeColor: '#FFFFFF',
                                        strokeWeight: 2,
                                        scale: 1.3,
                                        anchor: new google.maps.Point(12, 24)
                                    },
                                    animation: google.maps.Animation.DROP
                                });

                                // Construir URL correctamente
                                const propertyUrl = baseUrl.replace('SLUG_PLACEHOLDER', property.slug);

                                // Crear contenido del InfoWindow
                                const infoWindowContent = `
                                    <div class="p-3 max-w-sm">
                                        <div class="flex items-start justify-between mb-2">
                                            <h3 class="font-bold text-sm text-gray-900 leading-tight pr-2">${property.title}</h3>
                                            ${property.isFeatured ? '<span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full flex-shrink-0">Destacada</span>' : ''}
                                        </div>
                                        
                                        <img src="${property.image}" alt="${property.title}" class="w-full h-32 object-cover rounded mb-2" onerror="this.src='{{ asset('images/no-image.jpg') }}';" />
                                        
                                        <p class="text-sm text-gray-600 mb-2 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                            </svg>
                                            ${property.city}${property.province ? ', ' + property.province : ''}
                                        </p>
                                        
                                        <div class="text-xs text-gray-500 mb-2 flex items-center gap-3">
                                            ${property.rooms > 0 ? `<span>${property.rooms} hab</span>` : ''}
                                            ${property.bathrooms > 0 ? `<span>${property.bathrooms} baños</span>` : ''}
                                            ${property.area > 0 ? `<span>${property.area}m²</span>` : ''}
                                        </div>
                                        
                                        <p class="text-lg font-bold text-blue-600 mb-2">${property.price}</p>
                                        
                                        <a href="${propertyUrl}" 
                                        class="block w-full text-center bg-blue-600 text-white px-3 py-2 rounded text-sm hover:bg-blue-700 transition-colors">
                                            Ver detalles
                                        </a>
                                    </div>
                                `;

                                const infoWindow = new google.maps.InfoWindow({
                                    content: infoWindowContent
                                });

                                // Click en marcador para abrir info
                                marker.addListener('click', () => {
                                    // Cerrar todos los info windows abiertos
                                    infoWindows.forEach(iw => iw.close());
                                    infoWindow.open(map, marker);
                                });

                                markers.push(marker);
                                infoWindows.push(infoWindow);
                            });

                            console.log(`Marcadores creados: ${markers.length}`);

                            // Ajustar vista para mostrar todos los marcadores
                            if (hasValidCoordinates && propertiesData.length > 0) {
                                map.fitBounds(bounds);
                                
                                // Si solo hay una propiedad, hacer zoom más cercano
                                if (propertiesData.length === 1) {
                                    google.maps.event.addListenerOnce(map, 'bounds_changed', function() {
                                        map.setZoom(13);
                                    });
                                }
                            } else {
                                console.warn('No hay propiedades con coordenadas válidas');
                            }

                            mapLoaded = true;
                            console.log('Mapa cargado completamente');
                        }

                        function handleMapError() {
                            console.error('Error al cargar Google Maps');
                            const loadingElement = document.getElementById('map-loading');
                            if (loadingElement) {
                                loadingElement.innerHTML = `
                                    <div class="text-center text-red-600">
                                        <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        <p class="text-sm">Error al cargar el mapa</p>
                                        <p class="text-xs text-gray-500 mt-1">Verifique la API Key de Google Maps</p>
                                    </div>
                                `;
                            }
                        }

                        // Timeout de seguridad para detectar fallo de carga
                        setTimeout(() => {
                            if (!mapLoaded) {
                                console.warn('Timeout: el mapa no se ha cargado en 10 segundos');
                                handleMapError();
                            }
                        }, 10000);
                    </script>

                    <!-- Google Maps API -->
                    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&callback=initMap&loading=async" 
                            async defer 
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