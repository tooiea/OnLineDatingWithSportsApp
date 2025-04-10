@php
use Illuminate\Support\Facades\Storage;
@endphp

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="/public/css/common.css?q">
  <style>
    .card-body p {
      margin-bottom: 20px;
    }

    .col-12 {
      flex-basis: 0;
      flex-grow: 1;
      max-width: 100%;
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
          src="data:{{ $myTeam->team->image_extension }};base64,{{ base64_encode(file_get_contents(Storage::url($myTeam->team->image_path))) }}"
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
        <p><span class="mr-5">招待URL(ユーザ登録)</span>
          <div class="input-group">
            <input type="text" class="form-control" id="myInput" readonly
              value="{{ sprintf(url(__('route_const.invite_in_team') . '%s'), $myTeam->team->invitation_code) }}">
            <div class="input-group-append">
              <button class="btn btn-outline-secondary copy-button" type="button">Copy<i
                  class="fas fa-angle-right ml-2"></i></button>
            </div>
            <br>
          </div>
          <small class="small text-muted">*同じチームに招待したい場合、このリンクを共有してください</small>
          <div class="alert alert-success fade hidden" role="alert" id="copy-alert">コピーしました</div>
        </p>
        @if (!$myTeamAlbums->isEmpty())
        <div>
          <label for="teamAlbum">アルバム一覧</label>
          <div class="row">
            @php $count = 0; @endphp
            <div class="d-flex">
              @foreach ($myTeamAlbums as $image)
                @if ($count < 5)
                  <div class="album_container col-lg-2 col-md-4 col-sm-6 col-12 mb-4">
                    <div class="position-relative">
                      <div class="album-image-wrapper">
                        <img src="data:{{ $image->image_extension }};base64,{{ base64_encode(file_get_contents(Storage::url($image->image_name))) }}" class="img-fluid" alt="team album" />
                      </div>
                    </div>
                  </div>
                  @php $count++; @endphp
                @endif
              @endforeach
            </div>
          </div>
        </div>
        @endif
        <button class="btn btn-primary edit-button" type="button" onclick="location.href='{{ route('team.edit') }}'">編集する</button>
      </div>
    </div>
  </div>
  <script>
    const copyButton = document.querySelector('.copy-button');
    const input = document.querySelector('#myInput');
    const alert = document.querySelector('#copy-alert');

    copyButton.addEventListener('click', () => {
      input.focus();
      input.select();
      document.execCommand('copy');
      alert.classList.remove('hidden');
      alert.classList.add('show');
      input.blur();
      setTimeout(() => {
        alert.classList.remove('show');
        alert.classList.add('hidden');
      }, 3000);
    });
  </script>

</body>

</html>
