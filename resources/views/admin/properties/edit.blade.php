<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Editar Propiedad
            </h2>
            <a href="{{ route('admin.properties.show', $property->id) }}" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                Volver al detalle
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.properties.update', $property->id) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <!-- Información básica -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Información básica</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <!-- Referencia -->
                                <div>
                                    <label for="reference" class="block text-sm font-medium text-gray-700 mb-1">Referencia *</label>
                                    <input type="text" name="reference" id="reference" value="{{ old('reference', $property->reference) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    @error('reference')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Operación -->
                                <div>
                                    <label for="operation_id" class="block text-sm font-medium text-gray-700 mb-1">Operación *</label>
                                    <select name="operation_id" id="operation_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                        <option value="">Seleccionar operación</option>
                                        @foreach($operations as $operation)
                                            <option value="{{ $operation->id }}" {{ old('operation_id', $property->operation_id) == $operation->id ? 'selected' : '' }}>
                                                {{ $operation->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('operation_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tipo de propiedad -->
                                <div>
                                    <label for="property_type_id" class="block text-sm font-medium text-gray-700 mb-1">Tipo de propiedad *</label>
                                    <select name="property_type_id" id="property_type_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                        <option value="">Seleccionar tipo</option>
                                        @foreach($propertyTypes as $type)
                                            <option value="{{ $type->id }}" {{ old('property_type_id', $property->property_type_id) == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('property_type_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Estado -->
                                <div>
                                    <label for="status_id" class="block text-sm font-medium text-gray-700 mb-1">Estado *</label>
                                    <select name="status_id" id="status_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                        <option value="">Seleccionar estado</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->id }}" {{ old('status_id', $property->status_id) == $status->id ? 'selected' : '' }}>
                                                {{ $status->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Título -->
                                <div class="md:col-span-2">
                                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
                                    <input type="text" name="title" id="title" value="{{ old('title', $property->title) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    @error('title')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Meta descripción -->
                                <div class="md:col-span-3">
                                    <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">Meta descripción</label>
                                    <textarea name="meta_description" id="meta_description" rows="2"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('meta_description', $property->meta_description) }}</textarea>
                                    @error('meta_description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Ubicación -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Ubicación</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <!-- Calle -->
                                <div class="md:col-span-2">
                                    <label for="street" class="block text-sm font-medium text-gray-700 mb-1">Calle</label>
                                    <input type="text" name="street" id="street" value="{{ old('street', $property->address->street ?? '') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('street')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Número -->
                                <div>
                                    <label for="number" class="block text-sm font-medium text-gray-700 mb-1">Número</label>
                                    <input type="text" name="number" id="number" value="{{ old('number', $property->address->number ?? '') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Piso -->
                                <div>
                                    <label for="floor" class="block text-sm font-medium text-gray-700 mb-1">Piso</label>
                                    <input type="text" name="floor" id="floor" value="{{ old('floor', $property->address->floor ?? '') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('floor')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Puerta -->
                                <div>
                                    <label for="door" class="block text-sm font-medium text-gray-700 mb-1">Puerta</label>
                                    <input type="text" name="door" id="door" value="{{ old('door', $property->address->door ?? '') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('door')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Código Postal -->
                                <div>
                                    <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">Código Postal</label>
                                    <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $property->address->postal_code ?? '') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('postal_code')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Ciudad -->
                                <div class="md:col-span-3">

                                    <livewire:location-selector :selected-city="$property->address->city_id" />
                                    @error('city_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Google Map -->
                                <div class="md:col-span-3">
                                    <label for="google_map" class="block text-sm font-medium text-gray-700 mb-1">Código de Google Maps</label>
                                    <textarea name="google_map" id="google_map" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('google_map', $property->google_map) }}</textarea>
                                    <p class="mt-1 text-xs text-gray-500">Pegue aquí el código iframe de Google Maps</p>
                                    @error('google_map')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Características principales -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Características principales</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <!-- Precio -->
                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Precio (€) *</label>
                                    <input type="number" name="price" id="price" value="{{ old('price', $property->price) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    @error('price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Gastos de comunidad -->
                                <div>
                                    <label for="community_expenses" class="block text-sm font-medium text-gray-700 mb-1">Gastos de comunidad (€)</label>
                                    <input type="number" name="community_expenses" id="community_expenses" value="{{ old('community_expenses', $property->community_expenses) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('community_expenses')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Superficie construida -->
                                <div>
                                    <label for="built_area" class="block text-sm font-medium text-gray-700 mb-1">Superficie construida (m²) *</label>
                                    <input type="number" name="built_area" id="built_area" value="{{ old('built_area', $property->built_area) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    @error('built_area')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Estado (condición) -->
                                <div>
                                    <label for="condition" class="block text-sm font-medium text-gray-700 mb-1">Estado de la propiedad</label>
                                    <select name="condition" id="condition"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Seleccionar estado</option>
                                        <option value="A estrenar" {{ old('condition', $property->condition) == 'A estrenar' ? 'selected' : '' }}>A estrenar</option>
                                        <option value="Buen estado" {{ old('condition', $property->condition) == 'Buen estado' ? 'selected' : '' }}>Buen estado</option>
                                        <option value="A reformar" {{ old('condition', $property->condition) == 'A reformar' ? 'selected' : '' }}>A reformar</option>
                                        <option value="Reformado" {{ old('condition', $property->condition) == 'Reformado' ? 'selected' : '' }}>Reformado</option>
                                    </select>
                                    @error('condition')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Habitaciones -->
                                <div>
                                    <label for="rooms" class="block text-sm font-medium text-gray-700 mb-1">Habitaciones *</label>
                                    <input type="number" name="rooms" id="rooms" value="{{ old('rooms', $property->rooms) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    @error('rooms')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Baños -->
                                <div>
                                    <label for="bathrooms" class="block text-sm font-medium text-gray-700 mb-1">Baños *</label>
                                    <input type="number" name="bathrooms" id="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    @error('bathrooms')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Año de construcción -->
                                <div>
                                    <label for="year_built" class="block text-sm font-medium text-gray-700 mb-1">Año de construcción</label>
                                    <input type="number" name="year_built" id="year_built" value="{{ old('year_built', $property->year_built) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('year_built')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Plazas de parking -->
                                <div>
                                    <label for="parking_spaces" class="block text-sm font-medium text-gray-700 mb-1">Plazas de parking</label>
                                    <input type="number" name="parking_spaces" id="parking_spaces" value="{{ old('parking_spaces', $property->parking_spaces) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('parking_spaces')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Plantas -->
                                <div>
                                    <label for="floors" class="block text-sm font-medium text-gray-700 mb-1">Número de plantas</label>
                                    <input type="number" name="floors" id="floors" value="{{ old('floors', $property->floors) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('floors')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Planta -->
                                <div>
                                    <label for="floor" class="block text-sm font-medium text-gray-700 mb-1">Planta</label>
                                    <select name="floor" id="floor"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Seleccionar planta</option>
                                        <option value="Sótano" {{ old('floor', $property->floor) == 'Sótano' ? 'selected' : '' }}>Sótano</option>
                                        <option value="Semisótano" {{ old('floor', $property->floor) == 'Semisótano' ? 'selected' : '' }}>Semisótano</option>
                                        <option value="Planta baja" {{ old('floor', $property->floor) == 'Planta baja' ? 'selected' : '' }}>Planta baja</option>
                                        <option value="Entreplanta" {{ old('floor', $property->floor) == 'Entreplanta' ? 'selected' : '' }}>Entreplanta</option>
                                        <option value="1ª planta" {{ old('floor', $property->floor) == '1ª planta' ? 'selected' : '' }}>1ª planta</option>
                                        <option value="2ª planta" {{ old('floor', $property->floor) == '2ª planta' ? 'selected' : '' }}>2ª planta</option>
                                        <option value="3ª planta" {{ old('floor', $property->floor) == '3ª planta' ? 'selected' : '' }}>3ª planta</option>
                                        <option value="4ª planta" {{ old('floor', $property->floor) == '4ª planta' ? 'selected' : '' }}>4ª planta</option>
                                        <option value="5ª planta" {{ old('floor', $property->floor) == '5ª planta' ? 'selected' : '' }}>5ª planta</option>
                                        <option value="6ª planta" {{ old('floor', $property->floor) == '6ª planta' ? 'selected' : '' }}>6ª planta</option>
                                        <option value="7ª planta o superior" {{ old('floor', $property->floor) == '7ª planta o superior' ? 'selected' : '' }}>7ª planta o superior</option>
                                        <option value="Ático" {{ old('floor', $property->floor) == 'Ático' ? 'selected' : '' }}>Ático</option>
                                    </select>
                                    @error('floor')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Características adicionales -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Características adicionales</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <!-- Orientación -->
                                <div>
                                    <label for="orientation" class="block text-sm font-medium text-gray-700 mb-1">Orientación</label>
                                    <select name="orientation" id="orientation"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Seleccionar orientación</option>
                                        <option value="Norte" {{ old('orientation', $property->orientation) == 'Norte' ? 'selected' : '' }}>Norte</option>
                                        <option value="Sur" {{ old('orientation', $property->orientation) == 'Sur' ? 'selected' : '' }}>Sur</option>
                                        <option value="Este" {{ old('orientation', $property->orientation) == 'Este' ? 'selected' : '' }}>Este</option>
                                        <option value="Oeste" {{ old('orientation', $property->orientation) == 'Oeste' ? 'selected' : '' }}>Oeste</option>
                                        <option value="Noreste" {{ old('orientation', $property->orientation) == 'Noreste' ? 'selected' : '' }}>Noreste</option>
                                        <option value="Noroeste" {{ old('orientation', $property->orientation) == 'Noroeste' ? 'selected' : '' }}>Noroeste</option>
                                        <option value="Sureste" {{ old('orientation', $property->orientation) == 'Sureste' ? 'selected' : '' }}>Sureste</option>
                                        <option value="Suroeste" {{ old('orientation', $property->orientation) == 'Suroeste' ? 'selected' : '' }}>Suroeste</option>
                                    </select>
                                    @error('orientation')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tipo exterior -->
                                <div>
                                    <label for="exterior_type" class="block text-sm font-medium text-gray-700 mb-1">Tipo exterior</label>
                                    <select name="exterior_type" id="exterior_type"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Seleccionar tipo</option>
                                        <option value="Exterior" {{ old('exterior_type', $property->exterior_type) == 'Exterior' ? 'selected' : '' }}>Exterior</option>
                                        <option value="Interior" {{ old('exterior_type', $property->exterior_type) == 'Interior' ? 'selected' : '' }}>Interior</option>
                                        <option value="Exterior a calle" {{ old('exterior_type', $property->exterior_type) == 'Exterior a calle' ? 'selected' : '' }}>Exterior a calle</option>
                                        <option value="Exterior a patio abierto" {{ old('exterior_type', $property->exterior_type) == 'Exterior a patio abierto' ? 'selected' : '' }}>Exterior a patio abierto</option>
                                        <option value="Exterior a patio cerrado" {{ old('exterior_type', $property->exterior_type) == 'Exterior a patio cerrado' ? 'selected' : '' }}>Exterior a patio cerrado</option>
                                    </select>
                                    @error('exterior_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tipo de cocina -->
                                <div>
                                    <label for="kitchen_type" class="block text-sm font-medium text-gray-700 mb-1">Tipo de cocina</label>
                                    <select name="kitchen_type" id="kitchen_type"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Seleccionar tipo</option>
                                        <option value="Independiente" {{ old('kitchen_type', $property->kitchen_type) == 'Independiente' ? 'selected' : '' }}>Independiente</option>
                                        <option value="Americana" {{ old('kitchen_type', $property->kitchen_type) == 'Americana' ? 'selected' : '' }}>Americana</option>
                                        <option value="Office" {{ old('kitchen_type', $property->kitchen_type) == 'Office' ? 'selected' : '' }}>Office</option>
                                        <option value="Equipada" {{ old('kitchen_type', $property->kitchen_type) == 'Equipada' ? 'selected' : '' }}>Equipada</option>
                                        <option value="Sin equipar" {{ old('kitchen_type', $property->kitchen_type) == 'Sin equipar' ? 'selected' : '' }}>Sin equipar</option>
                                    </select>
                                    @error('kitchen_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tipo de calefacción -->
                                <div>
                                    <label for="heating_type" class="block text-sm font-medium text-gray-700 mb-1">Tipo de calefacción</label>
                                    <select name="heating_type" id="heating_type"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Seleccionar tipo</option>
                                        <option value="Individual" {{ old('heating_type', $property->heating_type) == 'Individual' ? 'selected' : '' }}>Individual</option>
                                        <option value="Central" {{ old('heating_type', $property->heating_type) == 'Central' ? 'selected' : '' }}>Central</option>
                                        <option value="Eléctrica" {{ old('heating_type', $property->heating_type) == 'Eléctrica' ? 'selected' : '' }}>Eléctrica</option>
                                        <option value="Gas" {{ old('heating_type', $property->heating_type) == 'Gas' ? 'selected' : '' }}>Gas</option>
                                        <option value="Gasoil" {{ old('heating_type', $property->heating_type) == 'Gasoil' ? 'selected' : '' }}>Gasoil</option>
                                        <option value="Sin calefacción" {{ old('heating_type', $property->heating_type) == 'Sin calefacción' ? 'selected' : '' }}>Sin calefacción</option>
                                    </select>
                                    @error('heating_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Carpintería interior -->
                                <div>
                                    <label for="interior_carpentry" class="block text-sm font-medium text-gray-700 mb-1">Carpintería interior</label>
                                    <select name="interior_carpentry" id="interior_carpentry"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Seleccionar tipo</option>
                                        <option value="Madera" {{ old('interior_carpentry', $property->interior_carpentry) == 'Madera' ? 'selected' : '' }}>Madera</option>
                                        <option value="Aluminio" {{ old('interior_carpentry', $property->interior_carpentry) == 'Aluminio' ? 'selected' : '' }}>Aluminio</option>
                                        <option value="PVC" {{ old('interior_carpentry', $property->interior_carpentry) == 'PVC' ? 'selected' : '' }}>PVC</option>
                                        <option value="Hierro" {{ old('interior_carpentry', $property->interior_carpentry) == 'Hierro' ? 'selected' : '' }}>Hierro</option>
                                    </select>
                                    @error('interior_carpentry')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- Carpintería exterior -->
                                <div>
                                    <label for="exterior_carpentry" class="block text-sm font-medium text-gray-700 mb-1">Carpintería exterior</label>
                                    <select name="exterior_carpentry" id="exterior_carpentry"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Seleccionar tipo</option>
                                        <option value="Madera" {{ old('exterior_carpentry', $property->exterior_carpentry) == 'Madera' ? 'selected' : '' }}>Madera</option>
                                        <option value="Aluminio" {{ old('exterior_carpentry', $property->exterior_carpentry) == 'Aluminio' ? 'selected' : '' }}>Aluminio</option>
                                        <option value="PVC" {{ old('exterior_carpentry', $property->exterior_carpentry) == 'PVC' ? 'selected' : '' }}>PVC</option>
                                        <option value="Hierro" {{ old('exterior_carpentry', $property->exterior_carpentry) == 'Hierro' ? 'selected' : '' }}>Hierro</option>
                                    </select>
                                    @error('exterior_carpentry')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- Tipo de suelo -->
                                <div>
                                    <label for="flooring_type" class="block text-sm font-medium text-gray-700 mb-1">Tipo de suelo (Debug: '{{ $property->flooring_type }}') </label>
                                    <select name="flooring_type" id="flooring_type"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Seleccionar tipo</option>
                                        <option value="Mármol" {{ old('flooring_type', $property->flooring_type) == 'Mármol' ? 'selected' : '' }}>Mármol</option>
                                        <option value="Gres" {{ old('flooring_type', $property->flooring_type) == 'Gres' ? 'selected' : '' }}>Gres</option>
                                        <option value="Parquet" {{ old('flooring_type', $property->flooring_type) == 'Parquet' ? 'selected' : '' }}>Parquet</option>
                                        <option value="Terrazo" {{ old('flooring_type', $property->flooring_type) == 'Terrazo' ? 'selected' : '' }}>Terrazo</option>
                                        <option value="Tarima" {{ old('flooring_type', $property->flooring_type) == 'Tarima' ? 'selected' : '' }}>Tarima</option>
                                        <option value="Piedra" {{ old('flooring_type', $property->flooring_type) == 'Piedra' ? 'selected' : '' }}>Piedra</option>
                                        <option value="Cerámico" {{ old('flooring_type', $property->flooring_type) == 'Cerámico' ? 'selected' : '' }}>Cerámico</option>
                                    </select>
                                    @error('flooring_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                        </div>

                        <!-- Botones de acción -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('admin.properties.index') }}"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancelar
                            </a>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Guardar cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Agregar JavaScript para sincronizar los valores -->
@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('location-updated', (event) => {
            const form = document.querySelector('form');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = event.type + '_id';
            input.value = event.value;

            const existingInput = form.querySelector(`input[name="${event.type}_id"]`);
            if (existingInput) {
                existingInput.remove();
            }

            form.appendChild(input);
        });
    });
</script>
@endpush
