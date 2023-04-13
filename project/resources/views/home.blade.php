@extends('layouts.base')
@section('title', '一般的な')
<style type="text/css">
	.link-site .flip-container img {
    background-color: #fff;
    
    height: auto; 
    padding-left: 3px; 
	}
</style>
@section('page-content')
<?php 
		$cuser=Auth::user();
	
	 $accesskey =encode_token2(env('LOGIN_SECRET_KEY'),$cuser->user_id,env('LOGIN_PUBLIC_KEY'),$cuser->access_token);
?>
<script type="text/javascript">
	var delayed=100;
	</script>
<div class="row">
	<div class="col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2 col-xs-12">
        <ul class="list-unstyled link-site">
		
			@foreach($menu as $k => $v)
				@if($userLatest->getUserReserves()[$v->position-1] == 1)
					<li id="m{{$v->app_id}}">
						@if($v->app_id == 7 || $v->app_id == 4)
							<a href="{{$v->app_url}}">
						@else
							<a href="{{url("/")}}/goto/{{$v->app_id}}">
						@endif
							<span class="link-site-item">@if($v->icon_url!='')<img src="{{$v->icon_url}}"/> @endif {{$v->app_name}}
								<span style="font-size:15px;color:orange">
									@if($v->app_id==2)
										（未読 :{{$unreadEmsg}}件）
									@elseif($v->app_id == 3)
										（未読 :{{$unreadKeiji}}件）
									@elseif($v->app_id == 1)
										(未読合計：{{$unreadEmsg+$unreadKeiji}}件)
									@endif
								</span>
							</span>
						</a>
					</li>
				@endif
			 @endforeach
		</ul>
	</div>
</div>

@endsection
