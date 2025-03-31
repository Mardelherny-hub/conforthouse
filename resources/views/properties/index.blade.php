<x-public-layout>
    <div class="container mx-auto px-4 relative z-30 -mt-20 md:-mt-24 lg:-mt-32">
        <div class="bg-white/90 backdrop-blur-sm shadow-xl rounded-lg p-6 md:p-8 border border-gray-100">
            <div class="mb-6">
                <h1 class="text-3xl font-luxury font-light text-gray-900">{{ __('messages.exclusive_properties') }}</h1>
            </div>

            {{-- Filtros de Búsqueda --}}
            <form class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                {{-- Tipo de Propiedad --}}
                <div class="col-span-1">
                    <select
                        class="w-full px-3 py-2 border border-gray-300 rounded-sm text-gray-700
                                   focus:ring-2 focus:ring-amber-300 focus:border-amber-300
                                   transition duration-300 luxury-nav">
                        <option>{{ __('messages.tipo_de_propiedad') }}</option>
                        <option>{{ __('messages.apartamento') }}</option>
                        <option>{{ __('messages.casa') }}</option>
                        <option>{{ __('messages.finca') }}</option>
                    </select>
                </div>

                {{-- Ubicación --}}
                <div class="col-span-1">
                    <select
                        class="w-full px-3 py-2 border border-gray-300 rounded-sm text-gray-700
                                   focus:ring-2 focus:ring-amber-300 focus:border-amber-300
                                   transition duration-300 luxury-nav">
                        <option>{{ __('messages.ubicacion') }}</option>
                        <option>{{ __('messages.todas') }}</option>
                        <option>{{ __('messages.lugar_a') }}</option>
                        <option>{{ __('messages.lugar_b') }}</option>
                        <option>{{ __('messages.lugar_c') }}</option>
                    </select>
                </div>

                {{-- Precio Mínimo --}}
                <div class="col-span-1">
                    <input type="number" placeholder="{{ __('messages.menor_precio') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-sm text-gray-700
                               focus:ring-2 focus:ring-amber-300 focus:border-amber-300
                               transition duration-300 luxury-nav">
                </div>

                {{-- Precio Máximo --}}
                <div class="col-span-1">
                    <input type="number" placeholder="{{ __('messages.mayor_precio') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-sm text-gray-700
                               focus:ring-2 focus:ring-amber-300 focus:border-amber-300
                               transition duration-300 luxury-nav">
                </div>

                {{-- Botón de Búsqueda --}}
                <div class="col-span-1">
                    <button type="submit"
                        class="btn-luxury bg-gradient-to-r from-[#a67c00] to-[#d4af37] text-white px-6 py-3 rounded-sm w-full transition duration-300 font-luxury tracking-wider shadow-md hover:shadow-lg">
                        {{ __('messages.search_button') }}
                    </button>
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

        {{-- Grid de Propiedades --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
             @foreach ($properties as $property)
                <div
                    class="group relative overflow-hidden rounded-sm h-96 cursor-pointer shadow-xl transform transition-all duration-500 hover:shadow-2xl hover:-translate-y-1">
                    {{-- Imagen con efecto de zoom --}}
                    <div class="absolute inset-0 overflow-hidden">
                        <img src="/storage/{{ $property->images->first()->image_path }}" alt="{{ $property->title }}"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    </div>

                    {{-- Overlay con gradiente --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent opacity-70">
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
                            <p class="text-sm text-gray-300 transition-all duration-500">
                                {{ $property->category }}
                            </p>
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
                                <a href="{{ route('prop.show', ['locale' => app()->getLocale(), 'id' => $property->id]) }}"
                                    class="inline-flex items-center text-amber-300 text-xs uppercase tracking-widest luxury-nav hover:text-amber-400 transition-colors duration-300">
                                    {{ __('messages.descubrir') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20"
                                        fill="currentColor">
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

        {{-- Paginación --}}
        <div class="my-8 flex justify-center items-center space-x-2">
            {{ $properties->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</x-public-layout>
