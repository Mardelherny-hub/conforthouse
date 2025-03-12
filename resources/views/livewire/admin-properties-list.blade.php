<div>
    <div class="py-6">
        <!-- Encabezado y acciones rápidas -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
                        Propiedades
                    </h2>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <a href="{{ route('admin.properties.create') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:shadow-outline-indigo focus:border-indigo-700 active:bg-indigo-700 transition duration-150 ease-in-out">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Nueva Propiedad
                    </a>
                </div>
            </div>
        </div>

        <!-- Filtros y búsqueda -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6 bg-white rounded-lg shadow p-4">
            <div class="md:flex md:items-center md:justify-between mb-4">
                <div class="flex-1 min-w-0">
                    <label for="search" class="sr-only">Buscar</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input wire:model.live.debounce.300ms="search" type="text" id="search"
                            class="form-input block w-full pl-10 sm:text-sm sm:leading-5"
                            placeholder="Buscar por título, referencia o dirección...">
                    </div>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-4 flex items-center space-x-2">
                    <select wire:model.live="perPage" class="form-select block w-full sm:text-sm sm:leading-5">
                        <option value="10">10 por página</option>
                        <option value="25">25 por página</option>
                        <option value="50">50 por página</option>
                        <option value="100">100 por página</option>
                    </select>
                </div>
            </div>

            <div x-data="{ open: false }" class="mb-4">
                <button @click="open = !open" type="button"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Filtros
                    <svg x-show="!open" class="ml-2 -mr-0.5 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <svg x-show="open" class="ml-2 -mr-0.5 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>

                <div x-show="open" class="mt-4 grid grid-cols-1 gap-y-4 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                        <select wire:model.live="filters.status" id="status"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">Todos</option>
                            <option value="active">Activa</option>
                            <option value="inactive">Inactiva</option>
                            <option value="sold">Vendida</option>
                            <option value="rented">Alquilada</option>
                        </select>
                    </div>

                    <div>
                        <label for="property_type" class="block text-sm font-medium text-gray-700">Tipo de
                            propiedad</label>
                        <select wire:model.live="filters.property_type" id="property_type"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">Todos</option>
                            <option value="apartment">Apartamento</option>
                            <option value="house">Casa</option>
                            <option value="land">Terreno</option>
                            <option value="commercial">Local Comercial</option>
                        </select>
                    </div>

                    <div>
                        <label for="min_price" class="block text-sm font-medium text-gray-700">Precio mínimo</label>
                        <input wire:model.live.debounce.500ms="filters.min_price" type="number" id="min_price"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div>
                        <label for="max_price" class="block text-sm font-medium text-gray-700">Precio máximo</label>
                        <input wire:model.live.debounce.500ms="filters.max_price" type="number" id="max_price"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>

                <div x-show="open" class="mt-4 flex justify-end">
                    <button wire:click="resetFilters" type="button"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                        Limpiar filtros
                    </button>
                </div>
            </div>
        </div>

        <!-- Mensaje de notificación -->
        @if (session()->has('message'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert">
                    <p class="font-medium">{{ session('message') }}</p>
                </div>
            </div>
        @endif

        <!-- Tabla de propiedades -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            <div class="flex items-center cursor-pointer" wire:click="sortBy('id')">
                                                ID
                                                @if ($sortField === 'id')
                                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        @if ($sortDirection === 'asc')
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                        @else
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                        @endif
                                                    </svg>
                                                @endif
                                            </div>
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            <div class="flex items-center cursor-pointer"
                                                wire:click="sortBy('title')">
                                                Título
                                                @if ($sortField === 'title')
                                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        @if ($sortDirection === 'asc')
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                        @else
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                        @endif
                                                    </svg>
                                                @endif
                                            </div>
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            <div class="flex items-center cursor-pointer"
                                                wire:click="sortBy('reference')">
                                                Referencia
                                                @if ($sortField === 'reference')
                                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        @if ($sortDirection === 'asc')
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                        @else
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                        @endif
                                                    </svg>
                                                @endif
                                            </div>
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            <div class="flex items-center cursor-pointer"
                                                wire:click="sortBy('price')">
                                                Precio
                                                @if ($sortField === 'price')
                                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        @if ($sortDirection === 'asc')
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                        @else
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                        @endif
                                                    </svg>
                                                @endif
                                            </div>
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            <div class="flex items-center cursor-pointer"
                                                wire:click="sortBy('property_type')">
                                                Tipo
                                                @if ($sortField === 'property_type')
                                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        @if ($sortDirection === 'asc')
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                        @else
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                        @endif
                                                    </svg>
                                                @endif
                                            </div>
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            <div class="flex items-center cursor-pointer"
                                                wire:click="sortBy('status')">
                                                Estado
                                                @if ($sortField === 'status')
                                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        @if ($sortDirection === 'asc')
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                        @else
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                        @endif
                                                    </svg>
                                                @endif
                                            </div>
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            <div class="flex items-center cursor-pointer"
                                                wire:click="sortBy('created_at')">
                                                Fecha
                                                @if ($sortField === 'created_at')
                                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        @if ($sortDirection === 'asc')
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                        @else
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                        @endif
                                                    </svg>
                                                @endif
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-3 bg-gray-50"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($properties as $property)
                                        <tr>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm leading-5 font-medium text-gray-900">
                                                {{ $property->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm leading-5 text-gray-900">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        @if ($property->images->isNotEmpty())
                                                            <img class="h-10 w-10 rounded-md object-cover"
                                                                src="{{ $property->images->first()->image_path }}"
                                                                alt="{{ $property->title }}">
                                                        @else
                                                            <div
                                                                class="h-10 w-10 rounded-md bg-gray-200 flex items-center justify-center">
                                                                <svg class="h-6 w-6 text-gray-400" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                                                    </path>
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                </svg>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm leading-5 font-medium text-gray-900">
                                                            {{ $property->title }}</div>
                                                        <div class="text-sm leading-5 text-gray-500">
                                                            {{ $property->address->street ?? 'Sin dirección' }}
                                                            {{ $property->address->number ?? '' }}
                                                            {{ $property->address->floor ?? '' }}
                                                            {{ $property->address->door ?? '' }}
                                                        </div>
                                                        <div class="text-sm leading-5 text-gray-500">
                                                            {{ $property->address->city ?? '' }}
                                                            {{ $property->address->state ?? '' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm leading-5 text-gray-500">
                                                {{ $property->reference }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm leading-5 text-gray-500">
                                                ${{ number_format($property->price, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm leading-5 text-gray-500">
                                                {{ $property->propertyType->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm leading-5 text-gray-500">
                                                {{ $property->status->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm leading-5 text-gray-500">
                                                {{ $property->created_at->format('d/m/Y') }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-right text-sm leading-5 font-medium">
                                                <div class="flex items-center justify-end space-x-3">
                                                    <a href="{{ route('admin.properties.show', $property) }}"
                                                        class="text-indigo-600 hover:text-indigo-900"
                                                        title="Ver detalles">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                            </path>
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                            </path>
                                                        </svg>
                                                    </a>
                                                    <a href="{{ route('admin.properties.edit', $property) }}"
                                                        class="text-indigo-600 hover:text-indigo-900" title="Editar">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                            </path>
                                                        </svg>
                                                    </a>
                                                    <button
                                                        wire:click="$emit('deletePropertyConfirm', {{ $property->id }})"
                                                        class="text-red-600 hover:text-red-900" title="Eliminar">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8"
                                                class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                                No hay propiedades disponibles
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
