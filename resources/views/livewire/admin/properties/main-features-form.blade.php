<div class="bg-gray-50 p-6 rounded-lg">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium text-gray-900">Características principales</h3>
        <div class="flex items-center">
            @if($successMessage)
                <div class="text-sm text-green-600 mr-4">
                    <i class="fas fa-check-circle mr-1"></i> {{ $successMessage }}
                </div>
            @endif
            @if($errorMessage)
                <div class="text-sm text-red-600 mr-4">
                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $errorMessage }}
                </div>
            @endif
            <button wire:click="updateMainFeatures" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                <span wire:loading.remove wire:target="updateMainFeatures">Guardar cambios</span>
                <span wire:loading wire:target="updateMainFeatures">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Guardando...
                </span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Precio -->
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Precio (€) *</label>
            <input wire:model.defer="price" type="number" id="price"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('price')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Gastos de comunidad -->
        <div>
            <label for="community_expenses" class="block text-sm font-medium text-gray-700 mb-1">Gastos de comunidad (€)</label>
            <input wire:model.defer="community_expenses" type="number" id="community_expenses"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('community_expenses')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Superficie construida -->
        <div>
            <label for="built_area" class="block text-sm font-medium text-gray-700 mb-1">Superficie construida (m²) *</label>
            <input wire:model.defer="built_area" type="number" id="built_area"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('built_area')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Estado (condición) -->
        <div>
            <label for="condition" class="block text-sm font-medium text-gray-700 mb-1">Estado de la propiedad</label>
            <select wire:model.defer="condition" id="condition"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">Seleccionar estado</option>
                <option value="A estrenar">A estrenar</option>
                <option value="Buen estado">Buen estado</option>
                <option value="A reformar">A reformar</option>
                <option value="Reformado">Reformado</option>
            </select>
            @error('condition')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Habitaciones -->
        <div>
            <label for="rooms" class="block text-sm font-medium text-gray-700 mb-1">Habitaciones *</label>
            <input wire:model.defer="rooms" type="number" id="rooms"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('rooms')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Baños -->
        <div>
            <label for="bathrooms" class="block text-sm font-medium text-gray-700 mb-1">Baños *</label>
            <input wire:model.defer="bathrooms" type="number" id="bathrooms"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('bathrooms')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Año de construcción -->
        <div>
            <label for="year_built" class="block text-sm font-medium text-gray-700 mb-1">Año de construcción</label>
            <input wire:model.defer="year_built" type="number" id="year_built"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('year_built')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Plazas de parking -->
        <div>
            <label for="parking_spaces" class="block text-sm font-medium text-gray-700 mb-1">Plazas de parking</label>
            <input wire:model.defer="parking_spaces" type="number" id="parking_spaces"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('parking_spaces')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Plantas -->
        <div>
            <label for="floors" class="block text-sm font-medium text-gray-700 mb-1">Número de plantas</label>
            <input wire:model.defer="floors" type="number" id="floors"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('floors')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Planta -->
        <div>
            <label for="floor" class="block text-sm font-medium text-gray-700 mb-1">Piso</label>
            <input type="number"
                   wire:model="floor"
                   id="floor"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                   min="0"
                   placeholder="Ejemplo: 1">
            @error('floor')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
    </div>


</div>
