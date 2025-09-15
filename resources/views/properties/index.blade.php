<x-properties-layout>
   

    <!-- Properties Grid Section -->
    <section class="james-properties">
        <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12">
            
            <!-- Results Header -->
            <div class="james-results-header">
                <div class="james-results-count font-body">
                    {{ $properties->total() }} {{ __('messages.properties_found') }}
                </div>
                
                <!-- Sort Options (future implementation) -->
                {{-- <div class="james-sort-options">
                    <select class="james-sort-select font-body">
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Newest First</option>
                        <option>Size: Large to Small</option>
                    </select>
                </div> --}}
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
                <div class="james-properties-grid">
                    @foreach ($properties as $property)
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
                                
                                <!-- Property Badges -->
                                @if ($property->is_featured == 1)
                                    <div class="james-property-badge featured font-body">{{ __('messages.featured') }}</div>
                                @endif
                                
                                <!-- Property Type Badge -->
                                {{-- <div class="absolute top-4 right-4 bg-black/70 text-white px-2 py-1 text-xs font-body rounded">
                                    {{ $property->operation->name }}
                                </div> --}}
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
                                    {{ $property->title }}
                                </h3>
                                
                                <div class="james-property-specs font-body">
                                    @if($property->built_area)
                                        <span>{{ $property->built_area }}m²</span>
                                        <span class="james-spec-separator">•</span>
                                    @endif
                                    @if($property->rooms)
                                        <span>{{ $property->rooms }} {{ __('messages.bed') }}</span>
                                        <span class="james-spec-separator">•</span>
                                    @endif
                                    @if($property->bathrooms)
                                        <span>{{ $property->bathrooms }} {{ __('messages.bath') }}</span>
                                    @endif
                                </div>
                                
                                <!-- Property Type -->
                                <div class="mb-3">
                                    <span class="inline-block bg-gray-100 text-gray-700 px-2 py-1 text-xs font-body rounded">
                                        {{ $property->propertyType->name }}
                                    </span>
                                </div>
                                
                                <div class="james-property-price font-body">
                                    €{{ number_format($property->price) }}
                                </div>
                                
                                <a href="{{ route('prop.show', ['locale' => app()->getLocale(), 'slug' => $property->slug ?? '']) }}"
                                   class="james-property-link font-body">
                                    {{ __('messages.view_details') }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="james-pagination">
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