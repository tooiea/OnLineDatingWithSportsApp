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
    <title>パスワード再設定</title>
  </head>
  <body>
    <div class="container-fluid mt-5">
      <div class="row justify-content-center">
        <div class="col-sm-8 col-md-6 col-lg-4">
          <div class="card">
            <div class="card-header">
              <h3>パスワード再設定</h3>
            </div>
            <div class="card-body">
              <form action="{{ route('password.email') }}" method="post">
                @csrf
                @if (session('pw-forgot.status')) <div class="alert alert-danger" role="alert"> {!! session('pw-forgot.status') !!} </div> @endif
                <div class="form-group">
                  <label for="email">メールアドレス</label>
                  <input type="email" name="email"
                      class="form-control @error('email') is-invalid @enderror" id="email"
                      placeholder="メールアドレス" aria-describedby="emailHelp">
                  @error('email')<small id="emailHelp" class="invalid-feedback" role="alert"> {{ $message }} </small> @enderror
                </div>
                <input type="submit" class="btn btn-primary btn-block" value="送信">
              </input>
              </form>
              <div class="mt-3">
                <p class="text-center">*登録しているメールアドレスを入力してください</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
