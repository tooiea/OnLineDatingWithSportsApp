<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">OLDws</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
    aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item {{ (request()->is('/')) ? 'active' : '' }}">
        <a class="nav-link" href="#">ホーム</a>
      </li>
      <li class="nav-item {{ (request()->routeIs('team.index')) ? 'active' : '' }}">
        <a class="nav-link" href="">Myチームトップ</a>
      </li>
      <li class="nav-item {{ (request()->routeIs('search.index')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('team.list') }}">チーム検索画面</a>
      </li>
      <li class="nav-item {{ (request()->routeIs('team.detail')) ? 'active' : '' }}">
        <a class="nav-link" href="">チームプロフィール</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="">ログアウト</a>
      </li>
    </ul>
  </div>
</nav>
