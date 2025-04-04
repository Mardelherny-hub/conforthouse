<div>
    <div class="bg-gray-50 p-6 rounded-lg">
        <!-- Opciones de idioma -->
        <div class="mb-4 flex gap-2">
            @foreach($availableLocales as $localeCode)
                <button
                    wire:click="changeLocale('{{ $localeCode }}')"
                    class="px-3 py-1 rounded {{ $locale === $localeCode ? 'bg-blue-600 text-white' : 'bg-gray-200' }}"
                >
                    {{ strtoupper($localeCode) }}
                </button>
            @endforeach
            <div class="ml-auto text-sm text-gray-500 flex items-center">
                @if($locale !== 'es')
                    <span class="mr-2">Editando traducciones en: <strong class="uppercase">{{ $locale }}</strong></span>
                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">
                        Las traducciones se generan automáticamente al crear o actualizar en español
                    </span>
                @else
                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">
                        Idioma principal: Español (ES)
                    </span>
                @endif
            </div>
        </div>

        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Características adicionales</h3>
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
                <button wire:click="updateAdditionalFeatures" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                    <span wire:loading.remove wire:target="updateAdditionalFeatures">
                        @if($locale === 'es')
                            Guardar cambios
                        @else
                            Guardar traducción
                        @endif
                    </span>
                    <span wire:loading wire:target="updateAdditionalFeatures">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Guardando...
                    </span>
                </button>
            </div>
        </div>

        @if($locale === 'es')
            <p class="text-xs text-gray-500 mb-4">
                Al actualizar en español, se generarán automáticamente traducciones para inglés, francés y alemán.
            </p>
        @endif

        <div class="grid grid-cols-3 gap-6">
            <!-- Orientación -->
            <div>
                <label for="orientation" class="block text-sm font-medium text-gray-700 mb-1">Orientación</label>
                <select wire:model="orientation" id="orientation"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Seleccionar orientación</option>
                    @if($locale === 'es')
                        @foreach (['Norte', 'Sur', 'Este', 'Oeste', 'Noreste', 'Noroeste', 'Sureste', 'Suroeste'] as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    @else
                        <option value="{{ $orientation }}" selected>{{ $orientation }}</option>
                    @endif
                </select>
                @error('orientation')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Carpintería Interior -->
            <div>
                <label for="interior_carpentry" class="block text-sm font-medium text-gray-700 mb-1">Carpintería Interior</label>
                <select wire:model="interior_carpentry" id="interior_carpentry"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Seleccionar tipo</option>
                    @if($locale === 'es')
                        @foreach (['Aluminio', 'Madera', 'PVC', 'Mixto', 'Sin carpintería'] as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    @else
                        <option value="{{ $interior_carpentry }}" selected>{{ $interior_carpentry }}</option>
                    @endif
                </select>
                @error('interior_carpentry')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Carpintería Exterior -->
            <div>
                <label for="exterior_carpentry" class="block text-sm font-medium text-gray-700 mb-1">Carpintería Exterior</label>
                <select wire:model="exterior_carpentry" id="exterior_carpentry"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Seleccionar tipo</option>
                    @if($locale === 'es')
                        @foreach (['Aluminio', 'Madera', 'PVC', 'Mixto', 'Sin carpintería'] as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    @else
                        <option value="{{ $exterior_carpentry }}" selected>{{ $exterior_carpentry }}</option>
                    @endif
                </select>
                @error('exterior_carpentry')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tipo de Suelo -->
            <div>
                <label for="flooring_type" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Suelo</label>
                <select wire:model="flooring_type" id="flooring_type"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Seleccionar tipo</option>
                    @if($locale === 'es')
                        @foreach (['Parquet', 'Tarima', 'Cerámica', 'Gres', 'Terrazo', 'Mármol', 'Cemento', 'Otros'] as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    @else
                        <option value="{{ $flooring_type }}" selected>{{ $flooring_type }}</option>
                    @endif
                </select>
                @error('flooring_type')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tipo exterior -->
            <div>
                <label for="exterior_type" class="block text-sm font-medium text-gray-700 mb-1">Tipo exterior</label>
                <select wire:model="exterior_type" id="exterior_type"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Seleccionar tipo</option>
                    @if($locale === 'es')
                        @foreach (['Exterior', 'Interior', 'Mixto'] as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    @else
                        <option value="{{ $exterior_type }}" selected>{{ $exterior_type }}</option>
                    @endif
                </select>
                @error('exterior_type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tipo de cocina -->
            <div>
                <label for="kitchen_type" class="block text-sm font-medium text-gray-700 mb-1">Tipo de cocina</label>
                <select wire:model="kitchen_type" id="kitchen_type"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Seleccionar tipo</option>
                    @if($locale === 'es')
                        @foreach (['Independiente', 'Americana', 'Office', 'Equipada', 'Sin equipar'] as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    @else
                        <option value="{{ $kitchen_type }}" selected>{{ $kitchen_type }}</option>
                    @endif
                </select>
                @error('kitchen_type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tipo de calefacción -->
            <div>
                <label for="heating_type" class="block text-sm font-medium text-gray-700 mb-1">Tipo de
                    calefacción</label>
                <select wire:model="heating_type" id="heating_type"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Seleccionar tipo</option>
                    @if($locale === 'es')
                        @foreach (['Individual', 'Central', 'Eléctrica', 'Gas', 'Gasoil', 'Sin calefacción'] as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    @else
                        <option value="{{ $heating_type }}" selected>{{ $heating_type }}</option>
                    @endif
                </select>
                @error('heating_type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
</div>
