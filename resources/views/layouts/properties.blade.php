<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Confort House') }}</title>

    <link rel="alternate" hreflang="es" href="https://localhost:8000/es/" />
    <link rel="alternate" hreflang="en" href="https://localhost:8000/en/" />
    <link rel="alternate" hreflang="fr" href="https://localhost:8000/fr/" />
    <link rel="alternate" hreflang="de" href="https://localhost:8000/de/" />

    <!--    Favicons
    =============================================
    -->
    <link rel="icon" type="image/png"sizes="57x57" href="assets/images/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/images/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicons/favicon.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/images/favicons/favicon.png">
    <meta name="theme-color" content="#ffffff">


    <!-- Importación de fuentes y estilos base de lujo -->
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=Montserrat:wght@300;400&display=swap'"
        rel="stylesheet">


    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans text-gray-900 antialiased bg-white">
    <!-- Header Navigation -->
    <header class="relative w-full h-[200px] sm:h-[200px] lg:h-[300px] bg-white border-b border-gray-100">      

        <!-- Estructura principal del header con solo navegación -->
        <div class="relative w-full h-full flex items-center z-40">
        <div class="relative w-full h-full flex items-center z-50">
            <!-- Solo navegación -->
            <div class="w-full">
                <x-navigation />
            </div>
        </div>

        {{-- imagen de fondo hero --}}
        <div class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('{{ asset('assets/images/properties/hero.webp') }}');">
        </div>
        
        <!-- Overlay mínimo para legibilidad -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent"></div>
    
        
        
    </header>
</header>


    <!-- Buscador Avanzado Properties -->
    <section class="bg-white py-6" x-data="{ showAdvanced: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('properties.index', ['locale' => app()->getLocale()]) }}" method="GET">
                
                <!-- Búsqueda Básica -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4">
                        <!-- Tipo de Propiedad -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">{{ __('messages.tipo_propiedad') }}</label>
                            <select name="type_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                <option value="">{{ __('messages.todos_tipos') }}</option>
                                @foreach($propertyTypes as $type)
                                    <option value="{{ $type->id }}" {{ $typeId == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Operación -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">{{ __('messages.operacion') }}</label>
                            <select name="operation_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                <option value="">{{ __('messages.todas_operaciones') }}</option>
                                @foreach($operations as $operation)
                                    <option value="{{ $operation->id }}" {{ $operationId == $operation->id ? 'selected' : '' }}>
                                        {{ $operation->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Precio Mínimo -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">{{ __('messages.precio_minimo') }}</label>
                            <select name="min_price" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                <option value="">{{ __('messages.sin_minimo') }}</option>
                                <option value="100000" {{ $min_price == '100000' ? 'selected' : '' }}>€100.000</option>
                                <option value="200000" {{ $min_price == '200000' ? 'selected' : '' }}>€200.000</option>
                                <option value="300000" {{ $min_price == '300000' ? 'selected' : '' }}>€300.000</option>
                                <option value="500000" {{ $min_price == '500000' ? 'selected' : '' }}>€500.000</option>
                                <option value="750000" {{ $min_price == '750000' ? 'selected' : '' }}>€750.000</option>
                                <option value="1000000" {{ $min_price == '1000000' ? 'selected' : '' }}>€1.000.000</option>
                                <option value="2000000" {{ $min_price == '2000000' ? 'selected' : '' }}>€2.000.000</option>
                            </select>
                        </div>

                        <!-- Precio Máximo -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">{{ __('messages.precio_maximo') }}</label>
                            <select name="max_price" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                <option value="">{{ __('messages.sin_maximo') }}</option>
                                <option value="300000" {{ $max_price == '300000' ? 'selected' : '' }}>€300.000</option>
                                <option value="500000" {{ $max_price == '500000' ? 'selected' : '' }}>€500.000</option>
                                <option value="750000" {{ $max_price == '750000' ? 'selected' : '' }}>€750.000</option>
                                <option value="1000000" {{ $max_price == '1000000' ? 'selected' : '' }}>€1.000.000</option>
                                <option value="1500000" {{ $max_price == '1500000' ? 'selected' : '' }}>€1.500.000</option>
                                <option value="2000000" {{ $max_price == '2000000' ? 'selected' : '' }}>€2.000.000</option>
                                <option value="3000000" {{ $max_price == '3000000' ? 'selected' : '' }}>€3.000.000</option>
                                <option value="5000000" {{ $max_price == '5000000' ? 'selected' : '' }}>€5.000.000</option>
                            </select>
                        </div>

                       <!-- Botones -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-transparent">{{ __('messages.buscar') }}</label>
                            <div class="flex gap-2">
                                <button type="submit" class="flex-1 bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-md font-medium transition-colors duration-200">
                                    {{ __('messages.buscar') }}
                                </button>
                                <button type="button" @click="showAdvanced = !showAdvanced"
                                        class="px-3 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors duration-200 flex items-center gap-1">
                                    <span class="text-xs font-medium hidden sm:inline" x-text="showAdvanced ? '{{ __('messages.basicos') }}' : '{{ __('messages.avanzados') }}'">
                                        {{ __('messages.avanzados') }}
                                    </span>
                                    <svg class="w-4 h-4 transform transition-transform duration-200" :class="{ 'rotate-180': showAdvanced }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Búsqueda Avanzada -->
                    <div x-show="showAdvanced" 
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 transform translate-y-0"
                        x-transition:leave-end="opacity-0 transform -translate-y-2"
                        class="border-t border-gray-200 pt-6">
                        
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('messages.busqueda_avanzada') }}</h3>
                        
                        <!-- Campos principales del filtrado avanzado -->
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                            <!-- Habitaciones -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">{{ __('messages.habitaciones') }}</label>
                                <select name="bedrooms" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                    <option value="">{{ __('messages.cualquier_cantidad') }}</option>
                                    <option value="1" {{ request('bedrooms') == '1' ? 'selected' : '' }}>1+</option>
                                    <option value="2" {{ request('bedrooms') == '2' ? 'selected' : '' }}>2+</option>
                                    <option value="3" {{ request('bedrooms') == '3' ? 'selected' : '' }}>3+</option>
                                    <option value="4" {{ request('bedrooms') == '4' ? 'selected' : '' }}>4+</option>
                                    <option value="5" {{ request('bedrooms') == '5' ? 'selected' : '' }}>5+</option>
                                </select>
                            </div>

                            <!-- Baños -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">{{ __('messages.banos') }}</label>
                                <select name="bathrooms" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                    <option value="">{{ __('messages.cualquier_cantidad') }}</option>
                                    <option value="1" {{ request('bathrooms') == '1' ? 'selected' : '' }}>1+</option>
                                    <option value="2" {{ request('bathrooms') == '2' ? 'selected' : '' }}>2+</option>
                                    <option value="3" {{ request('bathrooms') == '3' ? 'selected' : '' }}>3+</option>
                                    <option value="4" {{ request('bathrooms') == '4' ? 'selected' : '' }}>4+</option>
                                </select>
                            </div>

                            <!-- Vista (keyvista) -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">{{ __('messages.tipo_vista') }}</label>
                                <select name="keyvista" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                    <option value="">{{ __('messages.cualquier_vista') }}</option>
                                    <option value="sea" {{ request('keyvista') == 'sea' ? 'selected' : '' }}>{{ __('messages.vista_mar') }}</option>
                                    <option value="mountain" {{ request('keyvista') == 'mountain' ? 'selected' : '' }}>{{ __('messages.vista_montaña') }}</option>
                                    <option value="golf" {{ request('keyvista') == 'golf' ? 'selected' : '' }}>{{ __('messages.vista_golf') }}</option>
                                    <option value="city" {{ request('keyvista') == 'city' ? 'selected' : '' }}>{{ __('messages.vista_ciudad') }}</option>
                                    <option value="pool" {{ request('keyvista') == 'pool' ? 'selected' : '' }}>{{ __('messages.vista_piscina') }}</option>
                                </select>
                            </div>

                            <!-- Área Construida -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">{{ __('messages.area_minima') }}</label>
                                <select name="min_area" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                    <option value="">{{ __('messages.cualquier_area') }}</option>
                                    <option value="50" {{ request('min_area') == '50' ? 'selected' : '' }}>50+ m²</option>
                                    <option value="100" {{ request('min_area') == '100' ? 'selected' : '' }}>100+ m²</option>
                                    <option value="150" {{ request('min_area') == '150' ? 'selected' : '' }}>150+ m²</option>
                                    <option value="200" {{ request('min_area') == '200' ? 'selected' : '' }}>200+ m²</option>
                                    <option value="300" {{ request('min_area') == '300' ? 'selected' : '' }}>300+ m²</option>
                                    <option value="500" {{ request('min_area') == '500' ? 'selected' : '' }}>500+ m²</option>
                                </select>
                            </div>

                            <!-- Búsqueda de texto -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">{{ __('messages.busqueda_texto') }}</label>
                                <input type="text" name="search" value="{{ $search ?? '' }}" 
                                    placeholder="{{ __('messages.search_property_placeholder') }}" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            </div>
                        </div>

                        <!-- Características Exteriores - Lo que pidió el cliente -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">{{ __('messages.caracteristicas_exteriores') }}</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                                <!-- Piscina -->
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" name="features[]" value="piscina" 
                                        {{ in_array('piscina', request('features', [])) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-amber-500 focus:ring-amber-500">
                                    <span class="text-sm text-gray-700">{{ __('messages.piscina') }}</span>
                                </label>

                                <!-- Terraza -->
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" name="features[]" value="terraza" 
                                        {{ in_array('terraza', request('features', [])) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-amber-500 focus:ring-amber-500">
                                    <span class="text-sm text-gray-700">{{ __('messages.terraza') }}</span>
                                </label>

                                <!-- Jardín -->
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" name="features[]" value="jardin" 
                                        {{ in_array('jardin', request('features', [])) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-amber-500 focus:ring-amber-500">
                                    <span class="text-sm text-gray-700">{{ __('messages.jardin') }}</span>
                                </label>

                                <!-- Balcón -->
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" name="features[]" value="balcon" 
                                        {{ in_array('balcon', request('features', [])) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-amber-500 focus:ring-amber-500">
                                    <span class="text-sm text-gray-700">{{ __('messages.balcon') }}</span>
                                </label>

                                <!-- Parking -->
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" name="features[]" value="parking" 
                                        {{ in_array('parking', request('features', [])) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-amber-500 focus:ring-amber-500">
                                    <span class="text-sm text-gray-700">{{ __('messages.parking') }}</span>
                                </label>

                                <!-- Aire acondicionado -->
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" name="features[]" value="aire_acondicionado" 
                                        {{ in_array('aire_acondicionado', request('features', [])) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-amber-500 focus:ring-amber-500">
                                    <span class="text-sm text-gray-700">{{ __('messages.aire_acondicionado') }}</span>
                                </label>
                            </div>
                        </div>

                        <!-- Botones avanzados -->
                        <div class="flex gap-3">
                            <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-2 rounded-md font-medium transition-colors duration-200">
                                {{ __('messages.buscar_con_filtros') }}
                            </button>
                            <button type="button" onclick="this.closest('form').reset(); window.location.href='{{ route('properties.index', ['locale' => app()->getLocale()]) }}'" 
                                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md font-medium transition-colors duration-200">
                                {{ __('messages.limpiar_filtros') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Main Content -->
    <main class="flex-1">    

        {{ $slot }}

        @include('layouts.footer_guest')

        <div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div>
    </main>
    
    <!-- Antes de </body> -->
    <x-search-modal :operations="$operations ?? collect()" :property-types="$propertyTypes ?? collect()" />

    <!-- JavaScript Links -->
    <script src="{{ asset('js/contact-forms.js') }}"></script>

     <link rel="stylesheet" href="https://chat-bob.com/build/assets/widget-q4PC7p8G.css">
     <style>
        /* Lift Chat Bob widget a bit above the bottom edge */
        :root {
            --chatbob-bottom-offset: 60px;
        }
        body .chatbob-widget,
        body .chatbob-widget-button,
        body .chatbob-launcher,
        body .chatbob-container,
        body #chatbob-widget,
        body #chatbob-button {
            bottom: var(--chatbob-bottom-offset) !important;
        }
     </style>
     <!-- Chat Bob Widget -->
    <script>
    window.ChatBobConfig = {
        botId: 15,
        token: 'wgt_vzHQhpYzAldpXvU09F0KN9gKV4nllzuC',
        apiUrl: 'https://chat-bob.com',
        botName: 'LIVING ASSISTANT',
        botSubtitle: 'Asistente inmobiliario',
        primaryColor: '#B8860B',
        secondaryColor: '#FEF3C7',
        textColor: '#1F2937',
        bgColor: '#FFFFFF',
        position: 'bottom-right',
        buttonSize: 'medium',
        borderRadius: 'rounded',
        avatarUrl: 'https://rbconforthouse.com/assets/images/favicons/logo_white.png',
        showBranding: true,
        autoOpen: false,
        autoOpenDelay: 5,
        soundEnabled: true
    };
    </script>
    <script type="module" src="https://chat-bob.com/build/assets/widget.js"></script>
</body>

</html>
