@extends('layouts.base')
@section('title', 'ユーザー情報')
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
						<li><h3>ユーザー情報</h3></li>
						<li class="pull-right"><h3>{!! html_entity_decode(Html::link(route('admin.pias.user.getList'),'<i class="fa fa-arrow-left">&nbsp;</i> 戻る',['class' => 'btn btn-default'])) !!}</h3></li>
					</ul>
				</div>
				<div class="panel-body">
					<div class="form-horizontal">
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">No</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" readonly="" class="form-control col-md-7 col-xs-12" value="{{$userNo[0]['user_id']}}" />
							</div>
						</div>
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">Name</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" readonly="" class="form-control col-md-7 col-xs-12  has-feedback-left" value="{{$userNo[0]['username']}}" />
	                        	<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>	
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">Level</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" readonly="" class="form-control col-md-7 col-xs-12 has-feedback-left" value="{{$userNo[0]['role_id'] == 1 ? 'Admin' : ($userNo[0]['role_id'] == 2 ? 'Manage' : 'Member')}}" />
                        		<span class="fa fa-star form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>	
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">Gender</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" readonly="" class="form-control col-md-7 col-xs-12" value="{{$userNo[0]['gender'] == 1 ? '男性' : ($userNo[0]['gender'] == 2 ? '女性たち' : '')}}" />
							</div>
						</div>	
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">Birthday</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" readonly="" class="form-control col-md-7 col-xs-12 has-feedback-left" value="{{$userNo[0]['birthday'] ? date('Y/m/d', strtotime($userNo[0]['birthday'])) : ''}}" />
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>					
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">Phone</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" readonly="" class="form-control col-md-7 col-xs-12 has-feedback-left" value="{{$userNo[0]['phone']}}" />
                        		<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">Email</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" readonly="" class="form-control col-md-7 col-xs-12 has-feedback-left" value="{{$userNo[0]['email']}}" />
                        		<span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2 col-sm-3 col-xs-12">Avatar</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="block-area">
					                    <div id="photo-gallery-alt">
					                        <div class="gallery-item col-md-4 col-sm-6 col-xs-8">
											@if(strpos($userNo[0]["photo_url"], 'http') === 0)
					                            <a href="{{$userNo[0]["photo_url"]}}">
					                                <img src="{{ $userNo[0]["photo_url"] }}" alt="{{ $userNo[0]["username"] }}" title="{{ $userNo[0]["username"] }}" class="img-thumbnail" width="150px" height="150px" />
					                                <span><i class="fa fa-search"></i></span>
					                            </a>
											@else()
												 <a href="{{ asset('upload/user/'.$userNo[0]["photo_url"]) }}">
					                                <img src="{{ url('upload/user/'.$userNo[0]["photo_url"]) }}" alt="{{ $userNo[0]["photo_url"] }}" title="{{ $userNo[0]["username"] }}" class="img-thumbnail" width="150px" height="150px" />
					                                <span><i class="fa fa-search"></i></span>
					                            </a>
											@endif()
					                        </div>
					                    </div>
					                </div>
								</div>
						</div>
						
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">Company Name</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" readonly="" class="form-control col-md-7 col-xs-12" value="{{$userNo[0]['cp_name']}}" />
							</div>
						</div>
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">Team Name</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" readonly="" class="form-control col-md-7 col-xs-12" value="{{$userNo[0]['team_name']}}" />
							</div>
						</div>
						
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">Reserve 1</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" readonly="" class="form-control col-md-7 col-xs-12" value="{{$userNo[0]['reserve1']}}" />
							</div>
						</div>
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">Reserve 2</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" readonly="" class="form-control col-md-7 col-xs-12" value="{{$userNo[0]['reserve2']}}" />
							</div>
						</div>
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-3 col-xs-12">Reserve 3</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" readonly="" class="form-control col-md-7 col-xs-12" value="{{$userNo[0]['reserve3']}}" />
							</div>
						</div>
						
						<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2">
							{!! html_entity_decode(Html::link(route('admin.pias.user.getEdit',$userNo[0]['user_id']),'<i class="fa fa-pencil">&nbsp;</i> 更新',['class' => 'btn btn-info'])) !!}
							{!! html_entity_decode(Html::link(route('admin.pias.user.getDelete',$userNo[0]['user_id']),'<i class="fa fa-trash-o">&nbsp;</i> 削除', ['class' => 'btn btn-danger', 'onclick' => 'return confirmDelete();'])) !!}
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