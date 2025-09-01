<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\AutonomousCommunity;
use App\Models\Province;
use App\Models\City;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);

        /* Cargar Comunidades Autónomas
        $ccaa = json_decode(file_get_contents(database_path('data/ccaa.json')), true);
        foreach ($ccaa as $community) {
            AutonomousCommunity::create([
                'name' => $community['label'],
                'code' => $community['code']
            ]);
        }
        */
        /* Cargar Provincias
        $provinces = json_decode(file_get_contents(database_path('data/provincias.json')), true);
        foreach ($provinces as $province) {
            $community = AutonomousCommunity::where('code', $province['parent_code'])->first();
            if ($community) {
                Province::create([
                    'name' => $province['label'],
                    'code' => $province['code'],
                    'autonomous_community_id' => $community->id
                ]);
            }
        }

        // Cargar Ciudades
        $cities = json_decode(file_get_contents(database_path('data/poblaciones.json')), true);
        foreach ($cities as $city) {
            $province = Province::where('code', $city['parent_code'])->first();
            if ($province) {
                City::create([
                    'name' => $city['label'],
                    'code' => $city['code'],
                    'province_id' => $province->id
                ]);
            }
        }
        */
        //llamar a FixedDataSeeder
        $this->call(FixedDataSeeder::class);


        //llamar a PropertiesTableSeeder
        //$this->call(PropertiesTableSeeder::class);

        //llamar a AddressSeeder
        //$this->call(AddressSeeder::class);

        //llamar a ImagesSeeder
        //$this->call(PropertyImageSeeder::class);



    }
}
