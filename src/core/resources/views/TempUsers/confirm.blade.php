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
                <form action="{{route('tmp_user.registered')}}" method="post">
                    @csrf
                    <input type="submit" value="仮登録メールを送信" class="form-control btn btn-success">
                </form>
                <form action="{{route('tmp_user.back')}}" method="post">
                    @csrf
                    <input type="submit" value="入力内容を修正" class="form-control btn btn-secondary mt-2">
                </form>
            </div>
        </div>
    </div>
</body>
</html>