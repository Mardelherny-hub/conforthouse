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
        <div class="relative w-full h-full flex items-center z-30">
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
    
        {{-- incorporar el buscador en el hero lo sacamos de las vistas properties.index y show --}}
        <div class="absolute inset-x-0 bottom-4 z-40 hidden md:block">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white/95 backdrop-blur-sm p-3 rounded-lg shadow-lg border border-gray-200/50">
                    <form action="{{ route('properties.index', ['locale' => app()->getLocale()]) }}" method="GET"
                        class="search-form-compact">
                        
                        <div class="grid grid-cols-2 lg:grid-cols-5 gap-2 text-xs">
                            <!-- Property Type -->
                            <div class="space-y-1">
                                <select id="type_id" name="type_id" class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-amber-500 focus:border-amber-500 bg-white">
                                    <option value="">{{ __('messages.all_types') }}</option>
                                    @foreach ($propertyTypes as $type)
                                        <option value="{{ $type->id }}" {{ $typeId == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Operation -->
                            <div class="space-y-1">
                                <select id="operation_id" name="operation_id" class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-amber-500 focus:border-amber-500 bg-white">
                                    <option value="">{{ __('messages.all_operations') }}</option>
                                    @foreach ($operations as $operation)
                                        <option value="{{ $operation->id }}" {{ $operationId == $operation->id ? 'selected' : '' }}>
                                            {{ $operation->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Min Price -->
                            <div class="space-y-1">
                                <input type="number" id="min_price" name="min_price" value="{{ $min_price }}"
                                    placeholder="{{ __('messages.min_price') }}"
                                    class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-amber-500 focus:border-amber-500">
                            </div>

                            <!-- Max Price -->
                            <div class="space-y-1">
                                <input type="number" id="max_price" name="max_price" value="{{ $max_price }}"
                                    placeholder="{{ __('messages.max_price') }}"
                                    class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-amber-500 focus:border-amber-500">
                            </div>

                            <!-- Search Button -->
                            <div class="col-span-2 lg:col-span-1">
                                <button type="submit" class="w-full px-3 py-1.5 bg-amber-600 hover:bg-amber-700 text-white text-xs font-medium rounded transition-colors duration-200">
                                    {{ __('messages.buscar') }}
                                </button>
                            </div>
                        </div>

                        <!-- Clear Filters - más compacto -->
                        @if ($min_price || $max_price || $operationId || $typeId || $search)
                            <div class="mt-2 text-center">
                                <a href="{{ route('properties.index', ['locale' => app()->getLocale()]) }}"
                                    class="text-xs text-gray-600 hover:text-amber-600 underline transition-colors">
                                    {{ __('messages.clear_all_filters') }}
                                </a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        
    </header>

    <!-- Page Content -->
    <main>

        {{ $slot }}

        @include('layouts.footer_guest')

        <div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div>
    </main>
    
    <!-- Antes de </body> -->
    <x-search-modal :operations="$operations ?? collect()" :property-types="$propertyTypes ?? collect()" />

    <!-- JavaScript Links -->
</body>

</html>
