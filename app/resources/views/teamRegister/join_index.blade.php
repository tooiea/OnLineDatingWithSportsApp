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
        チームへ参加しましょう！
      </div>
      <div class="card-body">
        <form action="{{ route('tmp_team_user.confirm') }}" method="post" enctype="multipart/form-data">
          @csrf
          <h5 class="card-title mb-4">Team Information</h5>
          <div class="form-group">
            <label for="teamName">チーム名</label>
            <input type="text" name="teamName" value="{{ old('teamName') }}" id="teamName"
              aria-describedby="teamNameHelp" class="form-control @error('teamName') is-invalid @enderror" placeholder="例：チーム名">
            <small id="teamNameHelp" class="form-text text-muted">所属しているチーム名を入力してください</small>
            @error('teamName')<div class="invalid-feedback" role="alert"> {{ $message }} </div>@enderror
          </div>
          <button type="submit" class="btn btn-primary">確認する</button>
        </form>
      </div>
  </div>
</body>
</html>
