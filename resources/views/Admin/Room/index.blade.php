@extends('Admin.main')

@section('body')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>房间列表
                            <small></small>
                        </h5>
                    </div>
                    <div class="ibox-content">
                        <form id="filter_form" method="get" action="">
                            <div class="row">
                                <div class="col-sm-6 m-b-xs">
                                </div>
                                <div class="col-sm-3 m-b-xs">
                                    <input type="text" placeholder="请输入房间编号" class="input-sm form-control" name="id" value="{{ $input['id'] or '' }}"> <span
                                            class="input-group-btn">
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <input type="text" placeholder="请输入关键词" class="input-sm form-control" name="keyword" value="{{ $input['keyword'] or '' }}"> <span
                                                class="input-group-btn">
                                            <button class="btn btn-sm btn-primary"> 搜索</button> </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>房间编号</th>
                                    <th>房间标题</th>
                                    <th>房间图片</th>
                                    <th>SDK类型</th>
                                    <th>房间状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $room)
                                    <tr>
                                        <td class="center">{{ $room->id }}</td>
                                        <td>{{ $room->title }}</td>
                                        <td>
                                            <div class="image">
                                                <img alt="image" style="height: 40px" class="img-responsive" src="{{ $room->cover }}">
                                            </div>
                                        </td>
                                        <td>{{ $room->sdk_type }}</td>
                                        <td>{{ $room->getStatusName($room) }}</td>
                                        <td>
                                            <a class="btn btn-info" href="{{ url('Admin/Room',['id'=>$room->id],config('crucis.http_secure')) }}"><i class="fa fa-edit"></i> 详情</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="dataTables_paginate paging_simple_numbers" id="editable_paginate">
                                {{ $list->appends($input)->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
@endsection