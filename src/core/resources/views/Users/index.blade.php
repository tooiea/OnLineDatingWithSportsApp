<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('public/'. 'css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">ログイン</div>
                    <div class="card-body">
                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right" for="email">メールアドレス</label>
                                <div class="col-md-6">
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror" id="email"
                                        placeholder="メールアドレス">
                                    @error('email') <div class="invalid-feedback" role="alert"> {{ $message }} </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right" for="password">パスワード</label>
                                <div class="col-md-6">
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror" id="password"
                                        required autocomplete="password" placeholder="パスワード">
                                    @error('password') <div class="invalid-feedback" role="alert"> {{ $message }} </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 offset-md-4">
                                    <button class="btn btn-primary ml-3">ログイン</button>
                                </div>
                            </div>
                            @if (session('user.registered')) <div class="alert alert-light" role="alert"> {{
                                session('user.registered')
                                }} </div> @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>