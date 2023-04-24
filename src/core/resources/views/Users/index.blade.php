<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
      integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="/public/css/common.css">
    <title>Login Form</title>
    <style>
      body {
        padding-top: 0;
      }
    </style>
  </head>
  <body>
    <div class="container-xl mt-5">
      <div class="row justify-content-center">
        <div class="col-sm-7 col-md-5">
          <div class="card">
            <div class="card-header">
              <h3>Login</h3>
            </div>
            <div class="card-body">
              <form action="{{ route('login') }}" method="post">
                @csrf
                @if (session('user.register.error')) <div class="alert alert-danger" role="alert"> {!! session('user.register.error') !!} </div> @endif
                <div class="form-group">
                  <label for="email">メールアドレス</label>
                  <input type="email" name="email"
                      class="form-control @error('email') is-invalid @enderror" id="email"
                      placeholder="メールアドレス" aria-describedby="emailHelp">
                  @error('email')<small id="emailHelp" class="invalid-feedback" role="alert"> {{ $message }} </small> @enderror
                </div>
                <div class="form-group">
                  <label for="password">パスワード</label>
                  <input type="password" name="password"
                    class="form-control @error('password') is-invalid @enderror" id="password"
                    required autocomplete="password" placeholder="パスワード">
                    @error('password') <small id="passwordHelp" class="invalid-feedback" role="alert"> {{ $message }} </small> @enderror
                </div>
                @if (session('user.registered')) <div class="alert alert-light" role="alert"> {!! session('user.registered') !!} </div> @endif
                @if (session('new-pw.status')) <div class="alert alert-light" role="alert"> {!! session('new-pw.status') !!} </div> @endif
                <a href="{{ route('tmp_team_user.index') }}" class="btn btn-info btn-block mt-4 btn-lg">新しくチームを作る</a>
                <button type="submit" class="btn btn-primary btn-block btn-lg mb-2">
                  ログインする
                </button>
                <a href="{{ route('password.request') }}">→パスワードをお忘れの方はこちら</a>
                <hr />
                <a href="{{ route('google.login') }}" class="btn btn-block btn-lg"><img src="/public/images/btn_google_signin_dark_normal_web.png"></a>
                <a href="{{ route('line.login') }}" class="btn btn-block btn-lg"><img src="/public/images/btn_login_base.png" alt="" class="btn"></a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
