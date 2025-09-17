<x-properties-layout>   

    <!-- Properties Grid Section -->
    <section class="james-properties">
        <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12">
            
            <!-- Results Header -->
            <div class="james-results-count font-body">
                @if($showComplexes === 'true')
                    {{ $groupedComplexes ? $groupedComplexes->count() : 0 }} Complejos Residenciales 
                    <span style="color: #6b7280;">({{ $properties->total() }} viviendas disponibles)</span>
                @else
                    @if($operationId == 3)
                        {{ $properties->total() }} Viviendas de Lujo Encontradas
                    @elseif($operationId == 1)
                        {{ $properties->total() }} Propiedades en Venta
                    @elseif($operationId == 2) 
                        {{ $properties->total() }} Propiedades en Alquiler
                    @elseif($operationId == 3 || 'min_price' == 1000000)
                        {{ $properties->total() }} Propiedades de Lujo
                    @elseif($search)
                        {{ $properties->total() }} Resultados para "{{ $search }}"
                    @else
                        {{ $properties->total() }} Propiedades Disponibles
                    @endif
                @endif
            </div>

            @if ($properties->isEmpty())
                <!-- No Results -->
                <div class="james-no-results">
                    <div class="james-no-results-icon">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                            <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                            <polyline points="9,22 9,12 15,12 15,22"/>
                        </svg>
                    </div>
                    <h3 class="james-no-results-title font-luxury">{{ __('messages.no_properties_found') }}</h3>
                    <p class="james-no-results-text font-body">
                        {{ __('messages.try_adjusting_search') }}
                    </p>
                    <a href="{{ route('properties.index', ['locale' => app()->getLocale()]) }}"
                        class="james-btn-outline font-body mt-4">
                        {{ __('messages.view_all_properties') }}
                    </a>
                </div>
            @else

                <!-- Properties Grid -->
                @if($showComplexes === 'true' && $groupedComplexes)
                    <!-- Vista de Complejos Agrupados -->
                    @foreach($groupedComplexes as $complex)
                        <div style="margin-bottom: 2rem; border-bottom: 1px solid #f3f4f6; padding-bottom: 1.5rem;">
                            <h3 style="font-size: 1.5rem; font-weight: 300; color: #1f2937; margin-bottom: 0.5rem;">
                                🏛️ {{ $complex['name'] }} 
                                <span style="font-size: 0.875rem; color: #6b7280;">({{ $complex['count'] }} viviendas)</span>
                            </h3>
                            <p style="font-size: 0.875rem; color: #9ca3af; margin-bottom: 1rem;">{{ $complex['city'] }}</p>
                            
                            <div class="james-properties-index-grid">
                                @foreach($complex['properties'] as $property)
                                    <a href="{{ route('prop.show', ['locale' => app()->getLocale(), 'slug' => $property->slug ?? '']) }}" class="james-property-card block">
                                        
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
                                            
                                            <div style="position: absolute; top: 12px; right: 0px; background: #d4a574; color: white; padding: 4px 8px; font-size: 10px; font-weight: 600; z-index: 10; box-shadow: 0 2px 4px rgba(0,0,0,0.2); transform: skewX(-15deg); white-space: nowrap; max-width: 100px; overflow: hidden;">
                                                <span style="transform: skewX(15deg); display: inline-block;">{{ $property->zona_inmovilla }}</span>
                                            </div>
                                        </div>

                                        <div class="james-property-content">
                                            <div class="james-property-location font-body">
                                                @if($property->address)
                                                    {{ $property->address->city }}, {{ $property->address->province }}
                                                @else
                                                    {{ __('messages.location_available') }}
                                                @endif
                                            </div>
                                            
                                            <h3 class="james-property-title font-luxury">
                                                {{ Str::limit($property->title, 45) }}
                                            </h3>
                                            
                                            <div class="james-property-price font-body">
                                                €{{ number_format($property->price) }}
                                            </div>
                                            
                                            <div class="james-property-specs font-body">
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
                        </div>
                    @endforeach
                @else
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
                                            <img src="{{ $imageSrc }}" alt="{{ $property->title }}">
                                        @else
                                            <img src="{{ asset('assets/images/properties/placeholder.webp') }}" 
                                                alt="{{ $property->title }}">
                                        @endif
                                        
                                        <!-- Property Badges -->
                                        @if ($property->is_featured == 1)
                                            <div class="james-property-badge featured font-body">{{ __('messages.featured') }}</div>
                                        @else
                                            <div class="james-property-badge new font-body">{{ __('messages.new') }}</div>
                                        @endif

                                        {{-- BADGE DE COMPLEJO - ESQUINA SUPERIOR DERECHA --}}
                                        @if($property->keypromo && $property->keypromo != 0)
                                            <div class="james-complex-badge featured font-body">
                                                🏢 {{ $property->zona_inmovilla }}
                                            </div>
                                        @endif
                                        
                                        
                                        <!-- Property Type Badge -->
                                        @if($property->keypromo && $property->keypromo != 0)
                                            <div style="position: absolute; top: 12px; right: 2px; out border: 1px solid #d4a6748e; border-radius: 2px; background: #d4a6748e; color: black; padding: 4px 16px 4px 8px; font-size: 10px; font-weight: 600; z-index: 10; clip-path: polygon(0 0, 100% 0, 85% 50%, 100% 100%, 0 100%); box-shadow: 0 2px 4px rgba(0,0,0,0.2); white-space: nowrap; max-width: 100px; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $property->zona_inmovilla }}
                                            </div>
                                        @endif
                                                                        </div>

                                    <div class="james-property-content">
                                        <div class="james-property-location font-body">
                                            @if($property->address)
                                                {{ $property->address->city }}, {{ $property->address->province }}
                                            @else
                                                {{ __('messages.location_available') }}
                                            @endif
                                        </div>
                                        
                                        <h3 class="james-property-title font-luxury">
                                            {{ Str::limit($property->title, 45) }}
                                        </h3>
                                        
                                        <div class="james-property-price font-body">
                                            €{{ number_format($property->price) }}
                                        </div>
                                        
                                        <div class="james-property-specs font-body">
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
                @endif    

                <!-- Pagination -->
                <div class="james-pagination mt-8">
                    {{ $properties->appends([
                        'operation_id' => $operationId,
                        'type_id' => $typeId,
                        'min_price' => $min_price,
                        'max_price' => $max_price,
                        'search' => $search
                    ])->links('vendor.pagination.james-edition') }}
                </div>
            @endif
        </div>
    </section>

    @include('partials.floating-button')
</x-properties-layout>