<?php
use Illuminate\Support\Facades\Auth;

$user = Auth::user();
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<link rel="icon" href="{!! asset('images/logo-gray.png') !!}"/>-->
	<link rel="shortcut icon" href="{!! asset('images/logo-gray.ico') !!}"/>
	<link rel="apple-touch-icon" href="{!! asset('images/logo-gray.ico') !!}"/>
    
    <title>おもてなしメニュー</title>
    <script type="text/javascript">
      $_GLOBAL = {
        ROOT_URL : '{{url('/')}}'
      };
      function url(path) {
        return $_GLOBAL['ROOT_URL'] + path;
      }
    </script>

    <!-- Bootstrap -->
    <link href="{{asset('vendor/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{asset('vendor/iCheck/skins/flat/green.css')}}" rel="stylesheet">

    <link href="{{asset('vendor/datepicker/jquery.datetimepicker.css')}}" rel="stylesheet">

    <link href="{{asset('vendor/select2/dist/css/select2.min.css')}}" rel="stylesheet">
    
    <link href="{{asset('vendor/ion.rangeSlider/css/ion.rangeSlider.css')}}" rel="stylesheet">
    <link href="{{asset('vendor/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css')}}" rel="stylesheet">
	 <!-- jQuery -->
    <script src="{{asset('vendor/jquery/dist/jquery.min.js')}}"></script>
	 <script src="{{asset('vendor/datepicker/jquery.datetimepicker.full.min.js')}}"></script>
    @section('css')
    @show()
    <!-- Custom Theme Style -->
    <link href="{{asset('css/custom.css')}}" rel="stylesheet">
  </head>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
         <nav class="navbar navbar-inverse">
            <div class="navbar-header">
               <!--  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
                   <span class="sr-only">Toggle navigation</span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
               </button> -->
                <a href="{{url('/')}}" class="navbar-brand">おもてなしメニュー</a>
            </div>

            <div class="navbar-collapse pull-right" id="menu">
               
                <ul class="nav navbar-nav navbar-right" id="menu-user">
                    <li class="">
                      <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="{{val($user->photo_url, url('images/user-default.png'))}}" alt=""> {{$user->name}}
                        <span class=" fa fa-angle-down"></span>
                      </a>
                      <ul class="col-sm-12 dropdown-menu dropdown-usermenu pull-right" id="menu-logged">
						
                       
                        <li><a class="btn-logout" href="#"><i class="fa fa-sign-out pull-right"></i> ログアウト</a></li>
                      </ul>
                    </li>
                  </ul>
            </div>
        </nav>

        @section('page-content')

        @show

        <footer id="footer-e-kedou" class="text-center">
           <div class="col-md-12 col-sm-12">
				Copyright © <?php date('Y')?> KAGAYA. All Rights Reserved.
           
          </div>
          <div class="clearfix"></div>
        </footer>

      </div>
    </div>
    <style type="text/css">
        #menu-logged{
           padding-top: 5px;
        }

        #menu-logged>li>a {
          background-color: #080808 !important;
          color: #ECF0F1;
        }
    </style>
   
    <!-- Bootstrap -->
    <script src="{{asset('vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{asset('vendor/fastclick/lib/fastclick.js')}}"></script>
    <!-- NProgress -->
    <script src="{{asset('vendor/nprogress/nprogress.js')}}"></script>
    <!-- iCheck -->
    <script src="{{asset('vendor/iCheck/icheck.min.js')}}"></script>
    <script src="{{asset('vendor/ion.rangeSlider/js/ion.rangeSlider.min.js')}}"></script>

    <script src="{{asset('vendor/select2/dist/js/select2.min.js')}}"></script>

    <script src="{{asset('vendor/zoom_assets/jquery.smoothZoom.min.js')}}"></script>


    <script src="{{asset('vendor/moment/moment.js')}}"></script>

    <!-- Custom Theme Scripts -->
	<script src="{{asset('js/cookie.js?v=1')}}"></script>
    <script src="{{asset('js/custom.js')}}"></script>

    @section('page-script')
    @show

    <!-- myJs -->
    <script src="{{asset('js/admin.js')}}"></script>
    <script type="text/javascript">
      $(".select2_single").select2({
          allowClear: false
        });
		$(document).ready(function(){
          $('.btn-logout').on('click', function(){
			   $.removeCookie('AuthUser' , { //bnrReadを削除
				  path:'/' //有効にするパス
			   });
              location.href='{{route('e-kedou.logout')}}';
          });
		});
    </script>
  </body>
</html>