<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
      integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
      crossorigin="anonymous"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Team Detail</title>
  </head>
  <body>
    @include('layouts.nav')
    <div class="container my-5">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">チームプロフィール詳細</h3>
        </div>
        <div class="card-body">
          <h5>チーム名:</h5>
          <p>{{ $myTeam->team->team_name }}</p>
          <h5>チームの登録人数:</h5>
          <p>{{ $teamMembersNumber }}人</p>
          <h5>チームのロゴ画像:</h5>
          <img src="data:{{ $myTeam->team->image_extension }};base64,{{ base64_encode(file_get_contents($myTeam->team->team_logo)) }}" alt="team logo" />
          <h5>チーム紹介URL:</h5>
          <p>
            <a href="{{ $myTeam->team->team_url }}">{{ $myTeam->team->team_url }}</a>
          </p>
          <h5>チームへの招待URL:</h5>
          <!-- ボタンを押してコピー機能を追加 -->
          <p>{{ sprintf(url(__('route_const.invite_in_team') . "%s"), $myTeam->team->invitation_code) }}</p>
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
  </body>
</html>

