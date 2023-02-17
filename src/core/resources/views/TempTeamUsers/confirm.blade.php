<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <title>確認画面</title>
</head>

<body>
    <div class="container">
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
                        <p>スポーツ種別：<span id="team-name">{{
                                \App\Enums\SportAffiliationTypeEnum::from($values['sportAffiliationType'])->label()
                                }}</span></p>
                        <p>チーム名：<span id="team-name">{{ $values['teamName'] }}</span></p>
                        <p>チームロゴ：<img
                                src="data:{{ $values['image_extension'] }};base64,{{ base64_encode(file_get_contents($values['teamLogo'])) }}"
                                id="team-logo" width="100" height="100"></p>
                        <p>チームURL：<a id="team-url" target="_blank">@if(!empty($values['teamUrl'])){{ $values['teamUrl']
                                }}@enderror</a></p>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header">
                        <h4>チーム拠点</h4>
                    </div>
                    <div class="card-body">
                        <p>都道府県：<span id="team-prefecture">{{
                                \App\Constants\FormConstant::PREFECTURES[$values['prefecture']] }}</span></p>
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
                <form action="{{route('tmp_team_user.complete')}}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-primary mt-3">登録する</button>
                </form>
                <form action="{{route('tmp_team_user.back')}}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-secondary mt-3">修正する</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>