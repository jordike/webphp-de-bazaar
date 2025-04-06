<?php
namespace Database\Factories;

use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdvertisementFactory extends Factory
{
    protected $model = Advertisement::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'is_for_rent' => $this->faker->boolean,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'photo' => $this->faker->imageUrl,
            'user_id' => \App\Models\User::factory(),
            'expiration_date' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
        ];
    }
}