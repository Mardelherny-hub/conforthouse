<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Editar Usuario
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white p-6 rounded shadow-sm">
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PUT')

                    {{-- Nombre --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                               class="mt-1 block w-full border-gray-300 rounded shadow-sm" />
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                               class="mt-1 block w-full border-gray-300 rounded shadow-sm" />
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Roles --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Roles</label>
                        <select name="roles[]" multiple
                                class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ $user->roles->pluck('id')->contains($role->id) ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('roles')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Permisos agrupados --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @php
                            $groupedPermissions = [
                                'Propiedades' => ['ver propiedades', 'crear propiedades', 'editar propiedades', 'eliminar propiedades'],
                                'Características' => ['ver características', 'crear características', 'editar características', 'eliminar características'],
                                'Clientes' => ['ver clientes', 'crear clientes', 'editar clientes', 'eliminar clientes'],
                                'Usuarios' => ['ver usuarios', 'crear usuarios', 'editar usuarios', 'eliminar usuarios'],
                                'Traducciones' => ['ver traducciones', 'editar traducciones'],
                                'Solicitudes' => ['ver solicitudes', 'responder solicitudes', 'eliminar solicitudes'],
                            ];
                        @endphp

                        @foreach ($groupedPermissions as $group => $groupPermissions)
                            <div>
                                <h3 class="text-lg font-semibold mb-2 border-b pb-1 text-gray-700">{{ $group }}</h3>
                                @foreach ($groupPermissions as $perm)
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="permissions[]" value="{{ $perm }}"
                                               {{ $user->hasPermissionTo($perm) ? 'checked' : '' }}
                                               class="mr-2 text-indigo-600 rounded border-gray-300">
                                        <label class="text-sm text-gray-700">{{ ucfirst($perm) }}</label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>

                    {{-- Botón Guardar --}}
                    <div class="mt-6">
                        <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Guardar cambios
                        </button>
                        <a href="{{ route('admin.users.index') }}"
                           class="ml-4 text-sm text-gray-600 hover:underline">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
