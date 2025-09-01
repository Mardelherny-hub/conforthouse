<div class="bg-gray-50 p-6 rounded-lg mb-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium text-gray-900">Ubicación</h3>
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
            <button wire:click="updateLocation" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                <span wire:loading.remove wire:target="updateLocation">Guardar cambios</span>
                <span wire:loading wire:target="updateLocation">
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
        <!-- Calle -->
        <div class="md:col-span-2">
            <label for="street" class="block text-sm font-medium text-gray-700 mb-1">Calle</label>
            <input
                type="text"
                wire:model.deffer="street"
                id="street"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            >
            @error('street')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Número -->
        <div>
            <label for="number" class="block text-sm font-medium text-gray-700 mb-1">Número</label>
            <input
                type="text"
                wire:model.deffer="number"
                id="number"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('number')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Piso -->
        <div md:col-span-4>
            <label for="floor" class="block text-sm font-medium text-gray-700 mb-1">Piso</label>
            <input
                type="text"
                wire:model.deffer="floor"
                id="floor"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('floor')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Puerta -->
        <div md:col-span-4>
            <label for="door" class="block text-sm font-medium text-gray-700 mb-1">Puerta</label>
            <input
                type="text"
                wire:model.deffer="door"
                id="door"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('door')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Distrito -->
        <div md:col-span-4>
            <label for="district" class="block text-sm font-medium text-gray-700 mb-1">Distrito</label>
            <input
                type="text"
                wire:model.deffer="district"
                id="district"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('district')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Código Postal -->
        <div md:col-span-4>
            <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">Código Postal</label>
            <input
                type="text"
                wire:model.deffer="postal_code"
                id="postal_code"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('postal_code')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Ciudad -->
        <div>
            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Ciudad</label>
            <input
                type="text"
                wire:model.deffer="city"
                id="city"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('city')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Provincia -->
        <div>
            <label for="province" class="block text-sm font-medium text-gray-700 mb-1">Provincia</label>
            <input
                type="text"
                wire:model.deffer="province"
                id="province"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('province')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Comunidad Autónoma -->
        <div>
            <label for="autonomous_community" class="block text-sm font-medium text-gray-700 mb-1">Comunidad
                Autónoma</label>
            <input
                type="text"
                wire:model.deffer="autonomous_community"
                id="autonomous_community"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('autonomous_community')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Google Map -->
        <div class="md:col-span-3">
            <label for="google_map" class="block text-sm font-medium text-gray-700 mb-1">Código de Google
                Maps</label>
            <textarea wire:model.deffer="google_map" id="google_map" rows="2"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
            <p class="mt-1 text-xs text-gray-500">Pegue aquí el código iframe de Google Maps</p>
            @error('google_map')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
