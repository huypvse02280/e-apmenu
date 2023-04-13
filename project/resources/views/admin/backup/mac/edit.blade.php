@extends('layouts.base')
@section('title', '情報編集機器')
<style type="text/css">
	.select2-selection__rendered,
	.select2
	{width: 504px !important;}
</style>
@section('page-content')
    <div class="row">
		<div class="col-md-12">
			<div class="panel panel-default panel-content">
				<div class="panel-heading">
					<ul class="list-inline">
						<li><h3>情報編集機器</h3></li>
						<li class="pull-right"><h3>{!! html_entity_decode(Html::link(route('admin.pias.mac.getView', $mac[0]["mac_address"]),'<i class="fa fa-arrow-left">&nbsp;</i> 戻る',['class' => 'btn btn-default'])) !!}</h3></li>
					</ul>
				</div>
				<div class="panel-body">
					{{ Form::open(['route' => ['admin.pias.mac.putEdit', $mac[0]["mac_address"]], 'method' => 'put', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) }}
						<div class="form-group">
							{!!html_entity_decode(Form::label('mac-address','Mac <i style="color: red;">*</i>',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::text('mac_address',old('mac_address', $mac[0]["mac_address"]),['readonly' => true,'id' => 'mac-address', 'class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'ご記入ください。']) }}
								<span class="error"><?= $errors->first('mac_address') ? '('.$errors->first('mac_address').')' : ''?></span>
							</div>
						</div>
						
						<div class="form-group">
							{!!html_entity_decode(Form::label('map-name','ユーザー名',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::select('user_no', selectBox($userSelect, 'user_id', 'name'), old('user_no',$mac[0]["user_no"]),['id' => 'mac-user-no', 'class' => 'select2_single form-control col-md-7 col-xs-12', 'placeholder' => 'ご記入ください。']) }}
								<span class="error"><?= $errors->first('user_no') ? '('.$errors->first('user_no').')' : '' ?></span>
							</div>
						</div>
						<?php /*
						<div class="form-group">
							{!!html_entity_decode(Form::label('mac-persion','Registered Persion',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::text('mac_persion',old('mac_persion', $mac[0]["registered_persion"]),['id' => 'mac-persion', 'class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'ご記入ください。']) }}
								<span class="error"><?= $errors->first('mac_persion') ? '('.$errors->first('mac_persion').')' : ''?></span>
							</div>
						</div>
						*/?>
						<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2">
						{!! html_entity_decode(Html::link(redirect()->back()->getTargetUrl(),'<i class="fa fa-remove">&nbsp;</i> 取消',['class' => 'btn btn-danger'])) !!}
						{!! html_entity_decode(Form::button('<i class="fa fa-save">&nbsp;</i> 更新', ['type' => 'submit', 'class' => 'btn btn-primary'])) !!}
						</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop()
