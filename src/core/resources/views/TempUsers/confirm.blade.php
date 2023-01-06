<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <div>お名前(姓)</div>
        <div>{{ $values['name1'] }}</div>
    </div>
    <div>
        <div>お名前(名)</div>
        <div>{{ $values['name2'] }}</div>
    </div>
    <div>
        <div>フリガナ(姓)</div>
        <div>{{ $values['ruby1'] }}</div>
    </div>
    <div>
        <div>フリガナ(名)</div>
        <div>{{ $values['ruby2'] }}</div>
    </div>
    <div>
        <div>誕生日</div>
        <div>{{ \Carbon\Carbon::parse($values['birthday'])->format("Y年m月d日") }}</div>
    </div>
    <div>
        <div>パスワード</div>
        <div>********</div>
    </div>
    <div>
        <div>招待コード</div>
        <div>@if(isset($values['invitationCode'])) {{ $values['invitationCode'] }} @endif</div>
    </div>
    <form action="{{route('tmp_user.registered')}}" method="post">
        @csrf
        <input type="submit" value="戻る" name="back">
        <input type="submit" value="送信する" name="next">
    </form>
</body>
</html>