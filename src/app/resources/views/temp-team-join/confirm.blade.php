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
                
                <form action="{{ route('tmp_user.registered') }}" method="post" class="mt-3">
                    @csrf
                    <button type="submit" class="btn btn-success w-100">仮登録メールを送信</button>
                </form>
                
                <form action="{{ route('tmp_user.back') }}" method="post" class="mt-2">
                    @csrf
                    <button type="submit" class="btn btn-secondary w-100">入力内容を修正</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>