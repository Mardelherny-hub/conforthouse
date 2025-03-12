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

        // Obtener todas las ciudades disponibles
        $cities = City::pluck('id')->toArray();

        if (empty($cities)) {
            $this->command->warn("No hay ciudades en la base de datos. Asegúrate de ejecutar primero el seeder de ciudades.");
            return;
        }

        // Obtener las primeras 50 propiedades existentes
        $properties = Property::limit(50)->get();

        foreach ($properties as $property) {
            // Crear una dirección ficticia
            $address = Address::create([
                'street' => $faker->streetName(),
                'number' => $faker->numberBetween(1, 999),
                'floor' => $faker->optional()->numberBetween(1, 10),
                'door' => strtoupper($faker->optional()->randomLetter()),
                'postal_code' => $faker->postcode(),
                'city_id' => $faker->randomElement($cities), // Asignar ciudad aleatoria
                'district' => $faker->citySuffix(), // Generar un nombre de distrito ficticio
            ]);

            // Asignar la dirección a la propiedad
            $property->update(['address_id' => $address->id]);
        }
    }
}
