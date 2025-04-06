<?php

namespace App\Providers;

use App\Models\Album;
use App\Models\Code;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        /**
         * バリデーションルール
         * チームアルバムの画像の存在チェック
         */
        Validator::extend(
            'exist_team_album',
            function ($attribute, $value, $parameters, $validator) {
                return Album::existTeamAlbum($value);
            }
        );

        /**
         * バリデーションルール
         * アルバムの画像数が上限を超えていないか
         */
        Validator::extend('max_in_album', function ($attribute, $value, $parameters, $validator) {
            $max = (int)$parameters[0];
            $album = Album::withCount('image')->find($value['id']);
            if (empty($album)) {
                return true;
            }

            $currentInAlbum = $album->image_count;
            $countIn = ! empty($value['addImages']) ? count($value['addImages']) : 0;
            $countOut = ! empty($value['deleteImages']) ? count($value['deleteImages']) : 0;
            $count = $currentInAlbum + $countIn - $countOut;
            return $count <= $max;
        });

        /**
         * バリデーションルール
         * チームの招待コード存在確認
         */
        Validator::extend('exist_team_code', function ($attribute, $value, $parameters, $validator) {
            return Code::existTeamCode($value);
        });
    }
}
