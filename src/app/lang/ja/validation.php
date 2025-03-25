<?php

return [

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

    'accepted' => ':attributeを確認し、同意してください',
    'accepted_if' => ':otherが:valueの場合、:attributeを確認し、同意してください',
    'active_url' => ':attributeは正しいURLを入力してください',
    'after' => ':attributeは:date以降の日付を指定してください',
    'after_or_equal' => ':attributeは:date以降の日付を指定してください',
    'alpha' => ':attributeは文字のみ入力してください',
    'alpha_dash' => ':attributeは文字、数字、ハイフン（-）、アンダースコア（_）のみ使用してください',
    'alpha_num' => ':attributeは文字と数字のみ使用してください',
    'array' => ':attributeは配列形式で入力してください',
    'ascii' => ':attributeは英数字と記号のみ使用してください',
    'before' => ':attributeは:date以前の日付を指定してください',
    'before_or_equal' => ':attributeは:date以前の日付を指定してください',
    'between' => [
        'array' => ':attributeは:min〜:max個の要素を含めてください',
        'file' => ':attributeは:min〜:max KBのファイルサイズにしてください',
        'numeric' => ':attributeは:min〜:maxの範囲で入力してください',
        'string' => ':attributeは:min〜:max文字の範囲で入力してください',
    ],
    'boolean' => ':attributeは「はい」または「いいえ」を選択してください',
    'can' => ':attributeに許可されていない値が含まれています',
    'confirmed' => ':attributeと確認用の入力が一致しません',
    'contains' => ':attributeに必要な値が含まれていません',
    'current_password' => '現在のパスワードが正しくありません',
    'date' => ':attributeは有効な日付形式で入力してください',
    'date_equals' => ':attributeは:dateと同じ日付で入力してください',
    'date_format' => ':attributeは「:format」の形式で入力してください',
    'decimal' => ':attributeは:decimal桁の小数を入力してください',
    'declined' => ':attributeは拒否してください',
    'declined_if' => ':otherが:valueの場合、:attributeは拒否してください',
    'different' => ':attributeと:otherは異なる値にしてください',
    'digits' => ':attributeは:digits桁の数字を入力してください',
    'digits_between' => ':attributeは:min桁から:max桁の間で入力してください',
    'dimensions' => ':attributeの画像サイズが無効です',
    'distinct' => ':attributeに重複した値が含まれています',
    'doesnt_end_with' => ':attributeは:valuesで終わらないようにしてください',
    'doesnt_start_with' => ':attributeは:valuesで始まらないようにしてください',
    'email' => ':attributeは有効なメールアドレス形式で入力してください',
    'ends_with' => ':attributeは:valuesのいずれかで終わる必要があります',
    'enum' => '選択した:attributeが無効です',
    'exists' => '選択した:attributeが無効です',
    'extensions' => ':attributeは:values形式のファイルを指定してください',
    'file' => ':attributeは有効なファイル形式を指定してください',
    'filled' => ':attributeを入力してください',
    'gt' => [
        'array' => ':attributeは:value個を超える要素が必要です',
        'file' => ':attributeは:value KBを超えるサイズにしてください',
        'numeric' => ':attributeは:valueより大きい値を入力してください',
        'string' => ':attributeは:value文字を超える値を入力してください',
    ],
    'gte' => [
        'array' => ':attributeは:value個以上の要素が必要です',
        'file' => ':attributeは:value KB以上のサイズにしてください',
        'numeric' => ':attributeは:value以上の値を入力してください',
        'string' => ':attributeは:value文字以上の値を入力してください',
    ],
    'hex_color' => ':attributeは正しい16進数カラーコードを入力してください',
    'image' => ':attributeは画像形式で入力してください',
    'in' => '選択した:attributeが無効です',
    'in_array' => ':attributeは:otherに存在する値でなければなりません',
    'integer' => ':attributeは整数で入力してください',
    'ip' => ':attributeは正しいIPアドレスを入力してください',
    'ipv4' => ':attributeは正しいIPv4アドレスを入力してください',
    'ipv6' => ':attributeは正しいIPv6アドレスを入力してください',
    'json' => ':attributeは有効なJSON文字列で入力してください',
    'list' => ':attributeはリスト形式で入力してください',
    'lowercase' => ':attributeは小文字で入力してください',
    'lt' => [
        'array' => ':attributeは:value個未満の要素にしてください',
        'file' => ':attributeは:value KB未満のサイズにしてください',
        'numeric' => ':attributeは:value未満の値を入力してください',
        'string' => ':attributeは:value文字未満の値を入力してください',
    ],
    'lte' => [
        'array' => ':attributeは:value個以下の要素にしてください',
        'file' => ':attributeは:value KB以下のサイズにしてください',
        'numeric' => ':attributeは:value以下の値を入力してください',
        'string' => ':attributeは:value文字以下の値を入力してください',
    ],
    'mac_address' => ':attributeは正しいMACアドレスを入力してください',
    'max' => [
        'array' => ':attributeは:max個以下の要素にしてください',
        'file' => ':attributeは:max KB以下のサイズにしてください',
        'numeric' => ':attributeは:max以下の値を入力してください',
        'string' => ':attributeは:max文字以下の値にしてください',
    ],
    'max_digits' => ':attributeは:max桁以下にしてください',
    'mimes' => ':attributeは:values形式のファイルを指定してください',
    'mimetypes' => ':attributeは:values形式のファイルを指定してください',
    'min' => [
        'array' => ':attributeは:min個以上の要素が必要です',
        'file' => ':attributeは:min KB以上のサイズにしてください',
        'numeric' => ':attributeは:min以上の値を入力してください',
        'string' => ':attributeは:min文字以上の値を入力してください',
    ],
    'min_digits' => ':attributeは:min桁以上にしてください',
    'missing' => ':attributeを指定してください',
    'missing_if' => ':otherが:valueの場合、:attributeを指定してください',
    'missing_unless' => ':otherが:valueでない場合、:attributeを指定してください',
    'missing_with' => ':valuesが存在する場合、:attributeを指定してください',
    'missing_with_all' => ':valuesがすべて存在する場合、:attributeを指定してください',
    'multiple_of' => ':attributeは:valueの倍数である必要があります',
    'not_in' => '選択した:attributeが無効です',
    'not_regex' => ':attributeの形式が無効です',
    'numeric' => ':attributeは数値を入力してください',
    'password' => [
        'letters' => ':attributeは少なくとも1文字を含めてください',
        'mixed' => ':attributeは少なくとも1つの大文字と小文字を含めてください',
        'numbers' => ':attributeは少なくとも1つの数字を含めてください',
        'symbols' => ':attributeは少なくとも1つの記号を含めてください',
        'uncompromised' => ':attributeは過去に漏洩した可能性があるため、別の値を使用してください',
    ],
    'present' => ':attributeを入力してください',
    'present_if' => ':otherが:valueの場合、:attributeを入力してください',
    'present_unless' => ':otherが:valueでない場合、:attributeを入力してください',
    'present_with' => ':valuesが入力されている場合、:attributeを入力してください',
    'present_with_all' => ':valuesがすべて入力されている場合、:attributeを入力してください',
    'prohibited' => ':attributeは使用できません',
    'prohibited_if' => ':otherが:valueの場合、:attributeは使用できません',
    'prohibited_if_accepted' => ':otherが受け入れられた場合、:attributeは使用できません',
    'prohibited_if_declined' => ':otherが拒否された場合、:attributeは使用できません',
    'prohibited_unless' => ':otherが:valuesに含まれていない場合、:attributeは使用できません',
    'prohibits' => ':attributeを入力した場合、:otherは入力できません',
    'regex' => ':attributeの形式が正しくありません',
    'required' => ':attributeを入力してください',
    'required_array_keys' => ':attributeには次の項目を含めてください: :values',
    'required_if' => ':otherが:valueの場合、:attributeを入力してください',
    'required_if_accepted' => ':otherが受け入れられた場合、:attributeを入力してください',
    'required_if_declined' => ':otherが拒否された場合、:attributeを入力してください',
    'required_unless' => ':otherが:valuesに含まれていない場合、:attributeを入力してください',
    'required_with' => ':valuesが存在する場合、:attributeを入力してください',
    'required_with_all' => ':valuesがすべて存在する場合、:attributeを入力してください',
    'required_without' => ':valuesが存在しない場合、:attributeを入力してください',
    'required_without_all' => ':valuesがすべて存在しない場合、:attributeを入力してください',
    'same' => ':attributeと:otherは一致していません',
    'size' => [
        'array' => ':attributeは:size個の要素を含めてください',
        'file' => ':attributeは:size KBのサイズにしてください',
        'numeric' => ':attributeは:sizeにしてください',
        'string' => ':attributeは:size文字にしてください',
    ],
    'starts_with' => ':attributeは:valuesのいずれかで始めてください',
    'string' => ':attributeは文字列で入力してください',
    'timezone' => ':attributeは正しいタイムゾーンを入力してください',
    'unique' => ':attributeは既に使われています',
    'uploaded' => ':attributeのアップロードに失敗しました',
    'uppercase' => ':attributeを大文字にしてください',
    'url' => ':attributeは有効なURLを入力してください',
    'ulid' => ':attributeは正しいULIDを入力してください',
    'uuid' => ':attributeは正しいUUIDを入力してください',

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
            'required' => ':attributeを1点アップロードしてください',
            'max' => ' 2MB以下の画像を選択してください',
            'image' => 'jpeg,jpg,pngの形式をアップロードしてください'
        ],
        'sportAffiliationType' => [
            'required' => ':attributeを選択してください'
        ],
        'teamUrl' => [
            'url' => 'URL形式で入力してください',
        ],
        'teamAlbum' => [
            'max' => '1MB以下の画像を選択してください',
            'image' => 'jpeg,jpg,pngの形式をアップロードしてください'
        ],
        'teamAlbum.*' => [
            'max' => '1MB以下の画像を選択してください',
            'image' => 'jpeg,jpg,pngの形式をアップロードしてください',
            'uploaded' => '1MB以下の画像を選択してください',
        ],
        'teamAlbumTotal' => [
            'image_max_in_album' => 'アルバムの枚数が5枚を超えてます'
        ],
        'prefecture' => [
            'required' => ':attributeを選択してください',
        ],
        'invitationCode' => [
            'exists' => '入力されたチームが存在しません <br>再度、URLをご確認ください'
        ],
        'token' => [
            'expired' => 'トークンの有効期限切れです 再度、仮登録フォームより登録してください',
            'exists' => '不正な入力がありました 再度、URLをご確認ください',
            'notvalid' => '不正な入力がありました 再度、URLをご確認ください',
            'registered' => 'すでに本登録済みです',
        ],
        'error' => [
            'register' => 'サーバーエラーが発生しました<br>大変申し訳ありませんが再度、ご登録をお願いします'
        ],
        'user' => [
            'google' => '*このメールアドレスは登録されていません<br>*同じチームメンバーに共有されたURLで登録、<br>もしくは「新しくチームを作る」から登録してください',
            'line' => '*このメールアドレスは登録されていません<br>*同じチームメンバーに共有されたURLで登録、<br>もしくは「新しくチームを作る」から登録してください<br>*すでにOLDwsへ登録されていてる場合は、LINEのアカウントに同一のメールアドレスが登録されているかを確認してください'
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
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'nickname' => 'ニックネーム',
        'password2' => 'パスワード（再入力）',
        'sportAffiliationType' => 'スポーツ種別',
        'teamName' => 'チーム名',
        'teamLogo' => 'チームロゴ画像',
        'teamUrl' => 'チーム紹介用URL',
        'prefecture' => '都道府県',
        'address' => '市区町村'
    ],

];
