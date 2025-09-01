<x-public-layout>

    <div class="container mx-auto px-4">

        <div x-data="{
            activeTab: 'images',
            images: [
                { image_path: 'placeholder1.jpg' },
                { image_path: 'placeholder2.jpg' },
                { image_path: 'placeholder3.jpg' },
                { image_path: 'placeholder4.jpg' },
                { image_path: 'placeholder5.jpg' }
            ],
            currentIndex: 0,
            showModal: false,
            youtubeVideoId: '{{ $property->video }}', // Cambia esto por el ID de tu video de YouTube
            openModal(index) {
                this.currentIndex = index;
                this.showModal = true;
            },
            closeModal() {
                this.showModal = false;
            },
            nextImage() {
                this.currentIndex = (this.currentIndex + 1) % this.images.length;
            },
            prevImage() {
                this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
            },
            get currentImage() {
                return this.images[this.currentIndex];
            }
        }" class="mb-12">

            <!-- Tabs de navegación -->
            <div class="flex mb-6 border-b border-gray-200">
                <button @click="activeTab = 'images'"
                    :class="activeTab === 'images' ? 'border-amber-500 text-amber-500' :
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="py-4 px-6 font-medium border-b-2 transition-all duration-200 focus:outline-none">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Galería de Imágenes
                    </div>
                </button>
                <button @click="activeTab = 'video'"
                    :class="activeTab === 'video' ? 'border-amber-500 text-amber-500' :
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="py-4 px-6 font-medium border-b-2 transition-all duration-200 focus:outline-none">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        Video
                    </div>
                </button>
            </div>

            <!-- Contenido de la pestaña de imágenes -->
            <div x-show="activeTab === 'images'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                {{-- Galería de Imágenes con Alpine --}}
                <div x-data="{
                    images: @js($property->images),
                    currentIndex: 0,
                    showModal: false,
                    openModal(index) {
                        this.currentIndex = index;
                        this.showModal = true;
                    },
                    closeModal() {
                        this.showModal = false;
                    },
                    nextImage() {
                        this.currentIndex = (this.currentIndex + 1) % this.images.length;
                    },
                    prevImage() {
                        this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
                    },
                    get currentImage() {
                        return this.images[this.currentIndex];
                    }
                }" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                    {{-- Imagen Principal --}}
                    <div class="relative group">
                        @if($property->images->isNotEmpty())
                            <img src="/storage/{{ $property->images->first()->image_path }}"
                                alt="{{ $property->title }}"
                                @click="openModal(0)"
                                class="w-full h-[500px] object-cover rounded-lg shadow-xl transform transition-all duration-700 group-hover:scale-105 cursor-pointer">
                        @else
                            <img src="/images/placeholder-property.jpg"
                                alt="{{ $property->title }}"
                                class="w-full h-[500px] object-cover rounded-lg shadow-xl">
                        @endif
                        {{-- Overlay con gradiente --}}
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-70 rounded-lg">
                        </div>

                        {{-- Etiquetas --}}
                        <div class="absolute top-4 left-4 flex space-x-2">
                            <span class="bg-amber-500 text-white px-3 py-1 rounded-full text-sm">
                                {{ $property->propertyType->name }}
                            </span>
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">
                                {{ $property->operation->name }}
                            </span>
                        </div>
                    </div>

                    {{-- Miniaturas de Imágenes --}}
                    <div class="grid grid-cols-2 gap-4">
                        @foreach ($property->images->slice(1, 4) as $index => $image)
                            <div class="relative group overflow-hidden rounded-lg">
                                <img src="/storage/{{ $image->image_path }}" alt="{{ $property->title }}"
                                    @click="openModal({{ $index }})"
                                    class="w-full h-60 object-cover transform transition-all duration-700 group-hover:scale-110 cursor-pointer">
                            </div>
                        @endforeach
                    </div>

                    {{-- Modal de Imágenes --}}
                    <template x-teleport="body">
                        <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0" @keydown.escape.window="closeModal()"
                            @keydown.arrow-right.window="nextImage()" @keydown.arrow-left.window="prevImage()"
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-90"
                            @click.self="closeModal()">
                            <div class="relative max-w-4xl w-full max-h-[90vh] flex flex-col">
                                {{-- Botón de Cierre --}}
                                <button @click="closeModal()"
                                    class="absolute -top-10 right-0 text-white text-4xl hover:text-amber-500 transition-colors z-10">
                                    &times;
                                </button>

                                {{-- Navegación --}}
                                <button @click="prevImage()"
                                    class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-amber-500 text-white w-12 h-12 rounded-full flex items-center justify-center z-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <button @click="nextImage()"
                                    class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-amber-500 text-white w-12 h-12 rounded-full flex items-center justify-center z-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>

                                {{-- Imagen en Modal --}}
                                <div class="w-full h-full flex items-center justify-center">
                                    <img :src="'/storage/' + currentImage.image_path" alt="{{ $property->title }}"
                                        class="max-w-full max-h-[80vh] object-contain rounded-lg"
                                        x-transition:enter="transition ease-out duration-300 transform"
                                        x-transition:enter-start="opacity-0 scale-95"
                                        x-transition:enter-end="opacity-100 scale-100">
                                </div>

                                {{-- Contador de imágenes --}}
                                <div class="text-white text-center mt-4">
                                    <span x-text="currentIndex + 1"></span> / <span x-text="images.length"></span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

            </div>

            <!-- Contenido de la pestaña de video -->
            <div x-show="activeTab === 'video'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                class="grid grid-cols-1 gap-6">
                <!-- Contenedor del video con las mismas dimensiones que la imagen principal -->
                <div class="relative h-[500px] group">
                    <iframe :src="'https://www.youtube.com/embed/' + youtubeVideoId + '?rel=0&showinfo=0'"
                        class="w-full h-full object-cover rounded-lg shadow-xl" title="Video de la propiedad"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>
                <!-- Espacio en blanco para mantener la cuadrícula -->
                <div class="hidden md:block"></div>
            </div>

            {{-- Modal de Imágenes --}}
            <template x-teleport="body">
                <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" @keydown.escape.window="closeModal()"
                    @keydown.arrow-right.window="nextImage()" @keydown.arrow-left.window="prevImage()"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-90"
                    @click.self="closeModal()">
                    <div class="relative max-w-4xl w-full max-h-[90vh] flex flex-col">
                        {{-- Botón de Cierre --}}
                        <button @click="closeModal()"
                            class="absolute -top-10 right-0 text-white text-4xl hover:text-amber-500 transition-colors z-10">
                            &times;
                        </button>

                        {{-- Navegación --}}
                        <button @click="prevImage()"
                            class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-amber-500 text-white w-12 h-12 rounded-full flex items-center justify-center z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button @click="nextImage()"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-amber-500 text-white w-12 h-12 rounded-full flex items-center justify-center z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        {{-- Imagen en Modal --}}
                        <div class="w-full h-full flex items-center justify-center">
                            <img :src="'/storage/' + currentImage.image_path" alt="{{ $property->title }}"
                                class="max-w-full max-h-[80vh] object-contain rounded-lg"
                                x-transition:enter="transition ease-out duration-300 transform"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100">
                        </div>

                        {{-- Contador de imágenes --}}
                        <div class="text-white text-center mt-4">
                            <span x-text="currentIndex + 1"></span> / <span x-text="images.length"></span>
                        </div>
                    </div>
                </div>
            </template>
        </div>


        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            {{-- Columna Principal con Características --}}
            <div class="md:col-span-2">
                <h1 class="text-4xl font-luxury text-gray-800 mb-4">{{ $property->title }}</h1>
                {{-- Compartir en redes sociales --}}
                    <div class="flex items-center space-x-4 mb-6">
                        {{-- Share text
                        <span class="text-gray-600 font-medium">{{ __('messages.Compartir') }}:</span>
                        --}}
                        {{-- Facebook --}}
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                            target="_blank"
                            class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path>
                            </svg>
                        </a>

                        {{-- Twitter/X --}}
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($property->title) }}"
                            target="_blank"
                            class="flex items-center justify-center w-8 h-8 rounded-full bg-black text-white hover:bg-gray-800 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path>
                            </svg>
                        </a>

                        {{-- WhatsApp --}}
                        <a href="https://wa.me/?text={{ urlencode($property->title . ' ' . request()->url()) }}"
                            target="_blank"
                            class="flex items-center justify-center w-8 h-8 rounded-full bg-green-500 text-white hover:bg-green-600 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.048 2.088c-5.523 0-10 4.477-10 10 0 1.899.531 3.673 1.454 5.18L2.024 21.98l4.832-1.402A9.96 9.96 0 0012.048 22.088c5.523 0 10-4.477 10-10s-4.477-10-10-10zm0 1.6c4.64 0 8.4 3.76 8.4 8.4s-3.76 8.4-8.4 8.4c-1.698 0-3.276-.504-4.595-1.37l-.497-.324-.576.167-2.077.603.621-2.112.18-.612-.342-.524c-.913-1.399-1.414-3.044-1.414-4.828 0-4.64 3.76-8.4 8.4-8.4z" clip-rule="evenodd"></path>
                                <path d="M8.464 7.192c.192.508.384 1.016.576 1.524.096.256.192.508.264.76.144.508-.048 1.016-.384 1.368-.192.196-.384.388-.576.58-.192.196-.192.388-.096.58.48.76 1.056 1.428 1.728 1.98.768.652 1.632 1.112 2.592 1.368.192.052.384.1.576.148.384.1.768-.052 1.056-.292.384-.352.768-.704 1.152-1.056.288-.256.576-.256.864 0 .48.352.96.704 1.44 1.056.24.196.48.388.72.58.384.292.384.58 0 .872-.48.388-.96.776-1.44 1.164-.432.34-.912.484-1.44.388-.144-.024-.288-.048-.432-.072-1.572-.352-2.976-1.112-4.224-2.128-1.056-.86-1.968-1.86-2.736-2.992-.432-.632-.768-1.316-.96-2.076-.144-.58-.048-1.112.336-1.572.432-.508.864-1.016 1.296-1.524.288-.34.288-.632 0-.972-.36-.46-.72-.92-1.08-1.38-.192-.244-.384-.244-.576 0-.384.352-.768.704-1.152 1.056-.288.256-.384.58-.336.92z"></path>
                            </svg>
                        </a>

                        {{-- LinkedIn --}}
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode($property->title) }}"
                            target="_blank"
                            class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-700 text-white hover:bg-blue-800 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd"></path>
                            </svg>
                        </a>

                        {{-- Email --}}
                        <a href="mailto:?subject={{ urlencode($property->title) }}&body={{ urlencode(request()->url()) }}"
                            class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-600 text-white hover:bg-gray-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </a>
                    </div>
                <p class="text-gray-600 mb-6">{!! nl2br($property->description) !!}</p>

                {{-- Características Principales --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gray-100 p-4 rounded-lg text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto mb-2 text-amber-500"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="block text-sm text-gray-600">{{ __('messages.Ubicación') }}</span>
                        <span class="font-semibold">{{ $property->address->city }}</span> <br>
                        <span class="font-semibold">{{ $property->address->province }}</span> <br>
                        <span class="font-semibold">{{ $property->address->autonomous_community }}</span> <br>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto mb-2 text-amber-500"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                        </svg>
                        <span class="block text-sm text-gray-600">{{ __('messages.Precio') }}</span>
                        <span class="font-semibold text-amber-600">€
                            {{ number_format($property->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto mb-2 text-amber-500"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span class="block text-sm text-gray-600">{{ __('messages.Superficie') }}</span>
                        <span class="font-semibold">{{ $property->built_area }} m²</span>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto mb-2 text-amber-500"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="block text-sm text-gray-600">{{ __('messages.Estado') }}</span>
                        <span class="font-semibold">{{ $property->status->name }}</span>
                    </div>
                </div>

                {{-- Descripción Detallada --}}
                <div class="mb-6">
                    <h2 class="text-2xl font-luxury text-gray-800 mb-4">{{ __('messages.Descripción Detallada') }}
                    </h2>
                    <p class="text-gray-600">{{ $property->meta_description }}</p>
                </div>

                {{-- Características Detalladas de la Propiedad --}}
                <div class="mt-10 mb-12">
                    <h2 class="text-2xl font-luxury text-gray-800 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-amber-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        {{ __('messages.Características de la Propiedad') }}
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                        <!-- Detalles Básicos -->
                        <div
                            class="bg-white shadow-md p-6 rounded-lg border-l-4 border-amber-500 hover:shadow-lg transition-shadow">
                            <h3 class="text-lg font-semibold text-amber-600 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ __('messages.Detalles Básicos') }}
                            </h3>
                            <ul class="space-y-3">
                                <li class="flex items-center justify-between border-b border-gray-100 pb-2">
                                    <span class="text-gray-600">{{ __('messages.Referencia') }}:</span>
                                    <span class="font-medium">{{ $property->reference }}</span>
                                </li>
                                <li class="flex items-center justify-between border-b border-gray-100 pb-2">
                                    <span class="text-gray-600">{{ __('messages.Tipo') }}:</span>
                                    <span class="font-medium">{{ $property->propertyType->name }}</span>
                                </li>
                                <li class="flex items-center justify-between border-b border-gray-100 pb-2">
                                    <span class="text-gray-600">{{ __('messages.Operación') }}:</span>
                                    <span class="font-medium">{{ $property->operation->name }}</span>
                                </li>
                                <li class="flex items-center justify-between border-b border-gray-100 pb-2">
                                    <span class="text-gray-600">{{ __('messages.Condición') }}:</span>
                                    <span class="font-medium">{{ $property->condition }}</span>
                                </li>
                                <li class="flex items-center justify-between border-b border-gray-100 pb-2">
                                    <span class="text-gray-600">{{ __('messages.Año construcción') }}:</span>
                                    <span class="font-medium">{{ $property->year_built }}</span>
                                </li>
                                @if ($property->regime)
                                    <li class="flex items-center justify-between border-b border-gray-100 pb-2">
                                        <span class="text-gray-600">{{ __('messages.Régimen') }}:</span>
                                        <span class="font-medium">{{ $property->regime }}</span>
                                    </li>
                                @endif
                            </ul>
                        </div>

                        <!-- Distribución -->
                        <div
                            class="bg-white shadow-md p-6 rounded-lg border-l-4 border-amber-500 hover:shadow-lg transition-shadow">
                            <h3 class="text-lg font-semibold text-amber-600 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                                {{ __('messages.Distribución') }}
                            </h3>
                            <ul class="space-y-3">
                                <li class="flex items-center justify-between border-b border-gray-100 pb-2">
                                    <span class="text-gray-600">{{ __('messages.Superficie') }}:</span>
                                    <span class="font-medium">{{ $property->built_area }} m²</span>
                                </li>
                                <li class="flex items-center justify-between border-b border-gray-100 pb-2">
                                    <span class="text-gray-600">{{ __('messages.Habitaciones') }}:</span>
                                    <span class="font-medium">{{ $property->rooms }}</span>
                                </li>
                                <li class="flex items-center justify-between border-b border-gray-100 pb-2">
                                    <span class="text-gray-600">{{ __('messages.Baños') }}:</span>
                                    <span class="font-medium">{{ $property->bathrooms }}</span>
                                </li>
                                <li class="flex items-center justify-between border-b border-gray-100 pb-2">
                                    <span class="text-gray-600">{{ __('messages.Planta') }}:</span>
                                    <span class="font-medium">{{ $property->floor }}º</span>
                                </li>
                                <li class="flex items-center justify-between border-b border-gray-100 pb-2">
                                    <span class="text-gray-600">{{ __('messages.Plantas totales') }}:</span>
                                    <span class="font-medium">{{ $property->floors }}</span>
                                </li>
                                @if ($property->parking_spaces)
                                    <li class="flex items-center justify-between border-b border-gray-100 pb-2">
                                        <span class="text-gray-600">{{ __('messages.Plazas de garaje') }}:</span>
                                        <span class="font-medium">{{ $property->parking_spaces }}</span>
                                    </li>
                                @endif
                            </ul>
                        </div>

                        <!-- Características -->
                        <div
                            class="bg-white shadow-md p-6 rounded-lg border-l-4 border-amber-500 hover:shadow-lg transition-shadow">
                            <h3 class="text-lg font-semibold text-amber-600 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                                {{ __('messages.Características') }}
                            </h3>
                            <ul class="space-y-3">
                                <li class="flex items-center justify-between border-b border-gray-100 pb-2">
                                    <span class="text-gray-600">{{ __('messages.Orientación') }}:</span>
                                    <span class="font-medium">{{ $property->orientation }}</span>
                                </li>
                                <li class="flex items-center justify-between border-b border-gray-100 pb-2">
                                    <span class="text-gray-600">{{ __('messages.Exterior') }}:</span>
                                    <span class="font-medium">{{ $property->exterior_type }}</span>
                                </li>
                                @if ($property->views)
                                    <li class="flex items-center justify-between border-b border-gray-100 pb-2">
                                        <span class="text-gray-600">{{ __('messages.Vistas') }}:</span>
                                        <span class="font-medium">{{ $property->views }}</span>
                                    </li>
                                @endif
                                @if ($property->distance_to_sea)
                                    <li class="flex items-center justify-between border-b border-gray-100 pb-2">
                                        <span class="text-gray-600">{{ __('messages.Distancia al mar') }}:</span>
                                        <span class="font-medium">{{ $property->distance_to_sea }} m</span>
                                    </li>
                                @endif
                            </ul>
                        </div>

                        <!-- Acabados -->
                        <div
                            class="bg-white shadow-md p-6 rounded-lg border-l-4 border-amber-500 hover:shadow-lg transition-shadow">
                            <h3 class="text-lg font-semibold text-amber-600 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                </svg>
                                {{ __('messages.Acabados') }}
                            </h3>
                            <ul class="space-y-3">
                                <li class="flex items-center justify-between border-b border-gray-100 pb-2">
                                    <span class="text-gray-600">{{ __('messages.Cocina') }}:</span>
                                    <span class="font-medium">{{ $property->kitchen_type }}</span>
                                </li>
                                <li class="flex items-center justify-between border-b border-gray-100 pb-2">
                                    <span class="text-gray-600">{{ __('messages.Calefacción') }}:</span>
                                    <span class="font-medium">{{ $property->heating_type }}</span>
                                </li>
                                <li class="flex items-center justify-between border-b border-gray-100 pb-2">
                                    <span class="text-gray-600">{{ __('messages.Suelo') }}:</span>
                                    <span class="font-medium">{{ $property->flooring_type }}</span>
                                </li>
                                <li class="flex items-center justify-between border-b border-gray-100 pb-2">
                                    <span class="text-gray-600">{{ __('messages.Carpinterías interior') }}:</span>
                                    <span class="font-medium">{{ $property->interior_carpentry }}</span>
                                </li>
                                <li class="flex items-center justify-between border-b border-gray-100 pb-2">
                                    <span class="text-gray-600">{{ __('messages.Carpinterías exterior') }}:</span>
                                    <span class="font-medium">{{ $property->exterior_carpentry }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Fila adicional para Gastos y Google Maps -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                        <!-- Gastos -->
                        <div
                            class="bg-white shadow-md p-6 rounded-lg border-l-4 border-amber-500 hover:shadow-lg transition-shadow">
                            <h3 class="text-lg font-semibold text-amber-600 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ __('messages.Economía') }}
                            </h3>
                            <ul class="space-y-3">
                                <li class="flex items-center justify-between border-b border-gray-100 pb-2">
                                    <span class="text-gray-600">{{ __('messages.Precio') }}:</span>
                                    <span
                                        class="font-medium text-amber-600">€{{ number_format($property->price, 0, ',', '.') }}</span>
                                </li>
                                @if ($property->community_expenses)
                                    <li class="flex items-center justify-between border-b border-gray-100 pb-2">
                                        <span class="text-gray-600">{{ __('messages.Gastos comunidad') }}:</span>
                                        <span
                                            class="font-medium">€{{ number_format($property->community_expenses, 0, ',', '.') }}/mes</span>
                                    </li>
                                @endif
                                <li class="flex items-center justify-between border-b border-gray-100 pb-2">
                                    <span class="text-gray-600">{{ __('messages.Precio/m²') }}:</span>
                                    <span
                                        class="font-medium">€{{ number_format($property->price / $property->built_area, 0, ',', '.') }}/m²</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Ubicación -->
                        @if ($property->google_map)
                            <div
                                class="bg-white shadow-md p-6 rounded-lg border-l-4 border-amber-500 hover:shadow-lg transition-shadow">
                                <h3 class="text-lg font-semibold text-amber-600 mb-4 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ __('messages.Ubicación') }}
                                </h3>
                                <div class="aspect-video w-full rounded-lg overflow-hidden">
                                    <iframe src="{{ $property->google_map }}" width="100%" height="100%"
                                        style="border:0;" allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade" class="rounded-lg"></iframe>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Columna de Contacto --}}
            <div>
                <div class="bg-white shadow-lg rounded-lg p-6 sticky top-24">
                    <h3 class="text-2xl font-luxury text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-amber-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('messages.Contacta con nosotros') }}
                    </h3>
                    <p class="text-gray-600 mb-4">
                        {{ __('messages.Solicita más información sobre esta propiedad. Te responderemos a la mayor brevedad posible') }}.
                    </p>
                    <form class="space-y-4">
                        @csrf
                        <input type="hidden" name="property_id" value="{{ $property->id }}">
                        <div>
                            <label for="name"
                                class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.contact_form_name') }}</label>
                            <input type="text" id="name" name="name"
                                placeholder="{{ __('messages.contact_form_name_placeholder') }}"
                                class="w-full border-gray-300 rounded-md focus:ring-amber-500 focus:border-amber-500"
                                required>
                        </div>
                        <div>
                            <label for="email"
                                class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.contact_form_email') }}</label>
                            <input type="email" id="email" name="email"
                                placeholder="{{ __('messages.contact_form_email_placeholder') }}"
                                class="w-full border-gray-300 rounded-md focus:ring-amber-500 focus:border-amber-500"
                                required>
                        </div>
                        <div>
                            <label for="phone"
                                class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.Teléfono (opcional)') }}</label>
                            <input type="tel" id="phone" name="phone" placeholder="+34 600 000 000"
                                class="w-full border-gray-300 rounded-md focus:ring-amber-500 focus:border-amber-500">
                        </div>
                        <div>
                            <label for="message"
                                class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.contact_form_message_error') }}</label>
                            <textarea id="message" name="message" rows="4"
                                placeholder="{{ __('messages.Me interesa esta propiedad. Quisiera recibir más información') }}..."
                                class="w-full border-gray-300 rounded-md focus:ring-amber-500 focus:border-amber-500" required></textarea>
                        </div>
                        <div class="flex items-center">
                            <input id="privacy" name="privacy" type="checkbox"
                                class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded" required>
                            <label for="privacy" class="ml-2 block text-sm text-gray-700">
                                {!! __('messages.acepto_politica') !!}
                            </label>

                        </div>
                        <button type="submit"
                            class="w-full bg-amber-500 text-white py-3 rounded-md hover:bg-amber-600 transition-colors flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            {{ __('messages.contact_form_submit') }}
                        </button>
                    </form>
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex items-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500 mr-2"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class="font-medium text-gray-800">+34 900 000 000</span>
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500 mr-2"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="font-medium text-gray-800">info@inmobiliaria.com</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Propiedades Relacionadas --}}
        <div class="mb-12">
            <h2 class="text-3xl font-luxury text-gray-800 mb-8 text-center">{{ __('messages.Propiedades Similares') }}
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @foreach ($rel_properties as $relProperty)
                    <div
                        class="group relative overflow-hidden rounded-sm h-96 cursor-pointer shadow-xl transform transition-all duration-500 hover:shadow-2xl hover:-translate-y-1">
                        <div class="absolute inset-0 overflow-hidden">
                            <img src="/storage/{{ $relProperty->firstImage->thumbnail_path }}"
                                alt="{{ $relProperty->title }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        </div>
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent opacity-70 transition-opacity duration-500 group-hover:opacity-90">
                        </div>
                        <div
                            class="absolute bottom-0 left-0 right-0 h-0.5 bg-amber-300 transform scale-x-0 origin-left transition-transform duration-500 group-hover:scale-x-100">
                        </div>
                        <div
                            class="absolute bottom-0 left-0 p-8 transform transition-transform duration-500 group-hover:translate-y-0">
                            <div class="transition-all duration-500 transform group-hover:-translate-y-2">
                                <h3
                                    class="text-xl font-luxury text-white mb-1 group-hover:text-amber-300 transition-colors duration-300">
                                    {{ $relProperty->title }}
                                </h3>
                                <p
                                    class="text-sm text-gray-300 transition-all duration-500 opacity-80 group-hover:opacity-100">
                                    {{ $relProperty->propertyType->name }}
                                </p>
                            </div>
                            <div
                                class="overflow-hidden h-0 opacity-0 transition-all duration-500 group-hover:h-16 group-hover:opacity-100 mt-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-amber-300 text-xl font-bold">
                                        €{{ number_format($relProperty->price, 0, ',', '.') }}
                                    </span>
                                    <a href="{{ route('prop.show', ['locale' => app()->getLocale(), 'slug' => $relProperty->slug]) }}"
                                        class="inline-flex items-center text-amber-300 text-xs uppercase tracking-widest luxury-nav">
                                        {{ __('messages.discover') }}
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
        </div>
    </div>


</x-public-layout>
