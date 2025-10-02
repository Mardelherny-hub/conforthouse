<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UpdateInmovillaCommand extends Command
{
    protected $signature = 'inmovilla:update 
                            {--url= : URL del XML (opcional, usa la configurada por defecto)}';
    
    protected $description = 'Descarga XML de Inmovilla y actualiza la base de datos';

    private $xmlUrl = 'https://procesos.apinmo.com/xml/v2/LUUV4ajq/11855-web.xml';

    public function handle()
    {
        $this->info('🔄 Iniciando actualización diaria de Inmovilla...');
        $this->newLine();

        try {
            // Paso 1: Descargar XML
            $xmlPath = $this->downloadXml();
            
            if (!$xmlPath) {
                $this->error('❌ No se pudo descargar el XML');
                return Command::FAILURE;
            }

            // Paso 2: Ejecutar import
            $this->info('📊 Ejecutando importación...');
            $exitCode = $this->call('inmovilla:import', [
                'xml_file_path' => $xmlPath
            ]);

            if ($exitCode === Command::SUCCESS) {
                $this->newLine();
                $this->info('✅ Actualización completada exitosamente');
                Log::info('Actualización diaria Inmovilla completada');
                return Command::SUCCESS;
            } else {
                $this->error('❌ Error durante la importación');
                return Command::FAILURE;
            }

        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            Log::error('Error en actualización Inmovilla', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return Command::FAILURE;
        }
    }

    private function downloadXml()
    {
        $url = $this->option('url') ?: $this->xmlUrl;
        $this->info("📥 Descargando XML desde: {$url}");

        try {
            // Descargar contenido
            $xmlContent = file_get_contents($url);
            
            if ($xmlContent === false) {
                throw new \Exception('No se pudo obtener el contenido del XML');
            }

            // Validar que es XML válido
            $xml = simplexml_load_string($xmlContent);
            if (!$xml) {
                throw new \Exception('El contenido descargado no es XML válido');
            }

            // Guardar en storage con timestamp
            $filename = 'inmovilla-' . date('Y-m-d-His') . '.xml';
            $directory = 'inmovilla';
            
            // Crear directorio si no existe
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }

            $path = storage_path("app/{$directory}/{$filename}");
            file_put_contents($path, $xmlContent);

            $this->info("✅ XML descargado: {$filename}");
            $this->info("📍 Ubicación: {$path}");
            $this->newLine();

            return $path;

        } catch (\Exception $e) {
            $this->error("Error descargando XML: " . $e->getMessage());
            Log::error('Error descargando XML de Inmovilla', [
                'url' => $url,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }
}