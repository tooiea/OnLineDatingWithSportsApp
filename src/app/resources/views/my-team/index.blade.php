<!DOCTYPE html>
<html lang="ja">

<head>
  <title>Team Invitations</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="/css/common.css">
</head>

<body class="body-with-nav">
  @include('layouts.nav')

  <div class="container mt-3">
    <!-- Team Name Section -->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h5 class="mb-0">Myチーム</h5>
          </div>
          <div class="card-body">
            <p class="mb-0">チーム名　
              <a href="{{ route('team.detail') }}">{{ $myTeam->team->team_name }}</a>
            </p>
            @if (session('consent.reply'))
              <div class="alert alert-success" role="alert">{!! session('consent.reply') !!}</div>
            @elseif (session('consent.sent'))
              <div class="alert alert-success" role="alert">{!! session('consent.sent') !!}</div>
            @endif
          </div>
        </div>
      </div>
    </div>

    <!-- 招待状況 -->
    <div class="row mt-4">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h5>招待状況</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive-md">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>招待日</th>
                    <th>チーム名</th>
                    <th>進捗状況</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($myTeamInvites as $value)
                  <tr>
                    <td class="align-middle">
                      {{ \Carbon\Carbon::parse($value['consent_games_created_at'])->format('Y年m月d日') }}
                    </td>
                    <td class="align-middle">
                      <a href="{{ route('reply.detail', Crypt::encryptString($value->consent_games_id)) }}">
                        {{ $value['team_name'] }}
                      </a>
                    </td>
                    <td class="align-middle {{ 'status-' . \App\Enums\ConsentStatusTypeEnum::from($value['consent_status'])->className() }}">
                      {{ \App\Enums\ConsentStatusTypeEnum::from($value['consent_status'])->label() }}
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

    <!-- 他チームからの招待状況 -->
    <div class="row mt-4">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h5>他チームからの招待状況</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive-md">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>招待日</th>
                    <th>チーム名</th>
                    <th>進捗状況</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($asGuestInvites as $value)
                  <tr>
                    <td class="align-middle">
                      {{ \Carbon\Carbon::parse($value['consent_games_created_at'])->format('Y年m月d日') }}
                    </td>
                    <td class="align-middle">
                      @if ($value['consent_status'] === \App\Enums\ConsentStatusTypeEnum::WAIT->value)
                        <a href="{{ route('reply.index', Crypt::encryptString($value->consent_games_id)) }}">
                          {{ $value['team_name'] }}
                        </a>
                      @else
                        <a href="{{ route('reply.detail', Crypt::encryptString($value->consent_games_id)) }}">
                          {{ $value['team_name'] }}
                        </a>
                      @endif
                    </td>
                    <td class="align-middle {{ 'status-' . \App\Enums\ConsentStatusTypeEnum::from($value['consent_status'])->className() }}">
                      {{ \App\Enums\ConsentStatusTypeEnum::from($value['consent_status'])->label() }}
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
  </div>
</body>

</html>