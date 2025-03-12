<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition()
    {
        return [
            'reference' => $this->faker->unique()->word,
            'operation' => $this->faker->randomElement(['Alquilar', 'Vender', 'Promoción', 'Lujo']),
            'property_type' => $this->faker->randomElement(['ático', 'apartmento', 'condo', 'casa']),
            'status' => $this->faker->randomElement(['Disponible', 'Reservado', 'Vendido', 'Alquilado']),
            'price' => $this->faker->randomFloat(2, 100000, 1000000),
            'community_expenses' => $this->faker->randomFloat(2, 100, 1000),
            'zone' => $this->faker->word,
            'built_area' => $this->faker->numberBetween(50, 500),
            'condition' => $this->faker->randomElement(['new', 'good', 'needs renovation']),
            'rooms' => $this->faker->numberBetween(1, 10),
            'bathrooms' => $this->faker->numberBetween(1, 5),
            'year_built' => $this->faker->year,
            'parking_spaces' => $this->faker->numberBetween(0, 5),
            'floors' => $this->faker->numberBetween(1, 5),
            'floor' => $this->faker->numberBetween(1, 10),
            'orientation' => $this->faker->randomElement(['north', 'south', 'east', 'west']),
            'exterior_type' => $this->faker->word,
            'kitchen_type' => $this->faker->word,
            'heating_type' => $this->faker->word,
            'interior_carpentry' => $this->faker->word,
            'exterior_carpentry' => $this->faker->word,
            'flooring_type' => $this->faker->word,
            'views' => $this->faker->word,
            'distance_to_sea' => $this->faker->numberBetween(0, 100),
            'regime' => $this->faker->word,
            'google_map' => $this->faker->url,
            'description' => $this->faker->paragraph,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
