@php
use Illuminate\Support\Facades\Storage;
@endphp

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="/public/css/common.css?q">
  <title>Team Edit Form</title>
  <style>
    .col-12 {
      flex-basis: 0;
      flex-grow: 1;
      max-width: 100%;
    }
  </style>

</head>

<body class="body-with-nav">
  @include('layouts.nav')
  <div class="container my-5">
    <h1 class="text-center">チームプロフィール編集</h1>
    <div class="card">
      <div class="card-body">
        <form action="{{ route('team.update') }}" method="post" enctype="multipart/form-data">
          @method('put')
          @csrf
          <div class="form-group">
            <label for="teamName">チーム名</label>
            <input type="text" name="teamName" class="form-control" id="teamName" value="{{ !empty(old('teamName')) ? old('teamName') :  $myTeam->team->team_name }}"/>
            @error('teamName')<div class="invalid-feedback" role="alert"> {{ $message }} </div>@enderror
          </div>
          <div class="form-group">
            <label for="teamLogo">チームロゴ画像</label>
            <p>
              <img id="teamLogo" src="data:{{ $myTeam->team->image_extension }};base64,{{ base64_encode(file_get_contents(Storage::url($myTeam->team->image_path))) }}"
              class="img-fluid" alt="team logo" data-original-url="data:{{ $myTeam->team->image_extension }};base64,{{ base64_encode(file_get_contents(Storage::url($myTeam->team->image_path))) }}" />
            </p>
            <div class="custom-file">
              <input type="file" name="imagePath" class="custom-file-input" id="imagePath" />
              <label class="custom-file-label" for="imagePath"><small>変更時は選択してください</small></label>
              <div id="imagePreview" class="preview-container"></div>
            </div>
            <div id="updateNoticeText" class="notice-text" style="display: none;" >この画像はまだ更新されていません。</div>
            <button id="cancelUploadButton" type="button" class="btn btn-outline-secondary" style="display: none;">
              <i class="fas fa-times"></i> キャンセル
            </button>
            @error('imagePath')<div class="invalid-feedback" role="alert"> {{ $message }} </div>@enderror
          </div>
          <div class="form-group">
            <label for="teamURL">チーム紹介URL</label>
            <input type="text" name="teamUrl" class="form-control" id="teamURL" value="{{ !empty(old('teamUrl')) ? old('teamUrl') : $myTeam->team->team_url }}" />
            @error('teamUrl')<div class="invalid-feedback" role="alert"> {{ $message }} </div>@enderror
          </div>
          @if (!$myTeamAlbums->isEmpty())
          <div class="form-group">
            <label for="teamAlbum">アルバム画像を削除する↓</label>
            <div class="row justify-content-center">
              @php $count = 0; @endphp
              <div class="d-flex justify-content-center">
                @foreach ($myTeamAlbums as $image)
                  @if ($count < 5)
                    <div class="album_container col-lg-2 col-md-4 col-sm-6 col-12 mb-4">
                      <div class="position-relative">
                        <div class="album-image-wrapper">
                          <img src="data:{{ $image->image_extension }};base64,{{ base64_encode(file_get_contents(Storage::url($image->image_name))) }}" class="img-fluid" alt="team album" />
                        </div>
                        <div class="form-check position-absolute" style="top: 5px; right: 5px;">
                          <input type="checkbox" name="deleteAlbum[]" class="form-check-input" id="deleteAlbum{{ $image->id }}" value="{{ Crypt::encryptString($image->id) }}" />
                        </div>
                      </div>
                    </div>
                    @php $count++; @endphp
                  @endif
                @endforeach
              </div>
              @if ($count < 5)
                @for ($i = 0; $i < (5 - $count); $i++)
                  <div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-4"></div>
                @endfor
              @endif
            </div>
          </div>
          @endif
          <div class="form-group">
            <label for="teamAlbumAdd">アルバム画像を追加する(5枚まで)↓</label>
            <small>※画像1枚あたり1MB以内</small>
            <input type="file" name="teamAlbum[]" class="form-control-file" id="teamAlbumAdd" multiple />
            <div id="albumPreview" class="preview-container"></div>
            @error('teamAlbum')<div class="invalid-feedback" role="alert"> {{ $message }} </div>@enderror
            @error('teamAlbum.*')<div class="invalid-feedback" role="alert"> {{ $message }} </div>@enderror
            @error('teamAlbumTotal')<div class="invalid-feedback" role="alert"> {{ $message }} </div>@enderror
          </div>
          <div class="text-center">
            <button type="submit" name="update_button" class="btn btn-primary">更新する</button>
          </div>
        </form>
      </div>
    </div>
  </div>
    <script src="/public/js/preview.js"></script>
</body>

</html>
