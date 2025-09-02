<x-properties-layout>
    <!-- Search Filters Section -->
    <section class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="james-section-title font-luxury text-center mb-4">
                    {{ __('messages.exclusive_properties') }}
                </h1>
                <p class="text-center text-gray-600 font-body max-w-2xl mx-auto">
                    Discover exceptional properties in the world's most desirable locations
                </p>
            </div>

            <!-- Advanced Filters -->
            <form action="{{ route('properties.index', ['locale' => app()->getLocale()]) }}" method="GET"
                class="james-search-form">
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                    <!-- Property Type -->
                    <div class="james-filter-group">
                        <label class="james-filter-label font-body">Property Type</label>
                        <select id="type_id" name="type_id" class="james-filter-select font-body">
                            <option value="">All Types</option>
                            @foreach ($propertyTypes as $type)
                                <option value="{{ $type->id }}" {{ $typeId == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Operation -->
                    <div class="james-filter-group">
                        <label class="james-filter-label font-body">Operation</label>
                        <select id="operation_id" name="operation_id" class="james-filter-select font-body">
                            <option value="">All Operations</option>
                            @foreach ($operations as $operation)
                                <option value="{{ $operation->id }}" {{ $operationId == $operation->id ? 'selected' : '' }}>
                                    {{ $operation->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Min Price -->
                    <div class="james-filter-group">
                        <label class="james-filter-label font-body">Min Price</label>
                        <input type="number" id="min_price" name="min_price" value="{{ $min_price }}"
                            placeholder="€0"
                            class="james-filter-input font-body">
                    </div>

                    <!-- Max Price -->
                    <div class="james-filter-group">
                        <label class="james-filter-label font-body">Max Price</label>
                        <input type="number" id="max_price" name="max_price" value="{{ $max_price }}"
                            placeholder="€∞"
                            class="james-filter-input font-body">
                    </div>

                    <!-- Search Button -->
                    <div class="james-filter-group flex items-end">
                        <button type="submit" class="james-btn-primary w-full font-body">
                            Search Properties
                        </button>
                    </div>
                </div>

                <!-- Clear Filters -->
                @if ($min_price || $max_price || $operationId || $typeId || $search)
                    <div class="flex justify-center">
                        <a href="{{ route('properties.index', ['locale' => app()->getLocale()]) }}"
                            class="james-btn-outline font-body">
                            Clear All Filters
                        </a>
                    </div>
                @endif
            </form>

            <!-- Active Filters Display -->
            @if ($min_price || $max_price || $operationId || $typeId || $search)
                <div class="james-active-filters">
                    <span class="james-active-filters-label font-body">Active Filters:</span>
                    <div class="james-active-filters-list">
                        @if ($search)
                            <span class="james-filter-tag font-body">
                                Search: {{ $search }}
                            </span>
                        @endif
                        @if ($min_price || $max_price)
                            <span class="james-filter-tag font-body">
                                Price: 
                                @if ($min_price)€{{ number_format($min_price) }}@endif
                                @if ($min_price && $max_price) - @endif
                                @if ($max_price)€{{ number_format($max_price) }}@endif
                            </span>
                        @endif
                        @if ($operationId)
                            <span class="james-filter-tag font-body">
                                {{ $operations->where('id', $operationId)->first()->name ?? '' }}
                            </span>
                        @endif
                        @if ($typeId)
                            <span class="james-filter-tag font-body">
                                {{ $propertyTypes->where('id', $typeId)->first()->name ?? '' }}
                            </span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Properties Grid Section -->
    <section class="james-properties">
        <div class="max-w-7xl mx-auto px-6">
            
            <!-- Results Header -->
            <div class="james-results-header">
                <div class="james-results-count font-body">
                    {{ $properties->total() }} Properties Found
                </div>
                
                <!-- Sort Options (future implementation) -->
                <div class="james-sort-options">
                    <select class="james-sort-select font-body">
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Newest First</option>
                        <option>Size: Large to Small</option>
                    </select>
                </div>
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
                    <h3 class="james-no-results-title font-luxury">No Properties Found</h3>
                    <p class="james-no-results-text font-body">
                        Try adjusting your search criteria or browse all available properties
                    </p>
                    <a href="{{ route('properties.index', ['locale' => app()->getLocale()]) }}"
                        class="james-btn-outline font-body mt-4">
                        View All Properties
                    </a>
                </div>
            @else
                <!-- Properties Grid -->
                <div class="james-properties-grid">
                    @foreach ($properties as $property)
                        <div class="james-property-card">
                            <div class="james-property-image">
                                @if(!$property->images && $property->images->first())
                                    <img src="/storage/{{ $property->images->first()->image_path }}" 
                                         alt="{{ $property->title }}">
                                @else
                                    <img src="{{ asset('assets/images/properties/placeholder.webp') }}" 
                                         alt="{{ $property->title }}">
                                @endif
                                
                                <!-- Property Badges -->
                                @if ($property->is_featured == 1)
                                    <div class="james-property-badge featured font-body">Featured</div>
                                @endif
                                
                                <!-- Property Type Badge -->
                                <div class="absolute top-4 right-4 bg-black/70 text-white px-2 py-1 text-xs font-body rounded">
                                    {{ $property->operation->name }}
                                </div>
                            </div>

                            <div class="james-property-content">
                                <div class="james-property-location font-body">
                                    @if($property->address)
                                        {{ $property->address->city }}, {{ $property->address->province }}
                                    @else
                                        Location Available
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
                                        <span>{{ $property->rooms }} bed</span>
                                        <span class="james-spec-separator">•</span>
                                    @endif
                                    @if($property->bathrooms)
                                        <span>{{ $property->bathrooms }} bath</span>
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
                                    View Details
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