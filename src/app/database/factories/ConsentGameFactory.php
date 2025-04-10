<?php

namespace Database\Factories;

use App\Enums\ConsentStatusTypeEnum;
use App\Models\Team;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ConsentGame>
 */
class ConsentGameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'consent_status' => ConsentStatusTypeEnum::WAIT,
            'first_preferered_date' => CarbonImmutable::now()->addDays(rand(1, 30))->setTime(rand(0,23), rand(0,59), rand(0,59)),
            'second_preferered_date' => CarbonImmutable::now()->addDays(rand(1, 30))->setTime(rand(0,23), rand(0,59), rand(0,59)),
            'third_preferered_date' => rand(0, 1) ? CarbonImmutable::now()
                                        ->addDays(rand(1, 30))
                                        ->setTime(rand(0, 23), rand(0, 59), rand(0, 59)) : null,
            'message' => fake()->realText(100),
        ];
    }
}
