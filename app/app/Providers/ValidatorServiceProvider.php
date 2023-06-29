<?php

namespace App\Providers;

use App\Models\TeamAlbum;
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
        // チームアルバムのidが存在しているかをチェック
        Validator::extend(
            'exist_album_id', function ($attribute, $value, $parameters, $validator) {
                return TeamAlbum::isExistId($value);
            }
        );

        // チームアルバム内の画像枚数チェック
        Validator::extend(
            'imageQtyWithinMax', function ($attribute, $value, $parameters, $validator) {
                return TeamAlbum::isNumberOfImageWithinMaximum($value);
            }
        );
    }
}
