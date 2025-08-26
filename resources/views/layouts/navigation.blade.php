<header>
  {{-- ヘッダーの中身 --}}
  <a href="{{ route('index') }}" class="logo-link">
    <img src="{{ asset('images/atlas.png') }}" alt="Atlas Logo" class="logo-img">
  </a>

  <div class="user-header d-flex align-items-center gap-3">
  <div class="dropdown" id="dropdown">
    <span class="username">{{ Auth::user()->username }}&emsp;さん</span>
    <button id="dropdownToggle" class="dropdown-toggle">
      <span id="dropdownIcon" >∨</span>
    </button>
    <ul class="dropdown-menu">
      <li><a href="{{ route('index') }}">HOME</a></li>
      <li><a href="{{ route('pageA') }}">プロフィール編集</a></li>
      <li><a href="{{ route('logout') }}">ログアウト</a></li>
    </ul>
  </div>
  <img src="{{ asset('images/' . Auth::user()->icon_image) }}" alt="アイコン" class="user-icon" style="margin-left: 10px;">
</div>
</header>

<!-- BootstrapのJavaScriptを読み込み -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const toggleButton = document.getElementById('dropdownToggle');
  const dropdownIcon = document.getElementById('dropdownIcon');
  const dropdown = document.getElementById('dropdown');
  const dropdownMenu = dropdown.querySelector('.dropdown-menu');

  function placeMenu() {
    const header = document.querySelector('header');
    const sideBar = document.getElementById('side-bar');
    if (!header || !sideBar) return;

    // 画面座標
    const sbRect = sideBar.getBoundingClientRect();
    const hdRect = header.getBoundingClientRect();

    // スクロール考慮
    const scrollX = window.pageXOffset || document.documentElement.scrollLeft;
    const scrollY = window.pageYOffset || document.documentElement.scrollTop;

    // メニューは header 内にあるため、headerの原点との差分にする
    const headerLeft = hdRect.left + scrollX;
    const headerTop  = hdRect.top  + scrollY;

    // 左端＝サイドバー左端、幅＝サイドバー幅、上端＝ヘッダー直下
    dropdownMenu.style.left = (sbRect.left + scrollX - headerLeft) + 'px';
    dropdownMenu.style.width = sbRect.width + 'px';
    dropdownMenu.style.top  = (hdRect.bottom + scrollY - headerTop) + 'px';

    // 高さ：サイドバー内の横線（.sidebar-divider）までにしたい場合
    const divider = document.querySelector('#side-bar .sidebar-divider');
    if (divider) {
      const dvRect = divider.getBoundingClientRect();
      const maxPx = (dvRect.top + scrollY) - (hdRect.bottom + scrollY) - 8; // 余白8px
      if (maxPx > 100) { // 安全下限
        dropdownMenu.style.maxHeight = maxPx + 'px';
      }
    }
  }

  toggleButton.addEventListener('click', function (e) {
    e.stopPropagation();
    dropdownMenu.classList.toggle('show');
    dropdownIcon.textContent = dropdownMenu.classList.contains('show') ? '∧' : '∨';
    if (dropdownMenu.classList.contains('show')) {
      placeMenu();
    }
  });

  // 外側クリックで閉じる
  document.addEventListener('click', function (event) {
    if (!dropdown.contains(event.target)) {
      dropdownMenu.classList.remove('show');
      dropdownIcon.textContent = '∨';
    }
  });

  // 画面サイズが変わったら再配置（開いているときだけ）
  window.addEventListener('resize', function(){
    if (dropdownMenu.classList.contains('show')) placeMenu();
  });
});
</script>
