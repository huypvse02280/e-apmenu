@extends('layouts.base')
@section('title', 'ユーザー一覧')
@section('page-content')
	 <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default panel-content">
                <div class="panel-heading">
                    <ul class="list-inline">
                            <li> <h3>ユーザー一覧</h3></li>
                    </ul>
                </div>
                <div class="panel-body">
                   <div class="row">
                        {{ Form::open(['route' => 'e-kedou.logview','method' => 'get', 'class' => 'frm-filter']) }}
                        {{ Form::hidden('limit', isset($_GET['limit']) ? $_GET['limit'] : null)}}
                       
						
						<div class="form-group col-md-3 col-sm-6">
							{{ Form::label('name', 'User name') }}
							<input type="text" name="name" value="@if(isset($searchParams['name'])) {{$searchParams['name']}} @endif"  class="form-control" placeholder="Username"/>
						</div>
						<div class="form-group col-md-3  col-sm-6">
							{{ Form::label('app_id', 'App name') }}
							<select name="app" class="form-control">
								<option value="">All</option>
								
								
								<?php 
									foreach($menu as $m){
										?>
											<option value="<?=$m->app_id?>" <?php if(isset($_GET['app']) && $m->app_id==intval($_GET['app'])){echo "selected";}?> > <?=$m->app_name?></option>
							
										<?php
									}
								?>
								
							</select>
						</div>
					   
                      
						<div class="form-group col-md-3  col-sm-6">
                        {!! Form::label('startDate', '開始時間') !!}
                        {!! Form::text('startDate', date("Y/m/d H:i:s",strtotime('-7 days', time())), ['id' => 'startDate','class' => 'form-control', 'placeholder' => date('Y/m/d H:i:s',strtotime('-7 days', time()))]) !!}
                      </div>
                      <div class="form-group col-md-3  col-sm-6">
                        {!! Form::label('endDate', '終了時間') !!}
                        {!! Form::text('endDate', date("Y/m/d H:i:s"), ['id' => 'endDate', 'class' => 'form-control' , 'placeholder' => date('Y/m/d H:i:s')]) !!}
                      </div>
                       

                        <div class="form-group pull-right">
                            {!! html_entity_decode(Form::button('<i class="fa fa-search">&nbsp;</i> 検索', ['type' => 'submit','class' => 'btn btn-success input-submit'])) !!}
                            <a href="javascript:void(0)" class="btn btn-default input-clear input-submit" style="margin-right:10px;"><i class="fa fa-remove">&nbsp;</i>浄化</a>
                       
                        </div>
                        {{ Form::close() }}
                    </div> 
                    
                    <div class="overflow"">
                        <table class="table table-striped " id="table-mapp">
                            <thead>
                                <tr>
                                    <th>No</th>
                                  
                                    <th class="td-left">User</th>
									<th class="td-left">Email</th>
                                    <th class="td-left">App</th>
                                    
                                    <th class="td-left">Time</th>
                                   
                                </tr>
                            </thead>
							<?php $no=1;?>
							
                            <tbody>
								@foreach($listlog as $log)
									<tr>
										<td>{{$no++}}</td>
										<td>{{$log->name}}</td>	
										<td>{{$log->user_email}}</td>
										<td>{{$log->app_name}}</td>
										<td>{{$log->log_time}}</td>
									</tr>
								@endforeach
                            
                            </tbody>
                        </table>
                    </div>
                    @include('element.pagination',['results' => $listlog])
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
		$('#startDate').datetimepicker({
		format:'Y/m/d H:i:s',
		onShow:function( ct ){
			this.setOptions({
				maxDate: $('#startDate').val() ? $('#endDate').val() : false, formatDate:'Y/m/d H:is'
			})
		},
		timepicker:true,
	});

	$('#endDate').datetimepicker({
		format:'Y/m/d H:i:s',
		onShow:function( ct ){
			this.setOptions({
				minDate: $('#startDate').val() ? $('#startDate').val() : false, formatDate:'Y/m/d H:is'
			})
		},
		timepicker:true,
	});
</script>
@stop()