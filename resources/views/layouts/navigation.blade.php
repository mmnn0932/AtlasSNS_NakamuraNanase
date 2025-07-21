<div id="head">
            <head>
     <link rel="stylesheet" href="style.css">
   </head>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <h1><a href="{{ route('index') }}"><img src="{{ asset('images/atlas.png') }}"></a></h1>
            <div id="accordion" class="dropdown">
                <div id="accordion-header" class="accordion-header">
                    <span class="accordion-title">
                    <p>〇〇さん</p></span>
                    <span class="arrow">&#9660;</span> <!-- 矢印アイコン（下向き） -->
                </div>
                <div class="accordion-content">
                <ul>
                    <li><a href="{{ route('index') }}">ホーム</a></li>
                    <li><a href="{{ route('profile') }}">プロフィール</a></li>
                    <li><a href="{{ route('logout') }}">ログアウト</a></li>
                </ul>
                </div>
            </div>
        </div>
