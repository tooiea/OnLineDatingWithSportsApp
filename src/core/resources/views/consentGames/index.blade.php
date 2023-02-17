<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>練習試合の招待フォーム</title>
</head>

<body>
    <div class="container my-5">
        <h2 class="text-center">練習試合の招待フォーム</h2>
        <div class="card">
            <div class="card-header">
                招待カード
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="team-name">招待チーム名</label>
                    <p id="team-name">{{$guestTeam->team_name }}</p>
                </div>
                <div class="form-group">
                    <label for="team-url">招待チームURL</label>
                    <p><a id="team-url" href="#">{{ $guestTeam->team_url }}</a></p>
                </div>
                <div class="form-group">
                    <label for="team-logo">招待チームロゴ</label>
                    <img id="team-logo"
                        src="data:{{ $guestTeam->image_extension }};base64,{{ base64_encode(file_get_contents($guestTeam->team_logo)) }}"
                        alt="チームロゴ" width="120" height="120">
                </div>
                <div class="form-group">
                    <label for="date-1">第一希望日程</label>
                    <input type="date" id="date-1" class="form-control">
                </div>
                <div class="form-group">
                    <label for="date-2">第二希望日程</label>
                    <input type="date" id="date-2" class="form-control">
                </div>
                <div class="form-group">
                    <label for="date-3">第三希望日程</label>
                    <input type="date" id="date-3" class="form-control">
                </div>
                <div class="form-group">
                    <label for="message">メッセージ</label>
                    <textarea id="message" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">送信</button>
            </div>
        </div>
    </div>
</body>

</html>