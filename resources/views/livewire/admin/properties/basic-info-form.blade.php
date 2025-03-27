<div class="bg-gray-50 p-6 rounded-lg">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium text-gray-900">Información básica</h3>
        <div class="flex items-center">
            @if($successMessage)
                <div wire:loading.remove class="text-sm text-green-600 mr-4">
                    <i class="fas fa-check-circle mr-1"></i> {{ $successMessage }}
                </div>
            @endif
            @if($errorMessage)
                <div wire:loading.remove class="text-sm text-red-600 mr-4">
                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $errorMessage }}
                </div>
            @endif

            <button wire:click="updateBasicInfo" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                <span wire:loading.remove wire:target="updateBasicInfo">Guardar cambios</span>
                <span wire:loading wire:target="updateBasicInfo">
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
        <!-- Referencia -->
        <div>
            <label for="reference" class="block text-sm font-medium text-gray-700 mb-1">Referencia *</label>
            <input wire:model.defer="reference" type="text" id="reference"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('reference')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Operación -->
        <div>
            <label for="operation_id" class="block text-sm font-medium text-gray-700 mb-1">Operación *</label>
            <select wire:model.defer="operation_id" id="operation_id"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">Seleccionar operación</option>
                @foreach($operations as $operation)
                    <option value="{{ $operation->id }}">{{ $operation->name }}</option>
                @endforeach
            </select>
            @error('operation_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tipo de propiedad -->
        <div>
            <label for="property_type_id" class="block text-sm font-medium text-gray-700 mb-1">Tipo de propiedad *</label>
            <select wire:model.defer="property_type_id" id="property_type_id"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">Seleccionar tipo</option>
                @foreach($propertyTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
            @error('property_type_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Estado -->
        <div>
            <label for="status_id" class="block text-sm font-medium text-gray-700 mb-1">Estado *</label>
            <select wire:model.defer="status_id" id="status_id"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">Seleccionar estado</option>
                @foreach($statuses as $status)
                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                @endforeach
            </select>
            @error('status_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Título -->
        <div class="md:col-span-2">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
            <input wire:model.defer="title" type="text" id="title"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Meta descripción -->
        <div class="md:col-span-3">
            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">Meta descripción</label>
            <textarea wire:model.defer="meta_description" id="meta_description" rows="2"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
            @error('meta_description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>


</div>
