@php
use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
                        <p>第一希望日程：{{ Carbon::parse($values['first_preferered_date'])->format('Y年m月d日 G時i分') }}</p>
                        <p>第二希望日程：{{ Carbon::parse($values['second_preferered_date'])->format('Y年m月d日 G時i分') }}</p>
                        <p>第三希望日程：@isset($values['third_preferered_date']) {{ Carbon::parse($values['third_preferered_date'])->format('Y年m月d日 G時i分') }} @endisset</p>
                        <p class="mb-0">メッセージ：</p>
                        <p>@if(!is_null($values['message'])) {!! nl2br(htmlspecialchars($values['message'])) !!} @endif</p>
                    </div>
                </div>
                <div class="d-flex flex-row">
                    <form action="{{route('consent.back')}}" method="post" class="mr-2">
                        @csrf
                        <button type="submit" class="btn btn-secondary mt-3">修正する</button>
                    </form>
                    <form action="{{route('consent.complete')}}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary mt-3">送信する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
