<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'sport_affiliation_type' => 1,
            'prefecture_code' => fake()->numberBetween(1, 47),
            'address' => fake()->address(),
            'url' => fake()->url(),
        ];
    }
}
