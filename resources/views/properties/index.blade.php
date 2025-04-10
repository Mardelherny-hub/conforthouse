<x-public-layout>
    <div class="container mx-auto px-4 relative z-30 -mt-20 md:-mt-24 lg:-mt-32">
        <div class="bg-white/90 backdrop-blur-sm shadow-xl rounded-lg p-6 md:p-8 border border-gray-100">
            <div class="mb-6">
                <h1 class="text-3xl font-luxury font-light text-gray-900">{{ __('messages.exclusive_properties') }}</h1>
            </div>

            {{-- Filtros de Búsqueda --}}
            <form action="{{ route('prop.index', ['locale' => app()->getLocale()]) }}" method="GET"
                class="grid grid-cols-1 md:grid-cols-6 gap-4 items-end">
                {{-- Tipo de Propiedad --}}
                <div class="col-span-1">
                    <select id="type_id" name="type_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-sm text-gray-700
                                   focus:ring-2 focus:ring-amber-300 focus:border-amber-300
                                   transition duration-300 luxury-nav">
                        <option value="">{{ __('messages.tipo_de_propiedad') }}</option>
                        @foreach ($propertyTypes as $type)
                            <option value="{{ $type->id }}" {{ $typeId == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Ubicación --}}
                <div class="col-span-1">
                    <select id="operation_id" name="operation_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-sm text-gray-700
                                   focus:ring-2 focus:ring-amber-300 focus:border-amber-300
                                   transition duration-300 luxury-nav">
                        <option value="">{{ __('messages.Operación') }}</option>
                        @foreach ($operations as $operation)
                            <option value="{{ $operation->id }}" {{ $operationId == $operation->id ? 'selected' : '' }}>
                                {{ $operation->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Precio Mínimo --}}
                <div class="col-span-1">
                    <input type="number" id="max_price" name="max_price" value="{{ $max_price }}"
                        placeholder="{{ __('messages.menor_precio') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-sm text-gray-700
                               focus:ring-2 focus:ring-amber-300 focus:border-amber-300
                               transition duration-300 luxury-nav">
                </div>

                {{-- Precio Máximo --}}
                <div class="col-span-1">
                    <input type="number" id="min_price" name="min_price" value="{{ $min_price }}"
                        placeholder="{{ __('messages.mayor_precio') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-sm text-gray-700
                               focus:ring-2 focus:ring-amber-300 focus:border-amber-300
                               transition duration-300 luxury-nav">
                </div>

                {{-- Botón de Búsqueda --}}
                <div class="col-span-1">
                    <button type="submit"
                        class="btn-luxury bg-gradient-to-r from-[#a67c00] to-[#d4af37] text-white px-6 py-3 rounded-sm w-full transition duration-300 font-luxury tracking-wider shadow-md hover:shadow-lg flex justify-center items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ __('messages.search_button') }}
                    </button>
                </div>

                {{-- botón de limpiar --}}
                <div class="col-span-1">
                    <a href="{{ route('prop.index', ['locale' => app()->getLocale()]) }}"
                        class="btn-luxury bg-gradient-to-r from-[#d4af37] to-[#a67c00] text-white px-6 py-3 rounded-sm w-full transition duration-300 font-luxury tracking-wider shadow-md hover:shadow-lg flex justify-center items-center"
                        duration-300 font-luxury tracking-wider shadow-md hover:shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19.36 2.72L15.61 6.47C15.18 5.27 14.32 4.27 13.15 3.67L16.9 0L19.36 2.72Z"/>
                            <path d="M13.83 7.89C13.25 7.31 12.29 7.31 11.71 7.89C11.13 8.47 11.13 9.43 11.71 10.01C12.29 10.59 13.25 10.59 13.83 10.01C14.41 9.43 14.41 8.47 13.83 7.89Z"/>
                            <path d="M10.93 10.79L3.62 18.1C2.89 18.83 2.89 20.02 3.62 20.75C4.35 21.48 5.54 21.48 6.27 20.75L13.58 13.44L10.93 10.79Z"/>
                        </svg>
                        {{ __('messages.clear_button') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
    <div class="container mx-auto px-4">


        <!-- Encabezado de sección con elemento decorativo -->
        <div class="text-center mb-16 mt-8">
            <div class="inline-block mb-4">
                <div class="flex items-center justify-center">
                    <div class="h-[1px] w-12 bg-gradient-to-r from-transparent to-amber-300"></div>
                    <span
                        class="mx-4 text-amber-400 text-sm luxury-nav uppercase tracking-widest font-light">{{ __('messages.descubre') }}</span>
                    <div class="h-[1px] w-12 bg-gradient-to-l from-transparent to-amber-300"></div>
                </div>
            </div>
            <h2 class="text-4xl font-luxury font-light mb-3 text-gray-900">
                {!! __('messages.titulo_propiedades') !!}
            </h2>

            <p class="text-gray-500 max-w-xl mx-auto luxury-nav">{{ __('messages.subtitulo_propiedades') }}</p>
        </div>


        {{-- Indicador de filtros activos --}}
        @if ($min_price || $max_price || $operationId || $typeId || $search)
            <div class="mb-6 p-4 border-l-4 border-amber-400 bg-amber-50">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-gray-700">{{ __('messages.filtered_results') }}:</span>
                    @if ($search)
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                            {{ __('messages.searching') }}: {{ $search }}
                        </span>
                    @endif
                    @if ($min_price || $max_price)
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                            {{ __('messages.price_range') }}:
                            @if ($min_price)
                                {{ $min_price }} {{ __('messages.currency') }}
                            @endif
                            {{ __('messages.to') }}
                            @if ($max_price)
                                {{ $max_price }} {{ __('messages.currency') }}
                            @endif
                        </span>
                    @endif
                    @if ($operationId)
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                            {{ __('messages.operation') }}:
                            {{ $operations->where('id', $operationId)->first()->name ?? '' }}
                        </span>
                    @endif
                    @if ($typeId)
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                            {{ __('messages.type') }}: {{ $propertyTypes->where('id', $typeId)->first()->name ?? '' }}
                        </span>
                    @endif
                </div>
            </div>
        @endif

        {{-- Mensaje si no hay resultados --}}
        @if ($properties->isEmpty())
            <div class="w-full p-8 text-center bg-gray-50 rounded-lg shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="text-xl font-luxury text-gray-700 mb-2">{{ __('messages.no_properties_found') }}</h3>
                <p class="text-gray-500">{{ __('messages.try_different_filters') }}</p>
            </div>
        @else
            {{-- Grid de Propiedades --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($properties as $property)
                    <div
                        class="group relative overflow-hidden rounded-sm h-96 cursor-pointer shadow-xl transform transition-all duration-500 hover:shadow-2xl hover:-translate-y-1">
                        {{-- Imagen con efecto de zoom --}}
                        <div class="absolute inset-0 overflow-hidden">
                            <img src="/storage/{{ $property->images->first()->image_path }}"
                                alt="{{ $property->title }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        </div>
                        {{-- Overlay con gradiente --}}
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent opacity-70">
                        </div>
                        {{-- Línea decorativa --}}
                        <div
                            class="absolute bottom-0 left-0 right-0 h-0.5 bg-amber-300 transform scale-x-0 origin-left transition-transform duration-500 group-hover:scale-x-100">
                        </div>
                        {{-- Contenido con animación --}}
                        <div
                            class="absolute bottom-0 left-0 p-8 w-full transform translate-y-2 transition-all duration-500 group-hover:translate-y-0">
                            <div class="space-y-3">
                                <h3
                                    class="text-2xl font-luxury text-white mb-1 transition-colors duration-300 group-hover:text-amber-300">
                                    {{ $property->title }}
                                </h3>
                                <div class="flex flex-wrap gap-2">
                                    <span class="text-xs px-2 py-1 bg-amber-300/80 text-black rounded-sm">
                                        {{ $property->propertyType->name }}
                                    </span>
                                    <span class="text-xs px-2 py-1 bg-white/80 text-black rounded-sm">
                                        {{ $property->operation->name }}
                                    </span>
                                </div>
                            </div>
                            <div
                                class="mt-4 opacity-0 transform translate-y-4 transition-all duration-500 group-hover:opacity-100 group-hover:translate-y-0">
                                <p class="text-sm text-white/70 mb-4">
                                    {{ Str::limit($property->description, 100) }}
                                </p>
                                <div class="flex justify-between items-center">
                                    <span class="text-amber-300 text-xl font-bold">
                                        €{{ number_format($property->price, 0, ',', '.') }}
                                    </span>
                                    <a href="{{ route('prop.show', ['locale' => app()->getLocale(), 'slug' => $property->slug]) }}"
                                        class="inline-flex items-center text-amber-300 text-xs uppercase tracking-widest luxury-nav hover:text-amber-400 transition-colors duration-300">
                                        {{ __('messages.descubrir') }}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Paginación --}}
        @if ($properties->hasPages())
            <div class="mt-8">
                {{ $properties->appends(['operation_id' => $operationId, 'type_id' => $typeId, 'price' => $price])->links() }}
            </div>
        @endif

        {{-- Paginación --}}
        <div class="my-8 flex justify-center items-center space-x-2">
            {{ $properties->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</x-public-layout>
