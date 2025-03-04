<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/css/common.css">
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
                            @if (session('user.register.error'))
                                <div class="alert alert-danger" role="alert">
                                    {!! session('user.register.error') !!}
                                </div>
                            @endif
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">メールアドレス</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" id="email"
                                    placeholder="oldsws@gmail.com">
                                @error('email')
                                    <div class="invalid-feedback"> {{ $message }} </div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">パスワード</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" id="password"
                                    placeholder="password">
                                @error('password')
                                    <div class="invalid-feedback"> {{ $message }} </div>
                                @enderror
                            </div>

                            @if (session('user.registered'))
                                <div class="alert alert-light" role="alert">
                                    {!! session('user.registered') !!}
                                </div>
                            @endif
                            @if (session('new-pw.status'))
                                <div class="alert alert-light" role="alert">
                                    {!! session('new-pw.status') !!}
                                </div>
                            @endif

                            <a href="{{ route('temp_register.team.index') }}" class="btn btn-info w-100 mt-4 btn-lg">新しくチームを作る</a>
                            <button type="submit" class="btn btn-primary w-100 btn-lg mb-2">ログインする</button>
                            <div class="text-center">
                                <a href="{{ route('password.request') }}">→パスワードをお忘れの方はこちら</a>
                            </div>
                            
                            <hr>

                            <div class="row">
                                <div class="col">
                                    <div class="text-center">
                                        <a href="{{ route('google.login') }}" class="btn w-100 btn-lg">
                                            <img src="/images/btn_google_signin_dark_normal_web@2x.png" alt="Google Login" class="img-fluid">
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col">
                                    <div class="text-center">
                                        <a href="{{ route('line.login') }}" class="btn w-100 btn-lg">
                                            <img src="/images/btn_login_base.png" alt="Line Login" class="img-fluid">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div> <!-- card-body -->
                </div> <!-- card -->
            </div> <!-- col -->
        </div> <!-- row -->
    </div> <!-- container -->
</body>
</html>