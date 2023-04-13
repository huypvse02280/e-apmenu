@extends('layouts.base')
@section('title', '編集の設定')
@section('page-content')
    <div class="row">
		<div class="col-md-12">
			<div class="panel panel-default panel-content">
				<div class="panel-heading">
					<ul class="list-inline">
						<li><h3>編集の設定</h3></li>
						<li class="pull-right"><h3>{!! html_entity_decode(Html::link(route('admin.pias.config.getView', $config[0]['c_key']),'<i class="fa fa-arrow-left">&nbsp;</i> 戻る',['class' => 'btn btn-default'])) !!}</h3></li>
					</ul>
				</div>
				<div class="panel-body">
					{{ Form::open(['route' => ['admin.pias.config.putEdit',$c_key], 'method' => 'put', 'class' => 'form-horizontal']) }}
						<div class="form-group">
						{!!html_entity_decode(Form::label('c-key','Key <i style="color: red;">*</i>',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::text('c_key',old('c_key', $config[0]['c_key']),['id' => 'c-key', 'class' => 'form-control col-md-7 col-xs-12 has-feedback-left', 'placeholder' => 'ご記入ください。']) }}
	                        	<span class="fa fa-cog form-control-feedback left" aria-hidden="true"></span>
								<span class="error"><?= $errors->first('c_key') ? '('.$errors->first('c_key').')' : ''?></span>
							</div>
						</div>
						<div class="form-group">
						{!!html_entity_decode(Form::label('c-data','Data <i style="color: red;">*</i>',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::text('c_data',old('c_data', $config[0]['c_data']),['id' => 'c-data', 'class' => 'form-control col-md-7 col-xs-12 has-feedback-left', 'placeholder' => 'ご記入ください。']) }}
	                        	<span class="fa fa-database form-control-feedback left" aria-hidden="true"></span>
								<span class="error"><?= $errors->first('c_data') ? '('.$errors->first('c_data').')' : '' ?></span>
							</div>
						</div>
						<div class="form-group">
						{!!html_entity_decode(Form::label('c-help','Help <i style="color: red;">*</i>',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::textarea('c_help',old('c_help', $config[0]['c_help']),['id' => 'c-help', 'class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'ご記入ください。']) }}
								<span class="error"><?= $errors->first('c_help') ? '('.$errors->first('c_help').')' : '' ?></span>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2">
						{!! html_entity_decode(Form::button('<i class="fa fa-save">&nbsp;</i> 更新', ['type' => 'submit', 'class' => 'btn btn-primary'])) !!}
						</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop()