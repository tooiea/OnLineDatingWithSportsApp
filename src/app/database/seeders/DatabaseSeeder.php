<?php

namespace Database\Seeders;

use App\Models\ConsentGame;
use App\Models\DummyImage;
use App\Models\Team;
use App\Models\TeamMember;
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
        // 複数のチームを作成してそれぞれにCodeを紐付ける場合
        Team::factory(300)->create()->each(function ($team) {
            $team->code()->create([
                'codeable_id' => $team->id,
                'codeable_type' => Team::class,
                'code' => fake()->unique()->regexify('[A-Za-z0-9]{40}'),
                'expired_at' => \Carbon\Carbon::now()->addDay(7),
            ]);

            // 画像の保存パス
            $path = "images/teams/{$team->id}.png";
            DummyImage::makeDummyImage($team->id, $path);

            // データベースに画像情報を登録
            $team->image()->create([
                'path' => $path,
                'extension' => 'png',
                'mime_type' => 'image/png',
            ]);

            // チームメンバー
            $user = User::factory()->create();
            $user->teamMember()->create([
                'team_id' => $team->id,
                'user_id' => $user->id,
            ]);
        });

        $teams = Team::all();
        $myUser = User::factory()->create([
            'name' => 'watanabe',
            'email' => 'tooiea1113@gmail.com',
            'password'=> Hash::make('password'),
            'last_login_at' => \Carbon\Carbon::now(),
        ]);
        $myUser->teamMember()->create([
            'team_id' => Team::inRandomOrder()->first()->id,
            'user_id' => $myUser->id,
        ]);
        foreach ($teams as $team) {
            // チームアルバムの作成
            $album = $team->album()->create([
                'name' => fake()->name(),
            ]);

            for ($i = 0; $i < rand(0, 5); $i++) {
                $filename = $album->id . '_' . $i;
                $path = "images/teams/album/{$filename}.png";
                DummyImage::makeDummyImage($team->id, $path);

                // データベースに画像情報を登録
                $album->image()->create([
                    'path' => $path,
                    'extension' => 'png',
                    'mime_type' => 'image/png',
                ]);
            }

            // 招待するチームを取得
            $invitees = Team::where('id', '!=', $team->id)->inRandomOrder()->take(3)->get();
            $guests = Team::where('id', '!=', $team->id)->inRandomOrder()->take(3)->get();

            // 招待を送る側のデータを作成
            foreach ($invitees as $invitee) {
                $consentGame = ConsentGame::factory()->create([
                    'invitee_id' => $team->id,
                    'guest_id' => $invitee->id,
                ]);

                $teamMembers = TeamMember::where('team_id', $invitee->id)->inRandomOrder()->get();
                foreach ($teamMembers as $teamMember) {
                    $consentGame->notification()->create([
                        'notifiable_type' => ConsentGame::class,
                        'notifiable_id' => $consentGame->id,
                        'senderable_type' => User::class,
                        'senderable_id' => $teamMember->user_id,
                        'read_at' => null
                    ]);
                }
            }

            // 招待を受ける側のデータを作成
            foreach ($guests as $guest) {
                $consentGame = ConsentGame::factory()->create([
                    'invitee_id' => $guest->id,
                    'guest_id' => $team->id,
                ]);
                $teamMembers = TeamMember::where('team_id', $team->id)->inRandomOrder()->get();
                foreach ($teamMembers as $teamMember) {
                    $consentGame->notification()->create([
                        'notifiable_type' => ConsentGame::class,
                        'notifiable_id' => $consentGame->id,
                        'senderable_type' => User::class,
                        'senderable_id' => $teamMember->user_id,
                        'read_at' => null
                    ]);
                }
            }
        }
    }
}
