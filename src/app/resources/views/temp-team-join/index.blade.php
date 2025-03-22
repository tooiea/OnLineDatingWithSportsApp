<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Team Registration Form</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="/css/common.css">
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
          <div class="mb-3">
            <label for="name" class="form-label">ニックネーム</label>
            <input type="text" name="name" value="{{ old('name') }}" id="name"
                   class="form-control @error('name') is-invalid @enderror" placeholder="例：nickname">
            <div class="form-text text-muted">※本名での登録はご遠慮願います</div>
            @error('name')<div class="invalid-feedback"> {{ $message }} </div>@enderror
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror" id="email"
                   placeholder="例：oldws@gmail.com">
            <div class="form-text">使用可能なメールアドレスを入力してください</div>
            @error('email')<div class="invalid-feedback"> {{ $message }} </div>@enderror
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">パスワード</label>
            <input type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror" id="password"
                   placeholder="例：passW0rd">
            <div class="form-text">半角英数字の小文字・大文字を最低1字含み、8文字以上で入力してください</div>
            @error('password')<div class="invalid-feedback"> {{ $message }} </div>@enderror
          </div>

          <div class="mb-3">
            <label for="password2" class="form-label">パスワード：再入力</label>
            <input type="password" name="password2"
                   class="form-control @error('password2') is-invalid @enderror" id="password2"
                   placeholder="例：passW0rd">
            <div class="form-text">上記のパスワードと同じ入力をしてください</div>
            @error('password2')<div class="invalid-feedback"> {{ $message }} </div>@enderror
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-primary btn-lg w-100">確認する</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>