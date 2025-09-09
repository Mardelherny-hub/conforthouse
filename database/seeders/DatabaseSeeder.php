<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\AutonomousCommunity;
use App\Models\Province;
use App\Models\City;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesSeeder::class);
        $this->call(UserSeeder::class);

        
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
