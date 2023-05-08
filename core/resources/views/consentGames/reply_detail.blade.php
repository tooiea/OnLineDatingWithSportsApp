<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bootstrap 4.5 Example</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/common.css?q">
    <link rel="stylesheet" href="/public/css/reply_ui.css?q">
</head>

<body class="body-with-nav">
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
                            <div class="col-12 col-md-4 text-center">
                                @if($replies->invitee_id === $replies->my_team_id)
                                <img src="data:{{ $replies->guest_image_extension }};base64,{{ base64_encode(file_get_contents('public' . Illuminate\Support\Facades\Storage::url($replies->guest_team_logo))) }}"
                                    class="card-img-top rounded-circle img-fluid" alt="ロゴ">
                                @else
                                <img src="data:{{ $replies->invite_image_extension }};base64,{{ base64_encode(file_get_contents('public' . Illuminate\Support\Facades\Storage::url($replies->invite_team_logo))) }}"
                                    class="card-img-top rounded-circle img-fluid" alt="ロゴ">
                                @endif
                            </div>
                            <div class="col-12 col-md-8">
                                <h5 class="card-title text-center">
                                    @if($replies->invitee_id === $replies->my_team_id)
                                    {{ $replies->guest_team_name }}
                                    @else
                                    {{ $replies->invite_team_name }}
                                    @endif
                                </h5>
                                <p class="card-text text-center">
                                    @if($replies->invitee_id === $replies->my_team_id)
                                    <a href="{{ $replies->guest_team_url }}">{{ $replies->guest_team_url }}</a>
                                    @else
                                    <a href="{{ $replies->invite_team_url }}">{{ $replies->guest_team_url }}</a>
                                    @endif
                                </p>
                                <ul class="list-group">
                                    <li class="list-group-item message-bubble mt-2 text-center">
                                        <label for="">進捗状況　</label>
                                        <span class="{{ 'status-' . \App\Enums\ConsentStatusTypeEnum::from($replies->consent_status)->className() }}">
                                            {{ \App\Enums\ConsentStatusTypeEnum::from($replies->consent_status)->label()
                                            }}
                                        </span>
                                    </li>
                                    @if ($replies->consent_status === \App\Enums\ConsentStatusTypeEnum::ACCEPTED->value)
                                    <li class="list-group-item message-bubble mt-2">
                                        <label for="">試合決定日時</label>
                                        <p>
                                            {{ \Carbon\Carbon::parse($replies->game_date)->format('Y年m月d日G時i分') }}
                                        </p>
                                    </li>
                                    @elseif ($replies->consent_status ===
                                    \App\Enums\ConsentStatusTypeEnum::DECLINED->value)
                                    <li class="list-group-item message-bubble mt-2 text-center">
                                        <label for="">承認日程　-</label>
                                    </li>
                                    @else
                                    <li class="list-group-item message-bubble mt-2 text-center">
                                        <label for="">第一希望日程:</label>
                                        <p>{{ \Carbon\Carbon::parse($replies->first_preferered_date)->format('Y年m月d日
                                            G時i分') }}</p>
                                        <label for="">第二希望日程:</label>
                                        <p>{{ \Carbon\Carbon::parse($replies->second_preferered_date)->format('Y年m月d日
                                            G時i分') }}</p>
                                        @if (!empty($replies->third_preferered_date))
                                        <label for="">第三希望日程:</label>
                                        <p>{{ \Carbon\Carbon::parse($replies->third_preferered_date)->format('Y年m月d日
                                            G時i分') }}</p>
                                        @endif
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    <hr>
                    <p>メッセージ履歴</p>
                    @if($replies->invitee_id === $replies->my_team_id)
                    <div class="media mb-3 media-sender">
                        <div class="media-body text-right">
                            <div class="message-bubble">
                                @if (empty($replies->message))
                                <small>メッセージなし</small>
                                @else
                                {!! nl2br(e($replies->message)) !!}
                                @endif
                            </div>
                            <div class="small text-muted text-right">
                                {{ \Carbon\Carbon::parse($replies->created_at)->format('Y年m月d日 G時i分') }}
                            </div>
                        </div>
                        <img src="data:{{ $replies->invite_image_extension }};base64,{{ base64_encode(file_get_contents('public' . Illuminate\Support\Facades\Storage::url($replies->invite_team_logo))) }}"
                            class="ml-3 rounded-circle" alt="自分のアイコン" width="50" height="50">
                    </div>
                    @else
                    <div class="media mb-3 media-receiver">
                        <img src="data:{{ $replies->invite_image_extension }};base64,{{ base64_encode(file_get_contents('public' . Illuminate\Support\Facades\Storage::url($replies->invite_team_logo))) }}"
                            class="mr-3 rounded-circle" alt="送信者アイコン" width="50" height="50">
                        <div class="media-body">
                            <div class="message-bubble">
                                @if (empty($replies->message))
                                <small>メッセージなし</small>
                                @else
                                {!! nl2br(e($replies->message)) !!}
                                @endif
                            </div>
                            <div class="small text-muted pl-3">
                                {{ \Carbon\Carbon::parse($replies->created_at)->format('Y年m月d日 G時i分') }}
                            </div>
                        </div>
                    </div>
                    @endif
                @foreach ($replies->reply as $reply)
                @if($replies->invitee_id == $replies->my_team_id)
                    <!-- 招待した場合 -->
                    @if ($reply->team_id == $replies->my_team_id)
                    <div class="media mb-3 media-receiver">
                        <div class="media-body text-right">
                            <div class="message-bubble">
                                @if (empty($reply->message))
                                <small>メッセージなし</small>
                                @else
                                {!! nl2br(e($reply->message)) !!}
                                @endif
                            </div>
                            <div class="small text-muted pl-3">
                                {{ \Carbon\Carbon::parse($reply->created_at)->format('Y年m月d日G時i分') }}
                            </div>
                        </div>
                        <img src="data:{{ $replies->invite_image_extension }};base64,{{ base64_encode(file_get_contents('public' . Illuminate\Support\Facades\Storage::url($replies->invite_team_logo))) }}"
                            class="ml-3 rounded-circle" alt="送信者アイコン" width="50" height="50">
                    </div>
                    @else
                    <div class="media mb-3 media-sender">
                        <img src="data:{{ $replies->guest_image_extension }};base64,{{ base64_encode(file_get_contents('public' . Illuminate\Support\Facades\Storage::url($replies->guest_team_logo))) }}"
                            class="mr-3 rounded-circle" alt="自分のアイコン" width="50" height="50">
                        <div class="media-body">
                            <div class="message-bubble">
                                @if (empty($reply->message))
                                <small>メッセージなし</small>
                                @else
                                {!! nl2br(e($reply->message)) !!}
                                @endif
                            </div>
                            <div class="small text-muted">{{
                                \Carbon\Carbon::parse($reply->created_at)->format('Y年m月d日 G時i分') }}</div>
                        </div>
                    </div>
                    @endif
                @else
                    <!-- 招待された場合 -->
                    @if ($reply->team_id === $replies->my_team_id)
                    <div class="media mb-3 media-receiver">
                        <div class="media-body text-right">
                            <div class="message-bubble">
                                @if (empty($reply->message))
                                <small>メッセージなし</small>
                                @else
                                {!! nl2br(e($reply->message)) !!}
                                @endif
                            </div>
                            <img src="data:{{ $replies->guest_image_extension }};base64,{{ base64_encode(file_get_contents('public' . Illuminate\Support\Facades\Storage::url($replies->guest_team_logo))) }}"
                                class="ml-3 rounded-circle" alt="自分のアイコン" width="50" height="50">
                            <div class="small text-muted text-right">
                                {{ \Carbon\Carbon::parse($reply->created_at)->format('Y年m月d日 G時i分') }}
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="media mb-3 media-sender">
                        <div class="media-body">
                            <img src="data:{{ $replies->invite_image_extension }};base64,{{ base64_encode(file_get_contents('public' . Illuminate\Support\Facades\Storage::url($replies->invite_team_logo))) }}"
                                class="mr-3 rounded-circle" alt="送信者アイコン" width="50" height="50">
                            <div class="message-bubble">
                                @if (empty($reply->message))
                                <small>メッセージなし</small>
                                @else
                                {!! nl2br(e($reply->message)) !!}
                                @endif
                            </div>
                            <div class="small text-muted pl-3">
                                {{ \Carbon\Carbon::parse($reply->created_at)->format('Y年m月d日G時i分') }}
                            </div>
                        </div>
                    </div>
                    @endif
                @endif
                @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    <form action="{{ route('reply.message') }}" method="post">
                        @csrf
                        <div class="input-group">
                            <input type="hidden" name="consent_game_id" value="{{ request()->route('consent_game_id') }}">
                            <input type="text" name="message" id="message" class="form-control" placeholder="メッセージを入力してください" aria-label="メッセージを入力してください" aria-describedby="button-send">
                            <div class="input-group-append">
                                <input class="btn btn-primary" type="submit" id="button-send" value="返信"></input>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>
