@extends('layouts.base')
@section('title', 'XMLファイルのアップロード')
@section('page-content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                <ul class="list-inline">
                        <li><h3>XMLファイルのアップロード</h3></li>
                        <li class="pull-right"><h3>{!! html_entity_decode(Html::link(url('/'),'<i class="fa fa-arrow-left">&nbsp;</i> 戻る',['class' => 'btn btn-default'])) !!}</h3></li>
                    </ul>
                </div>
                <div class="panel-body">
                    {{ Form::open(['route' => 'admin.pias.upload.postXml', 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) }}
                    <div class="form-group">
                        {!!html_entity_decode(Form::label('xml-file','File <i style="color: red;">*</i>', ['class' => 'control-label col-md-2 col-sm-3 col-xs-12'])) !!}
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            {{ Form::file('xml_file', ['class' => 'form-control col-md-7 col-xs-12', 'accept' => '.xml, .txt, .csv',  'style' => 'padding-bottom: 40px; vertical-align: middle;']) }}
                            <span class="error"><?= $errors->first('xml_file') ? '('.$errors->first('xml_file').')' : '' ?></span>
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
                    <h2>同期データ <small><i>新しいデータは最後に追加されました  {{date('Y/m/d H:i', strtotime($lastTime->create_time))}}, {{diffForHumansText($agoTime)}}</i></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
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
                                <th class="td-center">開始時刻</th>
                                <th class="td-center">終了時間</th>
                                <th class="td-center">サーバー時間</th>
                                <th class="td-left">ユーザー名</th>
                                <th class="td-left">フロア名</th>
                                <th class="td-left">Mac</th>
                                <th class="td-right">X</th>
                                <th class="td-right">Y</th>
                                <th class="td-left">Eメール</th>
                                <th class="td-right">電話</th>
                                <th class="td-left">会社名</th>
                                <th class="td-center">ウェブサイト</th>
                                <th class="td-right">会社の電話番号</th>
                                <th class="td-left">会社の住所</th>

                            </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        @foreach($synced as $key => $val)
                            <tr>
                                <td>{{$i}}</td>
                                <td class="td-center">{{date('Y/m/d H:i', strtotime($val->first_located_time))}}</td>
                                <td class="td-center">{{date('Y/m/d H:i', strtotime($val->last_located_time))}}</td>
                                <td class="td-center">{{date('Y/m/d H:i', strtotime($val->current_server_time))}}</td>
                                <td class="td-left">{{$val->name}}</td>
                                <td class="td-left">{{$val->map_name}}</td>
                                <td class="td-left">{{$val->mac_address}}</td>
                                <td class="td-right">{{$val->position_x}}</td>
                                <td class="td-right">{{$val->position_y}}</td>
                                <td class="td-left">{{$val->email}}</td>
                                <td class="td-right">{{$val->phone}}</td>
                                <td class="td-left">{{$val->cp_name}}</td>
                                <td class="td-center">{{$val->web}}</td>
                                <td class="td-right">{{$val->tel}}</td>
                                <td class="td-left">{{$val->address}}</td>
                            </tr>
                        <?php $i++; ?>
                        @endforeach()
                        </tbody>
                    </table>
                </div>
                @include('element.pagination', ['results' => $synced, 'object' => 'position'])
            </div>
        </div>
    </div>
    @endif()
@stop()