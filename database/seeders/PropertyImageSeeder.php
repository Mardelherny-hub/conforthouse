<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\PropertyImage;
use Faker\Factory as Faker;

class PropertyImageSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Obtener todas las propiedades
        $properties = Property::all();

        foreach ($properties as $property) {
            // Generar entre 3 y 5 imágenes por propiedad
            $numImages = rand(3, 5);

            for ($i = 0; $i < $numImages; $i++) {
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_path' => 'https://picsum.photos/800/600?random=' . rand(1, 1000), // URL de imagen aleatoria
                    'thumbnail_path' => 'https://picsum.photos/200/150?random=' . rand(1, 1000), // Miniatura aleatoria
                    'order' => $i,
                    'is_featured' => $i === 0, // La primera imagen será la destacada
                    'alt_text' => $faker->sentence(6), // Texto alternativo aleatorio
                ]);
            }
        }
    }
}

