<div>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        @if (session()->has('message'))
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        <!-- Pasos del formulario -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <div
                        class="w-10 h-10 rounded-full flex items-center justify-center {{ $step >= 1 ? 'bg-blue-500 text-white' : 'bg-gray-300' }}">
                        1
                    </div>

                    <div class="mx-2 h-1 w-16 {{ $step >= 2 ? 'bg-blue-500' : 'bg-gray-300' }}"></div>
                    <div
                        class="w-10 h-10 rounded-full flex items-center justify-center {{ $step >= 2 ? 'bg-blue-500 text-white' : 'bg-gray-300' }}">
                        2
                    </div>
                    <div class="mx-2 h-1 w-16 {{ $step >= 3 ? 'bg-blue-500' : 'bg-gray-300' }}"></div>
                    <div
                        class="w-10 h-10 rounded-full flex items-center justify-center {{ $step >= 3 ? 'bg-blue-500 text-white' : 'bg-gray-300' }}">
                        3
                    </div>
                    <div class="mx-2 h-1 w-16 {{ $step >= 4 ? 'bg-blue-500' : 'bg-gray-300' }}"></div>
                    <div
                        class="w-10 h-10 rounded-full flex items-center justify-center {{ $step >= 4 ? 'bg-blue-500 text-white' : 'bg-gray-300' }}">
                        4
                    </div>
                </div>
                <div class="text-sm text-gray-500">Paso {{ $step }} de {{ $totalSteps }}</div>
            </div>
        </div>

        <form wire:submit="save">
            <!-- Paso 1: Información básica -->
            @if ($step == 1)
                <div>
                    <h2 class="text-xl font-bold mb-4">Información Básica</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 mb-1">Referencia</label>
                            <input type="text" wire:model="reference" class="w-full border p-2 rounded">
                            @error('reference')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-1">Estado</label>
                            <select wire:model="status_id" class="w-full border p-2 rounded">
                                <option value="">Seleccione...</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                            @error('status_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 mb-1">Operación</label>
                            <select wire:model="operation_id" class="w-full border p-2 rounded">
                                <option value="">Seleccione...</option>
                                @foreach ($operations as $operation)
                                    <option value="{{ $operation->id }}">{{ $operation->name }}</option>
                                @endforeach
                            </select>
                            @error('operation_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-1">Tipo de Propiedad</label>
                            <select wire:model="property_type_id" class="w-full border p-2 rounded">
                                <option value="">Seleccione...</option>
                                @foreach ($propertyTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('property_type_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Título</label>
                        <input type="text" wire:model="title" class="w-full border p-2 rounded">
                        @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Meta Descripción (para SEO, máx. 160 caracteres)</label>
                        <textarea wire:model="meta_description" class="w-full border p-2 rounded" maxlength="160" rows="2"></textarea>
                        @error('meta_description')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Descripción</label>
                        <textarea wire:model="description" class="w-full border p-2 rounded" rows="5"></textarea>
                        @error('description')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 mb-1">Precio</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center">€</span>
                                <input type="number" wire:model="price" class="w-full border p-2 pl-8 rounded">
                            </div>
                            @error('price')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-1">Gastos de Comunidad</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center">€</span>
                                <input type="number" wire:model="community_expenses"
                                    class="w-full border p-2 pl-8 rounded">
                            </div>
                            @error('community_expenses')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            @endif

            <!-- Paso 2: Ubicación -->
            @if ($step == 2)
                <div>
                    <h2 class="text-xl font-bold mb-4">Ubicación</h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 mb-1">Comunidad Autónoma</label>
                            <div class="relative">
                                <input type="text" wire:model="autonomous_community"
                                    class="w-full border p-2 rounded">
                            </div>
                            @error('autonomous_community')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-1">Provincia</label>
                            <div class="relative">
                                <input type="text" wire:model="province" class="w-full border p-2 rounded">
                            </div>
                            @error('province')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-1">Ciudad</label>
                            <div class="relative">
                                <input type="text" wire:model="city" class="w-full border p-2 rounded">
                            </div>
                            @error('city')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 mb-1">Calle</label>
                                <input type="text" wire:model="street" class="w-full border p-2 rounded">
                                @error('street')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-700 mb-1">Número</label>
                                    <input type="text" wire:model="number" class="w-full border p-2 rounded">
                                    @error('number')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-gray-700 mb-1">Código Postal</label>
                                    <input type="text" wire:model="postal_code" class="w-full border p-2 rounded">
                                    @error('postal_code')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 mb-1">Distrito</label>
                                <input type="text" wire:model="district" class="w-full border p-2 rounded">
                                @error('district')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-700 mb-1">Piso</label>
                                    <input type="text" wire:model="floor" class="w-full border p-2 rounded">
                                    @error('floor')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-gray-700 mb-1">Puerta</label>
                                    <input type="text" wire:model="door" class="w-full border p-2 rounded">
                                    @error('door')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-4 grid-cols-2 gap-4">
                            <label class="block text-gray-700 mb-1">Enlace de Google Maps</label>
                            <input type="url" wire:model="google_map" class="w-full border p-2 rounded">
                            @error('google_map')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
            @endif

            <!-- Paso 3: Características -->
            @if ($step == 3)
                <div>
                    <h2 class="text-xl font-bold mb-4">Características</h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 mb-1">Superficie construida (m²)</label>
                            <input type="number" wire:model="built_area" class="w-full border p-2 rounded">
                            @error('built_area')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-1">Dormitorios</label>
                            <input type="number" wire:model="rooms" class="w-full border p-2 rounded">
                            @error('rooms')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-1">Baños</label>
                            <input type="number" wire:model="bathrooms" class="w-full border p-2 rounded">
                            @error('bathrooms')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 mb-1">Año de construcción</label>
                            <input type="number" wire:model="year_built" class="w-full border p-2 rounded">
                            @error('year_built')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-1">Plazas de garaje</label>
                            <input type="number" wire:model="parking_spaces" class="w-full border p-2 rounded">
                            @error('parking_spaces')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-1">Estado</label>
                            <select wire:model="condition" class="w-full border p-2 rounded">
                                <option value="">Seleccione...</option>
                                @foreach ($conditionOptions as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('condition')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 mb-1">Plantas del edificio</label>
                            <input type="number" wire:model="floors" class="w-full border p-2 rounded">
                            @error('floors')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-1">Planta de la vivienda</label>
                            <input type="number" wire:model="floor" class="w-full border p-2 rounded">
                            @error('floor')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-1">Orientación</label>
                            <select wire:model="orientation" class="w-full border p-2 rounded">
                                <option value="">Seleccione...</option>
                                @foreach ($orientationOptions as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('orientation')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 mb-1">Tipo exterior/interior</label>
                            <select wire:model="exterior_type" class="w-full border p-2 rounded">
                                <option value="">Seleccione...</option>
                                @foreach ($exteriorOptions as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('exterior_type')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-1">Tipo de cocina</label>
                            <select wire:model="kitchen_type" class="w-full border p-2 rounded">
                                <option value="">Seleccione...</option>
                                @foreach ($kitchenOptions as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('kitchen_type')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-1">Tipo de calefacción</label>
                            <select wire:model="heating_type" class="w-full border p-2 rounded">
                                <option value="">Seleccione...</option>
                                @foreach ($heatingOptions as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('heating_type')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 mb-1">Carpintería interior</label>
                            <select wire:model="interior_carpentry" class="w-full border p-2 rounded">
                                <option value="">Seleccione...</option>
                                @foreach ($carpentryOptions as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('interior_carpentry')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-1">Carpintería exterior</label>
                            <select wire:model="exterior_carpentry" class="w-full border p-2 rounded">
                                <option value="">Seleccione...</option>
                                @foreach ($carpentryOptions as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('exterior_carpentry')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-1">Tipo de suelo</label>
                            <select wire:model="flooring_type" class="w-full border p-2 rounded">
                                <option value="">Seleccione...</option>
                                @foreach ($flooringOptions as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('flooring_type')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 mb-1">Vistas</label>
                            <input type="text" wire:model="views" class="w-full border p-2 rounded">
                            @error('views')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-1">Distancia al mar (m)</label>
                            <input type="number" wire:model="distance_to_sea" class="w-full border p-2 rounded">
                            @error('distance_to_sea')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Régimen</label>
                        <input type="text" wire:model="regime" class="w-full border p-2 rounded">
                        @error('regime')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @endif

            <!-- Paso 4: Fotos -->
            @if ($step == 4)
                <div>
                    <h2 class="text-xl font-bold mb-4">Fotos de la Propiedad</h2>

                    <div class="mb-4">
                        <p class="text-gray-600 mb-2">Sube imágenes de la propiedad. La primera imagen será
                            la
                            destacada en los listados.</p>

                        <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                            x-on:livewire-upload-finish="isUploading = false"
                            x-on:livewire-upload-error="isUploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress" class="mb-4">
                            <label class="block text-gray-700 mb-2">Subir imágenes</label>
                            <input type="file" wire:model="photos" class="w-full p-2 border rounded" multiple
                                accept="image/*">
                            @error('photos')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                            @error('photos.*')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror

                            <!-- Barra de progreso durante la carga -->
                            <div x-show="isUploading" class="mt-2">
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-blue-600 h-2.5 rounded-full" x-bind:style="`width: ${progress}%`">
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">Subiendo... <span x-text="progress"></span>%</p>
                            </div>
                        </div>

                        <!-- Previsualización de imágenes subidas -->
                        @if (count($tempPhotos) > 0)
                            <h3 class="text-lg font-semibold mb-2">Imágenes cargadas
                                ({{ count($tempPhotos) }})</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach ($tempPhotos as $index => $photo)
                                    <div class="relative group">
                                        <img src="{{ $photo['original']->temporaryUrl() }}"
                                            alt="Imagen {{ $index + 1 }}" class="w-full h-32 object-cover rounded">
                                        <!-- Indicador de imagen destacada para la primera imagen -->
                                        @if ($index === 0)
                                            <div
                                                class="absolute top-2 left-2 bg-green-500 text-white px-2 py-1 rounded text-xs">
                                                Destacada
                                            </div>
                                        @endif

                                        <!-- Botón para eliminar la imagen -->
                                        <button type="button" wire:click="removePhoto({{ $index }})"
                                            class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 opacity-70 hover:opacity-100"
                                            title="Eliminar imagen">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="mt-4 p-4 bg-blue-50 rounded">
                        <h3 class="text-blue-800 font-semibold mb-2">Consejos para fotos de calidad:</h3>
                        <ul class="list-disc list-inside text-blue-700 text-sm">
                            <li>Utiliza fotos horizontales para una mejor visualización</li>
                            <li>Asegúrate de que las habitaciones estén bien iluminadas</li>
                            <li>La primera foto será la destacada en los listados</li>
                            <li>Intenta mostrar los espacios más atractivos de la propiedad</li>
                            <li>Tamaño máximo por imagen: 2MB</li>
                        </ul>
                    </div>
                </div>
            @endif

    <!-- Botones de navegación -->
    <div class="flex justify-between mt-6">
        @if ($step > 1)
            <button type="button" wire:click="prevStep"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                Anterior
            </button>
        @else
            <div></div>
        @endif

        @if ($step < $totalSteps)
            <button type="button" wire:click="nextStep"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                Siguiente
            </button>
        @else
            <button wire:click="save"
                wire:loading.attr="disabled"
                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-900 focus:ring focus:ring-green-300 disabled:opacity-25 transition">
                <span wire:loading.remove wire:target="save">Guardar Propiedad</span>
                <span wire:loading wire:target="save" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Guardando...
                </span>
            </button>
        @endif
    </div>
    </form>
</div>
</div>
