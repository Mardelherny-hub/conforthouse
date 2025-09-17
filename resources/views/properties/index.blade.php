<x-properties-layout>   

    <!-- Properties Grid Section -->
    <section class="james-properties">
        <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12">
            
            <!-- Results Header Mejorada -->
            <div class="james-results-count font-body mb-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <!-- Contador principal -->
                    <div class="mb-4 lg:mb-0">
                        @if($showComplexes === 'true')
                            <span class="text-2xl font-semibold text-gray-900">{{ $groupedComplexes ? $groupedComplexes->count() : 0 }}</span>
                            <span class="text-lg text-gray-700">{{ __('messages.residential_complexes') }}</span>
                            <span class="text-sm text-gray-500">({{ $properties->total() }} {{ __('messages.available_homes') }})</span>
                        @else
                            <span class="text-2xl font-semibold text-gray-900">{{ $properties->total() }}</span>
                            <span class="text-lg text-gray-700">{{ __('messages.properties_available') }}</span>
                        @endif
                    </div>

                    <!-- Filtros aplicados -->
                    @if($operationId || $typeId || $min_price || $max_price || $bedrooms || $bathrooms || $keyvista || $min_area || !empty($features) || $search)
                        <div class="text-sm text-gray-600">
                            <span class="font-medium">{{ __('messages.search_filters_applied') }}:</span>
                            <div class="flex flex-wrap gap-2 mt-2">
                                
                                <!-- Operación -->
                                @if($operationId)
                                    @php $operation = $operations->find($operationId) @endphp
                                    @if($operation)
                                        <span class="bg-amber-100 text-amber-800 px-3 py-1 rounded-full text-xs font-medium">
                                            {{ $operation->name }}
                                        </span>
                                    @endif
                                @endif

                                <!-- Tipo de propiedad -->
                                @if($typeId)
                                    @php $propertyType = $propertyTypes->find($typeId) @endphp
                                    @if($propertyType)
                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-medium">
                                            {{ $propertyType->name }}
                                        </span>
                                    @endif
                                @endif

                                <!-- Precio mínimo -->
                                @if($min_price)
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium">
                                        {{ __('messages.from') }} €{{ number_format($min_price) }}
                                    </span>
                                @endif

                                <!-- Precio máximo -->
                                @if($max_price)
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium">
                                        {{ __('messages.up_to') }} €{{ number_format($max_price) }}
                                    </span>
                                @endif

                                <!-- Habitaciones -->
                                @if($bedrooms)
                                    <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-medium">
                                        {{ $bedrooms }}+ {{ __('messages.bedrooms') }}
                                    </span>
                                @endif

                                <!-- Baños -->
                                @if($bathrooms)
                                    <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-medium">
                                        {{ $bathrooms }}+ {{ __('messages.bathrooms') }}
                                    </span>
                                @endif

                                <!-- Vista -->
                                @if($keyvista)
                                    <span class="bg-cyan-100 text-cyan-800 px-3 py-1 rounded-full text-xs font-medium">
                                        @switch($keyvista)
                                            @case('sea')
                                                {{ __('messages.sea_view') }}
                                                @break
                                            @case('mountain')
                                                {{ __('messages.mountain_view') }}
                                                @break
                                            @case('golf')
                                                {{ __('messages.golf_view') }}
                                                @break
                                            @case('city')
                                                {{ __('messages.city_view') }}
                                                @break
                                            @case('pool')
                                                {{ __('messages.pool_view') }}
                                                @break
                                            @default
                                                {{ ucfirst($keyvista) }}
                                        @endswitch
                                    </span>
                                @endif

                                <!-- Área mínima -->
                                @if($min_area)
                                    <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-xs font-medium">
                                        {{ $min_area }}+ m²
                                    </span>
                                @endif

                                <!-- Características -->
                                @if(!empty($features))
                                    @foreach($features as $feature)
                                        <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-xs font-medium">
                                            @switch($feature)
                                                @case('piscina')
                                                    {{ __('messages.pool') }}
                                                    @break
                                                @case('terraza')
                                                    {{ __('messages.terrace') }}
                                                    @break
                                                @case('jardin')
                                                    {{ __('messages.garden') }}
                                                    @break
                                                @case('balcon')
                                                    {{ __('messages.balcony') }}
                                                    @break
                                                @case('parking')
                                                    {{ __('messages.parking') }}
                                                    @break
                                                @case('aire_acondicionado')
                                                    {{ __('messages.air_conditioning') }}
                                                    @break
                                                @default
                                                    {{ ucfirst(str_replace('_', ' ', $feature)) }}
                                            @endswitch
                                        </span>
                                    @endforeach
                                @endif

                                <!-- Búsqueda de texto -->
                                @if($search)
                                    <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs font-medium">
                                        "{{ $search }}"
                                    </span>
                                @endif

                                <!-- Botón limpiar filtros -->
                                <a href="{{ route('properties.index', ['locale' => app()->getLocale()]) }}"
                                    class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-medium hover:bg-red-200 transition-colors">
                                    {{ __('messages.clear_filters') }} ×
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Mensaje contextual -->
                @if($search)
                    <div class="mt-3 p-3 bg-amber-50 border-l-4 border-amber-400 text-sm">
                        <span class="font-medium text-amber-800">{{ __('messages.search_results_for') }}</span>
                        <span class="text-amber-700">"{{ $search }}"</span>
                    </div>
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
                                        <div style="position: absolute; top: 1rem;  out border: 1px solid #d4a674ff; border-radius: 2px; background: #d4a6748e; color: black; padding: 0.5rem; font-size: 0.75rem; font-weight: 600; z-index: 10; clip-path: polygon(0 0, 100% 0, 85% 50%, 100% 100%, 0 100%); box-shadow: 0 2px 4px rgba(0,0,0,0.2); white-space: nowrap; min-width: 10rem; overflow: hidden; text-overflow: ellipsis;">
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