@extends('Admin.main')
@section('title', "首页-Sramer")
@section('css')
    <link href="{{ asset('assets/Admin',config('crucis.http_secure')) }}/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
@endsection
@section('body')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>反馈列表
                            <small></small>
                        </h5>
                    </div>
                    <div class="ibox-content">
                        <form id="filter_form" method="get" action="">
                            <div class="row">
                                <div class="col-sm-4 m-b-xs">
                                    <div class="input-daterange input-group" id="datepicker">
                                        <input type="text" class="input-sm form-control" name="start" value="{{ $input['start'] or '' }}"/>
                                        <span class="input-group-addon">至</span>
                                        <input type="text" class="input-sm form-control" name="end" value="{{ $input['end'] or '' }}"/>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <input type="text" placeholder="请输入关键字" class="input-sm form-control" name="keyword" value="{{ $input['keyword'] or '' }}"> <span
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
                                    <th>#</th>
                                    <th>用户</th>
                                    <th>内容</th>
                                    {{--<th>图片</th>--}}
                                    <th>创建时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($list as $item)
                                        <tr>
                                            <td class="center">{{ $item->id }}</td>
                                            <td>{{ $item->user->nickname }}</td>
                                            <td>{{ $item->content }}</td>
                                            {{--<td>
                                                <div class="image">
                                                    <img alt="image" style="height: 40px" class="img-responsive" src="{{ $item->image }}">
                                                </div>
                                            </td>--}}
                                            <td>{{ $item->created_at }}</td>
                                            <td>
                                                <a class="btn btn-info" href="{{ url("/Admin/Feedback/{$item->id}/edit",[],config('crucis.http_secure')) }}"><i class="fa fa-edit"></i> 详情</a>
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
    <script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/datapicker/bootstrap-datepicker.js"></script>
    <script>
        $('.input-daterange').datepicker({
            language: "zh-CN",
            autoclose:true,
        });
    </script>
@endsection