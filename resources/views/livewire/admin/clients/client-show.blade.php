<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Información Personal</h3>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm text-gray-500">Nombre</span>
                                <p class="text-gray-900 font-medium">{{ $client->name }}</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500">Email</span>
                                <p class="text-gray-900 font-medium">{{ $client->email }}</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500">Teléfono</span>
                                <p class="text-gray-900 font-medium">
                                    {{ $client->phone ?? 'No proporcionado' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Estado y Registro</h3>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm text-gray-500">Estado</span>
                                <p class="text-gray-900 font-medium">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $client->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $client->status ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500">Fecha de Registro</span>
                                <p class="text-gray-900 font-medium">
                                    {{ $client->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500">Última Actualización</span>
                                <p class="text-gray-900 font-medium">
                                    {{ $client->updated_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-4">
                    <a
                        href="{{ route('admin.clients.edit', $client->id) }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 disabled:opacity-25 transition"
                    >
                        Editar Cliente
                    </a>
                    <a
                        href="{{ route('admin.clients.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-300 focus:outline-none focus:border-gray-300 focus:ring focus:ring-gray-200 disabled:opacity-25 transition"
                    >
                        Volver a la Lista
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
