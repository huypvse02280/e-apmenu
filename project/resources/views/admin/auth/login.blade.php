<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{!! asset('images/logo-gray.png') !!}"/>
    
    <title>利用者ログイン</title>

    <!-- Bootstrap -->
    <link href="{{asset('vendor/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{asset('vendor/iCheck/skins/flat/green.css')}}" rel="stylesheet">
    
    <link type="text/css" rel="stylesheet" media="all" href="{{url('css/entypo.css')}}">
    <link type="text/css" rel="stylesheet" media="all" href="{{url('css/neon-theme.css')}}">
    <link type="text/css" rel="stylesheet" media="all" href="{{url('css/neon-forms.css')}}">

    <link href="{{asset('css/custom.css')}}" rel="stylesheet">
  </head>

  <body class="page-body login-page" data-url="">
      <div class="login-container">
        <div class="login-header login-caret">
          <div class="login-content">
             <a href="{{route('e-kedou.login')}}" class="logo"><img alt="" src='{{url("images/logo-white.png")}}' width="240"></a><p class="description">利用者認証アプリ等起動システム</p>
          </div>
        </div>
        <div class="login-form">
          @if(Session::has('flash_message'))
            <div class="form-group" id="alert-success">
              <div class="alert alert-{{Session::get('flash_level')}}">
                {{ Session::get('flash_message') }}
              </div>
            </div>
          @endif()
          <div class="form-group">
                 <a style="text-decoration: none;" href="{{ route('e-kedou.oauth') }}" class="btn btn-block btn-danger submit btn-google-login" type="submit">ログイン</a>
          </div>
         </div>
		 <footer id="footer-e-kedou" class="text-center">
         
           Copyright © <?php date('Y')?> KAGAYA. All Rights Reserved.</br></br>
           <a href="#" style="color:#fff;" onclick="openPolicy('policy.htm','加賀屋プライバシーポリシー',600,600);">プライバシーポリシー</a>
        </footer>
      </div>
    <!-- Jquery -->
    <script src="{{asset('vendor/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>

    <script type='text/javascript' charset='utf-8' src='{{url("js/toastr.js")}}'></script>
    <script type='text/javascript' charset='utf-8' src='{{url("js/login.js")}}'></script>
    <script src="{{asset('js/admin.js')}}"></script>
    <script type="text/javascript">
        function openPolicy(pageURL, title,w,h) {
            var left = (screen.width/2)-(w/2);
            var top = (screen.height/2)-(h/2);
            var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
            return false;
        }
    </script>
   </body>
</html>