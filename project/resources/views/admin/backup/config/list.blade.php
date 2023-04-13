@extends('layouts.base')
@section('title', '構成リスト')
@section('page-content')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default panel-content">
                <div class="panel-heading">
                    <ul class="list-inline">
                        <li><h3>構成リスト</h3></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="row">
                        {{ Form::open(['route' => 'admin.pias.config.getList','method' => 'get', 'class' => 'frm-filter']) }}
                        {{ Form::hidden('limit', isset($_GET['limit']) ? $_GET['limit'] : null)}}
                        <div class="form-group col-md-3">
                            {{ Form::label('c-key', 'c_key') }}
                            {{ Form::text('c_key', $searchParams['c_key'], ['class' => 'form-control input-text', 'placeholder' => 'フロアの名前を入力し'])}}   
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('c-data', 'c_data') }}
                            {{ Form::text('c_data', $searchParams['c_data'], ['class' => 'form-control input-text', 'placeholder' => '床の高さを入力し']) }}
                        </div>
                         <div class="form-group col-md-3">
                            {{ Form::label('c-help', 'c_help') }}
                            {{ Form::text('c_help', $searchParams['c_help'], ['class' => 'form-control input-text', 'placeholder' => '床の幅を入力し']) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('start-date', '開始日') }}
                            {{ Form::text('startDate', $searchParams['startDate'], ['class' => 'form-control input-text', 'id' => 'start-date', 'placeholder' => '開始日']) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('end-date', '終了日') }}
                            {{ Form::text('endDate', $searchParams['endDate'], ['class' => 'form-control input-text', 'id' => 'end-date', 'placeholder' => '終了日']) }}
                        </div>
                        <div class="form-group pull-right">
                            {!! html_entity_decode(Form::button('<i class="fa fa-search">&nbsp;</i> 検索', ['type' => 'submit','class' => 'btn btn-success input-submit'])) !!}
                            <a href="javascript:void(0)" class="btn btn-default input-clear input-submit" style="margin-right:10px;"><i class="fa fa-remove">&nbsp;</i>浄化</a>
                        </div>
                        {{ Form::close() }}
                    </div> 
                <div class="overflow"">
                    <table class="table table-striped " id="table-config">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Action</th>
                                <th>c_key</th>
                                <th>c_data</th>
                                <th>c_help</th>
                                <th class="td-center">created_at</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                        @foreach($listConfig as $key => $config)
                             <tr>
                                <td>{{ $i }}</td>
                                <td class="td-inline td-center">{!! html_entity_decode(Html::link(route('admin.pias.config.getView', $config->c_key), '<i class="fa fa-eye">&nbsp;</i> 詳細', ['class' => 'btn btn-primary btn-xs', 'title' => '詳細'])) !!}</td>
                                <td class="td-inline td-left">{{ $config->c_key }}</td>
                                <td class="td-inline td-right">{{ $config->c_data }}</td>
                                <td style="height: 20px;" class="td-left"><div style="max-height: 20px;overflow: hidden;">{{ $config->c_help }}</div></td>
                                <td class="td-inline td-center">{{ date('Y/m/d H:i:s',strtotime($config->created_at)) }}</td>
                                
                            </tr>
                        <?php $i++; ?>
                        @endforeach()
                        </tbody>
                    </table>
                </div>
                @include('element.pagination', ['results' => $listConfig, 'object' => 'thiết lập'])
                </div>
            </div>
        </div>
    </div>
@stop()
