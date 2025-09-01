<div class="bg-gray-50 p-6 rounded-lg">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Gestión de Imágenes
        </h3>
        <div class="flex items-center space-x-4">
            @if (session('message'))
                <div wire:loading.remove class="flex items-center text-sm text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ session('message') }}
                </div>
            @endif
            <button wire:click="saveAll" wire:loading.attr="disabled"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                <span wire:loading.remove wire:target="saveAll">
                    Guardar cambios
                </span>
                <span wire:loading wire:target="saveAll" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Guardando...
                </span>
            </button>

            @if (!empty($tempPhotos))
                <button wire:click="saveImages" wire:loading.attr="disabled"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                    <span wire:loading.remove wire:target="saveImages">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        Guardar Imágenes
                    </span>
                    <span wire:loading wire:target="saveImages" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Guardando...
                    </span>
                </button>
            @endif
        </div>
    </div>

    <div class="space-y-6">
        <div>
            <div class="flex items-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 01-4.559-4.559l-.477-2.387a2 2 0 00-.547-1.022L6 5m14 0l-4-4m4 4l-4 4m-4 4H5a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v4a2 2 0 01-2 2H5" />
                </svg>
                <h4 class="text-md font-medium text-gray-700">Imágenes Existentes</h4>
            </div>

            @if ($existingImages->count() > 0)
                <div class="grid grid-cols-4 md:grid-cols-6 gap-3">
                    @foreach ($existingImages as $image)
                        <div class="relative group">
                            <img src="{{ Storage::url($image->thumbnail_path) }}" alt="{{ $image->alt_text }}"
                                class="w-full aspect-square object-cover rounded-lg shadow-md">
                            <button type="button" wire:click="removeExistingImage({{ $image->id }})"
                                wire:loading.attr="disabled" wire:target="removeExistingImage({{ $image->id }})"
                                class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200 hover:bg-red-600">
                                <span wire:loading.remove wire:target="removeExistingImage({{ $image->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </span>
                                <span wire:loading wire:target="removeExistingImage({{ $image->id }})"
                                    class="flex items-center">
                                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg text-center">
                    <p class="text-blue-600">No hay imágenes guardadas aún</p>
                </div>
            @endif
        </div>

        <div>
            <div class="flex items-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h4 class="text-md font-medium text-gray-700">Nuevas Imágenes</h4>
            </div>

            <div class="bg-white border-2 border-dashed border-blue-200 p-4 rounded-lg">
                <input type="file" wire:model="photos" multiple accept="image/*"
                    class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100">
                @error('photos.*')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @if (!empty($tempPhotos))
                <div class="grid grid-cols-4 md:grid-cols-6 gap-3 mt-4">
                    @foreach ($tempPhotos as $index => $photo)
                        <div class="relative group">
                            <img src="{{ $photo['original']->temporaryUrl() }}"
                                class="w-full aspect-square object-cover rounded-lg shadow-md">
                            <button wire:click="removePhoto({{ $index }})"
                                class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200 hover:bg-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-lienjoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <!-- Video Section -->
    <div class="mt-8 bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Video de YouTube</h3>

        <div class="space-y-4">
            <div>
                <label for="video" class="block text-sm font-medium text-gray-700">
                    URL del video
                </label>
                <div class="mt-1">
                    <input type="text" id="video" wire:model.live="video"
                        class="shadow-sm focus:ring-amber-500 focus:border-amber-500 block w-full sm:text-sm border-gray-300 rounded-md"
                        placeholder="https://youtube.com/watch?v=xxx o https://youtu.be/xxx">
                </div>
                <p class="mt-1 text-sm text-gray-500">
                    Acepta cualquier formato de URL de YouTube
                </p>
                @error('video')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Video Preview -->
            @if ($videoPreview)
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Vista previa del video
                    </label>
                    <div class="relative aspect-video w-full max-w-2xl">
                        <iframe src="https://www.youtube.com/embed/{{ $videoPreview }}"
                            class="absolute inset-0 w-full h-full rounded-lg" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
