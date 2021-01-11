<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laratable</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body style="padding-top:6rem;">
    <div class="wrapper">
        <header class="navbar navbar-expand-lg navbar-white fixed-top">
            <div class="container">
                <div class="navbar-brand"></div>
                <div class="collapse navbar-collapse" id="Navbar">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a href="/" class="nav-link">アバウト</a>
                    </li>
                    <li class="nav-item">
                        <a href="/" class="nav-link">マイページ</a>
                    </li>
                    <li class="nav-item">
                        <a href="/" class="nav-link">レシピ</a>
                    </li>
                    <li class="nav-item">
                        <a href="/" class="nav-link">レシピ投稿</a>
                    </li>
                    </ul>
                </div>
            </div>
        </header>
        <div class="content">
            @yield('content')
        </div>
        <footer>
            <div class="container">
                <span style="font-size: 10px">Copyright(c) 2020 Delitable</span>
                  <span class="footer-logo" style="margin-top: 20px;"></span>
              </div>
        </footer>
    </div>
</body>
</html>
