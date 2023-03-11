<!DOCTYPE html>
<html>

<head>
  <title>Team Invitations</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <style>
    /* Adjust table font sizes for mobile devices */
    @media screen and (max-width: 767px) {
      table {
        font-size: 12px;
      }

      thead th {
        font-size: 10px;
      }
    }
  </style>
</head>

<body>
  @include('layouts.nav')
  <!-- Main content -->
  <div class="container mt-3">
    <!-- Team Name Section -->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h5 class="mb-0">Team Name</h5>
          </div>
          <div class="card-body">
            <p class="mb-0">{{ $myTeam->team->team_name }}</p>
            <a href="{{ route('team.detail') }}">チーム詳細ページへ</a>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h5>My Teamの招待ステータス</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>日付</th>
                    <th>チーム名</th>
                    <th>ステータス</th>
                    <th>詳細ページ</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($myTeamInvites as $value)
                  <tr>
                    <td class="align-middle">{{
                      \Carbon\Carbon::parse($value['consent_games_created_at'])->format('Y年m月d日')
                      }}</td>
                    <td class="align-middle">{{ $value['team_name'] }}</td>
                    <td class="align-middle">{{
                      \App\Enums\ConsentStatusTypeEnum::from($value['consent_status'])->label() }}
                    </td>
                    <td class="align-middle"><a
                        href="{{ route('reply.detail', Crypt::encryptString($value->consent_games_id)) }}">詳細</a>
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

    <!-- Other Team Invitations Section -->
    <div class="row mt-4">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h5>他チームからの招待ステータス</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>日付</th>
                    <th>チーム名</th>
                    <th>ステータス</th>
                    <th>お返事する</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($asGuestInvites as $value)
                  <tr>
                    <td class="align-middle">{{
                      \Carbon\Carbon::parse($value['consent_games_created_at'])->format('Y年m月d日')
                      }}</td>
                    <td class="align-middle">{{ $value['team_name'] }}</td>
                    <td class="align-middle">{{
                      \App\Enums\ConsentStatusTypeEnum::from($value['consent_status'])->label() }}
                    </td>
                    @if ($value['consent_status'] === \App\Enums\ConsentStatusTypeEnum::ACCEPT->value)
                    <td class="align-middle"><a
                        href="{{ route('reply.detail', Crypt::encryptString($value->consent_games_id)) }}">詳細
                    </td>
                    @else
                    <td class="align-middle"><a
                        href="{{ route('reply.index', Crypt::encryptString($value->consent_games_id)) }}">返信
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