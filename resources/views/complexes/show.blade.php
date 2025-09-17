<x-complex-layout>
    <!-- Hero Section -->
    <section class="relative h-96 bg-gradient-to-r from-neutral-900 to-neutral-800 flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent"></div>
        
        <div class="relative z-10 text-center text-white max-w-4xl mx-auto px-4">
            <nav class="mb-4">
                <ol class="flex items-center justify-center space-x-2 text-sm">
                    <li><a href="{{ route('complexes.index', ['locale' => app()->getLocale()]) }}" class="text-neutral-300 hover:text-white">{{ __('messages.complejos') }}</a></li>
                    <li class="text-neutral-400">/</li>
                    <li class="text-white">{{ $complex['name'] }}</li>
                </ol>
            </nav>
            
            <h1 class="text-4xl md:text-6xl font-light mb-4 font-luxury">
                {{ $complex['name'] }}
            </h1>
            <p class="text-lg md:text-xl text-neutral-300 font-body">
                {{ $complex['city'] }} • {{ $complex['count'] }} {{ __('messages.propiedades_disponibles') }}
            </p>
        </div>
    </section>

    <!-- Properties Grid -->
    <section class="py-16 bg-gray-50">
        <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12">
            
            <!-- Section Header -->
            <div class="james-section-header">
                <h2 class="james-section-title font-luxury">
                    {{ $properties->total() }} {{ __('messages.propiedades_en_complejo') }}
                </h2>
                <a href="{{ route('complexes.index', ['locale' => app()->getLocale()]) }}"
                   class="james-view-all font-body ml-6">{{ __('messages.ver_todos_complejos') }}</a>
            </div>

            @if($properties->count() > 0)
                <!-- Properties Grid -->
                <div class="james-properties-index-grid">
                    @foreach ($properties as $property)
                        <a href="{{ route('prop.show', ['locale' => app()->getLocale(), 'slug' => $property->slug ?? '']) }}" class="james-property-card block">
                            
                            <div class="james-property-image">
                                @if($property->images && $property->images->first())
                                    @php
                                        $image = $property->images->first();
                                        $imageSrc = str_starts_with($image->image_path, 'http') 
                                            ? $image->image_path 
                                            : '/storage/' . $image->image_path;
                                    @endphp
                                    <img src="{{ $imageSrc }}" 
                                         alt="{{ $property->title }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-400 text-sm">Sin imagen</span>
                                    </div>
                                @endif
                                
                                <!-- Property Type Badge -->
                                @if($property->propertyType)
                                    <div class="james-property-badge absolute top-4 right-24 bg-neutral-800 text-white px-3 py-1 text-xs font-medium rounded">
                                        {{ $property->propertyType->name }}
                                    </div>
                                @endif
                            </div>
                            
                            <div class="james-property-content">
                                <h3 class="james-property-title">{{ $property->title }}</h3>
                                
                                <div class="james-property-price mb-3">
                                    @if($property->operation && $property->operation->name == 'Alquiler')
                                        €{{ number_format($property->precioalq ?? 0, 0, ',', '.') }}/{{ __('messages.mes') }}
                                    @else
                                        €{{ number_format($property->precioinmo ?? 0, 0, ',', '.') }}
                                    @endif
                                </div>
                                
                                <div class="james-property-specs">
                                    @if($property->built_area)
                                        {{ $property->built_area }}m²
                                        @if($property->rooms || $property->bathrooms) • @endif
                                    @endif
                                    @if($property->rooms)
                                        {{ $property->rooms }} hab
                                        @if($property->bathrooms) • @endif
                                    @endif
                                    @if($property->bathrooms)
                                        {{ $property->bathrooms }} baños
                                    @endif
                                </div>
                            </div>
                            
                        </a>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="james-pagination mt-8">
                    {{ $properties->links('vendor.pagination.james-edition') }}
                </div>
            @else
                <!-- No properties found -->
                <div class="text-center py-16">
                    <div class="max-w-md mx-auto">
                        <div class="mb-8">
                            <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-medium text-gray-900 mb-2">{{ __('messages.no_properties_found') }}</h3>
                        <p class="text-gray-600 mb-6">{{ __('messages.no_propiedades_complejo') }}</p>
                        <a href="{{ route('complexes.index', ['locale' => app()->getLocale()]) }}" 
                           class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gold-600 hover:bg-gold-700 transition-colors">
                            {{ __('messages.ver_otros_complejos') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>

    @include('partials.floating-button')
</x-complex-layout>