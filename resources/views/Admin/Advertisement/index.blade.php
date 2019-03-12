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
                        <h5>广告列表
                            <small></small>
                        </h5>
                        <div class="ibox-tools">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="table_data_tables.html#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li>
                                    <a href="{{ url('Admin/Advertisement/create',[],config('crucis.http_secure')) }}"><i class="fa fa-plus"></i> 新增</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form id="filter_form" method="get" action="">
                            <div class="row">
                                <div class="col-sm-4 m-b-xs">
                                    <div data-toggle="buttons" class="btn-group">
                                        @php !isset($input['position']) ? $input['position'] = '' : '';@endphp
                                        <label class="btn btn-sm btn-white {{ $input['position']=='' ? 'active' : ''}}">
                                            <input type="radio" id="all" name="position" value="">全部</label>
                                        <label class="btn btn-sm btn-white {{ $input['position'] == 'banner' ? 'active' : ''}}">
                                            <input type="radio" id="position1" name="position" value="banner">首页banner</label>
                                    </div>
                                </div>
                                <div class="col-sm-4 m-b-xs">
                                    <div class="input-daterange input-group" id="datepicker">
                                        <input type="text" class="input-sm form-control" name="start" value="{{ $input['start'] or '' }}"/>
                                        <span class="input-group-addon">至</span>
                                        <input type="text" class="input-sm form-control" name="end" value="{{ $input['end'] or '' }}"/>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <input type="text" placeholder="请输入广告标题" class="input-sm form-control" name="title" value="{{ $input['title'] or '' }}"> <span
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
                                    <th>标题</th>
                                    <th>子标题</th>
                                    <th>图片</th>
                                    <th>广告位</th>
                                    <th>排序</th>
                                    <th>创建时间</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($list as $item)
                                        <tr>
                                            <td class="center">{{ $item->id }}</td>
                                            <td>{{ $item->title }}</td>
                                            <td>{{ $item->sub_title }}</td>
                                            <td>
                                                <div class="image">
                                                    <img alt="image" style="height: 40px" class="img-responsive" src="{{ $item->image }}">
                                                </div>
                                            </td>
                                            <td>{{ $item->position }}</td>
                                            <td>{{ $item->sort }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>
                                                {{ $item->status == 1 ? '开启' : '关闭' }}
                                            </td>
                                            <td>
                                                <a class="btn btn-info" href="{{ url("/Admin/Advertisement/{$item->id}/edit",[],config('crucis.http_secure')) }}"><i class="fa fa-edit"></i> 编辑</a>
                                                <a class="btn btn-danger" onclick="delete_adv({{ $item->id }})"><i class="fa fa-trash"></i> 删除</a>
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
        function delete_adv(id)
        {
            swal({
                title: "您确定要删除这条广告吗",
                text: "删除后将无法恢复，请谨慎操作！",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确定",
                cancelButtonText: "取消",
                closeOnConfirm: false
            }, function () {
                var URL = '{{ url('Admin/Advertisement',[],config('crucis.http_secure')) }}/'+id;
                var data = {_method:"DELETE"};
                $.post(URL, data, function (result) {
                    if (result.status == 200)
                    {
                        swal("广告删除成功！", result.message, "success");
                    }else {
                        swal("广告删除失败！", result.message, "error");
                    }
                });
            })
        }
        $('input:radio[name="position"]').change(function () {
            $("#filter_form").submit();
        });
        $('.input-daterange').datepicker({
            language: "zh-CN",
            autoclose:true,
        });
    </script>
@endsection