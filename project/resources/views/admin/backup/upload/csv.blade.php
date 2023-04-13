@extends('layouts.base')
@section('title', 'CSVファイルのアップロード')
@section('page-content')
	 <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                <ul class="list-inline">
                        <li><h3>CSVファイルのアップロード</h3></li>
                        <li class="pull-right"><h3>{!! html_entity_decode(Html::link(url('/'),'<i class="fa fa-arrow-left">&nbsp;</i> 戻る',['class' => 'btn btn-default'])) !!}</h3></li>
                    </ul>
                </div>
                <div class="panel-body">
                    {{ Form::open(['route' => 'admin.pias.upload.postCsv', 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) }}
                    <div class="form-group">
                        {!!html_entity_decode(Form::label('csv-file','File <i style="color: red;">*</i>', ['class' => 'control-label col-md-2 col-sm-3 col-xs-12'])) !!}
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            {{ Form::file('csv_file', ['class' => 'form-control col-md-7 col-xs-12', 'accept' => '.csv',  'style' => 'padding-bottom: 40px; vertical-align: middle;']) }}
                            <span class="error"><?= $errors->first('csv_file') ? '('.$errors->first('csv_file').')' : '' ?></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2">
                        {!! html_entity_decode(Form::button('<i class="fa fa-upload">&nbsp;</i> アップロード', ['type' => 'submit','class' => 'btn btn-primary'])) !!}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    @if(!is_empty($synced))
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>同期データ <small><i>新しいデータは最後に追加されました  {{date('Y/m/d H:i', strtotime($lastTime->created_at))}}, {{diffForHumansText($agoTime)}}</i></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                <div class="clearfix"></div>
                </div>
                <div class="x_content overflow">
                    <table class="table table-striped" id="table-synced">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Level</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Gender</th>
                                <th>Birthday</th>
                                <th>Company Name</th>
                                <th>Company Website</th>
                                <th>Company Tel</th>
                                <th>Company Address</th>
                                <th>Team Name</th>

                            </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        @foreach($synced as $key => $val)
                            <tr>
                                <td>{{$i}}</td>
                                <td class="td-right">{{$val->no}}</td>
                                <td class="td-left">{{$val->name}}</td>
                                <td class="td-left">{{isset($val->use_classify) && $val->use_classify == 1 ? 'Admin' : (isset($val->use_classify) && $val->use_classify == 2 ? 'Manage' : 'Member')}}</td>
                                <td class="td-left">{{$val->email}}</td>
                                <td class="td-right">{{$val->phone}}</td>
                                <td class="td-left">{{isset($val->gender) && $val->gender == 1 ? '男性' : '女性たち'}}</td>
                                <td class="td-center">{{!is_empty($val->birthday) ? date('Y/m/d', strtotime($val->birthday)) : null}}</td>
                                <td class="td-left">{{$val->companyName}}</td>
                                
                                <td class="td-left">{{$val->companyWeb}}</td>
                                <td class="td-right">{{$val->companyTel}}</td>
                                <td class="td-left">{{$val->companyAddress}}</td>
                                <td class="td-left">{{$val->teamName}}</td>
                            </tr>
                        <?php $i++; ?>
                        @endforeach()
                        </tbody>
                    </table>
                </div>
                @include('element.pagination', ['results' => $synced, 'object' => 'user']) 
            </div>
        </div>
    </div>
    @endif()
@stop()