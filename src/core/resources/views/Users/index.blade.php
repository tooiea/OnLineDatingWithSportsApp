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
        <form action="{{ route('users.confirm', $token) }}" method="post">
            @csrf
            <div>
                <div><label>お名前(姓)<input type="text" name="name1" value="{{ old('name1') }}"></label></div>
                <div>@error('name1') {{ $message }} @enderror</div>
            </div>
            <div>
                <div><label>お名前(名)<input type="text" name="name2" value="{{ old('name2') }}"></label></div>
                <div>@error('name2') {{ $message }} @enderror</div>
            </div>
            <div>
                <div><label>フリガナ(姓)<input type="text" name="ruby1" value="{{ old('ruby1') }}"></label></div>
                <div>@error('ruby1') {{ $message }} @enderror</div>
            </div>
            <div>
                <div><label>フリガナ(名)<input type="text" name="ruby2" value="{{ old('ruby2') }}"></label></div>
                <div>@error('ruby2') {{ $message }} @enderror</div>
            </div>
            <div>
                <div><label>誕生日<input type="date" name="birthday" value="{{ old('birthday') }}"></label></div>
                <div>@error('birthday') {{ $message }} @enderror</div>
            </div>
            <div>
                <div><label>メールアドレス<input type="email" name="email" value="{{ old('email') }}"></label></div>
                <div>@error('email') {{ $message }} @enderror</div>
            </div>
            <div>
                <div><label>パスワード<input type="password" name="password"></label></div>
                <div>@error('password') {{ $message }} @enderror</div>
            </div>
            <div>
                <div><label>パスワード(再入力)<input type="password" name="password2"></label></div>
                <div>@error('password2') {{ $message }} @enderror</div>
            </div>
            <div>
                <div><label>チームの招待コード<input type="text" name="invitationCode" value="{{ old('invitationCode') }}"></label></div>
                <div>@error('invitationCode') {{ $message }} @enderror</div>
            </div>
            <input type="submit" value="送信する">

        </form>
    </div>
</body>
</html>
