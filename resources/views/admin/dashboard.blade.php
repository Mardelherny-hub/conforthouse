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
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-indigo-100 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Propiedades</p>
                            <p class="text-2xl font-semibold">{{ \App\Models\Property::count() ?? '0' }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Disponibles</p>
                            <p class="text-2xl font-semibold">0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Reservados</p>
                            <p class="text-2xl font-semibold">0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Atención</p>
                            <p class="text-2xl font-semibold">0</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Módulos principales -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Propiedades -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Propiedades</h3>
                            <a href="{{ route('admin.properties.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">Ver todas</a>
                        </div>
                        <div class="flex flex-col space-y-4">
                            <a href="{{ route('admin.properties.index') }}" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="p-2 rounded-md bg-indigo-100 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="block font-medium">Añadir Nueva Propiedad</span>
                                    <span class="text-sm text-gray-500">Registrar nueva propiedad en el sistema</span>
                                </div>
                            </a>
                            <a href="{{ route('admin.properties.index') }}" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="p-2 rounded-md bg-indigo-100 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="block font-medium">Gestionar Propiedades</span>
                                    <span class="text-sm text-gray-500">Editar y administrar propiedades existentes</span>
                                </div>
                            </a>
                            <a href="#" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="p-2 rounded-md bg-indigo-100 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="block font-medium">Estadísticas</span>
                                    <span class="text-sm text-gray-500">Ver informes y estadísticas</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Clientes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Clientes</h3>
                            <a href="#" class="text-sm text-indigo-600 hover:text-indigo-900">Ver todos</a>
                        </div>
                        <div class="flex flex-col space-y-4">
                            <a href="#" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="p-2 rounded-md bg-green-100 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="block font-medium">Registrar Cliente</span>
                                    <span class="text-sm text-gray-500">Añadir nuevo cliente al sistema</span>
                                </div>
                            </a>
                            <a href="#" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="p-2 rounded-md bg-green-100 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="block font-medium">Gestionar Clientes</span>
                                    <span class="text-sm text-gray-500">Ver y editar información de clientes</span>
                                </div>
                            </a>
                            <a href="#" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="p-2 rounded-md bg-green-100 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="block font-medium">Contratos</span>
                                    <span class="text-sm text-gray-500">Gestionar contratos de clientes</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Finanzas -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Finanzas</h3>
                            <a href="#" class="text-sm text-indigo-600 hover:text-indigo-900">Ver todas</a>
                        </div>
                        <div class="flex flex-col space-y-4">
                            <a href="#" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="p-2 rounded-md bg-blue-100 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="block font-medium">Registrar Pago</span>
                                    <span class="text-sm text-gray-500">Añadir nuevo pago al sistema</span>
                                </div>
                            </a>
                            <a href="#" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="p-2 rounded-md bg-blue-100 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="block font-medium">Informes Financieros</span>
                                    <span class="text-sm text-gray-500">Ver informes de ingresos y gastos</span>
                                </div>
                            </a>
                            <a href="#" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="p-2 rounded-md bg-blue-100 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="block font-medium">Proyecciones</span>
                                    <span class="text-sm text-gray-500">Análisis de futuras ganancias</span>
                                </div>
                            </a>
                        </div>
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
                            <!-- Actividad 1 -->
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Nueva propiedad añadida: Apartamento en Centro</p>
                                    <p class="text-sm text-gray-500">Hace 2 horas</p>
                                </div>
                            </div>

                            <!-- Actividad 2 -->
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <div class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Pago recibido: Alquiler Villa Serena</p>
                                    <p class="text-sm text-gray-500">Ayer</p>
                                </div>
                            </div>

                            <!-- Actividad 3 -->
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <div class="h-8 w-8 rounded-full bg-yellow-500 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Contrato actualizado: Casa en Valle Verde</p>
                                    <p class="text-sm text-gray-500">Hace 2 días</p>
                                </div>
                            </div>

                            <!-- Actividad 4 -->
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <div class="h-8 w-8 rounded-full bg-red-500 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Incidencia: Reparación urgente en Edificio Playa</p>
                                    <p class="text-sm text-gray-500">Hace 3 días</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 text-right">
                            <a href="#" class="text-sm text-indigo-600 hover:text-indigo-900">Ver todo el historial →</a>
                        </div>
                    </div>
                </div>

                <!-- Enlaces rápidos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Acciones Rápidas</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('profile.edit') }}" class="group p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition flex flex-col items-center justify-center">
                                <div class="p-3 rounded-full bg-purple-100 mb-2 group-hover:bg-purple-200 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium">Mi Perfil</span>
                            </a>

                            <a href="#" class="group p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition flex flex-col items-center justify-center">
                                <div class="p-3 rounded-full bg-indigo-100 mb-2 group-hover:bg-indigo-200 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium">Calendario</span>
                            </a>

                            <a href="#" class="group p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition flex flex-col items-center justify-center">
                                <div class="p-3 rounded-full bg-green-100 mb-2 group-hover:bg-green-200 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium">Mensajes</span>
                            </a>

                            <a href="#" class="group p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition flex flex-col items-center justify-center">
                                <div class="p-3 rounded-full bg-red-100 mb-2 group-hover:bg-red-200 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium">Tareas</span>
                            </a>
                        </div>

                        <div class="mt-6">
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
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer de acciones generales -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Herramientas y Recursos</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <a href="#" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="p-2 rounded-md bg-orange-100 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <span class="block font-medium">Informes</span>
                                <span class="text-sm text-gray-500">Generar informes personalizados</span>
                            </div>
                        </a>

                        <a href="#" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="p-2 rounded-md bg-cyan-100 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cyan-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16l2.879-2.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <span class="block font-medium">Buscador Avanzado</span>
                                <span class="text-sm text-gray-500">Buscar en todos los registros</span>
                            </div>
                        </a>

                        <a href="#" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="p-2 rounded-md bg-pink-100 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <span class="block font-medium">Calendario</span>
                                <span class="text-sm text-gray-500">Ver y programar eventos</span>
                            </div>
                        </a>

                        <a href="#" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="p-2 rounded-md bg-purple-100 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <div>
                                <span class="block font-medium">Documentos</span>
                                <span class="text-sm text-gray-500">Gestionar documentación</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
