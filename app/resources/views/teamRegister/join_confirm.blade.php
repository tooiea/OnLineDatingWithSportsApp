<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <title>確認画面</title>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>確認画面</h3>
            </div>
            <div class="card-body">
                <div class="card">
                    <div class="card-header">
                        <h4>チーム登録</h4>
                    </div>
                    <div class="card-body">
                        <p>チームURL：<a id="team-url" target="_blank">{{ $team->team_name }}</a></p>
                        <p class="text-muted"><small>*このチームで登録する場合は登録ボタンを押してください</small></p>
                    </div>
                </div>
                <form action="{{route('tmp_sns_join.complete')}}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-primary mt-3">登録する</button>
                </form>
                <form action="{{route('tmp_sns_join.index')}}" method="get">
                    @csrf
                    <button type="submit" class="btn btn-secondary mt-3">キャンセル</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>