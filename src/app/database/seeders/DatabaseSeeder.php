<?php

namespace Database\Seeders;

use App\Enums\ConsentStatusTypeEnum;
use App\Models\ConsentGame;
use App\Models\Team;
use App\Models\User;
use Carbon\CarbonImmutable;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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

            // 画像の保存パス
            $path = "images/teams/{$team->id}.png";

            // 画像サイズの設定
            $width = 300;
            $height = 300;

            // 画像リソースを作成
            $image = imagecreatetruecolor($width, $height);

            // ランダムな背景色を作成
            $bgColor = imagecolorallocate($image, rand(150, 255), rand(150, 255), rand(150, 255));
            imagefill($image, 0, 0, $bgColor);

            // ランダムなテキスト色を設定 (背景との差を考慮)
            $textColor = imagecolorallocate($image, rand(0, 100), rand(0, 100), rand(0, 100));

            // フォントサイズ設定（ランダム）
            $fontSize = rand(20, 30);
            $text = 'Team ' . $team->id;

            // 使用フォント (適切なフォントファイルを指定)
            $fontPath = public_path('fonts/kingyolanternmini.otf'); // Laravelの `public/fonts/arial.ttf` を指定

            // テキストの幅と高さを取得
            $bbox = imagettfbbox($fontSize, 0, $fontPath, $text);
            $textWidth = $bbox[2] - $bbox[0];
            $textHeight = $bbox[1] - $bbox[7];

            // テキストを中央に配置
            $textX = ($width - $textWidth) / 2;
            $textY = ($height - $textHeight) / 2 + $textHeight;

            // テキストを描画
            imagettftext($image, $fontSize, 0, $textX, $textY, $textColor, $fontPath, $text);

            // ランダムな形（円 or 長方形 or ライン）を描画
            switch (rand(1, 3)) {
                case 1: // 円
                    $circleColor = imagecolorallocate($image, rand(50, 150), rand(50, 150), rand(50, 150));
                    imagefilledellipse($image, rand(50, 250), rand(50, 250), rand(50, 150), rand(50, 150), $circleColor);
                    break;
                case 2: // 長方形
                    $rectColor = imagecolorallocate($image, rand(100, 200), rand(100, 200), rand(100, 200));
                    imagerectangle($image, rand(10, 100), rand(10, 100), rand(200, 290), rand(200, 290), $rectColor);
                    break;
                case 3: // 斜線
                    $lineColor = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
                    imageline($image, 0, 0, 300, 300, $lineColor);
                    imageline($image, 300, 0, 0, 300, $lineColor);
                    break;
            }

            // 画像を保存
            // 出力バッファリングを開始
            ob_start();

            // 画像をPNG形式で出力
            imagepng($image);

            // 出力バッファを取得して保存
            $imageData = ob_get_clean();

            // ストレージに保存
            Storage::put($path, $imageData);

            // メモリを解放
            imagedestroy($image);

            // データベースに画像情報を登録
            $team->image()->create([
                'imageable_id' => $team->id,
                'imageable_type' => Team::class,
                'path' => $path,
                'extension' => 'png',
                'mime_type' => 'image/png',
            ]);
        });

        $teams = Team::all();

        foreach ($teams as $team) {
            // 招待するチームを取得
            $invitees = Team::where('id', '!=', $team->id)->inRandomOrder()->take(3)->get();
            $guests = Team::where('id', '!=', $team->id)->inRandomOrder()->take(3)->get();

            // 招待を送る側のデータを作成
            foreach ($invitees as $invitee) {
                ConsentGame::factory()->create([
                    'invitee_id' => $team->id,
                    'guest_id' => $invitee->id,
                ]);
            }

            // 招待を受ける側のデータを作成
            foreach ($guests as $guest) {
                ConsentGame::factory()->create([
                    'invitee_id' => $guest->id,
                    'guest_id' => $team->id,
                ]);
            }
        }

        User::factory(10)->create()->each(function ($user) {
            $myTeamId = Team::inRandomOrder()->first()->id;
            $user->teamMember()->create([
                'team_id' => $myTeamId,
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
