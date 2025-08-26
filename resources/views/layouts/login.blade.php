<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <!--IEブラウザ対策-->
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="ページの内容を表す文章" />
  <title></title>
  <link rel="stylesheet" href="{{ asset('css/reset.css') }} ">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }} ">
  <!--スマホ,タブレット対応-->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Scripts -->
  <!--サイトのアイコン指定-->
  <link rel="icon" href="画像URL" sizes="16x16" type="image/png" />
  <link rel="icon" href="画像URL" sizes="32x32" type="image/png" />
  <link rel="icon" href="画像URL" sizes="48x48" type="image/png" />
  <link rel="icon" href="画像URL" sizes="62x62" type="image/png" />
  <!--iphoneのアプリアイコン指定-->
  <link rel="apple-touch-icon-precomposed" href="画像のURL" />
  <!--OGPタグ/twitterカード-->
</head>

<body class="login-layout">
  <header>
    @include('layouts.navigation')
  </header>
  <!-- Page Content -->
  <div id="row">
    <div id="container">
      {{ $slot }}
    </div>
    <!-- サイドバー内 -->
<div id="side-bar">
  <div id="confirm">
    <p>{{ Auth::user()->username }}さんの</p>

    <div>
      <p>フォロー数&emsp;&emsp;{{ Auth::user()->followingCount() }}人</p>
    </div>
    <p style="text-align: right;">
  <a href="{{ route('followlist') }}" class="btn btn-primary">フォローリスト</a>
</p>

    <div>
      <p>フォロワー数&emsp;{{ Auth::user()->followerCount() }}人</p>
    </div>
    <p style="text-align: right;">
  <a href="{{ route('followerlist') }}" class="btn btn-primary">フォロワーリスト</a>
</p>

    <!-- 横線 -->
    <hr class="sidebar-divider" id="sidebarLimit">

      <p class="user-search-button">
  <a href="{{ route('users.search') }}" class="btn btn-primary">ユーザー検索</a>
</p>
  </div>
</div>
  <footer>
  </footer>
  <script src="{{ asset('js/app.js') }}"></script>
  <!-- jQuery CDN -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- 独自スクリプト -->
  <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
