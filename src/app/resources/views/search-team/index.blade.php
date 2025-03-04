<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search Team</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="/css/common.css">
</head>

<body class="body-with-nav">
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
              <div class="mb-3">
                <label for="prefecture" class="form-label">都道府県</label>
                <select name="prefecture" class="form-control @error('prefecture') is-invalid @enderror" id="prefecture">
                  <option value="">選択してください</option>
                  @foreach (\App\Constants\FormConstant::PREFECTURES as $key => $value)
                  <option value="{{ $key }}" @if(old('prefecture')==$key || $prefecture==$key) selected @endif>{{ $value }}</option>
                  @endforeach
                </select>
                <div class="form-text">検索したいチームの都道府県を選択してください。</div>
                @error('prefecture')<div class="invalid-feedback"> {{ $message }} </div>@enderror
              </div>

              <div class="mb-3">
                <label for="address" class="form-label">住所</label>
                <input type="text" name="address" value="{{ old('address')  . $address }}" id="address"
                  class="form-control @error('address') is-invalid @enderror" placeholder="例：宮崎市">
                <div class="form-text">市町村区を入力してください。</div>
                @error('address')<div class="invalid-feedback"> {{ $message }} </div>@enderror
              </div>

              <button type="submit" class="btn btn-primary w-100">検索する</button>
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
              <td>{{ \App\Constants\FormConstant::PREFECTURES[$value->prefecture] . $value->address }}</td>
              <td>
                @if (!empty($value->image_extension))
                <img src="data:{{ $value->image_extension }};base64,{{ base64_encode(file_get_contents($value->team_logo)) }}"
                  id="team-logo" width="50" height="50" class="img-fluid">
                @endif
              </td>
              <td>
                <a href="{{ sprintf(url(__('route_const.consent_link') . '%s'), $value->invitation_code) }}">招待する</a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>

        <nav aria-label="ページネーション">
          <ul class="pagination justify-content-center">
            <li class="page-item {{ $teams->onFirstPage() ? 'disabled' : '' }}">
              <a class="page-link" href="{{ $teams->previousPageUrl() }}">前のページ</a>
            </li>
            @for ($i = 1; $i <= $teams->lastPage(); $i++)
              <li class="page-item {{ $teams->currentPage() == $i ? 'active' : '' }}">
                <a class="page-link" href="{{ $teams->url($i) }}">{{ $i }}</a>
              </li>
            @endfor
            <li class="page-item {{ $teams->hasMorePages() ? '' : 'disabled' }}">
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