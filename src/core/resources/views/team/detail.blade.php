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
  <link rel="stylesheet" href="/public/css/common.css">
  <style>
    .card-body h5 {
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
        <h5>チーム名　　　{{ $myTeam->team->team_name }}</h5>
        <h5>
          チームロゴ　　<img
          src="data:{{ $myTeam->team->image_extension }};base64,{{ base64_encode(file_get_contents($myTeam->team->team_logo)) }}"
          class="img-fluid  w-25" alt="team logo" />
        </h5>
        <h5>登録人数　　　{{ $teamMembersNumber }}人</h5>
        <h5>
          チーム紹介URL<br>
          <a href="{{ $myTeam->team->team_url }}">{{ $myTeam->team->team_url }}</a>
          @empty($myTeam->team->team_url)
          　未登録
          @endempty
        </h5>
        <h5>他選手を登録(招待URL)</h5>
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="myInput"
            value="{{ sprintf(url(__('route_const.invite_in_team') . '%s'), $myTeam->team->invitation_code) }}">
          <div class="input-group-append">
            <button class="btn btn-outline-secondary copy-button" type="button">Copy<i
                class="fas fa-angle-right ml-2"></i></button>
          </div>
        </div>


        <div class="alert alert-success fade" role="alert" id="copy-alert">
          コピーしました
        </div>
        <!-- TODO 後日実装 -->
        <!-- <h5>アルバム画像:</h5>
          <div class="row">
            <div class="col-4">
              <img src="album_image_1.jpg" alt="album image 1" />
            </div>
            <div class="col-4">
              <img src="album_image_2.jpg" alt="album image 2" />
            </div>
          </div> -->
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
