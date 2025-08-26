<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AtlasSNS</title>

    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/logout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Google Fonts（M PLUS Rounded 1c） -->
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c&display=swap" rel="stylesheet">
</head>

<body class="logout-page gradation">
    <header class="centered-header">
    <img src="{{ asset('images/atlas.png') }}" alt="AtlasSNSロゴ" class="logo-img2">
    <p class="sub-title">Social Network Service</p>
    </header>

    <main id="container" class="logout-main">
  {{ $slot }}
</main>
</body>
</html>
