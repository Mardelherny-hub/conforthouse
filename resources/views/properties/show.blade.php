<x-properties-layout>
<div>

    <!-- James Edition Property Detail Hero -->
    <div x-data="{
             activeTab: 'images',
             images: @js($property->images),
             currentImageIndex: 0,
             showImageModal: false,
             youtubeVideoId: '{{ $property->video }}',
             openImageModal(index) {
                 this.currentImageIndex = index;
                 this.showImageModal = true;
             },
             closeImageModal() {
                 this.showImageModal = false;
             },
             nextImage() {
                 this.currentImageIndex = (this.currentImageIndex + 1) % this.images.length;
             },
             prevImage() {
                 this.currentImageIndex = (this.currentImageIndex - 1 + this.images.length) % this.images.length;
             },
             get currentImage() {
                 return this.images[this.currentImageIndex];
             }
         }">
        <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12">
        <!-- Navigation Tabs - James Edition Style -->
        <div class="james-detail-nav">
            <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12">
                <nav class="flex items-center justify-center py-4">
                    <div class="flex space-x-8">
                        <button @click="activeTab = 'images'"
                                :class="activeTab === 'images' ? 'james-tab-active' : 'james-tab-inactive'"
                                class="james-detail-tab">
                            <span class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ __('messages.gallery') }}</span>
                            </span>
                        </button>
                        @if($property->videos->isNotEmpty())
                        <button @click="activeTab = 'video'"
                                :class="activeTab === 'video' ? 'james-tab-active' : 'james-tab-inactive'"
                                class="james-detail-tab">
                            <span class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <span>{{ __('messages.video') }}</span>
                            </span>
                        </button>
                        @endif
                    </div>
                </nav>
            </div>
        </div>

        <!-- Image Gallery - James Edition Style -->
        <div x-show="activeTab === 'images'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                {{-- Galería de Imágenes con Alpine --}}
                <div x-data="{
                    images: @js($property->images),
                    currentIndex: 0,
                    showModal: false,
                    openModal(index) {
                        this.currentIndex = index;
                        this.showModal = true;
                    },
                    closeModal() {
                        this.showModal = false;
                    },
                    nextImage() {
                        this.currentIndex = (this.currentIndex + 1) % this.images.length;
                    },
                    prevImage() {
                        this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
                    },
                    get currentImage() {
                        return this.images[this.currentIndex];
                    }
                }" class="grid grid-cols-1 md:grid-cols-2 gap-0.5 mb-12">
                    {{-- Imagen Principal --}}
                    <div class="relative group overflow-hidden">
                        @if($property->images->isNotEmpty()) 
                            @php
                                $mainImage = $property->images->first();
                                $mainImageSrc = str_starts_with($mainImage->image_path, 'http') 
                                    ? $mainImage->image_path 
                                    : '/storage/' . $mainImage->image_path;
                            @endphp
                            <img src="{{ $mainImageSrc }}"
                                alt="{{ $property->title }}"
                                @click="openModal(0)"
                                class="w-full h-[500px] object-cover shadow-xl transform transition-all duration-700 group-hover:scale-105 cursor-pointer">
                        @else
                            <img src="/images/placeholder-property.jpg"
                                alt="{{ $property->title }}"
                                class="w-full h-[500px] object-cover shadow-xl">
                        @endif
                        {{-- Overlay con gradiente --}}
                        {{-- <div
                            class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-70">
                        </div> --}}

                        {{-- Etiquetas 
                        <div class="absolute top-4 left-4 flex space-x-2">
                            <span class="bg-neutral-400 text-white px-3 py-1 rounded-none text-sm">
                                {{ $property->propertyType->name }}
                            </span>
                            <span class="bg-gold-800 text-white px-3 py-1 rounded-none text-sm">
                                {{ $property->operation->name }}
                            </span>
                        </div>--}}
                    </div>

                    {{-- Miniaturas de Imágenes --}}
                    <div class="grid grid-cols-2 gap-0.5 h-[500px]">
                        @foreach ($property->images->slice(1, 4) as $index => $image)
                            <div class="relative group overflow-hidden">
                                @php
                                    $thumbSrc = str_starts_with($image->image_path, 'http') 
                                        ? $image->image_path 
                                        : '/storage/' . $image->image_path;
                                @endphp
                                <div class="relative group overflow-hidden aspect-square">
                                    <img src="{{ $thumbSrc }}" alt="{{ $property->title }}"
                                        @click="openModal({{ $index }})"
                                        class="w-full h-full object-cover transform transition-all duration-700 group-hover:scale-110 cursor-pointer">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Modal de Imágenes Mejorado -->
                    <template x-teleport="body">
                        <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0" @keydown.escape.window="closeModal()"
                            @keydown.arrow-right.window="nextImage()" @keydown.arrow-left.window="prevImage()"
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-95"
                            @click.self="closeModal()">
                            
                            <!-- Contenedor principal del modal -->
                            <div class="relative w-full h-full flex flex-col p-4 md:p-6 lg:p-8">
                                
                                <!-- Botón de cierre -->
                                <button @click="closeModal()"
                                    class="absolute top-4 right-4 z-20 text-white text-3xl md:text-4xl hover:text-amber-500 transition-colors duration-200 bg-black/30 hover:bg-black/50 rounded-full w-12 h-12 md:w-14 md:h-14 flex items-center justify-center backdrop-blur-sm">
                                    <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>

                                <!-- Navegación izquierda -->
                                <button @click="prevImage()"
                                    class="absolute left-4 top-1/2 transform -translate-y-1/2 z-20 bg-black/40 hover:bg-amber-500/80 text-white w-12 h-12 md:w-16 md:h-16 rounded-full flex items-center justify-center backdrop-blur-sm transition-all duration-200 hover:scale-105">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 md:h-8 md:w-8" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                
                                <!-- Navegación derecha -->
                                <button @click="nextImage()"
                                    class="absolute right-4 top-1/2 transform -translate-y-1/2 z-20 bg-black/40 hover:bg-amber-500/80 text-white w-12 h-12 md:w-16 md:h-16 rounded-full flex items-center justify-center backdrop-blur-sm transition-all duration-200 hover:scale-105">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 md:h-8 md:w-8" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>

                                <!-- Contenedor de la imagen - Ocupa todo el espacio disponible -->
                                <div class="flex-1 flex items-center justify-center min-h-0 pt-16 pb-16">
                                    <img :src="currentImage.image_path.startsWith('http') ? currentImage.image_path : '/storage/' + currentImage.image_path" 
                                        alt="{{ $property->title }}"
                                        class="max-w-full max-h-full object-contain shadow-2xl"
                                        style="max-height: calc(100vh - 8rem);"
                                        x-transition:enter="transition ease-out duration-300 transform"
                                        x-transition:enter-start="opacity-0 scale-95"
                                        x-transition:enter-end="opacity-100 scale-100">
                                </div>

                                <!-- Contador de imágenes -->
                                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 text-white text-center bg-black/40 backdrop-blur-sm rounded-full px-4 py-2">
                                    <span class="text-lg font-medium">
                                        <span x-text="currentIndex + 1"></span> / <span x-text="images.length"></span>
                                    </span>
                                </div>

                                <!-- Thumbnails opcionales (para pantallas grandes) -->
                                <div class="hidden lg:block absolute bottom-20 left-1/2 transform -translate-x-1/2 w-full max-w-4xl">
                                    <div class="flex justify-center space-x-2 px-4">
                                        <template x-for="(image, index) in images.slice(Math.max(0, currentIndex - 2), currentIndex + 3)" :key="index">
                                            <button @click="currentIndex = images.indexOf(image)"
                                                    :class="images.indexOf(image) === currentIndex ? 'ring-2 ring-amber-500' : 'ring-1 ring-white/30'"
                                                    class="w-16 h-16 rounded overflow-hidden transition-all duration-200 hover:ring-2 hover:ring-amber-400 opacity-70 hover:opacity-100">
                                                <img :src="image.image_path.startsWith('http') ? image.image_path : '/storage/' + image.image_path"
                                                    :alt="'Thumbnail ' + (images.indexOf(image) + 1)"
                                                    class="w-full h-full object-cover">
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

            </div>

            <!-- Contenido de la pestaña de video -->
<div x-show="activeTab === 'video'" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    class="grid grid-cols-1 gap-6">
    
    @if($property->videos->isNotEmpty())
        @foreach($property->videos as $video)
            <div class="relative h-[500px] group mb-4">
                @if($video->embed_url)
                    <iframe src="{{ $video->embed_url }}"
                        class="w-full h-full object-cover shadow-lg"
                        frameborder="0" allowfullscreen>
                    </iframe>
                    @if($video->title)
                        <p class="mt-2 text-gray-600">{{ $video->title }}</p>
                    @endif
                @endif
            </div>
        @endforeach
    @else
        <div class="h-[500px] bg-gray-100 flex items-center justify-center">
            <p class="text-gray-500">No hay videos disponibles para esta propiedad</p>
        </div>
    @endif
</div>

        <!-- Image Modal - James Edition Style -->
        <template x-teleport="body">
            <div x-show="showImageModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100"
                 @keydown.escape.window="closeImageModal()"
                 @keydown.arrow-right.window="nextImage()" 
                 @keydown.arrow-left.window="prevImage()"
                 class="james-image-modal"
                 @click.self="closeImageModal()">
                
                <div class="james-modal-content">
                    <button @click="closeImageModal()" class="james-modal-close">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    
                    <button @click="prevImage()" class="james-modal-nav james-modal-prev">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    
                    <button @click="nextImage()" class="james-modal-nav james-modal-next">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                    
                    <div class="james-modal-image">
                        <img :src="'/storage/' + currentImage.image_path" 
                             alt="{{ $property->title }}"
                             class="max-w-full max-h-full object-contain">
                    </div>
                    
                    <div class="james-modal-counter">
                        <span x-text="currentImageIndex + 1"></span> / <span x-text="images.length"></span>
                    </div>
                </div>
            </div>
        </template>
        </div>
    </div>


    <!-- Property Content - James Edition Layout -->
    <div class="james-property-content">
        <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12 md:col-span-2">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-x-8">
                
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Property Header -->
                    <div class="james-property-header">
                        <div class="flex flex-wrap items-center gap-2 mb-4">
                            <span class="james-property-badge">{{ $property->propertyType->name }}</span>
                            <span class="james-property-badge james-badge-secondary">{{ $property->operation->name }}</span>
                        </div>
                        
                        
                        <h1 class="james-property-title">{{ $property->title }}</h1>
                        
                        <div class="james-property-location">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ $property->address->city }}, {{ $property->address->province }}, {{ $property->address->autonomous_community }}</span>
                        </div>

                        <div class="james-property-price">
                            €{{ number_format($property->price, 0, ',', '.') }}
                        </div>
                    </div>

                    <!-- Property Stats -->
                    <div class="james-property-stats">
                        <div class="james-stat-item">
                            <div class="james-stat-value">{{ $property->built_area }}</div>
                            <div class="james-stat-label">{{ __('messages.m2_built') }}</div>
                        </div>
                        <div class="james-stat-item">
                            <div class="james-stat-value">{{ $property->rooms }}</div>
                            <div class="james-stat-label">{{ __('messages.Habitaciones') }}</div>
                        </div>
                        <div class="james-stat-item">
                            <div class="james-stat-value">{{ $property->bathrooms }}</div>
                            <div class="james-stat-label">{{ __('messages.Banios') }}</div>
                        </div>
                        <div class="james-stat-item">
                            <div class="james-stat-value">{{ $property->floor }}</div>
                            <div class="james-stat-label">{{ __('messages.floor') }}</div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="james-property-description">
                        <h2 class="james-section-title">{{ __('messages.description') }}</h2>
                        <div class="james-description-content">
                            @php
                                // Dividir por ~ para crear párrafos
                                $paragraphs = explode('~', $property->description);
                            @endphp
                            
                            @foreach($paragraphs as $index => $paragraph)
                                @if(trim($paragraph))
                                    @php
                                        $cleanParagraph = trim($paragraph);
                                    @endphp
                                    
                                    @if($index === 1) {{-- El primer párrafo después del ~ es el destacado --}}
                                        <p class="mb-4 leading-relaxed text-amber-800 font-semibold bg-amber-50 p-3 rounded border-l-2 border-amber-400">
                                            {{ $cleanParagraph }}
                                        </p>
                                    @else
                                        <p class="mb-4 leading-relaxed text-gray-700">
                                            {{ $cleanParagraph }}
                                        </p>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Property Details -->
                    <div class="james-property-details">
                        <h3 class="james-details-title">{{ __('messages.basic_information') }}</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Basic Details -->
                            <div class="james-details-section">
                                <h3 class="james-details-title">{{ __('messages.basic_information') }}</h3>
                                <div class="james-details-list">
                                    <div class="james-detail-item">
                                        <span class="james-detail-label">{{ __('messages.reference') }}</span>
                                        <span class="james-detail-value">{{ $property->reference }}</span>
                                    </div>
                                    <div class="james-detail-item">
                                        <span class="james-detail-label">{{ __('messages.type') }}</span>
                                        <span class="james-detail-value">
                                            @if(app()->getLocale() !== 'es')
                                                {{ $property->propertyType->translations->where('locale', app()->getLocale())->first()->name ?? $property->propertyType->name }}
                                            @else
                                                {{ $property->propertyType->name }}
                                            @endif
                                        </span>
                                    </div>
                                    <div class="james-detail-item">
                                        <span class="james-detail-label">{{ __('messages.operation') }}</span>
                                        <span class="james-detail-value">
                                            @if(app()->getLocale() !== 'es')
                                                {{ $property->operation->translations->where('locale', app()->getLocale())->first()->name ?? $property->operation->name }}
                                            @else
                                                {{ $property->operation->name }}
                                            @endif
                                        </span>
                                    </div>
                                    <div class="james-detail-item">
                                        <span class="james-detail-label">{{ __('messages.condition') }}</span>
                                        <span class="james-detail-value">
                                            @if($property->status)
                                                @if(app()->getLocale() !== 'es')
                                                    {{ $property->status->translations->where('locale', app()->getLocale())->first()->name ?? $property->status->name }}
                                                @else
                                                    {{ $property->status->name }}
                                                @endif
                                            @else
                                                {{ $property->condition }}
                                            @endif
                                        </span>
                                    </div>
                                    @if($property->year_built)
                                    <div class="james-detail-item">
                                        <span class="james-detail-label">{{ __('messages.year_built') }}</span>
                                        <span class="james-detail-value">{{ $property->year_built }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Space Details -->
                            <div class="james-details-section">
                                <h3 class="james-details-title">{{ __('messages.space_layout') }}</h3>
                                <div class="james-details-list">
                                    <div class="james-detail-item">
                                        <span class="james-detail-label">{{ __('messages.built_area') }}</span>
                                        <span class="james-detail-value">{{ $property->built_area }} m²</span>
                                    </div>
                                    <div class="james-detail-item">
                                        <span class="james-detail-label">{{ __('messages.bedrooms') }}</span>
                                        <span class="james-detail-value">{{ $property->rooms }}</span>
                                    </div>
                                    <div class="james-detail-item">
                                        <span class="james-detail-label">{{ __('messages.bathrooms') }}</span>
                                        <span class="james-detail-value">{{ $property->bathrooms }}</span>
                                    </div>
                                    <div class="james-detail-item">
                                        <span class="james-detail-label">{{ __('messages.floor') }}</span>
                                        <span class="james-detail-value">{{ $property->floor }}</span>
                                    </div>
                                    @if($property->parking_spaces)
                                    <div class="james-detail-item">
                                        <span class="james-detail-label">{{ __('messages.parking') }}</span>
                                        <span class="james-detail-value">{{ $property->parking_spaces }} {{ __('messages.spaces') }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Location Map Section -->
                    @if($property->address && $property->address->latitude && $property->address->longitude)
                    <div class="james-property-map">
                        <h2 class="james-section-title">{{ __('messages.location') }}</h2>
                        
                        <!-- Map Container -->
                        <div class="relative w-full h-96 rounded-lg overflow-hidden shadow-lg">
                            <div id="property-map" class="w-full h-full"></div>
                            
                            <!-- Loading State -->
                            <div id="property-map-loading" class="absolute inset-0 bg-gray-100 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto mb-2"></div>
                                    <p class="text-gray-500 text-sm">Cargando mapa...</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Map Script -->
                    <script>
                        let propertyMap;
                        let propertyMapLoaded = false;

                        function initPropertyMap() {
                            console.log('🗺️ Iniciando mapa de propiedad...');
                            
                            // Ocultar loading
                            const loadingElement = document.getElementById('property-map-loading');
                            if (loadingElement) {
                                loadingElement.style.display = 'none';
                            }

                            const mapContainer = document.getElementById('property-map');
                            if (!mapContainer) {
                                console.error('❌ No se encontró el contenedor del mapa');
                                return;
                            }

                            // Coordenadas de la propiedad
                            const propertyLocation = {
                                lat: {{ $property->address->latitude }},
                                lng: {{ $property->address->longitude }}
                            };

                            console.log('📍 Coordenadas:', propertyLocation);

                            // Inicializar mapa
                            propertyMap = new google.maps.Map(mapContainer, {
                                zoom: 15,
                                center: propertyLocation,
                                mapTypeControl: true,
                                streetViewControl: true,
                                fullscreenControl: true,
                                styles: [
                                    {
                                        "featureType": "poi",
                                        "elementType": "labels",
                                        "stylers": [{ "visibility": "off" }]
                                    }
                                ]
                            });

                            // Crear marcador
                            const marker = new google.maps.Marker({
                                position: propertyLocation,
                                map: propertyMap,
                                title: {!! json_encode($property->title) !!},
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

                            // Contenido del InfoWindow
                            const infoContent = `
                                <div class="p-4 max-w-sm">
                                    <h3 class="font-bold text-lg text-gray-900 mb-2">{!! addslashes($property->title) !!}</h3>
                                    
                                    @if($property->images && $property->images->first())
                                        @php
                                            $image = $property->images->first();
                                            $imageSrc = str_starts_with($image->image_path, 'http') 
                                                ? $image->image_path 
                                                : asset('storage/' . $image->image_path);
                                        @endphp
                                        <img src="{{ $imageSrc }}" 
                                            alt="{{ $property->title }}" 
                                            class="w-full h-32 object-cover rounded mb-3"
                                            onerror="this.style.display='none';" />
                                    @endif
                                    
                                    <p class="text-sm text-gray-600 mb-2 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $property->address->city }}, {{ $property->address->province }}
                                    </p>
                                    
                                    <div class="text-sm text-gray-500 mb-3 flex items-center gap-3">
                                        @if($property->rooms > 0)
                                            <span>{{ $property->rooms }} hab</span>
                                        @endif
                                        @if($property->bathrooms > 0)
                                            <span>{{ $property->bathrooms }} baños</span>
                                        @endif
                                        @if($property->built_area > 0)
                                            <span>{{ $property->built_area }}m²</span>
                                        @endif
                                    </div>
                                    
                                    <p class="text-xl font-bold text-blue-600">€{{ number_format($property->price, 0, ',', '.') }}</p>
                                </div>
                            `;

                            // Crear InfoWindow
                            const infoWindow = new google.maps.InfoWindow({
                                content: infoContent
                            });

                            // Click en marcador
                            marker.addListener('click', () => {
                                infoWindow.open(propertyMap, marker);
                            });

                            // Abrir automáticamente después de 500ms
                            setTimeout(() => {
                                infoWindow.open(propertyMap, marker);
                            }, 500);

                            propertyMapLoaded = true;
                            console.log('✅ Mapa cargado correctamente');
                        }

                        function handlePropertyMapError() {
                            console.error('❌ Error al cargar Google Maps');
                            const loadingElement = document.getElementById('property-map-loading');
                            if (loadingElement) {
                                loadingElement.innerHTML = `
                                    <div class="text-center text-red-600 py-8">
                                        <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        <p class="text-sm font-medium">Error al cargar el mapa</p>
                                        <p class="text-xs text-gray-500 mt-1">Verifique la configuración de Google Maps</p>
                                    </div>
                                `;
                            }
                        }

                        // Timeout de seguridad (10 segundos)
                        setTimeout(() => {
                            if (!propertyMapLoaded) {
                                console.warn('⚠️ Timeout: el mapa no se ha cargado en 10 segundos');
                                handlePropertyMapError();
                            }
                        }, 10000);
                    </script>

                    <!-- Google Maps API -->
                    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBcKA1RrcEhTjruBl6y4wvgxpKEGUrpoig&callback=initPropertyMap&v=weekly" 
                            async defer 
                            onerror="handlePropertyMapError()">
                    </script>
                    @endif

                    <!-- Share Property -->
                    <div class="james-property-share">
                        <h3 class="james-section-title">{{ __('messages.share_property') }}</h3>
                        <div class="james-share-buttons">
                            <!-- Facebook -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                            target="_blank" class="james-share-btn james-share-facebook">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                {{ __('messages.facebook') }}
                            </a>

                            <!-- Instagram -->
                            <a href="https://www.instagram.com/" 
                            target="_blank" class="james-share-btn james-share-instagram"
                            title="{{ __('messages.visit_instagram') }}">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                                {{ __('messages.instagram') }}
                            </a>

                            <!-- WhatsApp -->
                            <a href="https://wa.me/?text={{ urlencode($property->title . ' ' . request()->url()) }}"
                            target="_blank" class="james-share-btn james-share-whatsapp">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                </svg>
                                {{ __('messages.whatsapp') }}
                            </a>

                            <!-- Email -->
                            <a href="mailto:?subject={{ urlencode($property->title) }}&body={{ urlencode('Mira esta propiedad: ' . request()->url()) }}"
                            class="james-share-btn james-share-email">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                </svg>
                                {{ __('messages.email') }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Sidebar - Contact -->
                <div class="my-2">
                    <div class="sticky top-8">
                        <div class="james-contact-card">
                            <h3 class="james-contact-title">{{ __('messages.Contacta con nosotros') }}</h3>
                            <p class="james-contact-subtitle">
                                 {{ __('messages.more-info') }}.
                            </p>

                            <form class="james-contact-form" 
                                method="POST" 
                                action="{{ route('property.contact.store', ['locale' => app()->getLocale()]) }}"
                                data-property-contact-form>
                                @csrf
                                <input type="hidden" name="property_id" value="{{ $property->id }}">
                                
                                <div class="james-form-group">
                                    <label for="name" class="james-form-label">{{ __('messages.full_name') }}</label>
                                    <input type="text" 
                                           id="name" 
                                           name="name" 
                                           class="james-form-input"
                                           placeholder="{{ __('messages.enter_name') }}"
                                           required>
                                </div>
                                
                                <div class="james-form-group">
                                    <label for="email" class="james-form-label">{{ __('messages.email_address') }}</label>
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           class="james-form-input"
                                           placeholder="{{ __('messages.enter_email') }}"
                                           required>
                                </div>
                                
                                <div class="james-form-group">
                                    <label for="phone" class="james-form-label">{{ __('messages.phone_optional') }}</label>
                                    <input type="tel" 
                                           id="phone" 
                                           name="phone" 
                                           class="james-form-input"
                                           placeholder="{{ __('messages.phone_placeholder') }}">
                                </div>
                                
                                <div class="james-form-group">
                                    <label for="message" class="james-form-label">{{ __('messages.message') }}</label>
                                    <textarea id="message" 
                                              name="message" 
                                              rows="4"
                                              class="james-form-textarea"
                                              placeholder="{{ __('messages.interested_property') }}"
                                              required></textarea>
                                </div>
                                
                                <div class="james-form-checkbox">
                                    <input type="checkbox" 
                                           id="privacy" 
                                           name="privacy" 
                                           class="james-checkbox"
                                           required>
                                    <label for="privacy" class="james-checkbox-label">
                                        {{ __('messages.accept_privacy_terms') }}
                                    </label>
                                </div>
                                
                                <button type="submit" class="james-contact-submit">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    {{ __('messages.send_message') }}
                                </button>
                            </form>

                            <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const form = document.querySelector('[data-property-contact-form]');
                                
                                if (form) {
                                    form.addEventListener('submit', async function(e) {
                                        e.preventDefault();
                                        
                                        const submitButton = form.querySelector('button[type="submit"]');
                                        const originalText = submitButton.innerHTML;
                                        
                                        // Deshabilitar botón y mostrar loading
                                        submitButton.disabled = true;
                                        submitButton.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 inline" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Enviando...';
                                        
                                        try {
                                            const formData = new FormData(form);
                                            const response = await fetch(form.action, {
                                                method: 'POST',
                                                body: formData,
                                                headers: {
                                                    'X-Requested-With': 'XMLHttpRequest',
                                                    'Accept': 'application/json'
                                                }
                                            });
                                            
                                            const data = await response.json();
                                            
                                            if (data.success) {
                                                // Mostrar mensaje de éxito
                                                alert(data.message || 'Mensaje enviado correctamente');
                                                form.reset();
                                            } else {
                                                alert(data.message || 'Error al enviar el mensaje');
                                            }
                                        } catch (error) {
                                            console.error('Error:', error);
                                            alert('Error al enviar el mensaje. Por favor, intente nuevamente.');
                                        } finally {
                                            // Restaurar botón
                                            submitButton.disabled = false;
                                            submitButton.innerHTML = originalText;
                                        }
                                    });
                                }
                            });
                            </script>

                            <!-- Contact Info -->
                            <div class="james-contact-info">
                                <div class="james-contact-item">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span>696 649 243 | 963 385 030</span>
                                </div>
                                <div class="james-contact-item">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <span>conforthouseliving@rbconforthouse.com</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Similar Properties - James Edition Style -->
    @if($rel_properties && $rel_properties->count() > 0)
    <div class="james-similar-properties">
        <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12 py-16">
            <div class="james-section-header">
                <h2 class="james-section-title">{{ __('messages.similar_properties') }}</h2>
                <p class="james-section-subtitle ml-4">{{ __('messages.discover_properties') }}</p>
            </div>
            
            <div class="james-properties-similar-grid">
                @foreach($rel_properties as $relProperty)
                    <div class="james-property-card">
                        <div class="james-property-image">
                            @php
                                $relImageSrc = $relProperty->firstImage 
                                    ? (str_starts_with($relProperty->firstImage->image_path, 'http') 
                                        ? $relProperty->firstImage->image_path 
                                        : '/storage/' . $relProperty->firstImage->image_path)
                                    : asset('assets/images/properties/placeholder.webp');
                            @endphp
                            <img src="{{ $relImageSrc }}" 
                                alt="{{ $relProperty->title }}"
                                class="w-full h-full object-cover">
                            <div class="james-property-overlay">
                                <a href="{{ route('prop.show', ['locale' => app()->getLocale(), 'slug' => $relProperty->slug]) }}" 
                                   class="james-property-link">
                                    {{ __('messages.view_details') }}
                                    
                                </a>
                            </div>
                        </div>
                        <div class="james-property-content">
                            <div class="james-property-price">€{{ number_format($relProperty->price, 0, ',', '.') }}</div>
                            <h3 class="james-property-card-title">{{ $relProperty->title }}</h3>
                            <div class="james-property-specs">
                                <span>{{ $relProperty->built_area }} m²</span>
                                <span>•</span>
                                <span>{{ $relProperty->rooms }} {{ __('messages.bed') }}</span>
                                <span>•</span>
                                <span>{{ $relProperty->bathrooms }} {{ __('messages.bath') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    
</div>
</x-public-layout>


  