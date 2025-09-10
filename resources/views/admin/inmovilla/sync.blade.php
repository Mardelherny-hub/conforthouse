<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🏠 {{ __('Sincronización Masiva Inmovilla') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    
                    <!-- Estado de servicios -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-blue-800 mb-3">🔍 Estado de Servicios</h3>
                            <button id="checkServicesBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm mb-3">
                                Verificar Servicios
                            </button>
                            <div id="servicesStatus" class="text-sm text-gray-600">
                                <p>Haga clic para verificar servicios</p>
                            </div>
                        </div>
                        
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-green-800 mb-3">📊 Estadísticas Actuales</h3>
                            <div class="text-sm space-y-1">
                                <p><strong>Total Propiedades:</strong> {{ number_format($stats['total_properties']) }}</p>
                                <p><strong>Con Traducciones:</strong> {{ number_format($stats['properties_with_translations']) }}</p>
                                <p><strong>Sin Traducciones:</strong> {{ number_format($stats['total_properties'] - $stats['properties_with_translations']) }}</p>
                                @if($stats['last_sync'])
                                    <p><strong>Última Sync:</strong> {{ $stats['last_sync']->format('d/m/Y H:i') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Formulario de sincronización -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold text-yellow-800 mb-4">🚀 Carga Masiva de Propiedades</h3>
                        
                        <form id="syncForm">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label for="limit" class="block text-sm font-medium text-gray-700 mb-1">Límite de propiedades</label>
                                    <input type="number" id="limit" name="limit" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                           placeholder="0 = sin límite" min="0" max="1000">
                                    <p class="mt-1 text-xs text-gray-500">Máximo 1000 por ejecución</p>
                                </div>
                                
                                <div>
                                    <label for="batch_size" class="block text-sm font-medium text-gray-700 mb-1">Tamaño de lote</label>
                                    <input type="number" id="batch_size" name="batch_size" value="50"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                           min="10" max="100">
                                    <p class="mt-1 text-xs text-gray-500">Propiedades por lote</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">&nbsp;</label>
                                    <div class="flex items-center mt-2">
                                        <input type="checkbox" id="skip_translation" name="skip_translation" checked
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <label for="skip_translation" class="ml-2 text-sm text-gray-700">
                                            Omitir traducción automática
                                        </label>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Recomendado en servidor producción</p>
                                </div>
                            </div>
                            
                            <div class="flex space-x-4">
                                <button type="submit" id="startSyncBtn" 
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg">
                                    🚀 Iniciar Sincronización
                                </button>
                                <button type="button" id="translateOnlyBtn" 
                                        class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg">
                                    🔤 Solo Traducir Existentes
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Progreso -->
                    <div id="progressSection" class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6" style="display: none;">
                        <h3 class="text-lg font-semibold text-blue-800 mb-4">📈 Progreso</h3>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                            <div id="progressBar" class="bg-blue-600 h-2.5 rounded-full transition-all duration-300" style="width: 0%"></div>
                        </div>
                        <div id="progressMessage" class="text-sm text-gray-700 mb-2">Preparando...</div>
                        <div id="progressDetails" class="text-xs text-gray-500"></div>
                    </div>

                    <!-- Resultados -->
                    <div id="resultsSection" class="bg-green-50 border border-green-200 rounded-lg p-6" style="display: none;">
                        <h3 class="text-lg font-semibold text-green-800 mb-4">✅ Resultados</h3>
                        <div id="resultsContent"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Script cargado');
        
        let isRunning = false;
        let progressInterval;

        // Verificar servicios
        document.getElementById('checkServicesBtn').addEventListener('click', function() {
            console.log('Verificando servicios...');
            
            const btn = this;
            btn.disabled = true;
            btn.textContent = 'Verificando...';
            
            fetch('{{ route("admin.inmovilla.sync.check-services") }}', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
})
.then(response => {
    console.log('Status:', response.status);
    return response.text();
})
.then(data => {
    console.log('Respuesta completa:', data);
    document.getElementById('servicesStatus').innerHTML = '<pre>' + data + '</pre>';
})
.catch(error => {
    console.error('Error:', error);
    document.getElementById('servicesStatus').innerHTML = '<p class="text-red-600">Error: ' + error.message + '</p>';
})
            .finally(() => {
                btn.disabled = false;
                btn.textContent = 'Verificar Servicios';
            });
        });

        // Auto-verificar al cargar
        document.getElementById('checkServicesBtn').click();
    });
    </script>
</x-app-layout>