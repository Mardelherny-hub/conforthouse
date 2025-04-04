<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Administrar Propiedades
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- agregar componente livewire AdminPropertiesList -->
            <livewire:admin-properties-list :properties="$properties" />
        </div>
    </div>
</x-app-layout>
