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
                        <h5>订单列表
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
                                    <div data-toggle="buttons" class="btn-group">
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
                                        <input type="text" placeholder="请输入订单号" class="input-sm form-control" name="sn" value="{{ $input['sn'] or '' }}"> <span
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
                                    <th>订单号</th>
                                    <th>用户</th>
                                    <th>金额</th>
                                    <th>订单类型</th>
                                    <th>创建时间</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($list as $item)
                                        <tr>
                                            <td class="center">{{ $item->order_sn }}</td>
                                            <td>{{ $item->user->nickname }}</td>
                                            <td>{{ $item->amount }}</td>
                                            <th>{{ \App\Http\Models\Order::getOrderTypeName($item) }}</th>
                                            <td>{{ $item->created_at }}</td>
                                            <td>
                                                {{ \App\Http\Models\Order::getStatusName($item) }}
                                            </td>
                                            <td>
                                                <a class="btn btn-info" href="{{ url('Admin/Order/detail',['sn'=>$item->order_sn],config('crucis.http_secure')) }}"><i class="fa fa-edit"></i> 查看</a>
                                                <a class="btn btn-danger" onclick="cancel_order({{ $item->order_sn }})"><i class="fa fa-trash"></i> 取消</a>
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
        function cancel_order(sn)
        {
            swal({
                title: "您确定要取消这条订单吗",
                text: "删除后将无法恢复，请谨慎操作！",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确定",
                cancelButtonText: "取消",
                closeOnConfirm: false
            }, function () {
                var URL = '{{ url('Admin/Order/cancelOrder',[],config('crucis.http_secure')) }}';
                var data = {_method:"DELETE",sn:sn};
                $.post(URL, data, function (result) {
                    if (result.status == 200)
                    {
                        swal("订单取消成功！", result.message, "success");
                    }else {
                        swal("订单取消失败！", result.message, "error");
                    }
                });
            })
        }
        $('input:radio[name="status"]').change(function () {
            $("#filter_form").submit();
        });
        $('.input-daterange').datepicker({
            language: "zh-CN",
            autoclose:true,
        });
    </script>
@endsection