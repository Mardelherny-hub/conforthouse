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


                         <!-- Información básica -->
                        <div id="basic-info-panel" class="mb-6">
                            <livewire:admin.properties.basic-info-form :property="$property" />
                        </div>

                        <!-- Ubicación -->
                        <div id="basic-info-panel" class="mb-6">
                            <livewire:admin.properties.location-form :property="$property" />
                        </div>

                        <!-- Características principales -->
                        <div id="main-features-panel" class="mb-6">
                            <livewire:admin.properties.main-features-form :property="$property" />
                        </div>

                        <!-- Características adicionales -->
                        <div id="aditional-features-panel" class="mb-6">
                            <livewire:admin.properties.additional-features-form :property="$property" />
                        </div>

                        <!-- Imágenes -->
                        <div class="mb-6">
                            <livewire:admin.properties.images-form :property="$property" />
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Agregamos JavaScript para sincronizar los valores -->

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('basic-info-updated', () => {
            const panel = document.querySelector('#basic-info-panel');
            if (panel) {
                panel.classList.add('bg-green-50');
                setTimeout(() => {
                    panel.classList.remove('bg-green-50');
                }, 2000);
            }
        });
    });
</script>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('location-updated', (event) => {
            const form = document.querySelector('form');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = event[0].type + '_id';
            input.value = event[0].value;

            const existingInput = form.querySelector(`input[name="${input.name}"]`);
            if (existingInput) {
                existingInput.remove();
            }

            form.appendChild(input);
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('main-features-updated', event => {
            // Opcional: agregar animación o efecto visual para confirmar actualización
            const panel = document.querySelector('#main-features-panel');
            if (panel) {
                panel.classList.add('bg-green-50');
                setTimeout(() => {
                    panel.classList.remove('bg-green-50');
                }, 1000);
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('additional-features-updated', event => {
            // Opcional: agregar animación o efecto visual para confirmar actualización
            const panel = document.querySelector('#aditional-features-panel');
            if (panel) {
                panel.classList.add('bg-green-50');
                setTimeout(() => {
                    panel.classList.remove('bg-green-50');
                }, 1000);
            }
        });
    });
    </script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('image-removed', (event) => {
                // Show success notification
                Toast.fire({
                    icon: 'success',
                    title: event.message
                });
            });

            Livewire.on('image-removal-failed', (event) => {
                // Show error notification
                Toast.fire({
                    icon: 'error',
                    title: event.message
                });
            });
        });
    </script>

@endpush
