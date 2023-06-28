<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="/public/css/common.css?q">
  <style>
    .card-body p {
      margin-bottom: 20px;
    }
  </style>
  <title>Team Detail</title>
</head>

<body class="body-with-nav">
  @include('layouts.nav')
  <div class="container my-5">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">チームプロフィール</h4>
      </div>
      <div class="card-body">
        <p><span class="mr-5">チーム名</span>{{ $myTeam->team->team_name }}</p>
        <p><span class="mr-4">チームロゴ</span><img
          src="data:{{ $myTeam->team->image_extension }};base64,{{ base64_encode(file_get_contents('public' . Illuminate\Support\Facades\Storage::url($myTeam->team->image_path))) }}"
          class="img-fluid" alt="team logo" />
        </p>
        <p><span class="mr-5">登録人数</span>{{ $teamMembersNumber }}人</p>
        <p><span class="mr-1">チーム紹介URL</span>
          @if(!empty($myTeam->team->team_url))
          <br><a href="{{ $myTeam->team->team_url }}">{{ $myTeam->team->team_url }}</a>
          @else
          　未登録
          @endif
        </p>
        <p>このチームに招待する(ユーザ登録)</p>
        <div class="input-group">
          <input type="text" class="form-control" id="myInput" readonly disabled
            value="{{ sprintf(url(__('route_const.invite_in_team') . '%s'), $myTeam->team->invitation_code) }}">
          <div class="input-group-append">
            <button class="btn btn-outline-secondary copy-button" type="button">Copy<i
                class="fas fa-angle-right ml-2"></i></button>
          </div>
          <br>

        </div>
        <small class="small text-muted">*同じチームに招待したい場合、このリンクを共有してください</small>
        <div class="alert alert-success fade" role="alert" id="copy-alert">
          コピーしました
        </div>

        <!-- TODO 後日実装 -->
        <!-- <p>アルバム画像:</p>
          <div class="row">
            <div class="col-4">
              <img src="album_image_1.jpg" alt="album image 1" />
            </div>
            <div class="col-4">
              <img src="album_image_2.jpg" alt="album image 2" />
            </div>
          </div> -->
        <button class="btn btn-primary edit-button" type="button" onclick="location.href='{{ route('team.edit') }}'">編集する</button>
      </div>
    </div>
  </div>
  <script>
    const copyButton = document.querySelector('.copy-button');
    const input = document.querySelector('#myInput');
    const alert = document.querySelector('#copy-alert');

    copyButton.addEventListener('click', () => {
      input.select();
      document.execCommand('copy');
      alert.classList.add('show');
      setTimeout(() => {
        alert.classList.remove('show');
      }, 3000);
    });
  </script>
</body>

</html>
