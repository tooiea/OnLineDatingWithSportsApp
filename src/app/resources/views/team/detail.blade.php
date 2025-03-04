<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Team Detail</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="/css/common.css">
</head>

<body class="body-with-nav">
  @include('layouts.nav')

  <div class="container my-5">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">チームプロフィール詳細</h3>
      </div>
      <div class="card-body">
        <h5>チーム名</h5>
        <p>{{ $myTeam->team->team_name }}</p>
        <p>
          <img src="data:{{ $myTeam->team->image_extension }};base64,{{ base64_encode(file_get_contents($myTeam->team->team_logo)) }}"
            class="img-fluid" alt="team logo">
        </p>

        <h5>登録人数</h5>
        <p>{{ $teamMembersNumber }}人</p>

        <h5>チーム紹介URL</h5>
        <p>
          <a href="{{ $myTeam->team->team_url }}">{{ $myTeam->team->team_url }}</a>
          @empty($myTeam->team->team_url)
          -
          @endempty
        </p>

        <h5>他選手の招待URL</h5>
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="myInput"
            value="{{ sprintf(url(__('route_const.invite_in_team') . '%s'), $myTeam->team->invitation_code) }}" readonly>
          <button class="btn btn-outline-secondary copy-button" type="button">Copy<i class="fas fa-angle-right ms-2"></i></button>
        </div>

        <div class="alert alert-success fade" role="alert" id="copy-alert">
          コピーしました
        </div>

        <!-- TODO: 後日実装 -->
        <!-- 
        <h5>アルバム画像:</h5>
        <div class="row">
          <div class="col-4">
            <img src="album_image_1.jpg" alt="album image 1" />
          </div>
          <div class="col-4">
            <img src="album_image_2.jpg" alt="album image 2" />
          </div>
        </div> 
        -->
      </div>
    </div>
  </div>

  <script>
    document.querySelector('.copy-button').addEventListener('click', async () => {
      const input = document.querySelector('#myInput');
      const alert = document.querySelector('#copy-alert');

      try {
        await navigator.clipboard.writeText(input.value);
        alert.classList.add('show');
        setTimeout(() => {
          alert.classList.remove('show');
        }, 3000);
      } catch (err) {
        console.error('コピーに失敗しました:', err);
      }
    });
  </script>

</body>

</html>