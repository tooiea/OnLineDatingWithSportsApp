<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
      crossorigin="anonymous"
    />
    <title>Team Edit Form</title>
  </head>
  <body>
    @include('layouts.nav')
    <div class="container my-5">
      <h1 class="text-center">Team Edit Form</h1>
      <div class="card">
        <div class="card-body">
          <form>
            <div class="form-group">
              <label for="teamName">Team Name:</label>
              <input type="text" class="form-control" id="teamName" value="[Team Name]" readonly />
            </div>
            <div class="form-group">
              <label for="teamLogo">Team Logo:</label>
              <input type="file" class="form-control-file" id="teamLogo" />
            </div>
            <div class="form-group">
              <label for="teamURL">Team URL:</label>
              <input type="text" class="form-control" id="teamURL" value="[Team URL]" />
            </div>
            <div class="form-group">
              <label for="teamAlbum">Team Album:</label>
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="teamAlbum" />
                <label class="form-check-label" for="teamAlbum">Delete</label>
              </div>
            </div>
            <div class="form-group">
              <label for="teamAlbumAdd">Add to Team Album:</label>
              <input type="file" class="form-control-file" id="teamAlbumAdd" />
            </div>
            <div class="form-group">
              <label for="teamJoinURL">Team Join URL:</label>
              <input type="text" class="form-control" id="teamJoinURL" value="[Team Join URL]" readonly />
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>