@extends('layouts.base')
@section('title', 'フロアのリスト')
@section('page-content')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default panel-content">
                <div class="panel-heading">
                    <ul class="list-inline">
                        <li> <h3>フロアのリスト</h3></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="row">
                        {{ Form::open(['route' => 'admin.pias.map.getlist','method' => 'get', 'class' => 'frm-filter']) }}
                        {{ Form::hidden('limit', isset($_GET['limit']) ? $_GET['limit'] : null)}}
                        <div class="form-group col-md-3">
                            {{ Form::label('map-id', 'コードの床、') }}
                            {{ Form::select('id',selectBox($listFloor , 'map_id', 'map_name') , $searchParams['id'], ['class' => 'form-control input-text', 'placeholder' => 'コードの床を選択'])}}   
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('map-name', 'フロアの名前') }}
                            {{ Form::text('name', $searchParams['name'], ['class' => 'form-control input-text', 'placeholder' => 'フロアの名前を入力し'])}}   
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('map-size-heigh', '床の高さ') }}
                            {{ Form::text('height', $searchParams['height'], ['class' => 'form-control input-text', 'placeholder' => '床の高さを入力し']) }}
                        </div>
                         <div class="form-group col-md-3">
                            {{ Form::label('map-size-width', '床の幅') }}
                            {{ Form::text('width', $searchParams['width'], ['class' => 'form-control input-text', 'placeholder' => '床の幅を入力し']) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('map-size-length', '床の長さ') }}
                            {{ Form::text('length', $searchParams['length'], ['class' => 'form-control input-text', 'placeholder' => '床の長さを入力し']) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('image-name', 'フロアの図') }}
                            {{ Form::text('image', $searchParams['image'], ['class' => 'form-control input-text', 'placeholder' => 'フロア図の名前を入力し']) }}
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
                            <a href="javascript:void(0)" class="btn btn-default input-clear input-submit" style="margin-right:10px;"><i class="fa fa-remove">&nbsp;</i>Clear</a>

                        </div>
                        {{ Form::close() }}
                    </div>
                    <div class="overflow"">
                        <table class="table table-striped " id="table-mapp">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th class="td-center">Action</th>
                                    <th class="td-center">コード</th>
                                    <th class="td-left">マップ名</th>
                                    <th class="td-right">高さ</th>
                                    <th class="td-right">幅</th>
                                    <th class="td-right">長さ</th>
                                    <th class="td-left">画像</th>
                                    <th class="td-center">登録日時</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                            @foreach($listMap as $key => $map)
                                 <tr>
                                    <td>{{ $i }}</td>
                                    <td class="td-inline td-center">
                                        {!! html_entity_decode(Html::link(route('admin.pias.map.getView', $map->map_id), '<i class="fa fa-eye"></i>', ['class' => 'btn btn-primary btn-xs', 'data-toggle' => 'tooltip', 'data-title' => '詳細'])) !!}
                                        {!! html_entity_decode(Html::link(route('admin.pias.map.getEdit', $map->map_id),'<i class="fa fa-pencil"></i>',['class' => 'btn btn-primary btn-xs', 'data-toggle' => 'tooltip', 'data-title' => '更新'])) !!}
                                        {!! html_entity_decode(Html::link(route('admin.pias.map.getDelete',$map->map_id),'<i class="fa fa-trash-o"></i>', ['class' => 'btn btn-danger btn-xs', 'data-toggle' => 'tooltip', 'data-title' => '削除', 'onclick' => 'return confirmDelete();'])) !!}
                                    </td>
                                    <td class="td-inline td-center">{{ $map->map_id }}</td>
                                    <td class="td-inline td-left">{{ $map->map_name }}</td>
                                    <td class="td-right">{{ $map->map_size_heigh }}</td>
                                    <td class="td-right">{{ $map->map_size_width }}</td>
                                    <td class="td-right">{{ $map->map_size_length }}</td>
                                    <td class="td-inline td-left">{{ $map->image_name }}</td>
                                    <td class="td-inline td-center">{{ $map->created_at ? date('Y/m/d H:i:s',strtotime($map->created_at)) : '' }}</td>
                                </tr>
                            <?php $i++; ?>
                            @endforeach()
                            </tbody>
                        </table>
                    </div>
                    @include('element.pagination',['results' => $listMap, 'object' => 'sơ đồ'])
                </div>
            </div>
        </div>
    </div>
@stop()
@section('page-script')
    <script src="{{asset('vendor/datepicker/jquery.datetimepicker.full.min.js')}}"></script>
    <!-- <script type="text/javascript">
        //$('#start-date, #end-date').datetimepicker({value:'date()',step:10});
        $('.input-submit').click(function() {
           // alert('ok');
           $('input').val(null);
        });
    </script> -->
@stop()
