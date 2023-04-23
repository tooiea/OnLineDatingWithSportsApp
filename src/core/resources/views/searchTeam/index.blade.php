<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="/public/css/common.css">
  <title>Search Team</title>
</head>

<body>
  @include('layouts.nav')
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-sm-6">
        <div class="card">
          <div class="card-header">
            <h3>招待チームを検索</h3>
          </div>
          <div class="card-body">
            <form action="{{ route('search.index') }}">
              @csrf
              <div class="form-group">
                <label for="prefecture">都道府県</label>
                <select name="prefecture" class="form-control @error('prefecture') is-invalid @enderror" id="prefecture"
                  aria-describedby="nameHelp">
                  <option value="">選択してください</option>
                  @foreach (\App\Constants\FormConstant::PREFECTURES as $key => $value)
                  <option value="{{ $key }}" @if(old('prefecture')==$key || $prefecture==$key) selected @endif>{{ $value
                    }}
                  </option>
                  @endforeach
                </select>
                <small id="prefectureHelp" class="form-text text-muted">検索したいチームの都道府県を選択してください。</small>
                @error('prefecture')<div class="invalid-feedback" role="alert"> {{ $message }} </div>
                @enderror
              </div>
              <div class="form-group">
                <label for="address">住所</label>
                <input type="text" name="address" value="{{ old('address')  . $address }}" id="address"
                  aria-describedby="nameHelp" class="form-control @error('address') is-invalid @enderror"
                  placeholder="例：宮崎市">
                <small id="nameHelp" class="form-text text-muted">市町村区を入力してください。</small>
                @error('address')<div class="invalid-feedback" role="alert"> {{ $message }} </div>@enderror
              </div>
              <button type="submit" class="btn btn-primary btn-block">
                検索する
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container mt-5">
    <div class="row">
      <div class="col-sm-12">
        @if ($teams->count() == 0 && ($prefecture != "" || $address != ""))
        <p class="text-center">検索した都道府県にはチームが登録されていません</p>
        @elseif ($teams->count() == 0)
        <p class="text-center">あなたが登録している都道府県にチームが登録されていません</p>
        @else
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>No</th>
              <th>チーム名</th>
              <th>チーム活動拠点</th>
              <th>チームロゴ</th>
              <th>招待する</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($teams as $key => $value)
            <tr>
              <th>{{ $key+1 }}</th>
              <td>{{ $value->team_name }}</td>
              <td>{{ \App\Constants\FormConstant::PREFECTURES[$value->prefecture] . $value->address }}
              </td>
              <td>
                @if (!empty($value->image_extension))
                <img
                  src="data:{{ $value->image_extension }};base64,{{ base64_encode(file_get_contents($value->team_logo)) }}"
                  id="team-logo" width="50" height="50">
                @endif
              </td>
              <td>
                <a href="{{ sprintf(url(__('route_const.consent_link') . '%s'), $value->invitation_code)
                  }}">招待する
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <nav aria-label="ページネーション">
          <ul class="pagination justify-content-center">
            <li class="page-item {{ $teams->currentPage() == 1 ? 'disabled' : '' }}">
              <a class="page-link" href="{{ $teams->previousPageUrl() }}" tabindex="-1">前のページ</a>
            </li>
            @for ($i = 1; $i <= $teams->lastPage(); $i++)
              <li class="page-item {{ $teams->currentPage() == $i ? 'active' : '' }}">
                <a class="page-link" href="{{ $teams->url($i) }}">{{ $i }}</a>
              </li>
              @endfor
              <li class="page-item {{ $teams->currentPage() == $teams->lastPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $teams->nextPageUrl() }}">次のページ</a>
              </li>
          </ul>
        </nav>
        @endif
      </div>
    </div>
  </div>
</body>

</html>
