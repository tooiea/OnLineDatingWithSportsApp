<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>練習試合の招待フォーム</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/css/common.css">
</head>

<body class="body-with-nav">
    @include('layouts.nav')

    <div class="container my-5">
        <h2 class="text-center">Let's invite to GAME!</h2>
        <div class="card">
            <div class="card-header">
                招待カード
            </div>
            <div class="card-body">
                <h5 class="card-title mb-4">▼チーム詳細</h5>
                <div class="mb-3">
                    <label for="team-name" class="form-label">招待チーム名</label>
                    <p id="team-name">{{ $guestTeam->team_name }}</p>
                </div>
                <div class="mb-3">
                    <label for="team-url" class="form-label">招待チームURL</label>
                    <p><a id="team-url" href="{{ $guestTeam->team_url }}">{{ $guestTeam->team_url }}</a></p>
                </div>
                <div class="mb-3">
                    <label for="team-logo" class="form-label">招待チームロゴ</label>
                    <p>
                        <img id="team-logo"
                            src="data:{{ $guestTeam->image_extension }};base64,{{ base64_encode(file_get_contents($guestTeam->team_logo)) }}"
                            width="100" height="100" alt="チームAロゴ">
                    </p>
                </div>
                <hr>
                <h5 class="card-title mb-4">▼招待希望日程</h5>
                <p>※以下の第一希望から第三希望の日程を選択してください。</p>
                <form action="{{ route('consent.confirm') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="date-1" class="form-label">第一希望日程</label>
                        <input type="datetime-local" name="first_preferered_date" id="date-1"
                            class="form-control @error('first_preferered_date') is-invalid @enderror"
                            value="{{ old('first_preferered_date') }}">
                        @error('first_preferered_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="date-2" class="form-label">第二希望日程</label>
                        <input type="datetime-local" name="second_preferered_date" id="date-2"
                            class="form-control @error('second_preferered_date') is-invalid @enderror"
                            value="{{ old('second_preferered_date') }}">
                        @error('second_preferered_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="date-3" class="form-label">第三希望日程</label>
                        <input type="datetime-local" name="third_preferered_date" id="date-3"
                            class="form-control @error('third_preferered_date') is-invalid @enderror"
                            value="{{ old('third_preferered_date') }}">
                        @error('third_preferered_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">メッセージ</label>
                        <textarea id="message" class="form-control @error('message') is-invalid @enderror"
                            name="message">{{ old('message') }}</textarea>
                        @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">確認する</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>