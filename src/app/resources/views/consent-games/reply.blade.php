<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>返信画面</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="/css/common.css">
  <style>
    .card {
      margin: 10px;
    }
  </style>
</head>

<body class="body-with-nav">
  @include('layouts.nav')

  <div class="container mt-3">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">チーム名：{{ $consents->team_name }}</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-4">
            <img src="data:{{ $consents->image_extension }};base64,{{ base64_encode(file_get_contents($consents->team_logo)) }}"
              id="team-logo" class="img-fluid">
          </div>
          <div class="col-8">
            <p>第一希望：<br>
              <span class="text-nowrap">{{ \Carbon\Carbon::parse($consents->first_preferered_date)->format('Y年m月d日 G時i分') }}</span>
            </p>
            <p>第二希望：<br>
              <span class="text-nowrap">{{ \Carbon\Carbon::parse($consents->second_preferered_date)->format('Y年m月d日 G時i分') }}</span>
            </p>
            @if (!empty($consents->third_preferered_date))
            <p>第三希望：<br>
              <span class="text-nowrap">{{ \Carbon\Carbon::parse($consents->third_preferered_date)->format('Y年m月d日 G時i分') }}</span>
            </p>
            @endif
          </div>
        </div>
        <hr>
        <form action="{{ route('reply.confirm') }}" method="post">
          @csrf
          <div class="mb-3">
            <label for="message" class="form-label">相手からのメッセージ</label>
            <textarea class="form-control" id="message" rows="3" readonly>{{ $consents->message }}</textarea>
          </div>
          <hr>
          @foreach (['first', 'second', 'third'] as $index => $label)
          @if ($index < 2 || !empty($consents->third_preferered_date))
          <div class="mb-3">
            <label class="form-label">{{ ucfirst($label) }}希望</label>
            <div class="btn-group" role="group">
              @foreach (\App\Constants\FormConstant::CONSENT_REPLY_FORM_VALUE_TEXT as $key => $value)
              <input type="radio" class="btn-check" name="{{ $label }}_preferered_date" id="{{ $label }}_{{ $key }}" value="{{ $key }}"
                @if (old("{$label}_preferered_date") == $key || (empty(old("{$label}_preferered_date")) && array_key_first(\App\Constants\FormConstant::CONSENT_REPLY_FORM_VALUE_TEXT) == $key)) checked @endif>
              <label class="btn btn-outline-secondary" for="{{ $label }}_{{ $key }}">{{ $value }}</label>
              @endforeach
            </div>
            @error ("{$label}_preferered_date") <div class="text-danger mt-2">{{ $message }}</div> @enderror
          </div>
          @endif
          @endforeach
          <hr>
          <div class="mb-3">
            <label for="reply" class="form-label">返信したいメッセージがあれば入力してください</label>
            <textarea class="form-control" id="reply" rows="3" name="message">{{ old('message') }}</textarea>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary w-100">確認する</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>