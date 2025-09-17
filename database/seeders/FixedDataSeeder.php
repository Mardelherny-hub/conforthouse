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
        // === OPERACIONES: SOLO MENÚ (Venta, Alquiler, Viviendas de Lujo) + Compatibilidad Inmovilla ===
        $operations = [
            // MENÚ PRINCIPAL - Estas 3 aparecen en el menú
            ['name' => 'Venta', 'translations' => ['en' => 'Sale', 'fr' => 'Vente', 'de' => 'Verkauf', 'nl' => 'Verkoop']],
            ['name' => 'Alquiler', 'translations' => ['en' => 'Rent', 'fr' => 'Location', 'de' => 'Miete', 'nl' => 'Verhuur']],
            ['name' => 'Viviendas de Lujo', 'translations' => ['en' => 'Luxury Properties', 'fr' => 'Propriétés de Luxe', 'de' => 'Luxus-Immobilien', 'nl' => 'Luxe Woningen']],
            
            // COMPATIBILIDAD INMOVILLA - No aparecen en menú, pero necesarias para mapeo
            ['name' => 'Leasing', 'translations' => ['en' => 'Leasing', 'fr' => 'Leasing', 'de' => 'Leasing', 'nl' => 'Leasing']],
            ['name' => 'Traspaso', 'translations' => ['en' => 'Transfer', 'fr' => 'Transfert', 'de' => 'Übertragung', 'nl' => 'Overdracht']],
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

        // === TIPOS DE PROPIEDADES CON TRADUCCIONES CORREGIDAS ===
        $propertyTypes = [
            ['name' => 'Casa', 'translations' => ['en' => 'House', 'fr' => 'Maison', 'de' => 'Haus', 'nl' => 'Huis']],
            ['name' => 'Departamento', 'translations' => ['en' => 'Apartment', 'fr' => 'Appartement', 'de' => 'Wohnung', 'nl' => 'Appartement']],
            ['name' => 'Ático', 'translations' => ['en' => 'Penthouse', 'fr' => 'Penthouse', 'de' => 'Dachgeschoss', 'nl' => 'Penthouse']],
            ['name' => 'Obra Nueva', 'translations' => ['en' => 'New Build', 'fr' => 'Nouveau Bâtiment', 'de' => 'Neubau', 'nl' => 'Nieuwbouw']],
            ['name' => 'Adosado', 'translations' => ['en' => 'Townhouse', 'fr' => 'Maison Mitoyenne', 'de' => 'Reihenhaus', 'nl' => 'Rijtjeshuis']],
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

        // === ESTADOS CON TRADUCCIONES CORREGIDAS ===
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