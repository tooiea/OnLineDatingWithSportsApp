<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 複数のチームを作成してそれぞれにCodeを紐付ける場合
        Team::factory(300)->create()->each(function ($team) {
            $team->code()->create([
                'codeable_id' => $team->id,
                'codeable_type' => Team::class,
                'code' => fake()->unique()->regexify('[A-Za-z0-9]{40}'),
                'expired_at' => \Carbon\Carbon::now()->addDay(7),
            ]);
            
            $team->image()->create([
                'imageable_id' => $team->id,
                'imageable_type' => Team::class,
                'path' => UploadedFile::fake()->create($team->id . '.png', 10)->store('images/teams'),
                'extension' => 'png',
                'mime_type' => 'image/png',
            ]);
        });

        User::factory(10)->create()->each(function ($user) {
            $user->teamMember()->create([
                'team_id' => Team::inRandomOrder()->first()->id,
                'user_id' => $user->id,
            ]);
        });
        $user = User::factory()->create([
            'name' => 'watanabe',
            'email' => 'tooiea1113@gmail.com',
            'password'=> Hash::make('Touya1008'),
            'last_login_at' => \Carbon\Carbon::now(),
        ]);
        $user->teamMember()->create([
            'team_id' => Team::inRandomOrder()->first()->id,
            'user_id' => $user->id,
        ]);
    }
}
