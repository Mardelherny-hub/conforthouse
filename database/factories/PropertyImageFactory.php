<?php

namespace Database\Factories;

use App\Models\PropertyImage;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyImageFactory extends Factory
{
    protected $model = PropertyImage::class;

    public function definition()
    {
        $images = [
            'assets/images/shop/product-1.jpg',
            'assets/images/shop/product-2.jpg',
            'assets/images/shop/product-3.jpg',
            'assets/images/shop/product-4.jpg',
            'assets/images/shop/product-5.jpg',
            'assets/images/shop/product-6.jpg',
            'assets/images/shop/product-7.jpg',
            'assets/images/shop/product-8.jpg',
            'assets/images/shop/product-9.jpg',
            'assets/images/shop/product-10.jpg',
            'assets/images/shop/product-11.jpg',
            'assets/images/shop/product-12.jpg',
            'assets/images/shop/product-13.jpg',
            'assets/images/shop/product-14.jpg',
        ];

        return [
            'property_id' => Property::factory(),
            'image_path' => $this->faker->randomElement($images),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
