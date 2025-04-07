<?php

namespace Database\Factories;

use App\Models\LandingPageComponent;
use Illuminate\Database\Eloquent\Factories\Factory;

class LandingPageComponentFactory extends Factory
{
    protected $model = LandingPageComponent::class;

    public function definition()
    {
        return [
            'company_id' => \App\Models\Company::factory(),
            'type' => $this->faker->randomElement(LandingPageComponent::getAllowedTypes()),
            'content' => $this->faker->text,
            'order' => $this->faker->numberBetween(1, 10),
        ];
    }
}