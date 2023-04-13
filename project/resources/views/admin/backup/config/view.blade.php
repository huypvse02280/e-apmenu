@extends('layouts.base')
@section('title', '詳細セット')
@section('page-content')
    <div class="row">
		<div class="col-md-12">
			<div class="panel panel-default panel-content">
				<div class="panel-heading">
					<ul class="list-inline">
						<li><h3>詳細セット</h3></li>
						<li class="pull-right"><h3>{!! html_entity_decode(Html::link(route('admin.pias.config.getList'),'<i class="fa fa-arrow-left">&nbsp;</i> 戻る',['class' => 'btn btn-default'])) !!}</h3></li>
					</ul>
				</div>
				<div class="panel-body">
					<div class="form-horizontal">
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">C-Key</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" readonly="" class="form-control col-md-7 col-xs-12 has-feedback-left" value="{{$config[0]['c_key']}}" />
	                        	<span class="fa fa-cog form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">C-Data</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" readonly="" class="form-control col-md-7 col-xs-12 has-feedback-left" value="{{$config[0]['c_data']}}" />
	                        	<span class="fa fa-database form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">C-Help</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<textarea class="form-control col-md-7 col-xs-12" readonly="">{{ $config[0]['c_help'] }}</textarea>
							</div>
						</div>
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">Created</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" readonly="" class="form-control col-md-7 col-xs-12" value="{{date('d/m/Y H:i:s',strtotime($config[0]['created_at']))}}" />
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2">
							{!! html_entity_decode(Html::link(route('admin.pias.config.getEdit',$config[0]->c_key),'<i class="fa fa-pencil">&nbsp;</i> 更新',['class' => 'btn btn-info'])) !!}
							{!! html_entity_decode(Html::link(route('admin.pias.config.getDelete',$config[0]->c_key),'<i class="fa fa-trash-o">&nbsp;</i> 削除', ['class' => 'btn btn-danger', 'onclick' => 'return confirmDelete();'])) !!}
						</div>
					</div><!-- form-horizontal -->					
				</div>
			</div>
		</div>
	</div>
@stop()