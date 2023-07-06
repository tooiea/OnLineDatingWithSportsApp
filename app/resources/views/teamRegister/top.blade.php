<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bootstrap 4.5 Example</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="/public/css/common.css?q"></head>

<body>
    <div class="container">
    <h2 class="text-center mt-3 mb-5">ようこそ、Oldwsへ！<br>チームに参加しよう！</h2>
    <div class="row">
        <div class="col-md-6 mx-auto menu_button">
        <div class="btn-diagonal">
            <button class="btn btn-primary rounded-circle-btn btn-block mb-3" type="button" onclick="location.href='{{ route('tmp_sns_create.index') }}'">
            新しくチームを作る
            </button>
            <button class="btn btn-success rounded-circle-btn btn-block" type="button" onclick="location.href='{{ route('tmp_sns_join.index') }}'">
            チームに参加する
            </button>
        </div>
        </div>
    </div>
    </div>
</body>
</html>