<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Laravel 5.3</title>
	<link rel="stylesheet" type="text/css" href="{!! url('public/bootstrap/css/bootstrap.min.css') !!}">
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<ul class="list-unstyled">
					<li class=""><a href="">Trang chủ</a></li>
					<li class=""><a href="">Tòa nhà</a>
						<ul>
							<li><a href="">A</a></li>
							<li><a href="">B</a></li>
							<li><a href="">C</a></li>
						</ul>
					</li>
					<li class=""><a href="">User</a></li>
					<li class=""><a href="">Contact</a></li>

				</ul>
			</div>
			<div class="col-md-9">
				<h3>@yield('module')</h3>
				<h4>@yield('title')</h4>
				<div class="col-md-12">
					@yield('content')
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="{!! asset('public/bootstrap/js/bootstrap.min.js') !!}"></script>
</body>
</html>