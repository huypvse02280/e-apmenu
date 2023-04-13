<!DOCTYPE html>
<html lang="ja">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{!! asset('images/logo-gray.png') !!}"/>
    <link type="text/css" rel="stylesheet" href="{{url('css/login.css')}}">
    <link type="text/css" rel="stylesheet" href="{{url('css/font-awesome/4.3.0/css/font-awesome.css')}}">
    <link type="text/css" rel="stylesheet" href="{{url('css/toastr.min.css')}}">

    <title>利用者ログイン</title>
</head>

<body class="page-body login-page" data-url="">
    <div class="body-container">
        <header class="login-header">
            <span class="login-logo">
                <img alt="" src='{{url("images/logo-white.png")}}' width="240">
            </span>
            <h1>利用者認証アプリ等起動システム</h1>
        </header>
        <section class="login-body">
            <div class="login-body-content">
                <div class="login-arubaito">
                    <form method="post" action="{{ route('auth.login') }}">
                        {{ csrf_field() }}
                        <div class="form-input">
                            <input type="email" name="mail" id="email" placeholder="メール" spellcheck="true" class="form-input-element userVo">
                        </div>
                        <div class="form-input">
                            <input type="password" name="password" placeholder="パスワード" class="form-input-element userVo">
                        </div>
                        <div>
                           {{-- <input class="login-btn"
                                    type="submit"
                                    data-action="{{ route('auth.login') }}">
                                <span class="google-btn-wrapper" style="align-items: center; align-self: center; flex: 1 1 auto; margin: 0px 4px; max-width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                 <span>ログイン</span>
                                </span>
                            />--}}
                            <input value="ログイン" type="submit" class="login-btn">
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <footer>
            <ul>
                <li>
                    <span>Copyright © 2018 KAGAYA. All Rights Reserved.</span>
                </li>
                <li>
                    <a href="#" style="color:#fff;" onclick="openPolicy('policy.htm','加賀屋プライバシーポリシー',600,600);">プライバシーポリシー</a>
                </li>
            </ul>
        </footer>
    </div>


<!-- Jquery -->
    <script src="{{asset('vendor/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>

    <script type='text/javascript' charset='utf-8' src='{{url("js/toastr.min.js")}}'></script>
    <script type='text/javascript' charset='utf-8' src='{{url("js/common.js")}}'></script>
    <script type="text/javascript">
        function openPolicy(pageURL, title,w,h) {
            var left = (screen.width/2)-(w/2);
            var top = (screen.height/2)-(h/2);
            var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
            return false;
        }
        @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
        @endif
    </script>
</body>
</html>