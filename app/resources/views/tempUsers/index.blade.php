<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="/public/css/common.css?q">
  <title>Team Registration Form</title>
</head>
<body>
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">
        チームに登録をしましょう！
      </div>
      <div class="card-body">
        <form action="{{ route('tmp_user.confirm') }}" method="post">
            @csrf
          <hr>
          <h5 class="card-title mb-4 mt-5 user">ユーザについて</h5>
          <hr>
          <div class="form-group">
            <label for="name">ニックネーム</label>
            <input type="text" name="name" value="{{ old('name') }}" id="name" aria-describedby="nameHelp"
                    class="form-control @error('name') is-invalid @enderror" placeholder="例：nickname">
            <small id="nameHelp" class="form-text text-muted">※本名での登録はご遠慮願います</small>
            @error('name')<div class="invalid-feedback" role="alert"> {{ $message }} </div>@enderror
          </div>
          <div class="form-group">
            <label for="email">メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror" id="email"
                    aria-describedby="emailHelp" placeholder="例：oldws@gmail.com">
            <small id="emailHelp" class="form-text text-muted">使用可能なメールアドレスを入力してください</small>
            @error('email')<div class="invalid-feedback" role="alert"> {{ $message }} </div>@enderror
          </div>
          <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" name="password"
                    class="form-control @error('password') is-invalid @enderror" id="password"
                    aria-describedby="passwordHelp" placeholder="例：passW0rd">
            <small id="passwordHelp"
                    class="form-text text-muted">半角英数字の小文字・大文字を最低1字含み、8文字以上で入力してください</small>
            @error('password')<div class="invalid-feedback" role="alert"> {{ $message }} </div>@enderror
          </div>
          <div class="form-group">
            <label for="password2">パスワード：再入力</label>
            <input type="password" name="password2"
                    class="form-control @error('password2') is-invalid @enderror" id="password2"
                    aria-describedby="passwordHelp" placeholder="例：passW0rd">
            <small id="passwordHelp" class="form-text text-muted">上記のパスワードと同じ入力をしてください</small>
            @error('password2')<div class="invalid-feedback" role="alert"> {{ $message }} </div>@enderror
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary btn-lg">確認する</button>
          </div>
        </form>
      </div>
  </div>
</body>
</html>
