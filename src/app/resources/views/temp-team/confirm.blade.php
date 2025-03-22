@php
use App\Enums\SportAffiliationTypeEnum;
use App\Enums\Prefecture;
@endphp
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>確認画面</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>確認画面</h3>
            </div>
            <div class="card-body">
                <div class="card">
                    <div class="card-header">
                        <h4>チーム登録</h4>
                    </div>
                    <div class="card-body">
                        <p>スポーツ種別：<span id="team-name">
                            {{ SportAffiliationTypeEnum::from($values['sportAffiliationType'])->label() }}
                        </span></p>
                        <p>チーム名：<span id="team-name">{{ $values['teamName'] }}</span></p>
                        <p>チームロゴ：
                            <img src="data:{{ $values['image_extension'] }};base64,{{ base64_encode(file_get_contents($values['teamLogo'])) }}"
                                id="team-logo" width="100" height="100" class="img-thumbnail">
                        </p>
                        <p>チームURL：
                            @if (!empty($values['teamUrl']))
                            <a href="{{ $values['teamUrl'] }}" id="team-url" target="_blank">{{ $values['teamUrl'] }}</a>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header">
                        <h4>チーム拠点</h4>
                    </div>
                    <div class="card-body">
                        <p>都道府県：<span id="team-prefecture">
                            {{ PREFECTURES::from([$values['prefecture']])->label() }}
                        </span></p>
                        <p>市町村区：<span id="team-address">{{ $values['address'] }}</span></p>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header">
                        <h4>ユーザ情報</h4>
                    </div>
                    <div class="card-body">
                        <p>ニックネーム：<span id="user-name">{{ $values['name'] }}</span></p>
                        <p>メールアドレス：<span id="user-email">{{ $values['email'] }}</span></p>
                        <p>パスワード：<span id="user-password">********</span></p>
                    </div>
                </div>
                <form action="{{ route('tmp_team_user.complete') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-primary mt-3 w-100">登録する</button>
                </form>
                <form action="{{ route('tmp_team_user.back') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-secondary mt-3 w-100">修正する</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>