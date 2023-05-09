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
    <link rel="stylesheet" href="/public/css/common.css?q">
    <title>Login Form</title>
  </head>
  <body>
    <div class="container-xl mt-5">
      <div class="row justify-content-center">
        <div class="col-sm-7 col-md-5">
          <div class="card">
            <div class="card-header">
              <h4>OLDwsへログイン</h4>
            </div>
            <div class="card-body">
              <form action="{{ route('login') }}" method="post">
                @csrf
                @if (session('user.register.error')) <div class="alert alert-danger" role="alert"> {!! session('user.register.error') !!} </div> @endif
                <div class="form-group">
                  <label for="email">メールアドレス</label>
                  <input type="email" name="email"
                      class="form-control @error('email') is-invalid @enderror" id="email"
                      placeholder="oldsws@gmail.com" aria-describedby="emailHelp">
                  @error('email')<small id="emailHelp" class="invalid-feedback" role="alert"> {{ $message }} </small> @enderror
                </div>
                <div class="form-group">
                  <label for="password">パスワード</label>
                  <input type="password" name="password"
                    class="form-control @error('password') is-invalid @enderror" id="password"
                    required autocomplete="password" placeholder="password">
                    @error('password') <small id="passwordHelp" class="invalid-feedback" role="alert"> {{ $message }} </small> @enderror
                </div>
                @if (session('user.registered')) <div class="alert alert-light" role="alert"> {!! session('user.registered') !!} </div> @endif
                @if (session('new-pw.status')) <div class="alert alert-light" role="alert"> {!! session('new-pw.status') !!} </div> @endif
                <button type="submit" class="btn btn-primary btn-block btn-lg mt-4">
                  ログインする
                </button>
                <a href="{{ route('tmp_team_user.index') }}" class="btn btn-info btn-block btn-lg mb-3">新しくチームを作る</a>
                @error('sns_login') <p class="text-danger small" role="alert"> {!! $message !!} </p>@enderror
                <p class="mb-0"><a href="{{ route('password.request') }}">→パスワードをお忘れの方はこちら</a></p>
                <div>
                  <hr />
                  <p>外部SNSアカウント</p>
                </div>
                <div class="row justify-content-center">
                  <div class="col" style="max-width: 100%;">
                    <div class="text-center border rounded-pill p-1 mt-2">
                      <a href="{{ route('google.login') }}" class="btn d-flex align-items-center">
                        <img src="/public/images/google.png" alt="Google Login" style="width: 15%; margin-right: 10px; margin-left: 10px;">
                        <span style="flex:1;">Google でログイン</span>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="row justify-content-center">
                  <div class="col" style="max-width: 100%;">
                    <div class="text-center border rounded-pill p-1 mt-2 mb-2">
                      <a href="{{ route('line.login') }}" class="btn d-flex align-items-center">
                        <img src="/public/images/LINE_Brand_icon.png" alt="Line Login" style="width: 15%; margin-right: 10px; margin-left: 10px;">
                        <span style="flex:1;">LINE でログイン</span>
                      </a>
                    </div>
                  </div>
                </div>
                <p class="small text-muted">
                  <small>-SNSアカウントログインについて-
                    <br>以下の方法で先にアカウント登録を行ってください
                    <br>*「新しくチームを作る」から新規登録を行う
                    <br>*チームが登録済みの場合、同じチームの方から登録用URLを共有頂き、ユーザ登録を行う
                  </small>
                </p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
