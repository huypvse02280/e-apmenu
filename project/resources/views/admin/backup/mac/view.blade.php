@extends('layouts.base')
@section('title', '詳細なデバイス情報')
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
						<li><h3>詳細なデバイス情報</h3></li>
						<li class="pull-right"><h3>{!! html_entity_decode(Html::link(route('admin.pias.mac.getList'),'<i class="fa fa-arrow-left">&nbsp;</i> 戻る',['class' => 'btn btn-default'])) !!}</h3></li>
					</ul>
				</div>
				<div class="panel-body">
					<div class="form-horizontal">
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">Mac</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" readonly="" class="form-control col-md-7 col-xs-12 has-feedback-left" value="{{$mac[0]['mac_address']}}" />
								<span class="fa fa-mobile-phone form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">ユーザー名</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" readonly="" class="form-control col-md-7 col-xs-12 has-feedback-left" value="{{$mac[0]['name']}}" />
								<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>						
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">Eメール</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" readonly="" class="form-control col-md-7 col-xs-12 has-feedback-left" value="{{$mac[0]['email']}}" />
								<span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">電話</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" readonly="" class="form-control col-md-7 col-xs-12 has-feedback-left" value="{{$mac[0]['phone']}}" />
								<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">ランク</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" readonly="" class="form-control col-md-7 col-xs-12 has-feedback-left" value="{{isset($mac[0]['use_classify']) && $mac[0]['use_classify'] == 1 ? 'Admin' : (isset($mac[0]['use_classify']) && $mac[0]['use_classify'] == 2 ? 'Manage' : 'Member')}}" />
								<span class="fa fa-star form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
					
						<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2">
							{!! html_entity_decode(Html::link(route('admin.pias.mac.getEdit', $mac[0]->mac_address),'<i class="fa fa-pencil">&nbsp;</i> 更新',['class' => 'btn btn-info'])) !!}
							{!! html_entity_decode(Html::link(route('admin.pias.mac.getDelete',$mac[0]->mac_address),'<i class="fa fa-trash-o">&nbsp;</i> 削除', ['class' => 'btn btn-danger', 'onclick' => 'return confirmDelete();'])) !!}
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