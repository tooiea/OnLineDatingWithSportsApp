<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <link rel="stylesheet" href="/public/css/common.css?q">
  <title>Team Registration Form</title>
</head>
<body>
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">
        チームの登録をしましょう！
      </div>
      <div class="card-body">
        <form action="{{ route('tmp_sns_create.confirm') }}" method="post" enctype="multipart/form-data">
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
            <label for="imagePath">チームロゴ画像</label>
            <input type="file" name="imagePath" value="{{ old('imagePath') }}" id="imagePath" aria-describedby="teamNameHelp"
              class="form-control-file @error('imagePath') is-invalid @enderror" placeholder="例：チーム名">
            <small id="imagePathHelp" class="form-text text-muted">jpg,jpeg,png形式のみ</small>
            @error('imagePath')<div class="invalid-feedback" role="alert"> {{ $message }} </div>@enderror
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
          <button type="submit" class="btn btn-primary">確認する</button>
        </form>
      </div>
  </div>
</body>
</html>
