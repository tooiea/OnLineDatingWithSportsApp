@php
use Illuminate\Support\Facades\Storage;
use App\Enums\SportAffiliationTypeEnum;
use App\Constants\FormConstant;
@endphp

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
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
                        <p>スポーツ種別：<span id="team-name">{{ SportAffiliationTypeEnum::from($values['sportAffiliationType'])->label() }}</span></p>
                        <p>チーム名：<span id="team-name">{{ $values['teamName'] }}</span></p>
                        <p>チームロゴ：　<img
                                src="data:{{ $values['imageExtension'] }};base64,{{ base64_encode(file_get_contents(Storage::url($values['imagePath']))) }}"
                                id="team-logo" class="team-logo" width="100" height="100"></p>
                        <p>チームURL：<a id="team-url" target="_blank">@if(!empty($values['teamUrl'])){{ $values['teamUrl'] }}@enderror</a></p>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header">
                        <h4>チーム拠点</h4>
                    </div>
                    <div class="card-body">
                        <p>都道府県：<span id="team-prefecture">{{ FormConstant::PREFECTURES[$values['prefecture']] }}</span></p>
                        <p>市町村区：<span id="team-address">{{ $values['address'] }}</span></p>
                    </div>
                </div>
                <form action="{{route('tmp_sns_create.complete')}}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-primary mt-3">登録する</button>
                </form>
                <form action="{{route('tmp_sns_create.back')}}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-secondary mt-3">修正する</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>