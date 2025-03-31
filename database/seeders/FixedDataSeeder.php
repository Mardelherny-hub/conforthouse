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
        $operations = [
            ['name' => 'Venta', 'translations' => ['en' => 'Sale', 'fr' => 'Vente', 'de' => 'Verkauf']],
            ['name' => 'Alquiler', 'translations' => ['en' => 'Rent', 'fr' => 'Location', 'de' => 'Miete']],
            ['name' => 'Leasing', 'translations' => ['en' => 'Leasing', 'fr' => 'Leasing', 'de' => 'Leasing']],
            ['name' => 'Traspaso', 'translations' => ['en' => 'Transfer', 'fr' => 'Transfert', 'de' => 'Übertragung']],
        ];

        foreach ($operations as $operation) {
            $op = Operation::create(['name' => $operation['name']]);
            foreach ($operation['translations'] as $locale => $name) {
                OperationTranslation::create([ 'operation_id' => $op->id, 'locale' => $locale, 'name' => $name ]);
            }
        }

        $propertyTypes = [
            ['name' => 'Casa', 'translations' => ['en' => 'House', 'fr' => 'Maison', 'de' => 'Haus']],
            ['name' => 'Departamento', 'translations' => ['en' => 'Apartment', 'fr' => 'Appartement', 'de' => 'Wohnung']],
            ['name' => 'Ático', 'translations' => ['en' => 'Penthouse', 'fr' => 'Penthouse', 'de' => 'Dachgeschoss']],
            ['name' => 'Obra Nueva', 'translations' => ['en' => 'New Build', 'fr' => 'Nouveau Bâtiment', 'de' => 'Neubau']],
            ['name' => 'Adosado', 'translations' => ['en' => 'Townhouse', 'fr' => 'Maison Mitoyenne', 'de' => 'Reihenhaus']],
        ];

        foreach ($propertyTypes as $type) {
            $pt = PropertyType::create(['name' => $type['name']]);
            foreach ($type['translations'] as $locale => $name) {
                PropertyTypeTranslation::create([ 'property_type_id' => $pt->id, 'locale' => $locale, 'name' => $name ]);
            }
        }

        $statuses = [
            ['name' => 'Disponible', 'translations' => ['en' => 'Available', 'fr' => 'Disponible', 'de' => 'Verfügbar']],
            ['name' => 'Reservado', 'translations' => ['en' => 'Reserved', 'fr' => 'Réservé', 'de' => 'Reserviert']],
        ];

        foreach ($statuses as $status) {
            $st = Status::create(['name' => $status['name']]);
            foreach ($status['translations'] as $locale => $name) {
                StatusTranslation::create([ 'status_id' => $st->id, 'locale' => $locale, 'name' => $name ]);
            }
        }
    }
}



