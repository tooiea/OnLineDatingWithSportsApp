<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="container">
            <h4 class="pl-5">チーム登録</h4>
            <div class="row m-5">
                <div class="col text-center">スポーツ種別</div>
                <div class="col text-center">{{
                    \App\Enums\SportAffiliationTypeEnum::from($values['sportAffiliationType'])->label() }}</div>
            </div>
            <div class="row m-5">
                <div class="col text-center">チーム名</div>
                <div class="col text-center">{{ $values['teamName'] }}</div>
            </div>
            <div class="row m-5">
                <div class="col text-center">チームロゴ画像</div>
                <div class="col text-center">
                    <img src="{{ asset($values['teamLogo']) }}" alt="" width="150" height="150">
                </div>
            </div>
            <div class="row m-5">
                <div class="col text-center">チーム紹介サイト</div>
                <div class="col text-center">@if(!empty($values['teamUrl'])){{ $values['teamUrl'] }}@enderror</div>
            </div>
        </div>
        <div class="container">
            <h4 class="pl-5">チーム登録</h4>
            <div class="row m-5">
                <div class="col text-center">都道府県</div>
                <div class="col text-center">{{ \App\Constants\FormConstant::PREFECTURES[$values['prefecture']] }}</div>
            </div>
            <div class="row m-5">
                <div class="col text-center">市町村区</div>
                <div class="col text-center">{{ $values['address'] }}</div>
            </div>
        </div>
        <div class="container">
            <h4 class="pl-5">ユーザ情報</h4>
            <div class="row m-5">
                <div class="col text-center">ニックネーム</div>
                <div class="col text-center">{{ $values['name'] }}</div>
            </div>
            <div class="row m-5">
                <div class="col text-center">メールアドレス</div>
                <div class="col text-center">{{ $values['email'] }}</div>
            </div>
        </div>
        <div class="row m-5">
            <div class="col">
                <form action="{{route('tmp_team_user.back')}}" method="post">
                    @csrf
                    <input type="submit" value="入力内容を修正" class="form-control btn btn-secondary">
                </form>
            </div>
            <div class="col">
                <form action="{{route('tmp_team_user.complete')}}" method="post">
                    @csrf
                    <input type="submit" value="仮登録メールを送信" class="form-control btn btn-success">
                </form>
            </div>
        </div>
    </div>
</body>

</html>