@extends('layouts.base')
@section('title', 'ユーザ情報を変更します')
<?php 
	$userCurrent = \Auth::user();
?>
@section('page-content')
    <div class="row">
		<div class="col-md-12">
			<div class="panel panel-default panel-content">
				<div class="panel-heading">
					<ul class="list-inline">
						<li><h3>ユーザ情報を変更します</h3></li>
						<li class="pull-right"><h3>{!! html_entity_decode(Html::link(route('admin.pias.user.getView', $user[0]['user_id']),'<i class="fa fa-arrow-left">&nbsp;</i> 戻る',['class' => 'btn btn-default '])) !!}</h3></li>
					</ul>
				</div>
				<div class="panel-body">
					<div class="form-horizontal">
					{{ Form::open(['route' => ['admin.pias.user.postEdit', $user[0]['user_id']], 'method' => 'put', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) }}
						<div class="form-group">
							{!!html_entity_decode(Form::label('user-no','No <i style="color: red;">*</i>',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::text('user_no',old('user_id',$user[0]["no"]),['readonly' => true,'id' => 'user-no', 'class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'ご記入ください。']) }}
								<span class="error"><?= $errors->first('user_no') ? '('.$errors->first('user_no').')' : ''?></span>
							</div>
						</div>
						<div class="form-group">
							{!!html_entity_decode(Form::label('user-name','Name <i style="color: red;">*</i>',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::text('username',old('username',$user[0]["username"]),['id' => 'username', 'class' => 'form-control col-md-7 col-xs-12 has-feedback-left', 'placeholder' => 'ご記入ください。']) }}
	                        	<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
								<span class="error"><?= $errors->first('username') ? '('.$errors->first('username').')' : ''?></span>
							</div>
						</div>	
						<div class="form-group">
							{!!html_entity_decode(Form::label('user-level','Level <i style="color: red;">*</i>',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="radio col-md-3 col-sm-3 col-xs-6">
									<label>{{ Form::radio('role_id', 1, $user[0]['role_id'] == 1 ? true : false, ['class' => 'flat', 'disabled' => $user[0]['role_id'] != 1 && $user[0]['user_id'] == $userCurrent['user_id'] ||  $userCurrent['role_id'] != 1 ? true : null]) }} <span>Admin</span></label>
								</div>
								<div class="radio col-md-3 col-sm-3 col-xs-6">
									<label>{{ Form::radio('role_id', 2, $user[0]['role_id'] == 2 ? true : false, ['class' => 'flat', 'disabled' => $user[0]['role_id'] != 2 && $user[0]['user_id'] == $userCurrent['user_id'] ? true : null]) }} <span>Manage</span></label>
								</div>	
								<div class="radio col-md-3 col-sm-3 col-xs-6">
									<label>{{ Form::radio('role_id', 3, $user[0]['role_id'] == 3 ? true : false, ['class' => 'flat', 'disabled' => $user[0]['role_id'] != 3 && $user[0]['user_id'] == $userCurrent['user_id'] ? true : null]) }} <span>Member</span></label>
								</div>
							</div>
						</div>	
						<div class="form-group">
							{!!html_entity_decode(Form::label('user-gender','Gender <i style="color: red;">*</i>',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="radio col-md-3 col-sm-3 col-xs-6">
									<label>{{ Form::radio('gender', 1, $user[0]['gender'] == 1 ? true : false, ['class' => 'flat'])}} <span>男性</span></label>
								</div>
								<div class="radio col-md-3 col-sm-3 col-xs-6">
									<label>{{ Form::radio('gender', 2, $user[0]['gender'] == 2 ? true : false, ['class' => 'flat'])}} <span>女性たち</span></label>
								</div>
							</div>
						</div>	
						<div class="form-group">
							{!!html_entity_decode(Form::label('user-birthday','Birthday',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::text('birthday',old('birthday',$user[0]["birthday"]),['id' => 'user-birthday', 'class' => 'form-control col-md-7 col-xs-12 has-feedback-left', 'placeholder' => 'ご記入ください。']) }}
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
								<span class="error"><?= $errors->first('birthday') ? '('.$errors->first('birthday').')' : ''?></span>
							</div>
						</div>					
						<div class="form-group">
							{!!html_entity_decode(Form::label('user-phone','Phone',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::number('phone',old('phone',$user[0]["phone"]),['id' => 'phone', 'class' => 'form-control col-md-7 col-xs-12 has-feedback-left', 'placeholder' => 'ご記入ください。']) }}
                                <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
								<span class="error"><?= $errors->first('phone') ? '('.$errors->first('phone').')' : ''?></span>
							</div>
						</div>
						<div class="form-group">
							{!!html_entity_decode(Form::label('user-email','Email <i style="color: red;">*</i>',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::text('email',old('email',$user[0]["email"]),['id' => 'email', 'class' => 'form-control col-md-7 col-xs-12 has-feedback-left', 'placeholder' => 'ご記入ください。']) }}
                                <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
								<span class="error"><?= $errors->first('email') ? '('.$errors->first('email').')' : ''?></span>
							</div>
						</div>

						<div class="form-group">
							{!!html_entity_decode(Form::label('user-avatar','Avatar',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								@if(strpos($user[0]["photo_url"], 'http') === 0)
		                            <img src="{{ $user[0]["photo_url"] }}" alt="{{ $user[0]["username"] }}" title="{{ $user[0]["username"] }}" width="150px" height="120px" class="img-thumbnail" />
								@else()
					                <img src="{{ url('upload/user/'.$user[0]["photo_url"]) }}" alt="{{ $user[0]["photo_url"] }}" title="{{ $user[0]["username"] }}" width="150px" height="120px"  class="img-thumbnail" />
								@endif()
								{{ Form::hidden('current_image',$user[0]["photo_url"]) }}
								{{ Form::file('photo_url', ['accept' => 'image/*', 'id' => 'photo-url','class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'ご記入ください。',  'style' => 'margin-top: 5px;padding-bottom: 40px; vertical-align: middle;'])}}
								<span class="error"><?= $errors->first('photo_url') ? '('.$errors->first('photo_url').')' : ''?></span>
							</div>
						</div>
						
						<div class="form-group">
							{!!html_entity_decode(Form::label('company-name','Company Name <i style="color: red;">*</i>',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::select('cp_code', selectBox($company, 'cp_code', 'cp_name'), old('cp_code',$user[0]["cp_code"]),['id' => 'cp_name', 'class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'ご記入ください。']) }}
								<span class="error"><?= $errors->first('cp_code') ? '('.$errors->first('cp_code').')' : ''?></span>
							</div>
						</div>
						<div class="form-group">
							{!!html_entity_decode(Form::label('team-name','Team Name <i style="color: red;">*</i>',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::select('team_id', selectBox($team, 'team_id', 'name'), old('team_id',$user[0]["team_id"]),['id' => 'team_name', 'class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'ご記入ください。']) }}
								<span class="error"><?= $errors->first('team_id') ? '('.$errors->first('team_id').')' : ''?></span>
							</div>
						</div>
						
						<div class="form-group">
							{!!html_entity_decode(Form::label('reserve-1','Reserve 1',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::text('reserve1',old('reserve1',$user[0]["reserve1"]),['id' => 'reserve1', 'class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'ご記入ください。']) }}
							</div>
						</div>
						<div class="form-group">
							{!!html_entity_decode(Form::label('reserve-2','Reserve 2',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::text('reserve2',old('reserve2',$user[0]["reserve2"]),['id' => 'reserve2', 'class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'ご記入ください。']) }}
							</div>
						</div>
						<div class="form-group">
							{!!html_entity_decode(Form::label('reserve-3','Reserve 3',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::text('reserve3',old('reserve3',$user[0]["reserve3"]),['id' => 'reserve3', 'class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'ご記入ください。']) }}
							</div>
						</div>
						
						<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2">
						{!! html_entity_decode(Form::button('<i class="fa fa-save">&nbsp;</i> 更新', ['type' => 'submit', 'class' => 'btn btn-primary'])) !!}
						</div>
					{{ Form::close()}}
					</div><!-- end form-horizontal -->
				</div>
			</div>
		</div>
	</div>
@stop()