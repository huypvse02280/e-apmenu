@extends('layouts.base')
@section('title', '新しいユーザーを追加')
<?php 
	$userCurrent = \Auth::user();
?>
@section('page-content')
    <div class="row">
		<div class="col-md-12">
			<div class="panel panel-default panel-content">
				<div class="panel-heading">
					<ul class="list-inline">
						<li><h3>新しいユーザーを追加</h3></li>
						<li class="pull-right"><h3>{!! html_entity_decode(Html::link(route('admin.pias.user.getList'),'<i class="fa fa-arrow-left">&nbsp;</i> 戻る',['class' => 'btn btn-default'])) !!}</h3></li>
					</ul>
				</div>
				<div class="panel-body">
					<div class="form-horizontal">
					{{ Form::open(['route' => 'admin.pias.user.postAdd', 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) }}
						<div class="form-group">
							{!!html_entity_decode(Form::label('user-name','Name <i style="color: red;">*</i>',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::text('username', null,['id' => 'username', 'class' => 'form-control col-md-7 col-xs-12  has-feedback-left', 'placeholder' => 'ご記入ください。']) }}
	                        	<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
								<span class="error"><?= $errors->first('username') ? '('.$errors->first('username').')' : ''?></span>
							</div>
						</div>	
						
						<div class="form-group">
							{!!html_entity_decode(Form::label('user-level','Level <i style="color: red;">*</i>',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="radio col-md-3 col-sm-3 col-xs-6">
									<label>{{ Form::radio('role_id', 1, null, ['class' => 'flat', 'disabled' => $userCurrent['role_id'] == 1 ? null : true]) }} <span>Admin</span></label>
								</div>
								<div class="radio col-md-3 col-sm-3 col-xs-6">
									<label>{{ Form::radio('role_id', 2, null, ['class' => 'flat']) }} <span>Manage</span></label>
								</div>	
								<div class="radio col-md-3 col-sm-3 col-xs-6">
									<label>{{ Form::radio('role_id', 3, true, ['class' => 'flat']) }} <span>Member</span></label>
								</div>
							</div>
						</div>	

						<div class="form-group">
							{!!html_entity_decode(Form::label('user-gender','Gender <i style="color: red;">*</i>',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="radio col-md-3 col-sm-3 col-xs-6">
									<label>{{ Form::radio('gender', 1, null, ['class' => 'flat'])}} <span>男性</span></label>
								</div>
								<div class="radio col-md-3 col-sm-3 col-xs-6">
									<label>{{ Form::radio('gender', 2, true, ['class' => 'flat'])}} <span>女性たち</span></label>
								</div>
							</div>
						</div>	

						<div class="form-group">
							{!!html_entity_decode(Form::label('user-birthday','Birthday',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::text('birthday', null,['id' => 'user-birthday', 'class' => 'form-control col-md-7 col-xs-12 has-feedback-left', 'placeholder' => 'ご記入ください。']) }}
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
								<span class="error"><?= $errors->first('birthday') ? '('.$errors->first('birthday').')' : ''?></span>
							</div>
						</div>

						<div class="form-group">
							{!!html_entity_decode(Form::label('user-phone','Phone',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::number('phone', null,['id' => 'phone', 'min' => 0,'class' => 'form-control col-md-7 col-xs-12 has-feedback-left', 'placeholder' => 'ご記入ください。']) }}
                        		<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
								<span class="error"><?= $errors->first('phone') ? '('.$errors->first('phone').')' : ''?></span>
							</div>
						</div>

						<div class="form-group">
							{!!html_entity_decode(Form::label('user-email','Email <i style="color: red;">*</i>',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::text('email', null,['id' => 'email', 'class' => 'form-control col-md-7 col-xs-12 has-feedback-left', 'placeholder' => 'ご記入ください。']) }}
								<span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
								<span class="error"><?= $errors->first('email') ? '('.$errors->first('email').')' : ''?></span>
							</div>
						</div>

						<div class="form-group">
							{!!html_entity_decode(Form::label('user-avatar','Avatar',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::file('photo_url', ['accept' => 'image/*', 'id' => 'photo-url','class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'ご記入ください。',  'style' => 'margin-top: 5px;padding-bottom: 40px; vertical-align: middle;'])}}
								<span class="error"><?= $errors->first('photo_url') ? '('.$errors->first('photo_url').')' : ''?></span>
							</div>
						</div>
						
						<div class="form-group">
							{!!html_entity_decode(Form::label('company-name','Company Name <i style="color: red;">*</i>',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::select('cp_code', selectBox($company, 'cp_code', 'cp_name'), null,['id' => 'company-name', 'class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'ご記入ください。']) }}
								<span class="error"><?= $errors->first('cp_code') ? '('.$errors->first('cp_code').')' : ''?></span>
							</div>
						</div>

						<div class="form-group">
							{!!html_entity_decode(Form::label('team-name','Team Name <i style="color: red;">*</i>',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::select('team_id', selectBox($team, 'team_id', 'name'), null,['id' => 'team_name', 'class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'ご記入ください。']) }}
								<span class="error"><?= $errors->first('team_id') ? '('.$errors->first('team_id').')' : ''?></span>
							</div>
						</div>
						
						<div class="form-group">
							{!!html_entity_decode(Form::label('reserve-1','Reserve 1',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::text('reserve1', null,['id' => 'reserve1', 'class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'ご記入ください。']) }}
							</div>
						</div>
						<div class="form-group">
							{!!html_entity_decode(Form::label('reserve-2','Reserve 2',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::text('reserve2', null,['id' => 'reserve2', 'class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'ご記入ください。']) }}
							</div>
						</div>
						<div class="form-group">
							{!!html_entity_decode(Form::label('reserve-3','Reserve 3',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::text('reserve3', null,['id' => 'reserve3', 'class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'ご記入ください。']) }}
							</div>
						</div>
						
						<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2">
						{!! html_entity_decode(Form::button('<i class="fa fa-save">&nbsp;</i> 追加', ['type' => 'submit', 'class' => 'btn btn-primary'])) !!}
						</div>
					{{ Form::close()}}
					</div><!-- end form-horizontal -->
				</div>
			</div>
		</div>
	</div>
@stop()