<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        User::factory()->create([
            'name' => 'watanabe',
            'email' => 'tooiea1113@gmail.com',
            'password'=> Hash::make('Touya1008'),
            'last_login_at' => \Carbon\Carbon::now(),
        ]);

        // 複数のチームを作成してそれぞれにCodeを紐付ける場合
        Team::factory(300)->create()->each(function ($team) {
            $team->code()->create([
                'codeable_id' => $team->id,
                'codeable_type' => Team::class,
                'code' => fake()->unique()->regexify('[A-Za-z0-9]{40}'),
                'expired_at' => \Carbon\Carbon::now()->addDay(7),
            ]);
        });
    }
}
