<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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
            <form action="{{route('tmp_user.back')}}" method="post">
                @csrf
                <input type="submit" value="入力内容を修正" class="form-control btn btn-secondary">
            </form>
        </div>
        <div class="col">
            <form action="{{route('tmp_user.registered')}}" method="post">
                @csrf
                <input type="submit" value="仮登録メールを送信" class="form-control btn btn-success">
            </form>
        </div>
    </div>
</body>
</html>