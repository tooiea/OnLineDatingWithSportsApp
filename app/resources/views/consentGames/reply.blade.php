<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>返信画面</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <link rel="stylesheet" href="/public/css/common.css?q">
  <style>
    .card {
      margin: 10px;
    }
  </style>
</head>

<body class="body-with-nav">
  @include('layouts.nav')
  <!-- TODO 前に戻るボタンを追加 -->
  <div class="container mt-3">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">チーム名　{{ $consents->team_name }}</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-3">
            <img
              src="data:{{ $consents->image_extension }};base64,{{ base64_encode(file_get_contents('public' . Illuminate\Support\Facades\Storage::url($consents->image_path))) }}"
              id="team-logo" class="team-logo">
          </div>
          <div class="col-8">
            <p>第一希望<br>
              <span style="white-space: nowrap; overflow: hidden;">
              {{ \Carbon\Carbon::parse($consents->first_preferered_date)->format('Y年m月d日 G時i分') }}
              </span>
            </p>
            <p>第二希望<br>
              <span style="white-space: nowrap; overflow: hidden;">
              {{ \Carbon\Carbon::parse($consents->second_preferered_date)->format('Y年m月d日 G時i分') }}
              </span>
            </p>
            @if (!empty($consents->third_preferered_date))
            <p>第三希望<br>
              <span style="white-space: nowrap; overflow: hidden;">
              {{ \Carbon\Carbon::parse($consents->third_preferered_date)->format('Y年m月d日 G時i分') }}
              </span>
            </p>
            @endif
          </div>
        </div>
        <hr>
        <form action="{{ route('reply.confirm') }}" method="post">
          @csrf
          <div class="form-group">
            <label for="message">相手からのメッセージ</label>
            <textarea class="form-control" id="message" rows="3" readonly>{{ $consents->message }}</textarea>
          </div>
          <hr>
          <div class="form-group">
            <label>第一希望</label>
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
              @foreach (\App\Constants\FormConstant::CONSENT_REPLY_FORM_VALUE_TEXT as $key => $value)
              <label
                class="btn btn-secondary
               @if (old('first_preferered_date') == $key || empty(old('first_preferered_date')) && array_key_first(\App\Constants\FormConstant::CONSENT_REPLY_FORM_VALUE_TEXT) == $key ) active @endif ">
                <input type="radio" name="first_preferered_date" value="{{ $key }}"
                @if (old('first_preferered_date') == $key || empty(old('first_preferered_date'))
                 && array_key_first(\App\Constants\FormConstant::CONSENT_REPLY_FORM_VALUE_TEXT) == $key ) checked @endif>
                {{ $value }}
              </label>
              @endforeach
            </div>
            @error ('first_preferered_date') <div class="text-danger mt-2">{{ $message }}</div> @enderror
          </div>
          <div class="form-group">
            <label>第二希望</label>
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
              @foreach (\App\Constants\FormConstant::CONSENT_REPLY_FORM_VALUE_TEXT as $key => $value)
              <label class="btn btn-secondary @if (old('second_preferered_date') == $key || empty(old('second_preferered_date')) && array_key_first(\App\Constants\FormConstant::CONSENT_REPLY_FORM_VALUE_TEXT) === $key ) active @endif
                  ">
                <input type="radio" name="second_preferered_date" value="{{ $key }}"
                @if (old('second_preferered_date') == $key || empty(old('second_preferered_date')) &&
                 array_key_first(\App\Constants\FormConstant::CONSENT_REPLY_FORM_VALUE_TEXT) == $key) checked @endif>
                {{ $value }}
              </label>
              @endforeach
            </div>
            @error ('second_preferered_date') <div class="text-danger mt-2">{{ $message }}</div> @enderror
          </div>
          @if (!empty($consents->third_preferered_date))
          <div class="form-group">
            <label>第三希望</label>
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
              @foreach (\App\Constants\FormConstant::CONSENT_REPLY_FORM_VALUE_TEXT as $key => $value)
              <label class="btn btn-secondary
              @if (old('third_preferered_date') == $key || empty(old('third_preferered_date'))
                && array_key_first(\App\Constants\FormConstant::CONSENT_REPLY_FORM_VALUE_TEXT) == $key ) active @endif ">
                <input type="radio" name="third_preferered_date" value="{{ $key }}"
                @if (old('third_preferered_date') == $key || empty(old('third_preferered_date')) &&
                 array_key_first(\App\Constants\FormConstant::CONSENT_REPLY_FORM_VALUE_TEXT) == $key ) checked @endif>
                {{ $value }}
              </label>
              @endforeach
            </div>
            @error ('third_preferered_date') <div class="text-danger mt-2">{{ $message }}</div> @enderror
          </div>
          @endif
          <hr>
          <div class="form-group">
            <label for="reply">メッセージを入力してください</label>
            <textarea class="form-control" id="reply" rows="3" name="message">{{ old('message') }}</textarea>
          </div>
          <div class="text-center">
            <input type="submit" class="btn btn-primary" value="確認する"></input>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
