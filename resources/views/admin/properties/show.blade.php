<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Administrar Propiedades
            </h2>
            <a href="{{ route('admin.properties.index') }}" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                Volver al listado
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-8">
                        <h3 class="text-xl font-bold mb-4">{{ $property->title }}</h3>
                        <div class="flex flex-wrap gap-4 mb-6">
                            <div class="flex items-center bg-blue-100 px-3 py-1 rounded-full text-blue-800">
                                <span class="font-semibold">Ref:</span>
                                <span class="ml-1">{{ $property->reference }}</span>
                            </div>
                            <div class="flex items-center bg-green-100 px-3 py-1 rounded-full text-green-800">
                                <span class="font-semibold">Operación:</span>
                                <span class="ml-1">{{ $property->operation->name }}</span>
                            </div>
                            <div class="flex items-center bg-yellow-100 px-3 py-1 rounded-full text-yellow-800">
                                <span class="font-semibold">Tipo:</span>
                                <span class="ml-1">{{ $property->propertyType->name }}</span>
                            </div>
                            <div class="flex items-center bg-purple-100 px-3 py-1 rounded-full text-purple-800">
                                <span class="font-semibold">Estado:</span>
                                <span class="ml-1">{{ $property->status->name }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Galería de imágenes -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold mb-3 pb-2 border-b">Galería de imágenes</h4>
                        @if($property->images->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach($property->images as $image)
                                    <div class="relative group">
                                        <img src="{{ asset('storage/' . $image->image_path) }}"
                                             alt="Imagen de propiedad"
                                             class="w-full h-48 object-cover rounded-lg">
                                        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-lg">
                                            <div class="flex space-x-2">
                                                <a href="{{ asset('storage/' . $image->image_path) }}" target="_blank" class="p-2 bg-white rounded-full">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                                <a href="#" class="p-2 bg-white rounded-full">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                        @if($image->is_featured)
                                            <div class="absolute top-2 left-2 bg-yellow-500 text-white px-2 py-1 text-xs rounded">
                                                Principal
                                            </div>
                                        @endif
                                        <div class="absolute bottom-2 right-2 bg-gray-800 text-white px-2 py-1 text-xs rounded">
                                            Orden: {{ $image->order }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-gray-100 p-4 rounded-lg text-center">
                                <p>No hay imágenes disponibles para esta propiedad</p>
                                <a href="#" class="mt-2 inline-block px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                    Añadir imágenes
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Información principal -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <h4 class="text-lg font-semibold mb-3 pb-2 border-b">Información principal</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="font-medium">Precio:</span>
                                    <span>{{ number_format($property->price, 0, ',', '.') }} €</span>
                                </div>
                                @if($property->community_expenses)
                                <div class="flex justify-between">
                                    <span class="font-medium">Gastos de comunidad:</span>
                                    <span>{{ number_format($property->community_expenses, 0, ',', '.') }} €</span>
                                </div>
                                @endif
                                <div class="flex justify-between">
                                    <span class="font-medium">Superficie construida:</span>
                                    <span>{{ $property->built_area }} m²</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Habitaciones:</span>
                                    <span>{{ $property->rooms }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Baños:</span>
                                    <span>{{ $property->bathrooms }}</span>
                                </div>
                                @if($property->year_built)
                                <div class="flex justify-between">
                                    <span class="font-medium">Año de construcción:</span>
                                    <span>{{ $property->year_built }}</span>
                                </div>
                                @endif
                                @if($property->parking_spaces)
                                <div class="flex justify-between">
                                    <span class="font-medium">Plazas de parking:</span>
                                    <span>{{ $property->parking_spaces }}</span>
                                </div>
                                @endif
                                @if($property->condition)
                                <div class="flex justify-between">
                                    <span class="font-medium">Estado:</span>
                                    <span>{{ $property->condition }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div>
                            <h4 class="text-lg font-semibold mb-3 pb-2 border-b">Ubicación</h4>
                            <div class="space-y-3">
                                @if($property->address)
                                    <div class="flex justify-between">
                                        <span class="font-medium">Dirección:</span>
                                        <span>{{ $property->address->street }} {{ $property->address->number }}</span>
                                    </div>
                                    @if($property->address->floor || $property->address->door)
                                    <div class="flex justify-between">
                                        <span class="font-medium">Piso/Puerta:</span>
                                        <span>{{ $property->address->floor }} {{ $property->address->door }}</span>
                                    </div>
                                    @endif
                                    @if($property->address->postal_code)
                                    <div class="flex justify-between">
                                        <span class="font-medium">Código postal:</span>
                                        <span>{{ $property->address->postal_code }}</span>
                                    </div>
                                    @endif
                                    @if($property->address->district)
                                    <div class="flex justify-between">
                                        <span class="font-medium">Distrito:</span>
                                        <span>{{ $property->address->district }}</span>
                                    </div>
                                    @endif
                                    @if($property->address->city)
                                    <div class="flex justify-between">
                                        <span class="font-medium">Ciudad:</span>
                                        <span>{{ $property->address->city }}</span>
                                    </div>
                                    @endif
                                    @if($property->address->province)
                                    <div class="flex justify-between">
                                        <span class="font-medium">Provincia:</span>
                                        <span>{{ $property->address->province }}</span>
                                    </div>
                                    @endif
                                    @if($property->address->autonomous_community)
                                    <div class="flex justify-between">
                                        <span class="font-medium">Comunidad autónoma:</span>
                                        <span>{{ $property->address->autonomous_community }}</span>
                                    </div>
                                    @endif
                                @else
                                    <p class="text-gray-500 italic">No hay información de dirección disponible</p>
                                @endif

                                @if($property->google_map)
                                <div class="mt-4">
                                    <div class="w-full h-64 rounded-lg overflow-hidden">
                                        {!! $property->google_map !!}
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Características adicionales -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <h4 class="text-lg font-semibold mb-3 pb-2 border-b">Características del inmueble</h4>
                            <div class="space-y-3">
                                @if($property->floors)
                                <div class="flex justify-between">
                                    <span class="font-medium">Número de plantas:</span>
                                    <span>{{ $property->floors }}</span>
                                </div>
                                @endif
                                @if($property->floor)
                                <div class="flex justify-between">
                                    <span class="font-medium">Planta:</span>
                                    <span>{{ $property->floor }}</span>
                                </div>
                                @endif
                                @if($property->orientation)
                                <div class="flex justify-between">
                                    <span class="font-medium">Orientación:</span>
                                    <span>{{ $property->orientation }}</span>
                                </div>
                                @endif
                                @if($property->exterior_type)
                                <div class="flex justify-between">
                                    <span class="font-medium">Tipo exterior:</span>
                                    <span>{{ $property->exterior_type }}</span>
                                </div>
                                @endif
                                @if($property->kitchen_type)
                                <div class="flex justify-between">
                                    <span class="font-medium">Tipo de cocina:</span>
                                    <span>{{ $property->kitchen_type }}</span>
                                </div>
                                @endif
                                @if($property->heating_type)
                                <div class="flex justify-between">
                                    <span class="font-medium">Tipo de calefacción:</span>
                                    <span>{{ $property->heating_type }}</span>
                                </div>
                                @endif
                                @if($property->interior_carpentry)
                                <div class="flex justify-between">
                                    <span class="font-medium">Carpintería interior:</span>
                                    <span>{{ $property->interior_carpentry }}</span>
                                </div>
                                @endif
                                @if($property->exterior_carpentry)
                                <div class="flex justify-between">
                                    <span class="font-medium">Carpintería exterior:</span>
                                    <span>{{ $property->exterior_carpentry }}</span>
                                </div>
                                @endif
                                @if($property->flooring_type)
                                <div class="flex justify-between">
                                    <span class="font-medium">Tipo de suelo:</span>
                                    <span>{{ $property->flooring_type }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div>
                            <h4 class="text-lg font-semibold mb-3 pb-2 border-b">Información adicional</h4>
                            <div class="space-y-3">
                                @if($property->views)
                                <div class="flex justify-between">
                                    <span class="font-medium">Vistas:</span>
                                    <span>{{ $property->views }}</span>
                                </div>
                                @endif
                                @if($property->distance_to_sea)
                                <div class="flex justify-between">
                                    <span class="font-medium">Distancia al mar:</span>
                                    <span>{{ $property->distance_to_sea }} m</span>
                                </div>
                                @endif
                                @if($property->regime)
                                <div class="flex justify-between">
                                    <span class="font-medium">Régimen:</span>
                                    <span>{{ $property->regime }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold mb-3 pb-2 border-b">Descripción</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            {!! nl2br(e($property->description)) !!}
                        </div>
                    </div>

                    <!-- SEO -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold mb-3 pb-2 border-b">Información SEO</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="font-medium">Meta descripción:</span>
                                <span class="max-w-lg">{{ $property->meta_description }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex justify-end space-x-4 mt-8">
                        <a href="{{ route('admin.properties.edit', $property->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                            Editar propiedad
                        </a>
                        <form action="{{ route('admin.properties.destroy', $property->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta propiedad?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                                Eliminar propiedad
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
