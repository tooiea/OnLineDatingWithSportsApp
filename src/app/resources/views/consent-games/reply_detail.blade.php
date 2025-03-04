<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 5 Example</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/css/common.css">
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

        .media-sender {
            display: flex;
            flex-direction: row-reverse;
            text-align: right;
        }

        .media-receiver {
            display: flex;
        }

        .media-body {
            flex: 1;
        }

        .small.text-muted {
            font-size: 0.875rem;
        }
    </style>
</head>

<body class="body-with-nav">
    @include('layouts.nav')

    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">招待情報
                            {{ ($replies->invitee_id === $replies->my_team_id) ? '(あなたが招待)' : '' }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <img src="data:{{ $replies->guest_image_extension }};base64,{{ base64_encode(file_get_contents($replies->guest_team_logo)) }}"
                                    class="card-img-top rounded-circle" alt="ロゴ">
                            </div>
                            <div class="col-12 col-md-8">
                                <h5 class="card-title">{{ $replies->guest_team_name }}</h5>
                                <p class="card-text">
                                    <a href="{{ $replies->guest_team_url }}">チームURL</a>
                                </p>
                                <ul class="list-group">
                                    <li class="message-bubble mt-2">
                                        <label>ステータス: </label>
                                        <span>{{ \App\Enums\ConsentStatusTypeEnum::from($replies->consent_status)->label() }}</span>
                                    </li>
                                    @if ($replies->consent_status === \App\Enums\ConsentStatusTypeEnum::ACCEPTED->value)
                                    <li class="message-bubble mt-2">
                                        <label>承認日程:</label>
                                        <p>{{ \Carbon\Carbon::parse($replies->game_date)->format('Y年m月d日G時i分') }}</p>
                                    </li>
                                    @elseif ($replies->consent_status === \App\Enums\ConsentStatusTypeEnum::DECLINED->value)
                                    <li class="message-bubble mt-2">
                                        <label>承認日程:　-</label>
                                    </li>
                                    @else
                                    <li class="message-bubble mt-2">
                                        <label>第一希望日程:</label>
                                        <p>{{ \Carbon\Carbon::parse($replies->first_preferered_date)->format('Y年m月d日 G時i分') }}</p>
                                        <label>第二希望日程:</label>
                                        <p>{{ \Carbon\Carbon::parse($replies->second_preferered_date)->format('Y年m月d日 G時i分') }}</p>
                                        <label>第三希望日程:</label>
                                        <p>{{ \Carbon\Carbon::parse($replies->third_preferered_date)->format('Y年m月d日 G時i分') }}</p>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-header">
                    <h5 class="card-title mb-0">メッセージ履歴</h5>
                </div>
                <div class="card-body">
                    @foreach ($replies->reply as $reply)
                    <div class="mb-3 {{ $reply->team_id == $replies->guest_id ? 'media-receiver' : 'media-sender' }}">
                        <img src="data:{{ $reply->team_id == $replies->guest_id ? $replies->guest_image_extension : $replies->invite_image_extension }};base64,{{ base64_encode(file_get_contents($reply->team_id == $replies->guest_id ? $replies->guest_team_logo : $replies->invite_team_logo)) }}"
                            class="rounded-circle" alt="送信者アイコン" width="50" height="50">
                        <div class="media-body">
                            <div class="message-bubble">
                                @if (empty($reply->message))
                                <small>メッセージなし</small>
                                @else
                                {!! nl2br(e($reply->message)) !!}
                                @endif
                            </div>
                            <div class="small text-muted">
                                {{ \Carbon\Carbon::parse($reply->created_at)->format('Y年m月d日 G時i分') }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</body>

</html>