<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bootstrap 4.5 Example</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    <style>
        /* LINE風のUI */
        .card-header {
            background-color: #d5f1d5;
            color: #312b2b;
            font-size: 1.2rem;
            border-radius: 0.5rem 0.5rem 0 0;
        }

        .card-body {
            background-color: #f2f2f2;
            border-radius: 0 0 0.5rem 0.5rem;
        }

        .list-group {
            width: auto;
        }

        .message-bubble {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            background-color: #fff;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.15);
            max-width: 90%;
        }

        /* 送信者アイコンを左寄せに */
        .media-sender .media-body {
            margin-left: 0;
            margin-right: auto;
        }

        /* 受信者アイコンを右寄せに */
        .media-receiver .media-body {
            margin-left: auto;
            margin-right: 0;
        }
    </style>


</head>

<body>
    @include('layouts.nav')
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-6">
                <div class="card rounded">
                    <div class="card-header">
                        <h5 class="card-title mb-0">招待情報</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <img src="data:{{ $consents->image_extension }};base64,{{ base64_encode(file_get_contents($consents->team_logo)) }}"
                                    class="card-img-top rounded-circle" alt="ロゴ">
                            </div>
                            <div class="col-12 col-md-8">
                                <h5 class="card-title">{{ $consents->team_name }}</h5>
                                <p class="card-text"><a href="{{ $consents->team_url }}">チームURL</a></p>
                                <ul class="list-group">
                                    <li class="message-bubble mt-2">
                                        <label for="">ステータス:　</label>
                                        <span>{{
                                            \App\Enums\ConsentStatusTypeEnum::from($consents->consent_status)->label()
                                            }}</span>
                                    </li>
                                    <li class="message-bubble mt-2">
                                        <label for="">第一希望日程:</label>
                                        <p>{{ \Carbon\Carbon::parse($consents->first_preferered_date)->format('Y年m月d日
                                            G時i分') }}</p>
                                        <label for="">第二希望日程:</label>
                                        <p>{{ \Carbon\Carbon::parse($consents->second_preferered_date)->format('Y年m月d日
                                            G時i分') }}</p>
                                        <label for="">第三希望日程:</label>
                                        <p>{{ \Carbon\Carbon::parse($consents->third_preferered_date)->format('Y年m月d日
                                            G時i分') }}</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-header">
                    <h5 class="card-title mb-0">メッセージの返信</h5>
                </div>
                <div class="card-body">
                    <div class="media mb-3 media-receiver">
                        <img src="data:{{ $replies->invite_image_extension }};base64,{{ base64_encode(file_get_contents($replies->invite_team_logo)) }}"
                            class="mr-3 rounded-circle" alt="送信者アイコン" width="50" height="50">
                        <div class="media-body">
                            <div class="message-bubble">
                                {!! nl2br(e($consents->message)) !!}
                            </div>
                            <div class="small text-muted">{{
                                \Carbon\Carbon::parse($consents->created_at)->format('Y年m月d日 G時i分') }}</div>
                        </div>
                    </div>
                    @foreach ($replies->reply as $reply)
                    @if ($reply->team_id == $consents->guest_id)
                    <div class="media mb-3 media-sender">
                        <div class="media-body">
                            <div class="message-bubble">
                                {!! nl2br(e($reply->message)) !!}
                            </div>
                            <div class="small text-muted text-right">{{
                                \Carbon\Carbon::parse($reply->created_at)->format('Y年m月d日 G時i分') }}</div>
                        </div>
                        <img src="data:{{ $replies->guest_image_extension }};base64,{{ base64_encode(file_get_contents($replies->guest_team_logo)) }}"
                            class="ml-3 rounded-circle" alt="自分のアイコン" width="50" height="50">
                    </div>
                    @else
                    <div class="media mb-3 media-receiver">
                        <img src="data:{{ $replies->invite_image_extension }};base64,{{ base64_encode(file_get_contents($replies->invite_team_logo)) }}"
                            class="mr-3 rounded-circle" alt="送信者アイコン" width="50" height="50">
                        <div class="media-body">
                            <div class="message-bubble">
                                {!! nl2br(e($reply->message)) !!}
                            </div>
                            <div class="small text-muted">{{ \Carbon\Carbon::parse($reply->created_at)->format('Y年m月d日
                                G時i分') }}</div>
                        </div>
                    </div>
                    @endif
                    @endforeach

                    <!-- <div class="media mb-3 media-sender">
                        <div class="media-body text-right">
                            <div class="message-bubble">
                                <h5 class="mt-0">自分の名前</h5>
                                メッセージの本文がここに入ります。
                            </div>
                            <div class="small text-muted">送信日時</div>
                        </div>
                        <img src="https://via.placeholder.com/50x50" class="ml-3 rounded-circle" alt="自分のアイコン">
                    </div>
                    <div class="media mb-3 media-receiver">
                        <img src="https://via.placeholder.com/50x50" class="mr-3 rounded-circle" alt="送信者アイコン">
                        <div class="media-body">
                            <div class="message-bubble">
                                <h5 class="mt-0">送信者名</h5>
                                メッセージの本文がここに入ります。
                            </div>
                            <div class="small text-muted">送信日時</div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</body>

</html>