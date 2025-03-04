@php
use App\Enums\Prefecture;
use App\Enums\SportAffiliationTypeEnum;
@endphp
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/css/common.css">
  <title>Team Registration Form</title>
</head>
<body>
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">
        チームの登録をしましょう！
      </div>
      <div class="card-body">
        <form action="{{ route('temp_register.team.confirm') }}" method="post" enctype="multipart/form-data">
          @csrf
          <hr>
          <h5 class="card-title mb-4 sports">チームについて</h5>
          <hr>
          <div class="mb-3">
            <label for="sportAffiliationType" class="form-label">スポーツ種別</label>
            <select name="sportAffiliationType"
              class="form-control @error('sportAffiliationType') is-invalid @enderror"
              id="sportAffiliationType" aria-describedby="nameHelp">
              <option value="" disabled selected>選択してください</option>
              @foreach(SportAffiliationTypeEnum::cases() as $value)
              <option value="{{ $value->value }}" @if(old('sportAffiliationType')==$value->value))
                  selected @endif>{{ $value->name }}</option>
              @endforeach
            </select>
            <div id="sportAffiliationTypeHelp" class="form-text">登録するスポーツ種別を選択してください</div>
            @error('sportAffiliationType')<div class="invalid-feedback"> {{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label for="teamName" class="form-label">チーム名</label>
            <input type="text" name="teamName" value="{{ old('teamName') }}" id="teamName"
              class="form-control @error('teamName') is-invalid @enderror" placeholder="例：チーム名">
            <div id="teamNameHelp" class="form-text">所属しているチーム名を入力してください</div>
            @error('teamName')<div class="invalid-feedback"> {{ $message }} </div>@enderror
          </div>
          <div class="mb-3">
            <label for="teamLogo" class="form-label">チームロゴ画像</label>
            <input type="file" name="teamLogo" value="{{ old('teamLogo') }}" id="teamLogo"
              class="form-control @error('teamLogo') is-invalid @enderror">
            <div id="teamLogoHelp" class="form-text">jpg,jpeg,png形式のみ</div>
            @error('teamLogo')<div class="invalid-feedback"> {{ $message }} </div>@enderror
          </div>
          <div class="mb-3">
            <label for="teamUrl" class="form-label">チームのサイトや紹介できるSNSサイト</label>
            <input type="url" name="teamUrl" value="{{ old('teamUrl') }}" id="teamUrl"
              class="form-control @error('teamUrl') is-invalid @enderror" placeholder="例：https://facebook.com/oldws/">
            <div id="teamUrlHelp" class="form-text">facebookやinstagramなどチームを紹介などでご使用ください</div>
            @error('teamUrl')<div class="invalid-feedback"> {{ $message }} </div>@enderror
          </div>
          <hr>
          <h5 class="card-title mb-4 team">チーム活動について</h5>
          <hr>
          <div class="mb-3">
            <label for="prefecture" class="form-label">都道府県</label>
            <select name="prefecture" class="form-control @error('prefecture') is-invalid @enderror" id="prefecture">
              <option value="" disabled selected>選択してください</option>
              @foreach (Prefecture::cases() as $value)
              <option value="{{ $value }}" @if(old('prefecture') == $value)) selected @endif>{{ $value->label() }}</option>
              @endforeach
            </select>
            <div id="prefectureHelp" class="form-text">都道府県を選択してください</div>
            @error('prefecture')<div class="invalid-feedback"> {{ $message }} </div>@enderror
          </div>
          <div class="mb-3">
            <label for="address" class="form-label">市町村区</label>
            <input type="text" name="address" value="{{ old('address') }}" id="address"
              class="form-control @error('address') is-invalid @enderror" placeholder="例：宮崎市">
            <div id="addressHelp" class="form-text">チームの拠点を入力してください</div>
            @error('address')<div class="invalid-feedback"> {{ $message }} </div>@enderror
          </div>
          <hr>
          <h5 class="card-title mb-4 mt-3 user">ユーザについて</h5>
          <hr>
          <div class="mb-3">
            <label for="name" class="form-label">ニックネーム</label>
            <input type="text" name="name" value="{{ old('name') }}" id="name"
              class="form-control @error('name') is-invalid @enderror" placeholder="例：nickname">
            <div id="nameHelp" class="form-text">※本名での登録はご遠慮願います</div>
            @error('name')<div class="invalid-feedback"> {{ $message }} </div>@enderror
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}"
              class="form-control @error('email') is-invalid @enderror" id="email"
              placeholder="例：oldws@gmail.com">
            <div id="emailHelp" class="form-text">使用可能なメールアドレスを入力してください</div>
            @error('email')<div class="invalid-feedback"> {{ $message }} </div>@enderror
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">パスワード</label>
            <input type="password" name="password"
              class="form-control @error('password') is-invalid @enderror" id="password"
              placeholder="例：passW0rd">
						<div id="passwordHelp" class="form-text">半角英数字の小文字・大文字を最低1字含み、8文字以上で入力してください</div>
						@error('password')<div class="invalid-feedback"> {{ $message }} </div>@enderror
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary btn-lg">確認する</button>
          </div>
        </form>
      </div>
  </div>
</body>
</html>