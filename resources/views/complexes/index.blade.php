<x-complex-layout>
    <!-- Hero Section -->
    <section class="relative h-96 bg-gradient-to-r from-neutral-900 to-neutral-800 flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent"></div>
        
        <div class="relative z-10 text-center text-white max-w-4xl mx-auto px-4">
            <h1 class="text-4xl md:text-6xl font-light mb-4 font-luxury">
                {{ __('messages.complejos_residenciales') }}
            </h1>
            <p class="text-lg md:text-xl text-neutral-300 font-body">
                {{ __('messages.descubre_exclusivos_complejos') }}
            </p>
        </div>
    </section>

    <!-- Complexes Grid -->
    <section class="py-16 bg-gray-50">
        <div class="w-full px-4 lg:px-6 xl:px-8 2xl:px-12">
            
            <!-- Section Header -->
            <div class="james-section-header">
                <div class="mr-2">
                    <h2 class="james-section-title font-luxury">
                        {{ $complexes->count() }} {{ __('messages.complejos_disponibles') }}
                    </h2>
                </div>
                <div class="ml-2">
                <!-- Buscador -->
                    <form action="{{ route('complexes.index', ['locale' => app()->getLocale()]) }}" method="GET" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Ciudad -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">{{ __('messages.ciudad') }}</label>
                                <select name="city" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                    <option value="">{{ __('messages.todas_ciudades') }}</option>
                                    @foreach($cities as $cityOption)
                                        <option value="{{ $cityOption }}" {{ $city == $cityOption ? 'selected' : '' }}>
                                            {{ $cityOption }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Precio mínimo -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">{{ __('messages.precio_minimo') }}</label>
                                <select name="min_price" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                    <option value="">{{ __('messages.sin_minimo') }}</option>
                                    <option value="200000">€200.000</option>
                                    <option value="500000">€500.000</option>
                                    <option value="1000000">€1.000.000</option>
                                    <option value="2000000">€2.000.000</option>
                                </select>
                            </div>

                            <!-- Precio máximo -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">{{ __('messages.precio_maximo') }}</label>
                                <select name="max_price" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                    <option value="">{{ __('messages.sin_maximo') }}</option>
                                    <option value="500000">€500.000</option>
                                    <option value="1000000">€1.000.000</option>
                                    <option value="2000000">€2.000.000</option>
                                    <option value="5000000">€5.000.000</option>
                                </select>
                            </div>

                            <!-- Botón -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-transparent">{{ __('messages.buscar') }}</label>
                                <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-md font-medium transition-colors duration-200">
                                    {{ __('messages.buscar_complejos') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if($complexes->count() > 0)
                <!-- Complexes Grid -->
                <div class="james-properties-index-grid">
                    @foreach ($complexes as $complex)
                        <a href="{{ route('complexes.show', ['locale' => app()->getLocale(), 'keypromo' => $complex['keypromo']]) }}" class="james-property-card block">
                            
                            <div class="james-property-image">
                                @if($complex['featured_image'])
                                    @php
                                        $image = $complex['featured_image'];
                                        $imageSrc = str_starts_with($image->image_path, 'http') 
                                            ? $image->image_path 
                                            : '/storage/' . $image->image_path;
                                    @endphp
                                    <img src="{{ $imageSrc }}" 
                                         alt="{{ $complex['name'] }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-400 text-sm">Sin imagen</span>
                                    </div>
                                @endif
                                
                                <!-- Complex Badge -->
                                <div class="james-property-badge complex absolute top-4 right-4 bg-gold-600 text-white px-3 py-1 text-xs font-medium rounded">
                                    {{ $complex['count'] }} {{ __('messages.propiedades') }}
                                </div>
                            </div>
                            
                            <div class="james-property-content">
                                <h3 class="james-property-title">{{ $complex['name'] }}</h3>
                                
                                <div class="james-property-location mb-3">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $complex['city'] }}
                                </div>
                                
                                <div class="james-property-price mb-3">
                                    {{ __('messages.desde') }} €{{ number_format($complex['min_price'], 0, ',', '.') }}
                                    @if($complex['min_price'] != $complex['max_price'])
                                        - €{{ number_format($complex['max_price'], 0, ',', '.') }}
                                    @endif
                                </div>
                                
                                <div class="james-property-specs">
                                    {{ $complex['count'] }} {{ __('messages.propiedades_disponibles') }}
                                </div>
                            </div>
                            
                        </a>
                    @endforeach
                </div>
            @else
                <!-- No complexes found -->
                <div class="text-center py-16">
                    <div class="max-w-md mx-auto">
                        <div class="mb-8">
                            <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-medium text-gray-900 mb-2">{{ __('messages.no_complejos_encontrados') }}</h3>
                        <p class="text-gray-600 mb-6">{{ __('messages.no_hay_complejos_disponibles') }}</p>
                        <a href="{{ route('properties.index', ['locale' => app()->getLocale()]) }}" 
                           class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gold-600 hover:bg-gold-700 transition-colors">
                            {{ __('messages.ver_todas_propiedades') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>

    @include('partials.floating-button')
</x-complex-layout>