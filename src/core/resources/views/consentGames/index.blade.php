@php
use Illuminate\Support\Facades\Storage;
@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="/public/css/common.css?q">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>練習試合の招待フォーム</title>
</head>

<body class="body-with-nav">
    @include('layouts.nav')
    <div class="container my-5">
        <h4 class="text-center">早速、試合に招待してみよう！</h4>
        <div class="card">
            <h3 class="card-header">
                招待内容
            </h3>
            <div class="card-body">
                <h5 class="card-title mb-4">▼招待するチームの詳細</h5>
                <div class="form-group">
                    <p><span class="mr-5">チーム名</span>{{ $guestTeam->team_name }}</p>
                </div>
                <div class="form-group">
                    <label for="team-url"><span class="mr-4">チームURL</span></label>
                    @if(!empty($guestTeam->team_url))
                    <p><a class="" href="{{ $guestTeam->team_url }}">{{ $guestTeam->team_url }}</a></p>
                    @else
                    未登録
                    @endif
                </div>
                <div class="form-group">
                    <p><span class="mr-4">チームロゴ</span><img id="team-logo"
                        src="data:{{ $guestTeam->image_extension }};base64,{{ base64_encode(file_get_contents(Storage::url($guestTeam->image_path))) }}"
                        id="team-logo" width="100" height="100" alt="チームAロゴ" class="team-logo"></p>
                </div>
                <hr>
                <h5 class="card-title mb-4">▼希望する日程</h5>
                <p><small>※第二希望まで必ず選択してください</small></p>
                <form action="{{ route('consent.confirm') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="date-1">第一希望日程</label>
                        <input type="datetime-local" name="first_preferered_date" id="date-1"
                            class="form-control @error('first_preferered_date') is-invalid @enderror"
                            value="{{ old('first_preferered_date') }}">
                        @error('first_preferered_date')<div class="invalid-feedback" role="alert"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="date-2">第二希望日程</label>
                        <input type="datetime-local" name="second_preferered_date" id="date-2"
                            class="form-control @error('second_preferered_date') is-invalid @enderror"
                            value="{{ old('second_preferered_date') }}">
                        @error('second_preferered_date')<div class="invalid-feedback" role="alert"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="date-3">第三希望日程</label>
                        <input type="datetime-local" name="third_preferered_date" id="date-3"
                            class="form-control @error('third_preferered_date') is-invalid @enderror"
                            value="{{ old('third_preferered_date') }}">
                        @error('third_preferered_date')<div class="invalid-feedback" role="alert"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="message">メッセージ</label>
                        <textarea id="message" class="form-control @error('message') is-invalid @enderror"
                            name="message">{{ old('message') }}</textarea>
                        @error('message')<div class="invalid-feedback" role="alert"> {{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary">確認する</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
