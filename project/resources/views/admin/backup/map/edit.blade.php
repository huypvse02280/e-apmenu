@extends('layouts.base')
@section('title', '編集情報床')
@section('page-content')
    <div class="row">
		<div class="col-md-12">
			<div class="panel panel-default panel-content">
				<div class="panel-heading">
					<ul class="list-inline">
						<li><h3>編集情報床</h3></li>
						<li class="pull-right"><h3>{!! html_entity_decode(Html::link(route('admin.pias.map.getView', $map[0]["map_id"]),'<i class="fa fa-arrow-left">&nbsp;</i> 戻る',['class' => 'btn btn-default'])) !!}</h3></li>
					</ul>
				</div>
				<div class="panel-body">
					{{ Form::open(['url' => ['admin/map/edit', $map[0]["map_id"]], 'method' => 'put', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) }}
						<div class="form-group">
							{!!html_entity_decode(Form::label('map-id','コード <i style="color: red;">*</i>',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::text('map_id',old('map_id',$map[0]["map_id"]),['readonly' => true,'id' => 'map-id', 'class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'ご記入ください。']) }}
								<span class="error"><?= $errors->first('map_id') ? '('.$errors->first('map_id').')' : ''?></span>
							</div>
						</div>
						<div class="form-group">
							{!!html_entity_decode(Form::label('map-name','氏名 <i style="color: red;">*</i>',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::text('map_name',old('map_name',$map[0]["map_name"]),['id' => 'map-name', 'class' => 'form-control col-md-7 col-xs-12 has-feedback-left', 'placeholder' => 'ご記入ください。']) }}
								<span class="fa fa-map-marker form-control-feedback left" aria-hidden="true"></span>
								<span class="error"><?= $errors->first('map_name') ? '('.$errors->first('map_name').')' : '' ?></span>
							</div>
						</div>
						<div class="form-group">
							{!!html_entity_decode(Form::label('map-height','高さ <i style="color: red;">*</i>',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::number('map_size_heigh',old('map_size_height',$map[0]["map_size_heigh"]),['step' => '0.00001', 'min' => 0, 'id' => 'map-size-height', 'class' => 'form-control col-md-7 col-xs-12 has-feedback-left', 'placeholder' => 'ご記入ください。']) }}
								<span class="fa fa-arrows-v form-control-feedback left" aria-hidden="true"></span>
								<span class="error"><?= $errors->first('map_size_heigh') ? '('.$errors->first('map_size_heigh').')' : '' ?></span>
							</div>
						</div>
						<div class="form-group">
							{!!html_entity_decode(Form::label('map-width','幅 <i style="color: red;">*</i>',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::number('map_size_width',old('map_size_width',$map[0]["map_size_width"]),['step' => '0.001', 'min' => 0, 'id' => 'map-size-width', 'class' => 'form-control col-md-7 col-xs-12 has-feedback-left', 'placeholder' => 'ご記入ください。']) }}
								<span class="fa fa-arrows-h form-control-feedback left" aria-hidden="true"></span>
								<span class="error"><?= $errors->first('map_size_width') ? '('.$errors->first('map_size_width').')' : '' ?></span>
							</div>
						</div>
						<div class="form-group">
							{!!html_entity_decode(Form::label('map-length','長さ <i style="color: red;">*</i>',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::number('map_size_length',old('map_size_length',$map[0]["map_size_length"]),['step' => '0.00001','min' => 0,'id' => 'map-size-length', 'class' => 'form-control col-md-7 col-xs-12 has-feedback-left', 'placeholder' => 'ご記入ください。']) }}
								<span class="fa fa-arrows-h form-control-feedback left" aria-hidden="true"></span>
								<span class="error"><?= $errors->first('map_size_length') ? '('.$errors->first('map_size_length').')' : '' ?></span>
							</div>
						</div>
						<div class="form-group">
							{!!html_entity_decode(Form::label('image-name','画像 <i style="color: red;">*</i>',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']))!!}
							<div class="col-md-6 col-sm-6 col-xs-12">
								<img title="{{$map[0]["image_name"]}}" src="{{ url('upload/map/'.$map[0]["image_name"]) }}" width="150" height="150" class="img-thumbnail" />
								{{ Form::hidden('current_image',$map[0]["image_name"]) }}
								{{ Form::file('image_name',null,['id' => 'image-name', 'class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'ご記入ください。']) }}
								<span class="error"><?= $errors->first('image_name') ? '('.$errors->first('image_name').')' : '' ?></span>
							</div>
						</div>
						<div class="form-group">
								{{ Form::label('reserve-1','Reserve_1',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']) }}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::text('reserve_1',old('reserve_1',$map[0]["reserve1"]),['id' => 'reserve-1', 'class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'ご記入ください。']) }}
							</div>
						</div>
						<div class="form-group">
								{{ Form::label('reserve-2','Reserve_2',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']) }}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::text('reserve_2',old('reserve_2',$map[0]["reserve2"]),['id' => 'reserve-2', 'class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'ご記入ください。']) }}
							</div>
						</div>
						<div class="form-group">
								{{ Form::label('reserve-3','Reserve_3',['class' => 'control-label col-md-2 col-sm-3 col-xs-12']) }}
							<div class="col-md-6 col-sm-6 col-xs-12">
								{{ Form::text('reserve_3',old('reserve_3',$map[0]["reserve3"]),['id' => 'reserve-3', 'class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'ご記入ください。']) }}
							</div>
						</div>
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
