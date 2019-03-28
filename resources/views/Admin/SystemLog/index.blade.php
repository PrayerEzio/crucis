@extends('Admin.main')

@section('css')
    <link href="{{ asset('assets/Admin',config('crucis.http_secure')) }}/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
@endsection
@section('body')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>系统日志列表
                            <small></small>
                        </h5>
                        <div class="ibox-tools">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="table_data_tables.html#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li>
                                    <a href="{{ url('Admin/Goods/addGoods',[],config('crucis.http_secure')) }}"><i class="fa fa-plus"></i> 新增</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form id="filter_form" method="get" action="">
                            <div class="row">
                                <div class="col-sm-4 m-b-xs">
                                    {{--<div data-toggle="buttons" class="btn-group">
                                        @php !isset($input['status']) ? $input['status'] = '' : '';@endphp
                                        <label class="btn btn-sm btn-white {{ $input['status']=='' ? 'active' : ''}}">
                                            <input type="radio" id="all" name="status" value="">全部订单</label>
                                        <label class="btn btn-sm btn-white {{ $input['status'] == 1 ? 'active' : ''}}">
                                            <input type="radio" id="status1" name="status" value="1">未支付</label>
                                        <label class="btn btn-sm btn-white {{ $input['status'] == 2 ? 'active' : ''}}">
                                            <input type="radio" id="status2" name="status" value="2">已付款</label>
                                        <label class="btn btn-sm btn-white {{ $input['status'] == 3 ? 'active' : ''}}">
                                            <input type="radio" id="status3" name="status" value="3">已发货</label>
                                        <label class="btn btn-sm btn-white {{ $input['status'] == 4 ? 'active' : ''}}">
                                            <input type="radio" id="status4" name="status" value="4">已收货</label>
                                        <label class="btn btn-sm btn-white {{ $input['status'] == 5 ? 'active' : ''}}">
                                            <input type="radio" id="status5" name="status" value="5">已完成</label>
                                        <label class="btn btn-sm btn-white {{ $input['status'] == -1 ? 'active' : ''}}">
                                            <input type="radio" id="status-1" name="status" value="-1">已取消</label>
                                    </div>--}}
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
                                    <th>标题</th>
                                    <th>类型</th>
                                    <th>等级</th>
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
                                            <td>{{ $item->operator_type }}</td>
                                            <td>{{ $item->level }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>
                                                {{ $item->status }}
                                            </td>
                                            <td>
                                                <a class="btn btn-info" onclick="show_detail({{ $item->id }})" data-toggle="modal" data-target="#myModal"><i class="fa fa-edit"></i> 详情</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <div class="modal inmodal fade" id="myModal" tabindex="-1" role="dialog"  aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                <h4 class="modal-title">日志详情</h4>
                                                <small class="font-bold" id="log_title">正在获取.</small>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div>日志类型：<span id="log_type">正在获取.</span></div>
                                                        <div>日志等级：<span id="log_level">正在获取.</span></div>
                                                        <div>操作者：<span id="log_operator_type">正在获取.</span></div>
                                                        <div>IP地址：<span id="log_ip">正在获取.</span></div>
                                                        <div>创建时间：<span id="log_created_at">正在获取.</span></div>
                                                        <div>日志内容：<pre id="log_content" class="p-m">正在获取.</pre></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
        function show_detail(id)
        {
            var URL = '{{ url('Admin/SystemLog/detail',[],config('crucis.http_secure')) }}/'+id;
            var data = {_method:"POST"};
            $.post(URL, data, function (result) {
                if (result.status == 200)
                {
                    $("#log_title").html(result.data.title);
                    $("#log_type").html(result.data.type);
                    $("#log_level").html(result.data.level);
                    $("#log_operator_type").html(result.data.operator_type);
                    $("#log_ip").html(result.data.ip);
                    $("#log_created_at").html(result.data.created_at);
                    $("#log_content").html(result.data.content);
                }
            },'json');
        }
    </script>
@endsection