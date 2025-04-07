<?php

namespace Database\Factories;

use App\Models\PurchasedProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchasedProductFactory extends Factory
{
    protected $model = PurchasedProduct::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'advertisement_id' => \App\Models\Advertisement::factory(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
        ];
    }
}