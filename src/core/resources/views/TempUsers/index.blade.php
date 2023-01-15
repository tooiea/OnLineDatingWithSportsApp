<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Document</title>
</head>

<body>
    <div class="form-group">
        <form action="{{ route('tmp_user.confirm') }}" method="post">
            @csrf
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label">お名前(ニックネーム)</label>
                <div class="col-sm-8">
                    <input type="text" name="name" value="{{ old('name') }}" id="name" aria-describedby="nameHelp"
                        class="form-control @error('name') is-invalid @enderror" placeholder="例：nickname">
                    <small id="nameHelp" class="form-text text-muted">ニックネームでの登録可</small>
                    <!--   classをエラー時に付与 -->
                    @error('name')<div class="alert alert-danger" role="alert">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label">メールアドレス</label>
                <div class="col-sm-8">
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror" id="email"
                        aria-describedby="emailHelp" placeholder="例：oldws@gmail.com">
                    <small id="emailHelp" class="form-text text-muted">使用可能なメールアドレスを入力してください</small>
                    @error('email')<div class="invalid-feedback" role="alert">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-3 col-form-label">パスワード</label>
                <div class="col-sm-8">
                    <input type="password" name="password" class="form-control @error('email') is-invalid @enderror"
                        id="password" aria-describedby="passwordHelp" placeholder="例：passW0rd">
                    <small id="passwordHelp" class="form-text text-muted">半角英数字の小文字・大文字を最低1字含み、8文字以上で入力してください</small>
                    @error('password')<div class="invalid-feedback" role="alert">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="password2" class="col-sm-3 col-form-label">パスワード(再入力)</label>
                <div class="col-sm-8">
                    <input type="password" name="password2" class="form-control @error('email') is-invalid @enderror"
                        id="password2" aria-describedby="passwordHelp" placeholder="例：passW0rd">
                    <small id="passwordHelp" class="form-text text-muted">上記のパスワードと同じ入力をしてください</small>
                    @error('password2')<div class="invalid-feedback" role="alert">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="invitationCode" class="col-sm-3 col-form-label">チーム招待コード</label>
                <div class="col-sm-8">
                    <input type="text" name="invitationCode" value="{{ old('invitationCode') }}"
                        aria-describedby="invitationCodeHelp"
                        class="form-control @error('invitationCode') is-invalid @enderror" id="invitationCode">
                    <small id="invitationCodeHelp" class="form-text text-muted">同じチームの方にもらった招待コードを入力してください</small>
                    @error('invitationCode')<div class="invalid-feedback" role="alert">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="form-group">
                <input type="submit" value="送信する" class="btn btn-primary btn-lg btn-block">
            </div>
        </form>
    </div>
</body>

</html>