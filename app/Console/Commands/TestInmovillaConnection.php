<?php

namespace App\Console\Commands;

use App\Services\InmovillaApiService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Exception;

class TestInmovillaConnection extends Command
{
    protected $signature = 'inmovilla:test-connection 
                            {--show-data : Mostrar datos de respuesta detallados}
                            {--test-type=basic : Tipo de prueba (basic|property|types)}';

    protected $description = 'Prueba la conexión con la API de Inmovilla y verifica el mapeo básico';

    private $apiService;

    public function handle()
    {
        $this->info('Iniciando prueba de conexión con Inmovilla...');
        $this->newLine();

        try {
            // Inicializar servicio
            $this->apiService = new InmovillaApiService();
            $this->info('✅ Servicio InmovillaApiService inicializado');

            // Mostrar configuración actual
            $this->showConfiguration();

            // Ejecutar prueba según tipo
            $testType = $this->option('test-type');
            
            switch ($testType) {
                case 'basic':
                    return $this->testBasicConnection();
                case 'property':
                    return $this->testSingleProperty();
                case 'types':
                    return $this->testPropertyTypes();
                default:
                    $this->error("Tipo de prueba no válido: {$testType}");
                    return Command::FAILURE;
            }

        } catch (Exception $e) {
            $this->error("Error durante la prueba: {$e->getMessage()}");
            Log::error('Error en prueba de conexión Inmovilla', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return Command::FAILURE;
        }
    }

    /**
     * Muestra la configuración actual
     */
    private function showConfiguration()
    {
        $this->info('📋 Configuración actual:');
        $this->line('  Usuario: ' . config('inmovilla.usuario'));
        $this->line('  Idioma: ' . config('inmovilla.idioma'));
        $this->line('  Rate Limit: ' . config('inmovilla.rate_limit.max_requests') . ' req/min');
        $this->line('  API File: ' . config('inmovilla.urls.api_file'));
        
        // Verificar si el archivo API existe
        $apiFile = config('inmovilla.urls.api_file');
        if (file_exists($apiFile)) {
            $this->info('  ✅ Archivo apiinmovilla.php encontrado');
        } else {
            $this->warn('  ⚠️  Archivo apiinmovilla.php NO encontrado - usando modo simulado');
        }
        
        $this->newLine();
    }

    /**
     * Prueba conexión básica
     */
    private function testBasicConnection(): int
    {
        $this->info('🔄 Ejecutando prueba básica...');

        try {
            // Probar obtener tipos de propiedad (llamada simple)
            $types = $this->apiService->getPropertyTypes();
            $this->info('✅ Conexión exitosa');
            $this->line('  Tipos de propiedad obtenidos: ' . count($types));

            if ($this->option('show-data')) {
                $this->showArrayData('Tipos de Propiedad', $types, 3);
            }

            // Probar obtener códigos disponibles
            $codes = $this->apiService->getAvailablePropertyCodes();
            $this->info('✅ Códigos de propiedades disponibles obtenidos');
            $this->line('  Total de propiedades: ' . count($codes));

            if ($this->option('show-data') && !empty($codes)) {
                $this->line('  Primeros 5 códigos: ' . implode(', ', array_slice($codes, 0, 5)));
            }

            // Probar estadísticas del servicio
            $stats = $this->apiService->getServiceStats();
            $this->info('📊 Estadísticas del servicio:');
            foreach ($stats as $key => $value) {
                $this->line("  {$key}: {$value}");
            }

            return Command::SUCCESS;

        } catch (Exception $e) {
            $this->error('❌ Error en prueba básica: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * Prueba obtener una propiedad específica
     */
    private function testSingleProperty(): int
    {
        $this->info('🏠 Probando obtener propiedad específica...');

        try {
            // Primero obtener códigos disponibles
            $codes = $this->apiService->getAvailablePropertyCodes();
            
            if (empty($codes)) {
                $this->warn('⚠️  No hay códigos de propiedades disponibles para probar');
                return Command::FAILURE;
            }

            // Tomar el primer código disponible
            $testCode = $codes[0];
            $this->info("📋 Probando con código: {$testCode}");

            // Obtener detalle de la propiedad
            $property = $this->apiService->getPropertyDetail($testCode);
            
            if ($property) {
                $this->info('✅ Propiedad obtenida exitosamente');
                $this->showPropertySummary($property);
                
                if ($this->option('show-data')) {
                    $this->showArrayData('Datos Completos de Propiedad', $property);
                }

                // Probar mapeo básico
                $this->testBasicMapping($property);
                
            } else {
                $this->warn('⚠️  No se pudo obtener la propiedad');
                return Command::FAILURE;
            }

            return Command::SUCCESS;

        } catch (Exception $e) {
            $this->error('❌ Error obteniendo propiedad: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * Prueba obtener tipos de propiedad detallados
     */
    private function testPropertyTypes(): int
    {
        $this->info('🏠 Probando tipos de propiedad...');

        try {
            $types = $this->apiService->getPropertyTypes();
            $this->info('✅ Tipos obtenidos: ' . count($types));

            // Mostrar mapeo de tipos
            $typeMapping = config('inmovilla.property_type_mapping');
            $this->info('📋 Mapeo de tipos configurado:');
            
            foreach ($types as $type) {
                $codTipo = $type['cod_tipo'] ?? null;
                $tipoNombre = $type['tipo'] ?? 'N/A';
                $mapeado = $typeMapping[$codTipo] ?? 'NO MAPEADO';
                
                $status = $mapeado !== 'NO MAPEADO' ? '✅' : '⚠️ ';
                $this->line("  {$status} {$codTipo}: {$tipoNombre} -> {$mapeado}");
            }

            return Command::SUCCESS;

        } catch (Exception $e) {
            $this->error('❌ Error obteniendo tipos: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * Muestra resumen de una propiedad
     */
    private function showPropertySummary(array $property)
    {
        $this->info('📄 Resumen de propiedad:');
        $this->line('  Código: ' . ($property['cod_ofer'] ?? 'N/A'));
        $this->line('  Referencia: ' . ($property['ref'] ?? 'N/A'));
        $this->line('  Tipo: ' . ($property['nbtipo'] ?? 'N/A'));
        $this->line('  Ciudad: ' . ($property['ciudad'] ?? 'N/A'));
        $this->line('  Precio venta: ' . ($property['precioinmo'] ?? 'N/A'));
        $this->line('  Precio alquiler: ' . ($property['precioalq'] ?? 'N/A'));
        $this->line('  Habitaciones: ' . ($property['total_hab'] ?? 'N/A'));
        $this->line('  Baños: ' . ($property['banyos'] ?? 'N/A'));
        $this->line('  M² construidos: ' . ($property['m_cons'] ?? 'N/A'));
    }

    /**
     * Prueba mapeo básico de campos
     */
    private function testBasicMapping(array $property)
    {
        $this->info('🔀 Probando mapeo de campos...');
        
        $mapping = config('inmovilla.field_mapping');
        $mapped = [];
        $unmapped = [];

        foreach ($property as $inmovillaField => $value) {
            if (isset($mapping[$inmovillaField])) {
                $laravelField = $mapping[$inmovillaField];
                $mapped[$inmovillaField] = $laravelField;
            } else {
                $unmapped[] = $inmovillaField;
            }
        }

        $this->info('✅ Campos mapeados: ' . count($mapped));
        $this->warn('⚠️  Campos sin mapear: ' . count($unmapped));

        if ($this->option('show-data')) {
            if (!empty($unmapped)) {
                $this->warn('Campos sin mapear: ' . implode(', ', $unmapped));
            }
        }

        // Probar mapeo de operación específicamente
        if (isset($property['keyacci'])) {
            $operationMapping = config('inmovilla.operation_mapping');
            $operation = $operationMapping[$property['keyacci']] ?? 'NO MAPEADO';
            $this->line("  Operación ({$property['keyacci']}): {$operation}");
        }

        // Probar mapeo de tipo específicamente
        if (isset($property['key_tipo'])) {
            $typeMapping = config('inmovilla.property_type_mapping');
            $type = $typeMapping[$property['key_tipo']] ?? 'NO MAPEADO';
            $this->line("  Tipo ({$property['key_tipo']}): {$type}");
        }
    }

    /**
     * Muestra datos de un array de forma legible
     */
    private function showArrayData(string $title, array $data, int $limit = 0)
    {
        $this->newLine();
        $this->info("📊 {$title}:");
        $this->line(str_repeat('-', 50));

        $items = $limit > 0 ? array_slice($data, 0, $limit) : $data;
        
        foreach ($items as $index => $item) {
            if (is_array($item)) {
                $this->line("  [{$index}]:");
                foreach ($item as $key => $value) {
                    $displayValue = is_array($value) ? '[Array]' : $value;
                    $this->line("    {$key}: {$displayValue}");
                }
                $this->line('');
            } else {
                $this->line("  [{$index}]: {$item}");
            }
        }

        if ($limit > 0 && count($data) > $limit) {
            $remaining = count($data) - $limit;
            $this->line("  ... y {$remaining} elementos más");
        }
    }
}