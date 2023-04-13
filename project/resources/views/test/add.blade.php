@extends('master')
@section('module','Add Test')
@section('title','Xin chào Add ')
@section('content')
	<div class="alert alert-info">
		<h5>Đây là trang Add Test</h5>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div>
			@if(count($errors) > 0)
			<div class="alert alert-danger">
				<ul>
					@foreach($errors->all() as $error)
						<li>{!! $error !!}</li>
					@endforeach
				</ul>
			</div>
			@endif
			</div>
			<form class="form-horizontal" method="POST" action="{!! route('app.test.postAdd') !!}">
				<input type="hidden" name="_token" value="{!! csrf_token() !!}">
				<div class="form-group">
					<div class="control-label col-xs-2">Name :</div>
					<div class="col-xs-10">
						<input type="text" name="name" value="{!! old('name') !!}" class="form-control" placeholder="Nhập tên vào đây">
					</div>
				</div>
				<div class="form-group">
					<div class="control-label col-xs-2">Địa chỉ :</div>
					<div class="col-xs-10">
						<input type="text" name="address" class="form-control" placeholder="Tai khoan cua ban" value="{!! old('address') !!}">
					</div>
				</div>
				<div class="col-xs-offset-2 col-xs-10">
					<button type="submit" class="btn btn-success">Lưu</button>
				</div>
			</form>
		</div>
	</div>
	<div class="row">
		<div><a href="{!! url('/testXml') !!}">Trang Test Xml</a></div>
		<div class="pull-right"><a href="{!! route('app.test')!!}">Trang Test</a></div>
	</div>
	
@stop()