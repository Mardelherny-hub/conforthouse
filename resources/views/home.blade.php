<x-public-layout>
   

    <!-- Category Navigation -->
    <section class="james-categories">
        <div class="max-w-7xl mx-auto">
            <div class="james-categories-grid">
                
                <!-- Real Estate -->
                <div class="james-category-item active">
                    <a href="{{ route('properties.index', ['locale' => app()->getLocale()]) }}" 
                       class="james-category-link">
                        <span class="james-category-name font-body">{{ __('messages.propiedades') }}</span>
                        <span class="james-category-count font-body">152 listings</span>
                    </a>
                </div>
                
                <!-- Homes -->
                <div class="james-category-item">
                    <a href="{{ route('properties.index', ['locale' => app()->getLocale(), 'type_id' => 1]) }}" 
                       class="james-category-link">
                        <span class="james-category-name font-body">{{ __('messages.Residencias') }}</span>
                        <span class="james-category-count font-body">87 listings</span>
                    </a>
                </div>
                
                <!-- Apartments -->
                <div class="james-category-item">
                    <a href="{{ route('properties.index', ['locale' => app()->getLocale(), 'type_id' => 2]) }}" 
                       class="james-category-link">
                        <span class="james-category-name font-body">{{ __('messages.Apartamentos') }}</span>
                        <span class="james-category-count font-body">234 listings</span>
                    </a>
                </div>
                
                <!-- Villas -->
                <div class="james-category-item">
                    <a href="{{ route('properties.index', ['locale' => app()->getLocale(), 'type_id' => 3]) }}" 
                       class="james-category-link">
                        <span class="james-category-name font-body">{{ __('messages.Villas') }}</span>
                        <span class="james-category-count font-body">65 listings</span>
                    </a>
                </div>
                
                <!-- Services -->
                <div class="james-category-item">
                    <a href="#servicios" class="james-category-link">
                        <span class="james-category-name font-body">{{ __('messages.servicios') }}</span>
                    </a>
                </div>
                
            </div>
        </div>
    </section>

    <!-- Featured Property -->
    @if ($featuredProperty)
        <section class="james-featured">
            <div class="max-w-7xl mx-auto px-6">
                <div class="james-featured-container">
                    
                    <!-- Property Image -->
                    <div class="james-featured-image">
                        @if(!$featuredProperty->images && $featuredProperty->images->first())
                            <img src="/storage/{{ $featuredProperty->images->first()->image_path }}"
                                 alt="{{ $featuredProperty->title }}"
                                 class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('assets/images/home/trend-2.png') }}"
                                 alt="{{ $featuredProperty->title }}"
                                 class="w-full h-full object-cover">
                        @endif
                        
                        <div class="james-featured-badge font-body">Featured</div>
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
    @endif

    <!-- Properties Grid -->
    <section class="james-properties">
        <div class="max-w-7xl mx-auto px-6">
            
            <div class="james-section-header">
                <h2 class="james-section-title font-luxury">Recent Listings</h2>
                <a href="{{ route('properties.index', ['locale' => app()->getLocale()]) }}"
                   class="james-view-all font-body">View All Properties</a>
            </div>
            
            <div class="james-properties-grid">
                @forelse ($properties as $property)
                    <div class="james-property-card">
                        <div class="james-property-image">
                            @if(!$property->images && $property->images->first())
                                <img src="/storage/{{ $property->images->first()->image_path }}" 
                                     alt="{{ $property->title }}">
                            @else
                                <img src="{{ asset('assets/images/home/trend-1.jpg') }}" 
                                     alt="{{ $property->title }}">
                            @endif
                            
                            @if ($property->is_featured == 1)
                                <div class="james-property-badge featured font-body">Featured</div>
                            @else
                                <div class="james-property-badge new font-body">New</div>
                            @endif
                        </div>

                        <div class="james-property-content">
                            <div class="james-property-location font-body">
                                {{ $property->address->city ?? '' }}, {{ $property->address->province ?? '' }}
                            </div>
                            
                            <h3 class="james-property-title font-luxury">{{ $property->title }}</h3>
                            
                            <div class="james-property-specs font-body">
                                <span class="james-spec">{{ $property->built_area }}m²</span>
                                <span class="james-spec-separator">•</span>
                                <span class="james-spec">{{ $property->rooms }} bed</span>
                                <span class="james-spec-separator">•</span>
                                <span class="james-spec">{{ $property->bathrooms }} bath</span>
                            </div>
                            
                            <div class="james-property-price font-body">€{{ number_format($property->price) }}</div>
                            
                            <a href="{{ route('prop.show', ['locale' => app()->getLocale(), 'slug' => $property->slug ?? '']) }}"
                               class="james-property-link font-body">
                                View Details
                            </a>
                        </div>
                    </div>
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
        <div class="max-w-7xl mx-auto px-6">
            <div class="james-services-container">
                
                <div class="james-services-content">
                    <h2 class="james-services-title font-luxury">Premium Services</h2>
                    <p class="james-services-description font-body">
                        Professional real estate services tailored to luxury properties. 
                        Our expert team provides comprehensive solutions for buyers, sellers, and investors.
                    </p>
                    
                    <div class="james-services-list">
                        <div class="james-service-item">
                            <h4 class="james-service-title font-body">Property Valuation</h4>
                            <p class="james-service-description font-body">Expert market analysis and accurate property valuation</p>
                        </div>
                        
                        <div class="james-service-item">
                            <h4 class="james-service-title font-body">Investment Consulting</h4>
                            <p class="james-service-description font-body">Strategic advice for luxury real estate investments</p>
                        </div>
                        
                        <div class="james-service-item">
                            <h4 class="james-service-title font-body">Property Management</h4>
                            <p class="james-service-description font-body">Complete property management for luxury estates</p>
                        </div>
                    </div>
                    
                    <a href="#contacto" class="james-btn-outline font-body">Learn More</a>
                </div>
                
                <div class="james-services-image">
                    <img src="{{ asset('assets/images/home/servicios-exclusivos.png') }}" 
                         alt="Premium Services" 
                         class="w-full h-full object-cover rounded-lg">
                </div>
                
            </div>
        </div>
    </section>

    <!-- Contact CTA -->
    <section class="james-cta" id="contacto">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="james-cta-title font-luxury">Ready to Find Your Dream Property?</h2>
            <p class="james-cta-description font-body">
                Connect with our luxury real estate experts and discover exclusive opportunities 
                in the world's most desirable locations.
            </p>
            
            <div class="james-cta-actions">
                <a href="{{ route('properties.index', ['locale' => app()->getLocale()]) }}"
                   class="james-btn-primary font-body">
                    Browse Properties
                </a>
                
                <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" 
                   class="james-btn-outline font-body">
                    Contact Us
                </a>
            </div>
        </div>
    </section>

    @include('partials.floating-button')
</x-public-layout>