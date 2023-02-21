<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <!-- TODO 対象ページの場合は、active classを付与条件を追加 -->
        <li class="nav-item active">
          <a class="nav-link" href="#">ホーム</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('team.index') }}">Myチームトップへ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('search.index') }}">チーム検索画面</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('logout') }}">ログアウト</a>
        </li>
      </ul>
    </div>
</nav>