<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <title>Team Registration Form</title>
</head>
<body>
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">
        チームの登録をしましょう！
      </div>
      <div class="card-body">
        <form action="{{ route('tmp_team_user.confirm') }}" method="post" enctype="multipart/form-data">
          @csrf
          <h5 class="card-title mb-4">Team Information</h5>
          <div class="form-group">
            <label for="teamName">スポーツ種別</label>
            <select name="sportAffiliationType"
              class="form-control @error('sportAffiliationType') is-invalid @enderror"
              id="sportAffiliationType" aria-describedby="nameHelp">
              <option value="" disabled selected>選択してください</option>
              @foreach(\App\Enums\SportAffiliationTypeEnum::cases() as $value)
              <option value="{{ $value->value }}" @if(old('sportAffiliationType')==$value->value))
                  selected @endif>{{ $value->name }}</option>
              @endforeach
            </select>
            <small id="sportAffiliationTypeHelp" class="form-text text-muted">登録するスポーツ種別を選択してください</small>
            @error('sportAffiliationType')<div class="invalid-feedback" role="alert"> {{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="teamName">チーム名</label>
            <input type="text" name="teamName" value="{{ old('teamName') }}" id="teamName"
              aria-describedby="teamNameHelp" class="form-control @error('teamName') is-invalid @enderror" placeholder="例：チーム名">
            <small id="teamNameHelp" class="form-text text-muted">所属しているチーム名を入力してください</small>
            @error('teamName')<div class="invalid-feedback" role="alert"> {{ $message }} </div>@enderror
          </div>
          <div class="form-group">
            <label for="teamLogo">チームロゴ画像</label>
            <input type="file" name="teamLogo" value="{{ old('teamLogo') }}" id="teamLogo" aria-describedby="teamNameHelp"
              class="form-control-file @error('teamLogo') is-invalid @enderror" placeholder="例：チーム名">
            <small id="teamLogoHelp" class="form-text text-muted">jpg,jpeg,png形式のみ</small>
            @error('teamLogo')<div class="invalid-feedback" role="alert"> {{ $message }} </div>@enderror
          </div>
          <div class="form-group">
            <label for="teamURL">チームのサイトや紹介できるSNSサイト</label>
            <input type="url" name="teamUrl" value="{{ old('teamUrl') }}" id="teamUrl"
              aria-describedby="teamUrlHelp" class="form-control @error('teamUrl') is-invalid @enderror" placeholder="例：https://facebook.com/oldws/">
            <small id="teamUrlHelp" class="form-text text-muted">facebookやinstagramなどチームを紹介などでご使用ください</small>
            @error('teamUrl')<div class="invalid-feedback" role="alert"> {{ $message }} </div>@enderror
          </div>
          <h5 class="card-title mb-4 mt-5">チームが主に活動するエリア</h5>
          <div class="form-group">
            <label for="prefecture">都道府県</label>
            <select name="prefecture" class="form-control @error('prefecture') is-invalid @enderror" id="prefecture" aria-describedby="nameHelp">
              <option value="" disabled selected>選択してください</option>
              @foreach (\App\Constants\FormConstant::PREFECTURES as $key => $value)
              <option value="{{ $key }}" @if(old('prefecture')==$key)) selected @endif>{{ $value }}</option>
              @endforeach
            </select>
            <small id="prefectureHelp" class="form-text text-muted">都道府県を選択してください</small>
            @error('prefecture')<div class="invalid-feedback" role="alert"> {{ $message }} </div>@enderror
          </div>
          <div class="form-group">
            <label for="address">市町村区</label>
            <input type="text" name="address" value="{{ old('address') }}" id="address"
              aria-describedby="addressHelp" class="form-control @error('address') is-invalid @enderror"
              placeholder="例：宮崎市">
            <small id="addressHelp" class="form-text text-muted">チームの拠点を入力してください</small>
            @error('address')<div class="invalid-feedback" role="alert"> {{ $message }} </div>@enderror
          </div>
          <h5 class="card-title mb-4 mt-5">User Information</h5>
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
          <button type="submit" class="btn btn-primary">確認する</button>
        </form>
      </div>
  </div>
</body>
</html>