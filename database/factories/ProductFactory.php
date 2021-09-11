<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->numberBetween(1000,9999),
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'price' => $this->faker->randomNumber(2), 
            'url_image' => $this->faker->imageUrl(200,100), 
            'like' => rand(0,10), 
            'dislike' => rand(0,10),
        ];
    }
}
