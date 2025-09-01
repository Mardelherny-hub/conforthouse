<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Administrar Usuarios
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow-sm rounded p-6">
                <h3 class="text-xl font-semibold mb-4">Listado de usuarios</h3>

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Nombre</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Email</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Roles</th>
                                <th class="px-4 py-2 text-right text-sm font-medium text-gray-500">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($users as $user)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-800">{{ $user->name }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $user->email }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">
                                        @foreach ($user->roles as $role)
                                            <span class="inline-block bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs">
                                                {{ ucfirst($role->name) }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                           class="inline-block bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm">
                                            Editar
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('¿Enviar este usuario a la papelera?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm px-3 py-1 rounded">
                                                Enviar a Papelera
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                                        No se encontraron usuarios.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
