<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="/public/css/common.css?q">
  <title>Team Edit Form</title>
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
            <input type="text" name="teamName" class="form-control" id="teamName" value="{{ $myTeam->team->team_name }}"/>
            @error('teamName')<div class="invalid-feedback" role="alert"> {{ $message }} </div>@enderror
          </div>
          <div class="form-group">
            <label for="teamLogo">チームロゴ画像</label>
            <p>
              <img id="teamLogo" src="data:{{ $myTeam->team->image_extension }};base64,{{ base64_encode(file_get_contents('public' . Illuminate\Support\Facades\Storage::url($myTeam->team->image_path))) }}"
              class="img-fluid" alt="team logo" data-original-url="data:{{ $myTeam->team->image_extension }};base64,{{ base64_encode(file_get_contents('public' . Illuminate\Support\Facades\Storage::url($myTeam->team->image_path))) }}" />
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
            <input type="text" name="teamUrl" class="form-control" id="teamURL" value="{{ $myTeam->team->team_url }}" />
            @error('teamUrl')<div class="invalid-feedback" role="alert"> {{ $message }} </div>@enderror
          </div>
          @if (!$myTeamAlbums->isEmpty())
          <div class="form-group">
            <label for="teamAlbum">アルバム画像を削除する:</label>
             @foreach ($myTeamAlbums as $image)
            <p>
              <img src="data:{{ $image->image_extension }};base64,{{ base64_encode(file_get_contents('public' . Illuminate\Support\Facades\Storage::url($image->image_name))) }}" class="img-fluid" alt="team album" />
            </p>
            <div class="form-check">
              <input type="checkbox" name="deleteAlbum[]" class="form-check-input" id="deleteAlbum" value="{{ Crypt::encryptString($image->id) }}" />
              <label class="form-check-label" for="deleteAlbum">削除する</label>
            </div>
            @endforeach
            @error('deleteAlbum')<div class="invalid-feedback" role="alert"> {{ $message }} </div>@enderror
            @error('deleteAlbum.*')<div class="invalid-feedback" role="alert"> {{ $message }} </div>@enderror
          </div>
          @endif
          <div class="form-group">
            <label for="teamAlbumAdd">アルバム画像を追加する(5枚まで)</label>
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
