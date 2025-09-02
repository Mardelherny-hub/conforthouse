<x-public-layout>
    <!-- James Edition Property Detail Hero -->
    <div class="james-property-hero" 
         x-data="{
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
        
        <!-- Navigation Tabs - James Edition Style -->
        <div class="james-detail-nav">
            <div class="max-w-7xl mx-auto px-4">
                <nav class="flex items-center justify-center py-4">
                    <div class="flex space-x-8">
                        <button @click="activeTab = 'images'"
                                :class="activeTab === 'images' ? 'james-tab-active' : 'james-tab-inactive'"
                                class="james-detail-tab">
                            <span class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Gallery</span>
                            </span>
                        </button>
                        @if($property->video)
                        <button @click="activeTab = 'video'"
                                :class="activeTab === 'video' ? 'james-tab-active' : 'james-tab-inactive'"
                                class="james-detail-tab">
                            <span class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <span>Video</span>
                            </span>
                        </button>
                        @endif
                    </div>
                </nav>
            </div>
        </div>

        <!-- Image Gallery - James Edition Style -->
        <div x-show="activeTab === 'images'" class="james-media-container">
            @if($property->images->isNotEmpty())
                <div class="james-main-image" @click="openImageModal(0)">
                    <img src="/storage/{{ $property->images->first()->image_path }}" 
                         alt="{{ $property->title }}"
                         class="w-full h-full object-cover cursor-pointer">
                </div>
                @if($property->images->count() > 1)
                    <div class="james-thumbnail-grid">
                        @foreach($property->images->slice(1, 4) as $index => $image)
                            <div class="james-thumbnail" @click="openImageModal({{ $index + 1 }})">
                                <img src="/storage/{{ $image->image_path }}" 
                                     alt="{{ $property->title }}"
                                     class="w-full h-full object-cover cursor-pointer">
                            </div>
                        @endforeach
                        @if($property->images->count() > 5)
                            <div class="james-thumbnail-overlay" @click="openImageModal(0)">
                                <span class="text-white font-medium">+{{ $property->images->count() - 5 }} more</span>
                            </div>
                        @endif
                    </div>
                @endif
            @else
                <div class="james-main-image">
                    <img src="/images/placeholder-property.jpg" 
                         alt="{{ $property->title }}"
                         class="w-full h-full object-cover">
                </div>
            @endif
        </div>

        <!-- Video Content -->
        @if($property->video)
        <div x-show="activeTab === 'video'" class="james-media-container">
            <div class="james-video-wrapper">
                <iframe :src="'https://www.youtube.com/embed/' + youtubeVideoId + '?rel=0&showinfo=0'"
                        class="w-full h-full"
                        title="Property Video"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                </iframe>
            </div>
        </div>
        @endif

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

    <!-- Property Content - James Edition Layout -->
    <div class="james-property-content">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
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
                            <div class="james-stat-label">m² Built</div>
                        </div>
                        <div class="james-stat-item">
                            <div class="james-stat-value">{{ $property->rooms }}</div>
                            <div class="james-stat-label">{{ __('messages.Habitaciones') }}</div>
                        </div>
                        <div class="james-stat-item">
                            <div class="james-stat-value">{{ $property->bathrooms }}</div>
                            <div class="james-stat-label">{{ __('messages.BaÃ±os') }}</div>
                        </div>
                        <div class="james-stat-item">
                            <div class="james-stat-value">{{ $property->floor }}</div>
                            <div class="james-stat-label">Floor</div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="james-property-description">
                        <h2 class="james-section-title">Description</h2>
                        <div class="james-description-content">
                            {!! nl2br($property->description) !!}
                        </div>
                    </div>

                    <!-- Property Details -->
                    <div class="james-property-details">
                        <h2 class="james-section-title">Property Details</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Basic Details -->
                            <div class="james-details-section">
                                <h3 class="james-details-title">Basic Information</h3>
                                <div class="james-details-list">
                                    <div class="james-detail-item">
                                        <span class="james-detail-label">Reference</span>
                                        <span class="james-detail-value">{{ $property->reference }}</span>
                                    </div>
                                    <div class="james-detail-item">
                                        <span class="james-detail-label">Type</span>
                                        <span class="james-detail-value">{{ $property->propertyType->name }}</span>
                                    </div>
                                    <div class="james-detail-item">
                                        <span class="james-detail-label">Operation</span>
                                        <span class="james-detail-value">{{ $property->operation->name }}</span>
                                    </div>
                                    <div class="james-detail-item">
                                        <span class="james-detail-label">Condition</span>
                                        <span class="james-detail-value">{{ $property->condition }}</span>
                                    </div>
                                    @if($property->year_built)
                                    <div class="james-detail-item">
                                        <span class="james-detail-label">Year Built</span>
                                        <span class="james-detail-value">{{ $property->year_built }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Space Details -->
                            <div class="james-details-section">
                                <h3 class="james-details-title">Space & Layout</h3>
                                <div class="james-details-list">
                                    <div class="james-detail-item">
                                        <span class="james-detail-label">Built Area</span>
                                        <span class="james-detail-value">{{ $property->built_area }} m²</span>
                                    </div>
                                    <div class="james-detail-item">
                                        <span class="james-detail-label">Bedrooms</span>
                                        <span class="james-detail-value">{{ $property->rooms }}</span>
                                    </div>
                                    <div class="james-detail-item">
                                        <span class="james-detail-label">Bathrooms</span>
                                        <span class="james-detail-value">{{ $property->bathrooms }}</span>
                                    </div>
                                    <div class="james-detail-item">
                                        <span class="james-detail-label">Floor</span>
                                        <span class="james-detail-value">{{ $property->floor }}</span>
                                    </div>
                                    @if($property->parking_spaces)
                                    <div class="james-detail-item">
                                        <span class="james-detail-label">Parking</span>
                                        <span class="james-detail-value">{{ $property->parking_spaces }} spaces</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Location Map -->
                    @if($property->google_map)
                    <div class="james-property-map">
                        <h2 class="james-section-title">Location</h2>
                        <div class="james-map-container">
                            <iframe src="{{ $property->google_map }}" 
                                    width="100%" 
                                    height="400"
                                    style="border:0;" 
                                    allowfullscreen="" 
                                    loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                    @endif

                    <!-- Share Property -->
                    <div class="james-property-share">
                        <h3 class="james-section-title">Share This Property</h3>
                        <div class="james-share-buttons">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                               target="_blank" class="james-share-btn james-share-facebook">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($property->title) }}" 
                               target="_blank" class="james-share-btn james-share-twitter">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                                Twitter
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($property->title . ' ' . request()->url()) }}" 
                               target="_blank" class="james-share-btn james-share-whatsapp">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                </svg>
                                WhatsApp
                            </a>
                            <a href="mailto:?subject={{ urlencode($property->title) }}&body={{ urlencode(request()->url()) }}" 
                               class="james-share-btn james-share-email">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Email
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Sidebar - Contact -->
                <div class="lg:col-span-1">
                    <div class="james-contact-sidebar sticky top-8">
                        <div class="james-contact-card">
                            <h3 class="james-contact-title">Contact Us</h3>
                            <p class="james-contact-subtitle">
                                Request more information about this property. We'll respond as soon as possible.
                            </p>
                            
                            <form class="james-contact-form" method="POST" action="#">
                                @csrf
                                <input type="hidden" name="property_id" value="{{ $property->id }}">
                                
                                <div class="james-form-group">
                                    <label for="name" class="james-form-label">Full Name</label>
                                    <input type="text" 
                                           id="name" 
                                           name="name" 
                                           class="james-form-input"
                                           placeholder="Enter your name"
                                           required>
                                </div>
                                
                                <div class="james-form-group">
                                    <label for="email" class="james-form-label">Email Address</label>
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           class="james-form-input"
                                           placeholder="Enter your email"
                                           required>
                                </div>
                                
                                <div class="james-form-group">
                                    <label for="phone" class="james-form-label">Phone (Optional)</label>
                                    <input type="tel" 
                                           id="phone" 
                                           name="phone" 
                                           class="james-form-input"
                                           placeholder="+34 600 000 000">
                                </div>
                                
                                <div class="james-form-group">
                                    <label for="message" class="james-form-label">Message</label>
                                    <textarea id="message" 
                                              name="message" 
                                              rows="4"
                                              class="james-form-textarea"
                                              placeholder="I'm interested in this property..."
                                              required></textarea>
                                </div>
                                
                                <div class="james-form-checkbox">
                                    <input type="checkbox" 
                                           id="privacy" 
                                           name="privacy" 
                                           class="james-checkbox"
                                           required>
                                    <label for="privacy" class="james-checkbox-label">
                                        I accept the privacy policy and terms of service
                                    </label>
                                </div>
                                
                                <button type="submit" class="james-contact-submit">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    Send Message
                                </button>
                            </form>

                            <!-- Contact Info -->
                            <div class="james-contact-info">
                                <div class="james-contact-item">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span>+34 900 000 000</span>
                                </div>
                                <div class="james-contact-item">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <span>info@inmobiliaria.com</span>
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
        <div class="max-w-7xl mx-auto px-4 py-16">
            <div class="james-section-header">
                <h2 class="james-section-title">Similar Properties</h2>
                <p class="james-section-subtitle">Discover other exceptional properties that might interest you</p>
            </div>
            
            <div class="james-properties-grid">
                @foreach($rel_properties as $relProperty)
                    <div class="james-property-card">
                        <div class="james-property-image">
                            <img src="/storage/{{ $relProperty->firstImage->thumbnail_path }}" 
                                 alt="{{ $relProperty->title }}"
                                 class="w-full h-full object-cover">
                            <div class="james-property-overlay">
                                <a href="{{ route('prop.show', ['locale' => app()->getLocale(), 'slug' => $relProperty->slug]) }}" 
                                   class="james-property-link">
                                    View Details
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="james-property-content">
                            <div class="james-property-price">€{{ number_format($relProperty->price, 0, ',', '.') }}</div>
                            <h3 class="james-property-card-title">{{ $relProperty->title }}</h3>
                            <div class="james-property-specs">
                                <span>{{ $relProperty->built_area }} m²</span>
                                <span>•</span>
                                <span>{{ $relProperty->rooms }} bed</span>
                                <span>•</span>
                                <span>{{ $relProperty->bathrooms }} bath</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    

</x-public-layout>


  