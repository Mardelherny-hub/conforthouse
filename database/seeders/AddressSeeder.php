<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\City;
use App\Models\Address;
use App\Models\Property;

class AddressSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Obtener las primeras 50 propiedades existentes
        $properties = Property::limit(50)->get();

        foreach ($properties as $property) {
            // Crear una dirección ficticia
            Address::create([
                'property_id' => $property->id,
                'street' => $faker->streetName(),
                'number' => $faker->numberBetween(1, 999),
                'floor' => $faker->optional()->numberBetween(1, 10),
                'door' => strtoupper($faker->optional()->randomLetter()),
                'postal_code' => $faker->postcode(),
                'district' => $faker->citySuffix(),
                'city' => $faker->city(),
                'province' => $faker->state(),
                'autonomous_community' => $faker->state(),
            ]);


        }
    }
}
