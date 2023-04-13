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

    <title>おもてなしメニュー</title>

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
	<!-- Jquery -->
    <script src="{{asset('vendor/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>
	<script type="text/javascript">
		
		
		function doRedirectOnLoad(){
			
			window.location.href="{{$urlinfo['url']}}";
			}
			
			
		$(document).ready(function(){
		
			@if($menu->blank_type!=1)
					
				@if($menu->app_id ==3)
					
					
				window.location.href="{{$menu->login_api}}?param.user.email={{ $user->email }}&param.imageUrl={{$user->photo_url}}";
				/*
								$.ajax({
									url:"{{$menu->login_api}}",
									
									method:"get",
									data:{"param.user.email": "{{ $user->email }}",
											"param.tokenAccess": "{{$user->access_token}}",
											"param.imageUrl":"{{$user->photo_url}}",
										},
									dataType:'json',
									success: function(result){
										if(result.success==true){
											doRedirectOnLoad();
												
											}else{
											window.location.href="{{url('/')}}";
										}
									},
									error: function (e){
											window.location.href="{{url('/')}}";
											
										}
								});
								*/
							
				@elseif($menu->app_id ==1)
                    @if(isset($urlinfo['accesskey_partime']))
                      window.location.href="{{$menu->login_api}}?userEmail={{ $user->email }}&accesskey_partime={{ $urlinfo['accesskey_partime'] }}&img_url={{$user->photo_url}}";
                    @else
                      window.location.href="{{$menu->login_api}}?userEmail={{ $user->email }}&accessToken={{$user->access_token}}&img_url={{$user->photo_url}}";
                    @endif
				@elseif($menu->app_id ==2)
					window.location.href="{{$menu->login_api}}?param.email={{ $user->email }}&access_token={{$user->access_token}}&imgUrl={{$user->photo_url}}";	
				@else
					doRedirectOnLoad();
				/*$.ajax({
							url:"{{$menu->login_api}}",
							
							method:"get",
							data:{"accesskey": "{{ $urlinfo['accesskey'] }}"},
							dataType:'json',
							success: function(result){
								if(result.success==true){
									
										
									}else{
									window.location.href="{{url('/')}}";
								}
							},
							error: function (e){
									window.location.href="{{url('/')}}";
									
								}
						});*/
				@endif
				
			@else
				doRedirectOnLoad();
			@endif
		
		
			
		
		});
	</script>
  </head>

  <body class="page-body login-page" data-url="">
     
      <img style="position:fixed;top:50%;left:50%;margin-left:-50px;margin-top:-50px;" src="{{url("images/loading.gif")}}" />
	  

   </body>
</html>