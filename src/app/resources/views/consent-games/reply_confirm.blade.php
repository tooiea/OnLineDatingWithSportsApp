<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>確認画面</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="body-with-nav">
    @include('layouts.nav')

    <div class="container mt-4">
        <h3>確認画面</h3>
        <hr>
        <h4>希望日程へのお返事</h4>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>日程</th>
              <th>返事</th>
              <th>日時</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>要望1</td>
              <td>
                <span class="badge {{ ($values['first_preferered_date'] == 1 ? 'bg-success' : 'bg-danger') }}">
                  {{ \App\Constants\FormConstant::CONSENT_REPLY_FORM_VALUE_TEXT[$values['first_preferered_date']] }}
                </span>
              </td>
              <td>{{ \Carbon\Carbon::parse($consents->first_preferered_date)->format('Y年m月d日 G時i分') }}</td>
            </tr>
            <tr>
              <td>要望2</td>
              <td>
                <span class="badge {{ ($values['second_preferered_date'] == 1 ? 'bg-success' : 'bg-danger') }}">
                  {{ \App\Constants\FormConstant::CONSENT_REPLY_FORM_VALUE_TEXT[$values['second_preferered_date']] }}
                </span>
              </td>
              <td>{{ \Carbon\Carbon::parse($consents->second_preferered_date)->format('Y年m月d日 G時i分') }}</td>
            </tr>
            @isset($values['third_preferered_date'])
            <tr>
              <td>要望3</td>
              <td>
                <span class="badge {{ ($values['third_preferered_date'] == 1 ? 'bg-success' : 'bg-danger') }}">
                  {{ \App\Constants\FormConstant::CONSENT_REPLY_FORM_VALUE_TEXT[$values['third_preferered_date']] }}
                </span>
              </td>
              <td>{{ \Carbon\Carbon::parse($consents->third_preferered_date)->format('Y年m月d日 G時i分') }}</td>
            </tr>
            @endisset
          </tbody>
        </table>

        <hr>
        <h4>メッセージ</h4>
        <p>@if (!empty($values['message'])) {!! nl2br(e($values['message'])) !!} @endif</p>
        <hr>

        <div class="row">
          <div class="col-6">
            <form action="{{ route('reply.back') }}" method="post">
              @csrf
              <button type="submit" class="btn btn-primary w-100">修正する</button>
            </form>
          </div>
          <div class="col-6">
            <form action="{{ route('reply.complete') }}" method="post">
              @csrf
              <button type="submit" class="btn btn-success w-100">送信する</button>
            </form>
          </div>
        </div>
    </div>

</body>
</html>