<?php

namespace Database\Factories;

use App\Models\Theme;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThemeFactory extends Factory
{
    protected $model = Theme::class;

    public function definition()
    {
        return [
            'company_id' => \App\Models\Company::factory(),
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'primary_color' => $this->faker->hexColor,
            'secondary_color' => $this->faker->hexColor,
            'background_color' => $this->faker->hexColor,
            'text_color' => $this->faker->hexColor,
            'font_family' => $this->faker->word,
            'font_size' => $this->faker->randomElement(['small', 'medium', 'large']),
            'logo_path' => $this->faker->filePath()
        ];
    }
}