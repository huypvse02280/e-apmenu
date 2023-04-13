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
                        {{ Form::open(['route' => 'admin.pias.user.getList','method' => 'get', 'class' => 'frm-filter']) }}
                        {{ Form::hidden('limit', isset($_GET['limit']) ? $_GET['limit'] : null)}}
                        <div class="form-group col-md-3">
                            {{ Form::label('user-no', '利用者コード') }}
                            {{ Form::text('userNo', $searchParams['userNo'], ['class' => 'form-control input-text', 'placeholder' => 'ご記入ください。'])}}   
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('user-name', 'ユーザー名') }}
                            {{ Form::text('userName', $searchParams['userName'], ['class' => 'form-control input-text', 'placeholder' => 'ご記入ください。']) }}
                        </div>
                         <div class="form-group col-md-3">
                            {{ Form::label('user-phone', '電話') }}
                            {{ Form::text('phone', $searchParams['phone'], ['class' => 'form-control input-text', 'placeholder' => 'ご記入ください。']) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('user-mail', 'メール') }}
                            {{ Form::text('email', $searchParams['email'], ['class' => 'form-control input-text', 'placeholder' => 'ご記入ください。']) }}
                        </div>
                        
                        <?php if (Auth::user()->role_id == 1): ?>
                            <div class="form-group col-md-3">
                                {{ Form::label('company-id', '会社名') }}
                                {{ Form::select('companyId',selectBox($company , 'cp_code', 'cp_name') , $searchParams['companyId'], ['class' => 'form-control input-text', 'placeholder' => 'ご記入ください。'])}}   
                            </div>
                            <div class="form-group col-md-3">
                                {{ Form::label('team-id', 'グループ名') }}
                                {{ Form::select('teamId',selectBox($team , 'team_id', 'name') , $searchParams['teamId'], ['class' => 'form-control input-text', 'placeholder' => 'ご記入ください。'])}}   
                            </div>
                        <?php endif ?>

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
                                    <th class="td-center">Action</th>
                                    <th class="td-right">Code</th>
                                    <th class="td-left">Name</th>
                                    <th class="td-left">Level</th>
                                    <th class="td-right">Birthday</th>
                                    <th class="td-right">Phone</th>
                                    <th class="td-left">Email</th>
                                    <th class="td-left">Company Name</th>
                                   <!--  <th class="td-left">Team Name</th> -->
                                </tr>
                            </thead>
                            <tbody>
                             <?php $i = 1; ?>
                            @foreach($userList as $key => $us)
                                 <tr>
                                    <td>{{ $i }}</td>
                                    <td class="td-inline td-center">{!! html_entity_decode(Html::link(route('admin.pias.user.getView', $us->user_id), '<i class="fa fa-eye">&nbsp;</i> 詳細', ['class' => 'btn btn-primary btn-xs', 'title' => '詳細'])) !!}</td>
                                    <td class="td-inline td-right">{{ $us->user_id }}</td>
                                    <td class="td-inline td-left">{{ $us->username }}</td>
                                    <td class="td-left">{{ isset($us->role_id) && $us->role_id == 1 ? 'Admin' :  (isset($us->role_id) && $us->role_id == 2 ? 'Manage' : 'Member')}}</td>
                                    <td class="td-right">{{$us->birthday ? date('Y/m/d', strtotime($us->birthday)) : null }}</td>
                                    <td class="td-right">{{ $us->phone }}</td>
                                    <td class="td-left">{{ $us->email }}</td>
                                    <td class="td-inline td-left">{{ $us->cp_name }}</td>
                                    {{--
                                    <td class="td-left">{{ $us->team_name }}</td>
                                    --}}
                                </tr>
                            <?php $i++; ?>
                            @endforeach()
                            </tbody>
                        </table>
                    </div>
                    @include('element.pagination',['results' => $userList, 'object' => 'user'])
                </div>
            </div>
        </div>
    </div>
@stop()