<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
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

            // 画像のパス
            $path = "images/teams/{$team->id}.png";

            // 画像サイズの設定
            $width = 300;
            $height = 300;

            // 画像リソースを作成
            $image = imagecreatetruecolor($width, $height);

            // 背景色を設定 (グレー色)
            $bgColor = imagecolorallocate($image, 204, 204, 204);
            imagefill($image, 0, 0, $bgColor);

            // テキスト色（黒色）を設定
            $textColor = imagecolorallocate($image, 0, 0, 0);

            // テキストを画像に描画 (GDのデフォルトフォント)
            $fontSize = 5; // GD標準フォントサイズ (1〜5)
            $text = 'Team ' . $team->id;
            $textWidth = imagefontwidth($fontSize) * strlen($text);
            $textHeight = imagefontheight($fontSize);

            // テキストを中央に配置
            $x = ($width - $textWidth) / 2;
            $y = ($height - $textHeight) / 2;
            imagestring($image, $fontSize, $x, $y, $text, $textColor);

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
            $team->image()->create([
                'imageable_id' => $team->id,
                'imageable_type' => Team::class,
                'path' => $path,
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
