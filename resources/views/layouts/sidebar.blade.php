<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>AtlasBulletinBoard</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&family=Oswald:wght@200&display=swap" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    </head>
    <body class="all_content">
        <div class="d-flex">
            <div class="sidebar">
                <p>
                    <a href="{{ route('top.show') }}">
                        <img src="{{ asset('image/home.png') }}" alt="ホーム" width="20" height="20" class="me-2 align-middle">
                        マイページ
                    </a>
                </p>
                <p>
                    <a href="/logout">
                        <img src="{{ asset('image/logout.png') }}" alt="ログアウト" width="20" height="20" class="me-2 align-middle">
                        ログアウト
                    </a>
                </p>
                <p>
                    <a href="{{ route('calendar.general.show',['user_id' => Auth::id()]) }}">
                        <img src="{{ asset('image/yoyaku.png') }}" alt="スクール予約" width="20" height="20" class="me-2 align-middle">
                        スクール予約
                    </a>
                </p>

                {{-- 講師のみ表示（role = 1, 2, 3） --}}
                @php
                    $role = Auth::check() ? Auth::user()->role : null;
                @endphp

                @if (in_array($role, [1, 2, 3]))
                    <p>
                        <a href="{{ route('calendar.admin.show',['user_id' => Auth::id()]) }}">
                            <img src="{{ asset('image/yoyakukakunin.png') }}" alt="スクール予約確認" width="20" height="20" class="me-2 align-middle">
                            スクール予約確認
                        </a>
                    </p>
                    <p>
                        <a href="{{ route('calendar.admin.setting',['user_id' => Auth::id()]) }}">
                            <img src="{{ asset('image/wakutouroku.png') }}" alt="スクール枠登録" width="20" height="20" class="me-2 align-middle">
                            スクール枠登録</a></p>
                @endif

                <p>
                    <a href="{{ route('post.show') }}">
                        <img src="{{ asset('image/keijiban.png') }}" alt="掲示板" width="20" height="20" class="me-2 align-middle">
                        掲示板
                    </a>
                </p>
                <p>
                    <a href="{{ route('user.show') }}">
                        <img src="{{ asset('image/user.png') }}" alt="ユーザー検索" width="20" height="20" class="me-2 align-middle">
                        ユーザー検索
                    </a>
                </p>
            </div>
            <div class="main-container">
                {{ $slot }}
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="{{ asset('js/bulletin.js') }}" rel="stylesheet"></script>
        <script src="{{ asset('js/user_search.js') }}" rel="stylesheet"></script>
        <script src="{{ asset('js/calendar.js') }}" rel="stylesheet"></script>
        <script src="{{ asset('js/category-toggle.js') }}" rel="stylesheet"></script>
    </body>
</html>
