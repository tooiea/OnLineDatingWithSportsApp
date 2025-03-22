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
        チームの登録をしましょう！
      </div>
      <div class="card-body">
        <form action="{{ route('tmp_team_user.confirm') }}" method="post" enctype="multipart/form-data">
          @csrf
          <h5 class="card-title mb-4">Team Information</h5>

          <div class="mb-3">
            <label for="sportAffiliationType" class="form-label">スポーツ種別</label>
            <select name="sportAffiliationType"
              class="form-control @error('sportAffiliationType') is-invalid @enderror"
              id="sportAffiliationType">
              <option value="" disabled selected>選択してください</option>
              @foreach(\App\Enums\SportAffiliationTypeEnum::cases() as $value)
              <option value="{{ $value->value }}" @if(old('sportAffiliationType')==$value->value)) selected @endif>{{ $value->name }}</option>
              @endforeach
            </select>
            <div class="form-text">登録するスポーツ種別を選択してください</div>
            @error('sportAffiliationType')<div class="invalid-feedback"> {{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label for="teamName" class="form-label">チーム名</label>
            <input type="text" name="teamName" value="{{ old('teamName') }}" id="teamName"
              class="form-control @error('teamName') is-invalid @enderror" placeholder="例：チーム名">
            <div class="form-text">所属しているチーム名を入力してください</div>
            @error('teamName')<div class="invalid-feedback"> {{ $message }} </div>@enderror
          </div>

          <div class="mb-3">
            <label for="teamLogo" class="form-label">チームロゴ画像</label>
            <input type="file" name="teamLogo" id="teamLogo"
              class="form-control @error('teamLogo') is-invalid @enderror">
            <div class="form-text">jpg, jpeg, png形式のみ</div>
            @error('teamLogo')<div class="invalid-feedback"> {{ $message }} </div>@enderror
          </div>

          <div class="mb-3">
            <label for="teamUrl" class="form-label">チームのサイトや紹介できるSNSサイト</label>
            <input type="url" name="teamUrl" value="{{ old('teamUrl') }}" id="teamUrl"
              class="form-control @error('teamUrl') is-invalid @enderror" placeholder="例：https://facebook.com/oldws/">
            <div class="form-text">facebookやinstagramなどチームを紹介などでご使用ください</div>
            @error('teamUrl')<div class="invalid-feedback"> {{ $message }} </div>@enderror
          </div>

          <h5 class="card-title mb-4 mt-5">チームが主に活動するエリア</h5>

          <div class="mb-3">
            <label for="prefecture" class="form-label">都道府県</label>
            <select name="prefecture" class="form-control @error('prefecture') is-invalid @enderror" id="prefecture">
              <option value="" disabled selected>選択してください</option>
              @foreach (\App\Constants\FormConstant::PREFECTURES as $key => $value)
              <option value="{{ $key }}" @if(old('prefecture')==$key)) selected @endif>{{ $value }}</option>
              @endforeach
            </select>
            <div class="form-text">都道府県を選択してください</div>
            @error('prefecture')<div class="invalid-feedback"> {{ $message }} </div>@enderror
          </div>

          <div class="mb-3">
            <label for="address" class="form-label">市町村区</label>
            <input type="text" name="address" value="{{ old('address') }}" id="address"
              class="form-control @error('address') is-invalid @enderror" placeholder="例：宮崎市">
            <div class="form-text">チームの拠点を入力してください</div>
            @error('address')<div class="invalid-feedback"> {{ $message }} </div>@enderror
          </div>

          <h5 class="card-title mb-4 mt-5">User Information</h5>

          <div class="mb-3">
            <label for="name" class="form-label">ニックネーム</label>
            <input type="text" name="name" value="{{ old('name') }}" id="name"
              class="form-control @error('name') is-invalid @enderror" placeholder="例：nickname">
            <div class="form-text">※本名での登録はご遠慮願います</div>
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

          <button type="submit" class="btn btn-primary w-100">確認する</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>