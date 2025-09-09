<?php

namespace App\Console\Commands;

use App\Services\InmovillaApiService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\DB;

class ValidateInmovillaSetup extends Command
{
    protected $signature = 'inmovilla:validate-setup 
                            {--fix : Intentar corregir problemas encontrados}
                            {--create-dirs : Crear directorios faltantes}';

    protected $description = 'Valida la configuración e instalación de Inmovilla API';

    public function handle()
    {
        $this->info('🔍 Validando configuración de Inmovilla...');
        $this->newLine();

        $allGood = true;
        
        // 1. Validar configuración
        $allGood &= $this->validateConfiguration();
        
        // 2. Validar estructura de directorios
        $allGood &= $this->validateDirectories();
        
        // 3. Validar archivo API
        $allGood &= $this->validateApiFile();
        
        // 4. Validar base de datos
        $allGood &= $this->validateDatabase();
        
        // 5. Test de conexión si todo está bien
        if ($allGood) {
            $allGood &= $this->testConnection();
        }
        
        $this->newLine();
        if ($allGood) {
            $this->info('✅ Todas las validaciones pasaron exitosamente!');
            $this->info('🚀 Inmovilla está listo para usar.');
            return Command::SUCCESS;
        } else {
            $this->error('❌ Algunas validaciones fallaron. Revise los errores arriba.');
            $this->warn('💡 Use --fix para intentar corregir automáticamente algunos problemas.');
            return Command::FAILURE;
        }
    }

    private function validateConfiguration(): bool
    {
        $this->info('📋 Validando configuración...');
        
        $errors = [];
        
        // Validar credenciales
        $usuario = config('inmovilla.usuario');
        $password = config('inmovilla.password');
        
        if (empty($usuario)) {
            $errors[] = 'INMOVILLA_USUARIO no está configurado';
        }
        
        if (empty($password)) {
            $errors[] = 'INMOVILLA_PASSWORD no está configurado';
        }
        
        // Validar idioma
        $idioma = config('inmovilla.idioma');
        if (!in_array($idioma, [1, 2, 3, 4, 5, 6, 7, 8])) {
            $errors[] = 'INMOVILLA_IDIOMA debe ser un número entre 1-8';
        }
        
        // Validar rate limiting
        $maxRequests = config('inmovilla.rate_limit.max_requests');
        if (!is_numeric($maxRequests) || $maxRequests > 70) {
            $errors[] = 'Rate limit no puede exceder 70 peticiones/minuto';
        }
        
        if (empty($errors)) {
            $this->line('  ✅ Configuración válida');
            $this->line("  📧 Usuario: {$usuario}");
            $this->line("  🌍 Idioma: {$idioma}");
            $this->line("  ⏱️  Rate Limit: {$maxRequests}/min");
            return true;
        } else {
            foreach ($errors as $error) {
                $this->line("  ❌ {$error}");
            }
            return false;
        }
    }

    private function validateDirectories(): bool
    {
        $this->info('📁 Validando directorios...');
        
        $directories = [
            storage_path('app/inmovilla'),
            storage_path('logs'),
            storage_path('app/public/properties'),
            storage_path('app/public/properties/images'),
        ];
        
        $errors = [];
        
        foreach ($directories as $dir) {
            if (!is_dir($dir)) {
                $errors[] = "Directorio faltante: {$dir}";
                
                if ($this->option('create-dirs')) {
                    if (mkdir($dir, 0755, true)) {
                        $this->line("  ✅ Directorio creado: {$dir}");
                    } else {
                        $this->line("  ❌ No se pudo crear: {$dir}");
                    }
                }
            } else {
                $this->line("  ✅ {$dir}");
            }
        }
        
        if (!empty($errors) && !$this->option('create-dirs')) {
            foreach ($errors as $error) {
                $this->line("  ❌ {$error}");
            }
            return false;
        }
        
        return true;
    }

    private function validateApiFile(): bool
    {
        $this->info('📄 Validando archivo API...');
        
        try {
            $apiService = new InmovillaApiService();
            $validation = $apiService->validateApiFile();
            
            if (!$validation['file_exists']) {
                $this->line('  ❌ apiinmovilla.php no encontrado');
                $this->line('  📍 Esperado en: ' . config('inmovilla.api_file_path', storage_path('app/inmovilla/apiinmovilla.php')));
                $this->warn('  💡 Debe obtener este archivo del panel de Inmovilla y colocarlo en la ruta indicada');
                return false;
            }
            
            if (!$validation['is_readable']) {
                $this->line('  ❌ Archivo no es legible - verificar permisos');
                return false;
            }
            
            $missingFunctions = [];
            foreach ($validation['functions_exist'] as $func => $exists) {
                if (!$exists) {
                    $missingFunctions[] = $func;
                }
            }
            
            if (!empty($missingFunctions)) {
                $this->line('  ❌ Funciones faltantes: ' . implode(', ', $missingFunctions));
                $this->warn('  💡 El archivo apiinmovilla.php parece estar corrupto o incompleto');
                return false;
            }
            
            $this->line('  ✅ Archivo API válido');
            $this->line('  ✅ Funciones Procesos() y PedirDatos() encontradas');
            return true;
            
        } catch (Exception $e) {
            $this->line("  ❌ Error validando archivo API: {$e->getMessage()}");
            return false;
        }
    }

    private function validateDatabase(): bool
    {
        $this->info('🗄️  Validando base de datos...');
        
        try {
            // Verificar tablas principales
            $tables = [
                'properties',
                'operations', 
                'property_types',
                'statuses',
                'addresses',
                'property_images',
                'property_translations',
                'property_videos',
                'property_descriptions',
            ];
            
            $missingTables = [];
            
            foreach ($tables as $table) {
                try {
                    DB::table($table)->limit(1)->get();
                    $this->line("  ✅ Tabla {$table}");
                } catch (Exception $e) {
                    $missingTables[] = $table;
                    $this->line("  ❌ Tabla {$table} no encontrada");
                }
            }
            
            if (!empty($missingTables)) {
                $this->warn('  💡 Ejecute: php artisan migrate');
                return false;
            }
            
            // Verificar datos semilla básicos
            $operationsCount = DB::table('operations')->count();
            $typesCount = DB::table('property_types')->count();
            $statusesCount = DB::table('statuses')->count();
            
            if ($operationsCount === 0 || $typesCount === 0 || $statusesCount === 0) {
                $this->line('  ⚠️  Datos semilla faltantes');
                $this->warn('  💡 Ejecute: php artisan db:seed --class=FixedDataSeeder');
                return false;
            }
            
            $this->line("  ✅ Operaciones: {$operationsCount}");
            $this->line("  ✅ Tipos de propiedad: {$typesCount}");
            $this->line("  ✅ Estados: {$statusesCount}");
            
            return true;
            
        } catch (Exception $e) {
            $this->line("  ❌ Error validando base de datos: {$e->getMessage()}");
            return false;
        }
    }

    private function testConnection(): bool
    {
        $this->info('🌐 Probando conexión con API...');
        
        try {
            $apiService = new InmovillaApiService();
            
            // Test básico de conexión
            if (!$apiService->testConnection()) {
                $this->line('  ❌ No se pudo conectar con la API de Inmovilla');
                $this->warn('  💡 Verifique las credenciales y la conectividad');
                return false;
            }
            
            // Obtener estadísticas
            $stats = $apiService->getServiceStats();
            $this->line('  ✅ Conexión exitosa');
            $this->line("  📊 Rate limit restante: {$stats['rate_limit_remaining']}");
            
            // Test obtener tipos
            try {
                $types = $apiService->getPropertyTypes();
                $this->line("  ✅ Tipos de propiedad: " . count($types));
            } catch (Exception $e) {
                $this->line("  ⚠️  Error obteniendo tipos: {$e->getMessage()}");
            }
            
            // Test obtener códigos disponibles  
            try {
                $codes = $apiService->getAvailablePropertyCodes();
                $this->line("  ✅ Propiedades disponibles: " . count($codes));
                
                if (count($codes) > 0) {
                    $this->line("  🏠 Códigos de ejemplo: " . implode(', ', array_slice($codes, 0, 3)));
                }
            } catch (Exception $e) {
                $this->line("  ⚠️  Error obteniendo códigos: {$e->getMessage()}");
            }
            
            return true;
            
        } catch (Exception $e) {
            $this->line("  ❌ Error en test de conexión: {$e->getMessage()}");
            return false;
        }
    }

    private function showNextSteps()
    {
        $this->newLine();
        $this->info('🚀 PRÓXIMOS PASOS:');
        $this->line('1. Ejecutar sincronización de prueba:');
        $this->line('   php artisan inmovilla:sync --dry-run --limit=5');
        $this->newLine();
        $this->line('2. Sincronización completa:');
        $this->line('   php artisan inmovilla:sync --type=full');
        $this->newLine();
        $this->line('3. Programar sincronización automática en crontab:');
        $this->line('   0 */6 * * * php artisan inmovilla:sync --type=delta');
        $this->newLine();
        $this->line('4. Probar interfaz web con propiedades sincronizadas');
    }
}