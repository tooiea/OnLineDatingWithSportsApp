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
        <a class="nav-link" href="{{ route('team.index') }}">Myチームトップ</a>
      </li>
      <li class="nav-item {{ (request()->routeIs('search.index')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('search.index') }}">チーム検索画面</a>
      </li>
      <li class="nav-item {{ (request()->routeIs('team.detail')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('team.detail') }}">チームプロフィール</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}">ログアウト</a>
      </li>
    </ul>
  </div>
</nav>
