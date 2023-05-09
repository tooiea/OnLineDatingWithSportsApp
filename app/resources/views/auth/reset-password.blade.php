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
    <title>新しいパスワード設定</title>
  </head>
  <body>
    <div class="container-fluid mt-5">
      <div class="row justify-content-center">
        <div class="col-sm-8 col-md-6 col-lg-4">
          <div class="card">
            <div class="card-header">
              <h3>新しいパスワード設定</h3>
            </div>
            <div class="card-body">
              <form action="{{ route('password.update') }}" method="post">
                @csrf
                @if (session('new-pw.status')) <div class="alert alert-danger" role="alert"> {!! session('new-pw.status') !!} </div> @endif
                <div class="form-group">
                  <input type="hidden" name="token" value="{{ $request->route('token')}}">
                  <label for="email">メールアドレス</label>
                  <input type="email" name="email"
                      class="form-control @error('email') is-invalid @enderror" id="email"
                      placeholder="登録しているメールアドレス" aria-describedby="emailHelp"
                      value="{{ !empty(old('email')) ? old('email') : $request->email }}"
                  >
                  @error('email')<small id="emailHelp" class="invalid-feedback" role="alert"> {{ $message }} </small> @enderror
                </div>
                <div class="form-group">
                  <label for="password">パスワード</label>
                  <input type="password" name="password"
                      class="form-control @error('password') is-invalid @enderror" id="password"
                      placeholder="以下のルールで入力してください">
                    <small style="font-size: 0.7rem; color:#999;">*8文字以上で半角英数(大文字/小文字/数字)を含む</small>
                  @error('password')<small id="passwordHelp" class="invalid-feedback" role="alert"> {{ $message }} </small> @enderror
                </div>
                <div class="form-group">
                  <label for="password_confirmation">パスワード確認</label>
                  <input type="password" name="password_confirmation"
                      class="form-control" id="password_confirmation"
                      placeholder="上記と同じ入力">
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                  登録
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
