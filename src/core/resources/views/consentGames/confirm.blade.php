<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
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
                        <h4>招待日程</h4>
                    </div>
                    <div class="card-body">
                        <p>第一希望日程：{{ $values['first_preferered_date'] }}</p>
                        <p>第二希望日程：{{ $values['second_preferered_date'] }}</p>
                        <p>第三希望日程：@isset($values['third_preferered_date']) {{ $values['third_preferered_date'] }} @endisset</p>
                        <p class="mb-0">メッセージ：</p>
                        <p>@if(!is_null($values['message'])) {!! nl2br(htmlspecialchars($values['message'])) !!} @endif</p>
                    </div>
                </div>
                <form action="{{route('consent.complete')}}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-primary mt-3">登録する</button>
                </form>
                <form action="{{route('consent.back')}}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-secondary mt-3">修正する</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>