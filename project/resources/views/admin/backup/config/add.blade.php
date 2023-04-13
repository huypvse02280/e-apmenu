@extends('layouts.base')
@section('title', '新しいセットを追加')
@section('page-content')
    <div class="row">
		<div class="col-md-12">
			<div class="panel panel-default panel-content">
				<div class="panel-heading">
					<ul class="list-inline">
						<li><h3>新しいセットを追加</h3></li>
						<li class="pull-right"><h3>{!! html_entity_decode(Html::link(route('admin.pias.config.getList'),'<i class="fa fa-arrow-left">&nbsp;</i> 戻る',['class' => 'btn btn-default'])) !!}</h3></li>
					</ul>				
				</div>
				<div class="panel-body">
					{{ Form::open(['route' => 'admin.pias.config.postAdd', 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) }}
						<div class="form-group">
								{{ Form::label('c-key','Key *',['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) }}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::text('c_key',null,['id' => 'c-key', 'class' => 'form-control col-md-7 col-xs-12 has-feedback-left', 'placeholder' => 'ご記入ください。']) }}
	                        	<span class="fa fa-cog form-control-feedback left" aria-hidden="true"></span>
								<span class="error"><?= $errors->first('c_key') ? '('.$errors->first('c_key').')' : ''?></span>
							</div>
						</div>
						<div class="form-group">
								{{ Form::label('c-data','Data *',['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) }}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::text('c_data',null,['id' => 'c-data', 'class' => 'form-control col-md-7 col-xs-12 has-feedback-left', 'placeholder' => 'ご記入ください。']) }}
	                        	<span class="fa fa-database form-control-feedback left" aria-hidden="true"></span>
								<span class="error"><?= $errors->first('c_data') ? '('.$errors->first('c_data').')' : '' ?></span>
							</div>
						</div>
						<div class="form-group">
								{{ Form::label('c-help','Help *',['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) }}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::textarea('c_help',null,['id' => 'c-help', 'class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'ご記入ください。']) }}
								<span class="error"><?= $errors->first('c_help') ? '('.$errors->first('c_help').')' : '' ?></span>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
						{!! html_entity_decode(Form::button('<i class="fa fa-save">&nbsp;</i> 追加', ['type' => 'submit', 'class' => 'btn btn-primary'])) !!}
						</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop()