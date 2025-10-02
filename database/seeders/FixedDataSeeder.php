<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Operation;
use App\Models\OperationTranslation;
use App\Models\PropertyType;
use App\Models\PropertyTypeTranslation;
use App\Models\Status;
use App\Models\StatusTranslation;

class FixedDataSeeder extends Seeder
{
    public function run()
    {
        // === OPERACIONES: SOLO 3 ===
        $operations = [
            ['name' => 'Venta', 'translations' => ['en' => 'Sale', 'fr' => 'Vente', 'de' => 'Verkauf', 'nl' => 'Verkoop']],
            ['name' => 'Alquiler', 'translations' => ['en' => 'Rent', 'fr' => 'Location', 'de' => 'Miete', 'nl' => 'Verhuur']],
            ['name' => 'Viviendas de Lujo', 'translations' => ['en' => 'Luxury Properties', 'fr' => 'Propriétés de Luxe', 'de' => 'Luxus-Immobilien', 'nl' => 'Luxe Woningen']],
        ];

        foreach ($operations as $operation) {
            $op = Operation::updateOrCreate(
                ['name' => $operation['name']],
                ['name' => $operation['name']]
            );
            
            foreach ($operation['translations'] as $locale => $name) {
                OperationTranslation::updateOrCreate(
                    ['operation_id' => $op->id, 'locale' => $locale],
                    ['name' => $name]
                );
            }
        }

        // === TIPOS DE PROPIEDADES - Solo 3 tipos ===
        $propertyTypes = [
            // En BD se llama "Casa" pero en español se muestra como "Villa"
            ['name' => 'Casa', 'translations' => [
                'es' => 'Villa',
                'en' => 'Villa', 
                'fr' => 'Villa', 
                'de' => 'Villa', 
                'nl' => 'Villa'
            ]],
            ['name' => 'apartamento', 'translations' => [
                'es' => 'Apartamento',
                'en' => 'Apartment', 
                'fr' => 'Appartement', 
                'de' => 'Wohnung', 
                'nl' => 'Appartement'
            ]],
            ['name' => 'Ático', 'translations' => [
                'es' => 'Ático',
                'en' => 'Penthouse', 
                'fr' => 'Penthouse', 
                'de' => 'Dachgeschoss', 
                'nl' => 'Penthouse'
            ]],
        ];

        foreach ($propertyTypes as $type) {
            $pt = PropertyType::updateOrCreate(
                ['name' => $type['name']],
                ['name' => $type['name']]
            );
            
            foreach ($type['translations'] as $locale => $name) {
                PropertyTypeTranslation::updateOrCreate(
                    ['property_type_id' => $pt->id, 'locale' => $locale],
                    ['name' => $name]
                );
            }
        }

        // === ESTADOS - Solo 2 ===
        $statuses = [
            ['name' => 'Disponible', 'translations' => ['en' => 'Available', 'fr' => 'Disponible', 'de' => 'Verfügbar', 'nl' => 'Beschikbaar']],
            ['name' => 'Reservado', 'translations' => ['en' => 'Reserved', 'fr' => 'Réservé', 'de' => 'Reserviert', 'nl' => 'Gereserveerd']],
        ];

        foreach ($statuses as $status) {
            $st = Status::updateOrCreate(
                ['name' => $status['name']],
                ['name' => $status['name']]
            );
            
            foreach ($status['translations'] as $locale => $name) {
                StatusTranslation::updateOrCreate(
                    ['status_id' => $st->id, 'locale' => $locale],
                    ['name' => $name]
                );
            }
        }
    }
}