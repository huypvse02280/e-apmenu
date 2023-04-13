@extends('layouts.base')
@section('title', '詳細床')
@section('css')
	<!-- CSS photo-gallery-alt-->
	<link href="{{asset('css/photo-gallery-alt/font-awesome.min.css')}}"  rel="stylesheet" />
	<link href="{{asset('css/photo-gallery-alt/photo-gallery-alt.css')}}"  rel="stylesheet" />
@stop()

@section('page-content')
    <div class="row">
		<div class="col-md-12">
			<div class="panel panel-default panel-content">
				<div class="panel-heading">
					<ul class="list-inline">
						<li><h3>詳細床</h3></li>
						<li class="pull-right"><h3>{!! html_entity_decode(Html::link(route('admin.pias.map.getlist'),'<i class="fa fa-arrow-left">&nbsp;</i> 戻る',['class' => 'btn btn-default'])) !!}</h3></li>
					</ul>
				</div>
				<div class="panel-body">
					<div class="form-horizontal">
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">コード</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" readonly="" class="form-control col-md-7 col-xs-12" value="{{$map[0]['map_id']}}" />
							</div>
						</div>
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">マップ名</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" readonly="" class="form-control col-md-7 col-xs-12 has-feedback-left" value="{{$map[0]['map_name']}}" />
								<span class="fa fa-map-marker form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>						
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">高さ</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" readonly="" class="form-control col-md-7 col-xs-12 has-feedback-left" value="{{$map[0]['map_size_heigh']}}" />
								<span class="fa fa-arrows-v form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">幅</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" readonly="" class="form-control col-md-7 col-xs-12 has-feedback-left" value="{{$map[0]['map_size_width']}}" />
								<span class="fa fa-arrows-h form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">長さ</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" readonly="" class="form-control col-md-7 col-xs-12 has-feedback-left" value="{{$map[0]['map_size_length']}}" />
								<span class="fa fa-arrows-h form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">画像</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="block-area">
				                    <div id="photo-gallery-alt">
				                        <div class="gallery-item col-md-4 col-sm-6 col-xs-8">
				                            <a href="{{ url('upload/map/'.$map[0]["image_name"]) }}">
				                            	<img src="{{ url('upload/map/'.$map[0]["image_name"]) }}" width="150" height="150" class="img-thumbnail"  title="{{$map[0]["image_name"]}}" />
				                                <span><i class="fa fa-search"></i></span>
				                            </a>
				                        </div>
				                    </div>
				                </div>
							</div>

						</div>
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">Reserve 1</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" readonly="" class="form-control col-md-7 col-xs-12" value="{{$map[0]['reserve1']}}" />
							</div>
						</div>
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">Reserve 2</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" readonly="" class="form-control col-md-7 col-xs-12" value="{{$map[0]['reserve2']}}" />
							</div>
						</div>
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">Reserve 3</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" readonly="" class="form-control col-md-7 col-xs-12" value="{{$map[0]['reserve3']}}" />
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2">
							{!! html_entity_decode(Html::link(route('admin.pias.map.getEdit', $map[0]->map_id),'<i class="fa fa-pencil">&nbsp;</i> 更新',['class' => 'btn btn-info'])) !!}
							{!! html_entity_decode(Html::link(route('admin.pias.map.getDelete',$map[0]->map_id),'<i class="fa fa-trash-o">&nbsp;</i> 削除', ['class' => 'btn btn-danger', 'onclick' => 'return confirmDelete();'])) !!}
						</div>
					</div><!-- end form-horizontal -->
				</div>
			</div>
		</div>
	</div>
@stop()

@section('page-script')
	<!-- Photo-gallery-alt -->
	<script src="{{asset('js/photo-gallery-alt/simple-inheritance.min.js')}}"></script> <!-- Photo Gallery alt  -->
	<script src="{{asset('js/photo-gallery-alt/code-photoswipe-1.0.11.min.js')}}"></script> <!-- Photo Gallery alt -->
	<script type="text/javascript">
	    document.addEventListener('DOMContentLoaded', function(){
		    Code.photoSwipe('a', '#photo-gallery-alt');
		}, false);
	</script>
@stop()