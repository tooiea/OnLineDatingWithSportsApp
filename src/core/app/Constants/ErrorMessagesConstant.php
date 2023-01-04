<?php

namespace App\Constants;

class ErrorMessagesConstant
{
    /**
     * 仮登録
     */
    public const REQUEST_MESSAGE_TEMP_USER = [
        'email.required' => 'メールアドレスを入力してください',
        'email.email' => 'メールアドレスを正しく入力してください',
        'email.unique' => '入力されたメールアドレスはすでに登録済みです'
    ];
    public const TEMPLATE_LOST_TOKEN = '不正な入力がありました。再度、URLをご確認ください。';

    /**
     * ユーザ本登録フォーム
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
        'password.regex' => 'パスワードを半角英数(大文字を含み)8文字以上で入力してください。',
        'password2.required' => 'パスワード(を入力してください。',
        'password2.same' => '同じパスワードを入力してください。',
        'invitationCode.exists' => '招待コードが存在しません。'
    ];
}