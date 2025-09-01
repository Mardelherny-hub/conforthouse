<div class="bg-white p-6 rounded-lg shadow-md">
    <h3 class="text-xl font-semibold mb-4">Gestión de Tipos</h3>

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

    <!-- Crear nuevo tipo (solo visible en español) -->
    @if($locale === 'es')
        <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
            <h4 class="text-lg font-medium mb-3 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Crear Nuevo Tipo
            </h4>
            <form wire:submit.prevent="store" class="flex flex-col gap-3">
                <div>
                    <label for="new-type-name" class="block text-sm font-medium text-gray-700 mb-1">Nombre del tipo:</label>
                    <input
                        id="new-type-name"
                        type="text"
                        wire:model.blur="name"
                        placeholder="Ej: Casa, Departamento, Loft..."
                        class="w-full border border-gray-300 p-2 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    >
                    @error('name') <span class="text-red-500 text-sm block mt-1">{{ $message }}</span> @enderror
                </div>
                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Crear Tipo
                    </button>
                </div>
                <p class="text-xs text-gray-500 mt-1">
                    Al crear un tipo en español, se generarán automáticamente traducciones para inglés, francés y alemán.
                </p>
            </form>
        </div>
    @endif

    <!-- Búsqueda -->
    <div class="mb-4">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </div>
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Buscar tipos..."
                class="w-full border border-gray-300 p-2 pl-10 rounded-lg"
            >
        </div>
    </div>

    <!-- Tabla -->
    <div class="overflow-x-auto rounded-lg border border-gray-300">
        <table class="w-full bg-white">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-3 border-b">ID</th>
                    <th class="px-4 py-3 border-b">Nombre</th>
                    <th class="px-4 py-3 border-b">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($typesList as $type)
                    <tr class="hover:bg-gray-50 {{ $editingTypeId === $type->id ? 'bg-blue-50' : '' }}">
                        <td class="px-4 py-3 border-b">{{ $type->id }}</td>
                        <td class="px-4 py-3 border-b">
                            {{ $type->translations->first()?->name ?? 'Sin traducción' }}
                        </td>
                        <td class="px-4 py-3 border-b">
                            <div class="flex gap-2">
                                <button
                                    wire:click="toggleEdit({{ $type->id }})"
                                    class="{{ $editingTypeId === $type->id ? 'bg-gray-500' : 'bg-amber-500 hover:bg-amber-600' }} text-white px-2 py-1 rounded transition flex items-center"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                    {{ $editingTypeId === $type->id ? 'Cancelar' : 'Editar' }}
                                </button>
                                <button
                                    wire:click="confirmDelete({{ $type->id }})"
                                    class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded transition flex items-center"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                    Eliminar
                                </button>
                            </div>
                        </td>
                    </tr>
                    <!-- Formulario de edición inline -->
                    @if($editingTypeId === $type->id)
                        <tr class="bg-blue-50">
                            <td colspan="3" class="px-4 py-3 border-b">
                                <form wire:submit.prevent="update" class="w-full">
                                    <div class="flex flex-col gap-3">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Editar nombre ({{ strtoupper($locale) }}):
                                            </label>
                                            <div class="flex gap-2">
                                                <input
                                                    type="text"
                                                    wire:model.blur="name"
                                                    class="flex-1 border border-gray-300 p-2 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                                >
                                                <button
                                                    type="submit"
                                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition flex items-center"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                    </svg>
                                                    Guardar
                                                </button>
                                            </div>
                                            @error('name') <span class="text-red-500 text-sm block mt-1">{{ $message }}</span> @enderror
                                        </div>

                                        @if($locale === 'es')
                                            <p class="text-xs text-gray-500 mt-1">
                                                Al actualizar en español, se actualizarán automáticamente las traducciones para inglés, francés y alemán.
                                            </p>
                                        @endif
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-3 text-center text-gray-500">
                            No se encontraron tipos
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-4">
        {{ $typesList->links() }}
    </div>

    <!-- Modal de confirmación para eliminar -->
    @if($confirmingDelete)
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full">
            <h3 class="text-lg font-semibold mb-4">Confirmar eliminación</h3>
            <p class="mb-6">¿Estás seguro que deseas eliminar este tipo? Esta acción no se puede deshacer.</p>
            <div class="flex justify-end gap-2">
                <button
                    wire:click="cancelDelete"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition"
                >
                    Cancelar
                </button>
                <button
                    wire:click="delete"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded transition"
                >
                    Eliminar
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Notificaciones -->
    <div
        x-data="{ show: false, message: '' }"
        x-on:type-saved.window="show = true; message = $event.detail; setTimeout(() => show = false, 3000)"
        x-on:type-updated.window="show = true; message = $event.detail; setTimeout(() => show = false, 3000)"
        x-on:type-deleted.window="show = true; message = $event.detail; setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition
        class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded shadow-lg"
        style="display: none;"
    >
        <p x-text="message"></p>
    </div>
</div>
