@extends('Admin.main')
@section('title', "首页-Sramer")
@section('css')
@endsection
@section('body')
    <div class="container">
        <div class="kimi-container">
            <div class="row">
                <form id="order_pay_form" method="post" action="">
                    {{ csrf_field() }}
                    <div class="col-sm-12">
                        <div class="ibox-content p-xl">
                            <div class="row">
                                <div class="col-sm-6">
                                    <address>
                                        {{--<strong>北京百度在线网络技术有限公司</strong><br>
                                        北京市海淀区上地十街10号<br>
                                        <abbr title="Phone">总机：</abbr> (+86 10) 5992 8888--}}
                                    </address>
                                </div>
                                <div class="col-sm-6 text-right">
                                    <h4>订单编号：</h4>
                                    <h4 class="text-navy">{{ $order_info->order_sn }}</h4>
                                    <address>
                                        <strong>{{ $order_info->user->nickname }}</strong><br>
                                        {{ $order_info->address->province }}
                                        {{ $order_info->address->city }}
                                        {{ $order_info->address->district }}
                                        {{ $order_info->address->address }}
                                        <br>
                                        <abbr title="Phone">手机：</abbr> {{ $order_info->address->phone }}
                                    </address>
                                    <p>
                                        <span><strong>日期：</strong> {{ $order_info->created_at }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="table-responsive m-t">
                                <table class="table invoice-table">
                                    <thead>
                                    <tr>
                                        <th>清单</th>
                                        <th>规格</th>
                                        <th>数量</th>
                                        <th>单价</th>
                                        <th>总价</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order_info->products as $order_product)
                                    <tr>
                                        <td>
                                            <div><strong>{{ $order_product->goods_name }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            @isset($order_product->attributes)
                                                @foreach($order_product->attributes as $attribute)
                                                    {{ $attribute->value }}
                                                @endforeach
                                            @else
                                                /
                                            @endisset
                                        </td>
                                        <td>{{ $order_product->qty }}</td>
                                        <td>&yen;{{ $order_product->price }}</td>
                                        <td>&yen;{{ $order_product->price*$order_product->qty }}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /table-responsive -->
                            <table class="table invoice-total">
                                <tbody>
                                <tr>
                                    <td><strong>总价：</strong>
                                    </td>
                                    <td>&yen;{{ $order_info->amount }}</td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="text-right">
                                <button class="btn btn-primary" type="button" onclick="print_order()"><i class="fa fa-dollar"></i> 打印发货单</button>
                                @if (!in_array($order_info->status,[-1,5]))
                                <button class="btn btn-primary" type="button" onclick="cancel_order()"><i class="fa fa-dollar"></i> 取消订单</button>
                                @endif
                            @switch ($order_info->status)
                                @case (1)
                                        <button class="btn btn-primary" type="button" onclick="next_status({{ $order_info->order_sn }})"><i class="fa fa-dollar"></i> 确认支付</button>
                                    @break
                                @case (2)
                                        <button class="btn btn-primary" type="button" onclick="next_status({{ $order_info->order_sn }})"><i class="fa fa-dollar"></i> 确认发货</button>
                                    @break
                                @case (3)
                                        <button class="btn btn-primary" type="button" onclick="next_status({{ $order_info->order_sn }})"><i class="fa fa-dollar"></i> 确认收货</button>
                                    @break
                                @case (4)
                                        <button class="btn btn-primary" type="button" onclick="next_status({{ $order_info->order_sn }})"><i class="fa fa-dollar"></i> 完成订单</button>
                                    @break
                                @default
                                    @break
                            @endswitch
                            </div>
                            <div class="hr-line-dashed"></div>
                            @foreach($order_info->logs as $log)
                                <div class="ibox-content timeline">
                                    <div class="timeline-item">
                                        <div class="row">
                                            <div class="col-xs-3 date">
                                                {{ $log->created_at }}
                                                <br>
                                                <small class="text-navy">{{ $log->created_at->diffForHumans() }}</small>
                                            </div>
                                            <div class="col-xs-7 content no-top-border">
                                                <p class="m-b-xs"><strong>{{ $log->title }}</strong></p>
                                                <p>{{ $log->content }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.container -->
@endsection
@section('javascript')
    <script type="text/javascript">
        function print_order()
        {
            window.print();
        }
        function cancel_order(sn)
        {
            swal({
                title: "您确定要取消订单吗",
                text: "请谨慎操作！",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确认",
                cancelButtonText: "关闭",
                closeOnConfirm: false
            }, function () {
                var URL = '{{ url('Admin/Order/cancelOrder',[],config('crucis.http')) }}';
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
        function next_status(sn)
        {
            swal({
                title: "您确定要变更订单状态吗",
                text: "变更后将无法恢复，请谨慎操作！",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "变更",
                cancelButtonText: "取消",
                closeOnConfirm: false
            }, function () {
                var URL = '{{ url('Admin/Order/nextStatus',[],config('crucis.http_secure')) }}';
                var data = {_method:"POST",sn:sn};
                $.post(URL, data, function (result) {
                    if (result.status == 200)
                    {
                        swal("变更成功！", result.message, "success");
                        window.location.reload();
                    }else {
                        swal("变更失败！", result.message, "error");
                    }
                });
            })
        }
    </script>
@endsection