<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    protected static $teamNames = [
        'ファイターズ', 'ドラゴンズ', 'ジャイアンツ', 'ホークス', 'ライオンズ',
        'マリーンズ', 'バファローズ', 'スワローズ', 'ベイスターズ', 'カープ'
    ];

    public function baseballTeam()
    {
        return fake()->streetName() . ' ' . fake()->randomElement(self::$teamNames);
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->baseballTeam(),
            'sport_affiliation_type' => 1,
            'prefecture_code' => fake()->numberBetween(1, 47),
            'address' => fake()->city() . fake()->streetAddress(),
            'url' => fake()->url(),
        ];
    }
}
