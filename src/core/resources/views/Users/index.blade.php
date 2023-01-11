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
        <form action="{{ route('login') }}" method="post">
            <div>
                <div><label>メールアドレス<input type="email" name="email"></label></div>
                <div>@error('email') {{ $message }} @enderror</div>
                <div><label>パスワード<input type="password" name="password"></label></div>
                <div>@error('password') {{ $message }} @enderror</div>
                <div><input type="submit" value="ログイン"></div>
            </div>
        </form>
    </div>
</body>

</html>