<!DOCTYPE html>
<html>

<head>
  <title>Team Invitations</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="/public/css/common.css?q">
</head>

<body class="body-with-nav">
  @include('layouts.nav')
  <!-- Main content -->
  <div class="container mt-3">
    <!-- Team Name Section -->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h5 class="mb-0">Myチーム</h5>
          </div>
          <div class="card-body">
            <p class="mt-2 ml-2"><span class="mr-4">チーム名</span>
              <a class="mr-5" href="{{ route('team.detail') }}">{{ $myTeam->team->team_name }}</a>
              <img src="data:{{ $myTeam->team->image_extension }};base64,{{ base64_encode(file_get_contents('public' . Illuminate\Support\Facades\Storage::url($myTeam->team->image_path))) }}"
                 width="45px" height="45px" alt="team logo" class="img-fluid"/>
            </p>
            @if (session('consent.reply'))
            <div class="alert alert-success" role="alert"> {!! session('consent.reply') !!} </div>
            @elseif (session('consent.sent'))
            <div class="alert alert-success" role="alert"> {!! session('consent.sent') !!} </div>
            @endif
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h5 class="mb-0">招待状況</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>招待日</th>
                    <th>チーム名</th>
                    <th>進捗状況<br><small>※詳細ページへ</small></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($myTeamInvites as $value)
                  <tr>
                    <td class="align-middle">{{
                      \Carbon\Carbon::parse($value['consent_games_created_at'])->format('Y年m月d日')
                      }}</td>
                    <td class="align-middle">
                        {{ $value['team_name'] }}
                    </td>
                    <td
                      class="align-middle">
                      <a href="{{ route('reply.detail', Crypt::encryptString($value->consent_games_id)) }}"
                      class=" {{ 'status-' . \App\Enums\ConsentStatusTypeEnum::from($value['consent_status'])->className() }}">
                        {{ \App\Enums\ConsentStatusTypeEnum::from($value['consent_status'])->label() }}
                      </a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h5 class="mb-0">他チームからの招待状況</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>招待日</th>
                    <th>チーム名</th>
                    <th>進捗状況<br><small>※詳細ページへ</small></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($asGuestInvites as $value)
                  <tr>
                    <td class="align-middle">{{
                      \Carbon\Carbon::parse($value['consent_games_created_at'])->format('Y年m月d日')
                      }}</td>
                    <td
                      class="align-middle">
                      {{ $value['team_name'] }}
                    </td>
                    @if ($value['consent_status'] === \App\Enums\ConsentStatusTypeEnum::WAIT->value)
                    <td class="align-middle">
                      <a href="{{ route('reply.index', Crypt::encryptString($value->consent_games_id)) }}"
                      class="{{ 'status-' . \App\Enums\ConsentStatusTypeEnum::from($value['consent_status'])->className() }}">
                        {{ \App\Enums\ConsentStatusTypeEnum::from($value['consent_status'])->label() }}
                      </a>
                    </td>
                    @else
                    <td class="align-middle">
                      <a href="{{ route('reply.detail', Crypt::encryptString($value->consent_games_id)) }}"
                      class="{{ 'status-' . \App\Enums\ConsentStatusTypeEnum::from($value['consent_status'])->className() }}">
                        {{ \App\Enums\ConsentStatusTypeEnum::from($value['consent_status'])->label() }}
                      </a>
                    </td>
                    @endif
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>
