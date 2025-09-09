<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use App\Models\Property;
use App\Models\PropertyTranslation;
use App\Models\Operation;
use App\Models\PropertyType;
use App\Models\Status;
use App\Models\Address;

class PropertiesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $operations = Operation::all()->pluck('id')->toArray();
        $propertyTypes = PropertyType::all()->pluck('id')->toArray();
        $statuses = Status::all()->pluck('id')->toArray();
        $addresses = Address::all()->pluck('id')->toArray();
        $languages = ['en', 'fr', 'de', 'nl'];

        for ($i = 1; $i <= 50; $i++) {
            $property = Property::create([
                'reference' => strtoupper(Str::random(10)),
                'operation_id' => $faker->randomElement($operations),
                'property_type_id' => $faker->randomElement($propertyTypes),
                'status_id' => $faker->randomElement($statuses),
                'title' => $faker->sentence(3),
                'meta_description' => $faker->sentence(10),
                'price' => $faker->randomFloat(2, 50000, 1000000),
                'community_expenses' => $faker->randomFloat(2, 50, 500),
                'built_area' => $faker->numberBetween(50, 500),
                'condition' => $faker->randomElement(['New', 'Good', 'Needs Renovation']),
                'rooms' => $faker->numberBetween(1, 6),
                'bathrooms' => $faker->numberBetween(1, 4),
                'year_built' => $faker->numberBetween(1950, 2023),
                'parking_spaces' => $faker->numberBetween(0, 3),
                'floors' => $faker->numberBetween(1, 3),
                'floor' => $faker->numberBetween(1, 10),
                'orientation' => $faker->randomElement(['North', 'South', 'East', 'West']),
                'exterior_type' => $faker->randomElement(['Open', 'Closed']),
                'kitchen_type' => $faker->randomElement(['Independent', 'American', 'Open Concept']),
                'heating_type' => $faker->randomElement(['Gas', 'Electric', 'Solar']),
                'interior_carpentry' => $faker->randomElement(['Wood', 'PVC', 'Aluminum']),
                'exterior_carpentry' => $faker->randomElement(['Wood', 'PVC', 'Aluminum']),
                'flooring_type' => $faker->randomElement(['Tile', 'Parquet', 'Marble']),
                'views' => $faker->randomElement(['Sea', 'Mountain', 'City', 'Garden']),
                'distance_to_sea' => $faker->numberBetween(0, 5000),
                'regime' => $faker->randomElement(['Freehold', 'Leasehold']),
                'google_map' => $faker->url,
                'description' => $faker->paragraph(4),
            ]);

            foreach ($languages as $lang) {
                PropertyTranslation::create([
                    'property_id' => $property->id,
                    'locale' => $lang,
                    'title' => $faker->sentence(3),
                    'description' => $faker->paragraph(4),
                    'meta_description' => $faker->sentence(10),
                    'condition' => $faker->randomElement(['New', 'Good', 'Needs Renovation']),
                    'orientation' => $faker->randomElement(['North', 'South', 'East', 'West']),
                    'exterior_type' => $faker->randomElement(['Open', 'Closed']),
                    'kitchen_type' => $faker->randomElement(['Independent', 'American', 'Open Concept']),
                    'heating_type' => $faker->randomElement(['Gas', 'Electric', 'Solar']),
                    'interior_carpentry' => $faker->randomElement(['Wood', 'PVC', 'Aluminum']),
                    'exterior_carpentry' => $faker->randomElement(['Wood', 'PVC', 'Aluminum']),
                    'flooring_type' => $faker->randomElement(['Tile', 'Parquet', 'Marble']),
                    'views' => $faker->randomElement(['Sea', 'Mountain', 'City', 'Garden']),
                    'regime' => $faker->randomElement(['Freehold', 'Leasehold']),
                ]);
            }
        }
    }
}
