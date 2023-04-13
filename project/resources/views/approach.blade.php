@extends('layouts.base')
@section('title', 'トラック・アプローチ')
@section('page-content')
<?php 
  $filterSrv    = new App\Service\FilterService();
  $companySrv   = new App\Service\CompanyService();
  $mapSrv       = new App\Service\MapService();
  $teamSrv      = new App\Service\TeamService();
  $map = $filterSrv->listFloor();
  $user = $filterSrv->listUser();
  $company = $companySrv->companyList();
  $team   = $teamSrv->teamList();
  $loggedUser = Auth::user();
  $mapImages = $mapSrv->listImages();
?>

<div class="">
  <div class="page-title hidden">
    <div class="title_left">
      <h3>Tables <small>Some examples to get you started</small></h3>
    </div>

    <div class="title_right">
      <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search for...">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button">Go!</button>
          </span>
        </div>
      </div>
    </div>
  </div>

  <div class="clearfix"></div>
  <div class="row">
    <div class="col-md-12">
      <div class="x_panel">
          <div class="x_title">
            <h2>ユーザー追跡</h2>
            <ul class="nav navbar-right panel_toolbox" style="min-width: auto;">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="canvas-container">
                <canvas id="map"></canvas>
                <div id="map-cp" class="map-cp">
                    <button onclick="javascript:map.zoomIn()">+</button>
                    <button onclick="javascript:map.zoomOut()">-</button>
                </div>
                <div class="loading"></div>
            </div>
            <h4 class="form-group" style="line-height: 30px;font-size: 20px;">
              <i class="fa fa-fw fa-bars" style="text-align: left;"></i>
              コントロールパネル
            </h4>
            <?php /*
            <div class="row" style="margin-top: 20px;">
                {!! Form::open(['url' => '/filter/locatetime', 'method' => 'get', 'class' =>'', 'name' => 'frm-locateTime']) !!}
                  {!! Form::token() !!}
                  <div class="col-md-8">
                    @if($loggedUser->role_id == 1)
                    <div class="form-group">
                      {!! Form::label('filter-company', '会社') !!}
                      {!! Form::select('floorId', selectBox($company, 'cp_code', 'cp_name'), null, ['id' => 'filter-company', 'class' => 'form-control select2_single','placeholder' => '&nbsp;']) !!}
                    </div>
                    @endif
                    <div class="form-group">
                      {!! Form::label('filter-floor', 'フロア') !!}
                      {!! Form::select('floorId',selectBox($map , 'map_id', 'map_name'), null, ['id' => 'filter-floor', 'class' => 'form-control select2_single']) !!}
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      {!! Form::label('filter-user', 'ユーザー') !!}
                      {!! Form::select('userId', selectBox($user, 'user_id', 'name'), null, ['id' => 'filter-user', 'class' => 'form-control select2_single']) !!}
                    </div>
                    
                    <div class="row">
                      <div class="form-group col-md-6">
                        {!! Form::label('filter-start-time', '始まる時間') !!}
                        {!! Form::text('startTime',null,['id' => 'filter-start-time','class' => 'form-control', 'placeholder' => date('Y-m-d 00:00:00')]) !!}
                      </div>
                      <div class="form-group col-md-6">
                        {!! Form::label('filter-end-time', '終了時間') !!}
                        {!! Form::text('endTime',null, ['id' => 'filter-end-time', 'class' => 'form-control' , 'placeholder' => date('Y-m-d H:i:s')]) !!}
                      </div>
                    </div>
                    
                  </div>
                  <div class="form-group">
                    <label>&nbsp;</label>
                    <div><button id="submit-filter" type="submit" class="btn btn-danger btn-sm pull-right"><i class="fa fa-fw fa-map-marker"></i> 適用します</button></div>
                  </div>
                  {!! Form::close() !!}
            </div>
            */?>
          </div>
        </div>
        
        <div class="x_panel">
          <div class="x_title">
            <h2>フィルタ</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="row" style="margin-top: 20px;">
                  <div class="col-md-8">
                    @if($loggedUser->role_id == 1)
                    <div class="form-group">
                      {!! Form::label('filter-company', '会社') !!}
                      {!! Form::select('floorId', selectBox($company, 'cp_code', 'cp_name'), null, ['id' => 'filter-company', 'class' => 'form-control select2_single','placeholder' => '&nbsp;']) !!}
                    </div>
                    @endif
                    <div class="form-group">
                      {!! Form::label('filter-floor', 'フロア') !!}
                      {!! Form::select('floorId',selectBox($map , 'map_id', 'map_name'), null, ['id' => 'filter-floor', 'class' => 'form-control select2_single']) !!}
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      {!! Form::label('filter-user', 'ユーザー') !!}
                      {!! Form::select('userId', selectBox($user, 'user_id', 'name'), null, ['id' => 'filter-user', 'class' => 'form-control select2_multiple', 'multiple' => 'multiple']) !!}
                    </div>
                    
                    <div class="row">
                      <div class="form-group col-md-6">
                        {!! Form::label('filter-start-time', '開始時間') !!}
                        {!! Form::text('startTime', date("Y/m/d 00:00"),['id' => 'filter-start-time','class' => 'form-control', 'placeholder' => date('Y/m/d 00:00')]) !!}
                      </div>
                      <div class="form-group col-md-6">
                        {!! Form::label('filter-end-time', '終了時間') !!}
                        {!! Form::text('endTime', date("Y/m/d 23:59"), ['id' => 'filter-end-time', 'class' => 'form-control' , 'placeholder' => date('Y/m/d 23:59')]) !!}
                      </div>
                    </div>
                    
                  </div>
                  <div class="form-group">
                    <label>&nbsp;</label>
                    <div style="margin-right: 5px;"><button id="submit-filter" type="submit" class="btn btn-danger btn-sm pull-right"><i class="fa fa-fw fa-map-marker"></i> 適用します</button></div>
                  </div>
                  {!! Form::close() !!}
            </div>
            <div class="x_panel">
	         	<div class="x_title">
	            	<h2>データ</h2>
	            	<div class="clearfix"></div>
	          	</div>
	          	<div class="x_content">
		            <div class="overflow" id="data-table">

		            </div>
		        </div>
	        </div>
            <!--
            <div id="tracking-table">
              {!! Form::label('filter-floor', 'ユーザーリスト') !!}
              <table class="table table-striped table-bordered">
              <thead>
                <tr><th>ユーサーＩＤ</th><th>ユーサー名前</th><th>メール</th><th>会社</th><th>チーム</th><th>識別コード</th><th width="125"><button class="btn btn-block btn-xs btn-primary"><i class="fa fa-fw fa-play-circle"></i>すべてを描く</button></th></tr>
              </thead>
              <tbody>
                
              </tbody>
              </table>
            </div>
            
            <div class="pull-right">
              <button data-toggle="modal" data-target=".bs-example-modal-sm" class="btn btn-primary">ユーザーを追加する</button>
              <button class="btn btn-default">すべてクリア</button>
            </div>
            -->
          
          </div>
        </div>
       

        <div class="modal fade bs-example-modal-sm" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">ユーザーリスト</h4>
              </div>
              <div class="modal-body" style="min-height: 100px">
                <div class="well">
                  <form class="row">
                  @if($loggedUser->role_id == 1)
                    <div class="form-group col-md-4">
                      {!! Form::label('filter-company', '会社') !!}
                      <div>
                      {!! Form::select('companyId', selectBox($company, 'cp_code', 'cp_name'), null, ['id' => 'filter-company', 'class' => 'form-control select2_single','placeholder' => '&nbsp;']) !!}
                      </div>
                    </div>
                  @endif
                  @if($loggedUser->role_id == 1 || $loggedUser->role_id == 2)
                    <div class="form-group col-md-4">
                      {!! Form::label('filter-team', 'チーム') !!}
                      <div>
                      {!! Form::select('teamId', [], null, ['id' => 'filter-team', 'class' => 'form-control select2_single','placeholder' => '&nbsp;', 'disabled' => true]) !!}
                      </div>
                    </div>
                  @endif
                    <div class="form-group col-md-4">
                      {!! Form::label('filter-user-name', 'ユーサー名前') !!}
                      {!! Form::text('username', null, ['id' => 'userName', 'class' => 'form-control', 'placeholder' => 'ご記入ください。']) !!}
                    </div>
                    <button class="pull-right btn btn-default">Search</button>
                  </form>
                </div>
                <div class="overflow" id="user-table"></div>
                <div class="loading"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
@endsection

@section('page-script')
<script type="text/javascript">
    $_GLOBAL['MAP_IMAGES'] = <?=json_encode($mapImages)?>;
</script>
<script src="{{asset('build/js/MainUserApproach.js')}}"></script>
@endsection