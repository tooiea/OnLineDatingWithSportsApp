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
                <div class="col text-center">test</div>
            </div>
            <div class="row m-5">
                <div class="col text-center">パスワード</div>
                <div class="col text-center">********</div>
            </div>
            <div class="row m-5">
                <div class="col text-center">招待コード</div>
                <div class="col text-center"></div>
            </div>
        </div>
        <div class="container">
            <h4 class="pl-5">チーム登録</h4>
            <div class="row m-5">
                <div class="col text-center">スポーツ種別</div>
                <div class="col text-center">test</div>
            </div>
            <div class="row m-5">
                <div class="col text-center">パスワード</div>
                <div class="col text-center">********</div>
            </div>
            <div class="row m-5">
                <div class="col text-center">招待コード</div>
                <div class="col text-center"></div>
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