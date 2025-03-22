<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Team Edit Form</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="/css/common.css">
</head>

<body class="body-with-nav">
  @include('layouts.nav')

  <div class="container my-5">
    <h1 class="text-center">チームプロフィール編集</h1>
    <div class="card">
      <div class="card-body">
        <form>
          <div class="mb-3">
            <label for="teamName" class="form-label">チーム名:</label>
            <input type="text" class="form-control" id="teamName" value="[Team Name]" readonly />
          </div>

          <div class="mb-3">
            <label for="teamLogo" class="form-label">チームロゴ画像:</label>
            <input type="file" class="form-control" id="teamLogo" />
          </div>

          <div class="mb-3">
            <label for="teamURL" class="form-label">チーム紹介URL:</label>
            <input type="text" class="form-control" id="teamURL" value="[Team URL]" />
          </div>

          <div class="mb-3">
            <label for="teamAlbum" class="form-label">アルバム画像:</label>
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="teamAlbum" />
              <label class="form-check-label" for="teamAlbum">削除</label>
            </div>
          </div>

          <div class="mb-3">
            <label for="teamAlbumAdd" class="form-label">アルバムに追加:</label>
            <input type="file" class="form-control" id="teamAlbumAdd" />
          </div>

          <div class="mb-3">
            <label for="teamJoinURL" class="form-label">チーム招待用URL:</label>
            <input type="text" class="form-control" id="teamJoinURL" value="[Team Join URL]" readonly />
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-primary w-100">更新する</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>