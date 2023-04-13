
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>利用者認証アプリ等起動システム</title>
		
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
				
				window.location.href="/login";
			}
			
			
			$(document).ready(function(){
			
				$.get('http://noto-nigiwai.com:8080/e-msg/logout');
				$.get('http://noto-nigiwai.com:8080/e-keijiban/logout');
			
			doRedirectOnLoad();
			});
		</script>
	</head>
	
	<body class="page-body login-page" data-url="">
		
		<img style="position:fixed;top:50%;left:50%;margin-left:-50px;margin-top:-50px;" src="{{url("images/loading.gif")}}" />
		
		
	</body>
</html>	