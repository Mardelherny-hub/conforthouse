<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel de Administración
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Resumen de estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

                <!-- Total de propiedades -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-indigo-100 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Propiedades</p>
                            <p class="text-2xl font-semibold">{{ $totalProperties }}</p>
                        </div>
                    </div>
                </div>

                <!-- Propiedades disponibles -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Disponibles</p>
                            <p class="text-2xl font-semibold">{{ $availableProperties }}</p>
                        </div>
                    </div>
                </div>

                <!-- Propiedades reservadas -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Reservados</p>
                            <p class="text-2xl font-semibold">{{ $reservedProperties }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total de clientes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A9 9 0 1118.88 6.196 9 9 0 015.12 17.804z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Clientes</p>
                            <p class="text-2xl font-semibold">{{ $totalClients }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Grid de módulos principales --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                {{-- Propiedades --}}
                <div class="bg-white overflow-hidden rounded-2xl shadow p-6">
                    <div class="flex items-center gap-3 mb-4">
                        {{-- Icono de propiedades --}}
                        <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" stroke-width="1.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 12l9-9 9 9M4 10v10h5v-6h6v6h5V10" />
                        </svg>
                        <h2 class="text-lg font-semibold text-gray-700">Propiedades</h2>
                    </div>
                    <div class="flex flex-col space-y-4">
                        <a href="{{ route('admin.properties.create') }}"
                            class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="p-2 rounded-md bg-indigo-100 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <div>
                                <span class="block font-medium">Añadir Nueva Propiedad</span>
                                <span class="text-sm text-gray-500">Registrar nueva propiedad en el sistema</span>
                            </div>
                        </a>
                        <a href="{{ route('admin.properties.index') }}"
                            class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="p-2 rounded-md bg-indigo-100 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                            </div>
                            <div>
                                <span class="block font-medium">Gestionar Propiedades</span>
                                <span class="text-sm text-gray-500">Administrar propiedades
                                    existentes</span>
                            </div>
                        </a>
                        <a x-data="{ showModal: false }" @open-future-modal.window="showModal = true"
                            @keydown.escape.window="showModal = false"
                            class="flex items-center bg-gray-50 rounded-lg hover:bg-gray-100 transition ">
                            <button @click="$dispatch('open-future-modal')"
                                class="flex items-center text-left p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="p-2 rounded-md bg-indigo-100 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-300"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="block font-medium text-gray-400">Estadísticas</span>
                                    <span class="text-sm text-gray-400">Ver informes y estadíticas</span>
                                </div>
                            </button>
                        </a>
                    </div>
                </div>

                {{-- Clientes --}}
                <div class="bg-white rounded-2xl shadow p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="1.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5.121 17.804A4 4 0 0110 20h4a4 4 0 014.879-2.196M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <h2 class="text-lg font-semibold text-gray-700">Clientes</h2>
                    </div>
                    <div class="flex flex-col space-y-4">
                        <a href="{{ route('admin.clients.create') }}"
                            class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="p-2 rounded-md bg-green-100 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <div>
                                <span class="block font-medium">Registrar Cliente</span>
                                <span class="text-sm text-gray-500">Agregar nuevo cliente al sistema</span>
                            </div>
                        </a>
                        <a href="{{ route('admin.clients.index') }}"
                            class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="p-2 rounded-md bg-green-100 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <span class="block font-medium">Gestionar Clientes</span>
                                <span class="text-sm text-gray-500">Ver y editar información de clientes</span>
                            </div>
                        </a>
                        <a x-data="{ showModal: false }" @open-future-modal.window="showModal = true"
                            @keydown.escape.window="showModal = false"
                            class="flex items-center bg-gray-50 rounded-lg hover:bg-gray-100 transition ">
                            <button @click="$dispatch('open-future-modal')"
                                class="flex items-center text-left p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="p-2 rounded-md bg-green-100 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-300"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="block font-medium text-gray-400">Contratos</span>
                                    <span class="text-sm text-gray-400">Gestionar contratos de clientes</span>
                                </div>
                            </button>
                        </a>
                    </div>

                </div>

                {{-- Finanzas --}}
                <div class="bg-white rounded-2xl shadow p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" stroke-width="1.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h2 class="text-lg font-semibold text-gray-700">Finanzas</h2>
                    </div>
                    <div class="flex flex-col space-y-4">
                        <a x-data="{ showModal: false }" @open-future-modal.window="showModal = true"
                            @keydown.escape.window="showModal = false"
                            class="flex items-center bg-gray-50 rounded-lg hover:bg-gray-100 transition ">
                            <button @click="$dispatch('open-future-modal')"
                                class="flex items-center text-left p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="p-2 rounded-md bg-yellow-100 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="block font-medium text-gray-400">Registrar Pago</span>
                                    <span class="text-sm text-gray-400">Añadir nuevo pago al sistema</span>
                                </div>
                            </button>
                        </a>
                        <a x-data="{ showModal: false }" @open-future-modal.window="showModal = true"
                            @keydown.escape.window="showModal = false"
                            class="flex items-center bg-gray-50 rounded-lg hover:bg-gray-100 transition ">
                            <button @click="$dispatch('open-future-modal')"
                                class="flex items-center text-left  p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="p-2 rounded-md bg-yellow-100 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="block font-medium text-gray-400">Informes Financieros</span>
                                    <span class="text-sm text-gray-400">Ver informes de ingresos y gastos</span>
                                </div>
                            </button>
                        </a>
                        <a x-data="{ showModal: false }" @open-future-modal.window="showModal = true"
                            @keydown.escape.window="showModal = false"
                            class="flex items-center bg-gray-50 rounded-lg hover:bg-gray-100 transition ">
                            <button @click="$dispatch('open-future-modal')"
                                class="flex items-center text-left p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="p-2 rounded-md bg-yellow-100 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="block font-medium text-gray-400">Proyecciones</span>
                                    <span class="text-sm text-gray-400">Análisis de futuras ganancias</span>
                                </div>
                            </button>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Actividad Reciente y Calendario -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Actividad Reciente -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Actividad Reciente</h3>
                        <div class="space-y-4">
                            @forelse($recentActivity as $activity)
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="h-8 w-8 rounded-full bg-{{ $activity['color'] }}-500 flex items-center justify-center">
                                            @switch($activity['icon'])
                                                @case('plus')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                    </svg>
                                                @break

                                                @case('user')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.799.755 6.879 2.043M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                @break

                                                @case('shield')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 2l8 4v5c0 5.25-3.75 10-8 11-4.25-1-8-5.75-8-11V6l8-4z" />
                                                    </svg>
                                                @break

                                                @default
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <circle cx="12" cy="12" r="10" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                            @endswitch
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">{{ $activity['message'] }}</p>
                                        <p class="text-sm text-gray-500">
                                            {{ $activity['created_at']->diffForHumans() }}</p>
                                    </div>
                                </div>
                                @empty
                                    <p class="text-sm text-gray-500">No hay actividad reciente.</p>
                                @endforelse
                            </div>

                            <div class="mt-4 text-right">
                                <a href="#" class="text-sm text-indigo-600 hover:text-indigo-900">Ver todo el
                                    historial →</a>
                            </div>
                        </div>
                    </div>


                    <!-- Enlaces rápidos -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Acciones Rápidas</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <a href="{{ route('profile.edit') }}"
                                    class="group p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition flex flex-col items-center justify-center">
                                    <div class="p-3 rounded-full bg-purple-100 mb-2 group-hover:bg-purple-200 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium">Mi Perfil</span>
                                </a>

                                <a x-data="{ showModal: false }" @open-future-modal.window="showModal = true"
                                    @keydown.escape.window="showModal = false"
                                    class="group p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition flex flex-col items-center justify-center">
                                    <button @click="$dispatch('open-future-modal')"
                                        class="group p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition flex flex-col items-center justify-center">
                                        <div
                                            class="p-3 rounded-full bg-indigo-100 mb-2 group-hover:bg-indigo-200 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-400">Calendario</span>
                                    </button>
                                </a>

                                <a x-data="{ showModal: false }" @open-future-modal.window="showModal = true"
                                    @keydown.escape.window="showModal = false"
                                    class="group p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition flex flex-col items-center justify-center">
                                    <button @click="$dispatch('open-future-modal')"
                                        class="group p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition flex flex-col items-center justify-center">
                                        <div
                                            class="p-3 rounded-full bg-green-100 mb-2 group-hover:bg-green-200 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-400">Mensajes</span>
                                    </button>
                                </a>

                                <a x-data="{ showModal: false }" @open-future-modal.window="showModal = true"
                                    @keydown.escape.window="showModal = false"
                                    class="group p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition flex flex-col items-center justify-center">
                                    <button @click="$dispatch('open-future-modal')"
                                        class="group p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition flex flex-col items-center justify-center">
                                        <div class="p-3 rounded-full bg-red-100 mb-2 group-hover:bg-red-200 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-400">Tareas</span>
                                    </button>
                                </a>

                            </div>

                            {{--  <div class="mt-6">
                                <h4 class="text-sm font-medium text-gray-700 mb-3">Próximas Citas</h4>
                                <div class="space-y-3">
                                    <div class="flex justify-between p-3 bg-gray-50 rounded-lg">
                                        <div>
                                            <p class="text-sm font-medium">Visita cliente: Eva González</p>
                                            <p class="text-xs text-gray-500">Apartamento Centro</p>
                                        </div>
                                        <div class="text-sm text-indigo-600">Hoy, 15:30</div>
                                    </div>
                                    <div class="flex justify-between p-3 bg-gray-50 rounded-lg">
                                        <div>
                                            <p class="text-sm font-medium">Firma contrato: Carlos Ruiz</p>
                                            <p class="text-xs text-gray-500">Casa en Valle Verde</p>
                                        </div>
                                        <div class="text-sm text-indigo-600">Mañana, 11:00</div>
                                    </div>
                                    <div class="flex justify-between p-3 bg-gray-50 rounded-lg">
                                        <div>
                                            <p class="text-sm font-medium">Inspección: Edificio Marina</p>
                                            <p class="text-xs text-gray-500">Mantenimiento anual</p>
                                        </div>
                                        <div class="text-sm text-indigo-600">Viernes, 09:15</div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>

                <!-- Footer de acciones generales -->
                <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Herramientas y Recursos</h3>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <a x-data="{ showModal: false }" @open-future-modal.window="showModal = true"
                                @keydown.escape.window="showModal = false"
                                class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <button @click="$dispatch('open-future-modal')"
                                    class="flex items-center text-left p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                    <div class="p-2 rounded-md bg-orange-100 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="block font-medium text-gray-400">Informes</span>
                                        <span class="text-sm text-gray-300">Informes personalizados</span>
                                    </div>
                                </button>
                            </a>

                            <a x-data="{ showModal: false }" @open-future-modal.window="showModal = true"
                                @keydown.escape.window="showModal = false"
                                class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <button @click="$dispatch('open-future-modal')"
                                    class="flex items-center text-left p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                    <div class="p-2 rounded-md bg-cyan-100 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cyan-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 16l2.879-2.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="block font-medium text-gray-400">Buscador Avanzado</span>
                                        <span class="text-sm text-gray-300">Buscar en todos los registros</span>
                                    </div>
                                </button>
                            </a>

                            <a x-data="{ showModal: false }" @open-future-modal.window="showModal = true"
                                @keydown.escape.window="showModal = false"
                                class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <button @click="$dispatch('open-future-modal')"
                                    class="flex items-center text-left p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                    <div class="p-2 rounded-md bg-pink-100 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="block font-medium text-gray-400">Calendario</span>
                                        <span class="text-sm text-gray-300">Ver y programar eventos</span>
                                    </div>
                                </button>
                            </a>

                            <a x-data="{ showModal: false }" @open-future-modal.window="showModal = true"
                                @keydown.escape.window="showModal = false"
                                class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <button @click="$dispatch('open-future-modal')"
                                    class="flex items-center text-left p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                    <div class="p-2 rounded-md bg-purple-100 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="block font-medium text-gray-400">Documentos</span>
                                        <span class="text-sm text-gray-300">Gestionar documentación</span>
                                    </div>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Modal informativo sobre módulos futuros --}}
            <div x-data="{ open: false }" x-show="open" @open-future-modal.window="open = true"
                @keydown.escape.window="open = false"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display: none;"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <div @click.away="open = false" class="bg-white rounded-xl shadow-lg p-6 max-w-sm w-full mx-4"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="transform scale-95 opacity-0"
                    x-transition:enter-end="transform scale-100 opacity-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="transform scale-100 opacity-100"
                    x-transition:leave-end="transform scale-95 opacity-0">

                    <div class="text-center mb-5">
                        <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-blue-50 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800">Funcionalidad disponible próximamente</h2>
                    </div>

                    <p class="text-gray-600 text-center mb-5">
                        Este módulo forma parte de las próximas actualizaciones de la plataforma, diseñadas para ampliar y
                        mejorar la gestión inmobiliaria.
                    </p>

                    <div class="bg-blue-50 p-3 rounded-lg mb-5">
                        <p class="text-blue-700 text-sm text-center">
                            ¿Te gustaría acceder a esta funcionalidad? Podemos priorizarla para tu negocio.
                        </p>
                    </div>

                    <div class="flex justify-center space-x-3">
                        <button @click="open = false"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                            Volver
                        </button>
                    </div>
                </div>
            </div>
        </div>



    </x-app-layout>
