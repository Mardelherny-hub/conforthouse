<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Editar Cliente
            </h2>
            <a href="{{ route('admin.clients.show', $client->id) }}" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                Volver al Listado
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                <!-- agregar componente livewire ClientEdit-->
                <livewire:admin.clients.client-edit :client="$client" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
