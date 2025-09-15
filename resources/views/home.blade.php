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
        <a href="{{ route('properties.index', ['locale' => app()->getLocale(), 'type_id' => 1]) }}" class="category-card">
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

    <!-- Featured Property -->
    {{-- @if ($featuredProperty)
        <section class="james-featured">
            <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12">
                <div class="james-featured-container">
                    
                    <!-- Property Image -->
                    <div class="james-featured-image">
                        @if($featuredProperty->images && $featuredProperty->images->first())
                            @php
                                $image = $featuredProperty->images->first();
                                $imageSrc = str_starts_with($image->image_path, 'http') 
                                    ? $image->image_path 
                                    : '/storage/' . $image->image_path;
                            @endphp
                            <img src="{{ $imageSrc }}" 
                                alt="{{ $featuredProperty->title }}"
                                class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('assets/images/home/trend-2.png') }}" 
                                alt="{{ $featuredProperty->title }}"
                                class="w-full h-full object-cover">
                        @endif
                        
                        <div class="james-featured-badge font-body">{{ __('messages.featured') }}</div>
                    </div>
                    
                    <!-- Property Details -->
                    <div class="james-featured-content">
                        <div class="james-featured-location font-body">
                            {{ $featuredProperty->address->city ?? '' }}, {{ $featuredProperty->address->province ?? '' }}
                        </div>
                        
                        <h2 class="james-featured-title font-luxury">
                            {{ $featuredProperty->title }}
                        </h2>
                        
                        <div class="james-featured-price font-body">
                            €{{ number_format($featuredProperty->price) }}
                        </div>
                        
                        <div class="james-featured-specs font-body">
                            <span class="james-spec">{{ $featuredProperty->built_area }}m²</span>
                            <span class="james-spec-separator">•</span>
                            <span class="james-spec">{{ $featuredProperty->rooms }} {{ __('messages.habitaciones') }}</span>
                            <span class="james-spec-separator">•</span>
                            <span class="james-spec">{{ $featuredProperty->bathrooms }} {{ __('messages.banios') }}</span>
                        </div>
                        
                        <p class="james-featured-description font-body">
                            {{ Str::limit(strip_tags($featuredProperty->description), 200) }}
                        </p>
                        
                        <div class="james-featured-actions">
                            <a href="{{ route('prop.show', ['locale' => app()->getLocale(), 'slug' => $featuredProperty->slug ?? '']) }}"
                               class="james-btn-primary font-body">
                                {{ __('messages.Ver Detalles') }}
                            </a>
                            
                            <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}"
                               class="james-btn-secondary font-body">
                                {{ __('messages.Contactar') }}
                            </a>
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>
    @endif --}}

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