<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>確認画面</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5">
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
                        <p>@isset($values['message']) {!! nl2br(e($values['message'])) !!} @endisset</p>
                    </div>
                </div>
                <div class="d-flex">
                    <form action="{{ route('consent.back') }}" method="post" class="me-2">
                        @csrf
                        <button type="submit" class="btn btn-secondary mt-3 w-100">修正する</button>
                    </form>
                    <form action="{{ route('consent.complete') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary mt-3 w-100">送信する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>