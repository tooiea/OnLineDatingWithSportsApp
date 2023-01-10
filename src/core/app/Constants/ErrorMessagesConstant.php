<?php

namespace App\Constants;

class ErrorMessagesConstant
{
    public const NOT_VALID_TOKEN = '不正な入力がありました。再度、URLをご確認ください。';
    public const EXPIRED_TOKEN = 'トークンの有効期限切れです。再度、仮登録フォームより登録してください。';
    public const ALREADY_REGISTERED = 'すでに本登録済みです。';

    /**
     * 仮登録フォーム
     */
    public const USER_FORM = [
        'name1.required' => 'お名前(姓)を入力してください。',
        'name1.max' => 'お名前(姓)を20文字以内で入力してください。',
        'name2.required' => 'お名前(名)を入力してください。',
        'name2.max' => 'お名前(名)を20文字以内で入力してください。',
        'ruby1.required' => 'フリガナ(姓)を入力してください。',
        'ruby1.max' => 'フリガナ(姓)を20文字以内で入力してください。',
        'ruby1.regex' => 'フリガナ(姓)をカタカナで入力してください。',
        'ruby2.required' => 'フリガナ(名)を入力してください。',
        'ruby2.max' => 'フリガナ(名)を20文字以内で入力してください。',
        'ruby2.regex' => 'フリガナ(名)をカタカナで入力してください。',
        'birthday.required' => '誕生日を入力してください。',
        'birthday.date' => '誕生日を正しく入力してください。',
        'email.required' => 'メールアドレスを入力してください。',
        'email.regex' => 'メールアドレスを正しく入力してください。',
        'email.unique' => 'このメールアドレスはすでに登録されています。',
        'password.required' => 'パスワードを入力してください。',
        'password.regex' => '半角英数で大文字・小文字すべてを含み、8文字以上で入力してください。',
        'password2.required' => 'パスワード(再入力)を入力してください。',
        'password2.same' => '同じパスワードを入力してください。',
        'invitationCode.exists' => 'チームの招待コードが存在しません。'
    ];
}
