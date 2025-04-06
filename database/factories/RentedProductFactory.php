<?php

namespace Database\Factories;

use App\Models\RentedProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class RentedProductFactory extends Factory
{
    protected $model = RentedProduct::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'advertisement_id' => \App\Models\Advertisement::factory(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'start_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'return_date' => $this->faker->optional()->dateTimeBetween('now', '+2 months'),
            'return_wear_state' => $this->faker->optional()->numberBetween(0, 100),
        ];
    }
}