<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Administrar Características de Propiedades
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mb-4">
            <!-- Componente de Estados-->
            <livewire:admin.caracteristics.statuses />
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Componente de Operaciones-->
            <livewire:admin.caracteristics.operations />

        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Componente de Tipos de Propiedad-->
            <livewire:admin.caracteristics.types />
        </div>
    </div>
</x-app-layout>

