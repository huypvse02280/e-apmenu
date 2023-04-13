@extends('layouts.base')
@section('title', '機器リスト')
@section('page-content')
	 <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default panel-content">
                <div class="panel-heading">
                    <ul class="list-inline">
                        <li> <h3>機器リスト</h3></li>
                    </ul>
                </div>
                <div class="panel-body">
                   	<div class="row">
                        {{ Form::open(['route' => 'admin.pias.mac.getList','method' => 'get', 'class' => 'frm-filter']) }}
                        {{ Form::hidden('limit', isset($_GET['limit']) ? $_GET['limit'] : null)}}
                        <div class="form-group col-md-3">
                            {{ Form::label('mac-address', 'MACアドレス') }}
                            {{ Form::text('mac_address', $searchParams['mac_address'], ['class' => 'form-control input-text', 'placeholder' => 'ご記入ください。'])}}   
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('mac-name', 'ユーザー名') }}
                            {{ Form::text('name', $searchParams['name'], ['class' => 'form-control input-text', 'placeholder' => 'ご記入ください。']) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('mac-user-email', 'メール') }}
                            {{ Form::text('email', $searchParams['email'], ['class' => 'form-control input-text', 'placeholder' => 'ご記入ください。']) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('mac-user-phone', '電話番号') }}
                            {{ Form::text('phone', $searchParams['phone'], ['class' => 'form-control input-text', 'placeholder' => 'ご記入ください。']) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('mac-level', 'ランク') }}
                            {{ Form::select('level', ['1' => 'Admin', '2' => 'Manage', '3' => 'Member'],$searchParams['level'], ['class' => 'form-control input-text', 'placeholder' => 'ご記入ください。']) }}
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
                                    <th class="td-center">Mac</th>
                                    <th class="td-left">ユーザー名</th>
                                    <th class="td-left">ランク</th>
                                    <th class="td-left">Eメール</th>
                                    <th class="td-right">電話</th>
                                    <th class="td-left">性別</th>
                                    <th class="td-center">登録日時</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                            @foreach($listMac as $key => $mac)
                                 <tr>
                                    <td>{{ $i }}</td>
                                    <td class="td-inline td-center">
                                        {!! html_entity_decode(Html::link(route('admin.pias.mac.getView', $mac->mac_address), '<i class="fa fa-eye"></i>', ['class' => 'btn btn-primary btn-xs', 'data-toggle' => 'tooltip', 'data-title' => '詳細'])) !!}
                                        {!! html_entity_decode(Html::link(route('admin.pias.mac.getEdit', $mac->mac_address),'<i class="fa fa-pencil"></i>',['class' => 'btn btn-primary btn-xs', 'data-toggle' => 'tooltip', 'data-title' => '更新'])) !!}
                                        {!! html_entity_decode(Html::link(route('admin.pias.mac.getDelete',$mac->mac_address),'<i class="fa fa-trash-o"></i>', ['class' => 'btn btn-danger btn-xs', 'data-toggle' => 'tooltip', 'data-title' => '削除', 'onclick' => 'return confirmDelete();'])) !!}
                                    </td>
                                    <td class="td-inline td-center">{{ $mac->mac_address }}</td>
                                    <td class="td-inline td-left">{{ $mac->name }}</td>
                                    <td class="td-left">{{ isset($mac->use_classify) && $mac->use_classify == 1 ? 'Admin' : (isset($mac->use_classify) && $mac->use_classify == 2 ? 'Manage' : 'Member') }}</td>
                                    <td class="td-left">{{ $mac->email }}</td>
                                    <td class="td-right">{{ $mac->phone }}</td>
                                    <td class="td-left">{{ isset($mac->gender) && $mac->gender == 1 ? '男性' : '女性たち' }}</td>
                                    <td class="td-inline td-center">{{ $mac->created_at ? date('Y/m/d H:i:s',strtotime($mac->created_at)) : '' }}</td>
                                </tr>
                            <?php $i++; ?>
                            @endforeach()
                            </tbody>
                        </table>
                    </div>
                    @include('element.pagination',['results' => $listMac, 'object' => 'mac'])
                </div>
            </div>
        </div>
    </div>
@stop()