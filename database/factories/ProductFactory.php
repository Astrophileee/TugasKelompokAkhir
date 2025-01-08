<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'code' => $this->faker->unique()->numerify('PROD###'),
            'name' => $this->faker->word,
            'price' => $this->faker->numberBetween(10000, 50000),
            'stock' => $this->faker->numberBetween(10, 100),
            'branch_id' => null
        ];
    }
}
