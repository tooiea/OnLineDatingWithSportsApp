<?php

return [

    'values' => [
        'first_preferered_date' => [
            'today' => '本日'
        ],
        'second_preferered_date' => [
            'today' => '本日'
        ],
        'third_preferered_date' => [
            'today' => '本日'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute must be accepted.',
    'accepted_if' => 'The :attribute must be accepted when :other is :value.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => ':attribute は :date 以降で選択してください。',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'The :attribute must only contain letters.',
    'alpha_dash' => 'The :attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute must only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => ':attribute は同じ入力でありません',
    'current_password' => 'The password is incorrect.',
    'date' => ':attribute を正しく入力してください。',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'declined' => 'The :attribute must be declined.',
    'declined_if' => 'The :attribute must be declined when :other is :value.',
    'different' => ':attribute と :other は異なるものを選択してください。',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => ':attribute を正しく入力してください。',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'enum' => ':attribute を正しく選択してください。',
    'exists' => ':attribute が存在しません。',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal to :value.',
        'file' => 'The :attribute must be greater than or equal to :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal to :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => '画像をアップロードしてください',
    'in' => '正しく選択してください。',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal to :value.',
        'file' => 'The :attribute must be less than or equal to :value kilobytes.',
        'string' => 'The :attribute must be less than or equal to :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'mac_address' => 'The :attribute must be a valid MAC address.',
    'max' => [
        'numeric' => 'The :attribute must not be greater than :max.',
        'file' => 'The :attribute must not be greater than :max kilobytes.',
        'string' => ':max 文字以内で入力してください。',
        'array' => 'The :attribute must not have more than :max items.',
    ],
    'mimes' => ':values の形式でアップロードしてください。',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => 'The :attribute must be at least :min characters.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'multiple_of' => 'The :attribute must be a multiple of :value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => 'The :attribute must be a number.',
    'password' => 'メールアドレスとパスワードが一致しません。',
    'present' => 'The :attribute field must be present.',
    'prohibited' => 'The :attribute field is prohibited.',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'regex' => '正しく入力してください。',
    'required' => ':attribute を入力してください。',
    'required_array_keys' => 'The :attribute field must contain entries for: :values.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => '同じパスワードを入力してください。',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid timezone.',
    'unique' => ':attribute はすでに本登録済みです。',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'URL形式で入力してください。',
    'uuid' => 'The :attribute must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'imagePath' => [
            'required' => ':attribute を1点アップロードしてください。',
            'max' => ' 2MB以下の画像を選択してください。',
            'image' => 'jpeg, jpg, pngの形式をアップロードしてください。'
        ],
        'teamUrl' => [
            'url' => 'URL形式で入力してください。',
        ],
        'teamAlbum' => [
            'max' => ' 1MB以下の画像を選択してください。',
            'image' => 'jpeg, jpg, pngの形式をアップロードしてください。'
        ],
        'teamAlbum.*' => [
            'max' => ' 1MB以下の画像を選択してください。',
            'image' => 'jpeg, jpg, pngの形式をアップロードしてください。'
        ],
        'teamAlbumTotal' => [
            'image_max_in_album' => 'アルバムの枚数が5枚を超えてます。'
        ],
        'prefecture' => [
            'required' => ':attribute を選択してください。',
        ],
        'invitationCode' => [
            'exists' => '入力されたチームが存在しません。<br>再度、URLをご確認ください。'
        ],
        'token' => [
            'expired' => 'トークンの有効期限切れです。再度、仮登録フォームより登録してください。',
            'notvalid' => '不正な入力がありました。再度、URLをご確認ください。',
            'registered' => 'すでに本登録済みです。',
        ],
        'error' => [
            'register' => 'サーバーエラーが発生しました。<br>大変申し訳ありませんが再度、ご登録をお願いします。'
        ],
        'user' => [
            'google' => '*このメールアドレスは登録されていません。<br>*同じチームメンバーに共有されたURLで登録、<br>もしくは「新しくチームを作る」から登録してください。',
            'line' => '*このメールアドレスは登録されていません。<br>*同じチームメンバーに共有されたURLで登録、<br>もしくは「新しくチームを作る」から登録してください。<br>*すでにOLDwsへ登録されていてる場合は、LINEのアカウントに同一のメールアドレスが登録されているかを確認してください。'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'name' => 'ニックネーム',
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'password2' => 'パスワード(再入力)',
        'passwords' => 'メールアドレス',
        'invitation_code' => '招待コード',
        'token' => 'トークン',
        'sportAffiliationType' => 'スポーツ種別',
        'teamName' => 'チーム名',
        'imagePath' => 'チームロゴ画像',
        'teamUrl' => 'チーム紹介サイトのURL',
        'prefecture' => '都道府県',
        'address' => '市町村区',
        'first_preferered_date' => '第一希望の日程',
        'second_preferered_date' => '第二希望の日程',
        'third_preferered_date' => '第三希望の日程',
        'message' => 'メッセージ',
        'consent_game_id' => '試合招待id',
    ],
];
