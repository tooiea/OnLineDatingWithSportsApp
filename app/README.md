# OnlineDatingWithSportsアプリケーション

### vendorインストール

composer install

### シンボリックリンク設定

php artisan storage:link

### シンボリックリンクを移動

mv public/storage ../WWW/public/storage

### 多言語化ディレクトリ

php artisan lang:publish

#### ファイルシステムインストール

composer require league/flysystem-aws-s3-v3 "^3.0"

### enumモジュール

composer require bensampo/laravel-enum

### SNSログイン

composer require laravel/socialite

### SNS:LINE

composer require socialiteproviders/line

### SNE:LINE_bot

composer require linecorp/line-bot-sdk

#### 全てインストール後に、設定ファイル反映

php artisan config:cache

#### 設定確認

php artisan about
