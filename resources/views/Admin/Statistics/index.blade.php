@extends('Admin.main')
@section('title', "首页-Sramer")
@section('body')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-sm-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <div class="pull-right">
                            <div class="btn-group">
                                <button id="recharge_statistics_day" type="button"
                                        class="btn btn-xs btn-white recharge_statistics_btn"
                                        onclick="get_recharge_statistics('day')">天
                                </button>
                                <button id="recharge_statistics_month" type="button"
                                        class="btn btn-xs btn-white recharge_statistics_btn"
                                        onclick="get_recharge_statistics('month')">月
                                </button>
                                <button id="recharge_statistics_year" type="button"
                                        class="btn btn-xs btn-white recharge_statistics_btn"
                                        onclick="get_recharge_statistics('year')">年
                                </button>
                            </div>
                        </div>
                        <h5>充值</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins" id="total_recharge">0</h1>
                        <div class="stat-percent font-bold text-success" id="recharge_ratio"><span>-</span>
                        </div>
                        <small>总收入</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <div class="pull-right">
                            <div class="btn-group">
                                <button id="order_statistics_day" type="button"
                                        class="btn btn-xs btn-white order_statistics_btn"
                                        onclick="get_order_statistics('day')">天
                                </button>
                                <button id="order_statistics_month" type="button"
                                        class="btn btn-xs btn-white order_statistics_btn"
                                        onclick="get_order_statistics('month')">月
                                </button>
                                <button id="order_statistics_year" type="button"
                                        class="btn btn-xs btn-white order_statistics_btn"
                                        onclick="get_order_statistics('year')">年
                                </button>
                            </div>
                        </div>
                        <h5>兑换</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins" id="count_order">0</h1>
                        <div class="stat-percent font-bold text-success" id="order_ratio"><span>-</span>
                        </div>
                        <small>新订单</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <div class="pull-right">
                            <div class="btn-group">
                                <button id="new_user_statistics_day" type="button"
                                        class="btn btn-xs btn-white new_user_statistics_btn"
                                        onclick="get_new_user_statistics('day')">天
                                </button>
                                <button id="new_user_statistics_month" type="button"
                                        class="btn btn-xs btn-white new_user_statistics_btn"
                                        onclick="get_new_user_statistics('month')">月
                                </button>
                                <button id="new_user_statistics_year" type="button"
                                        class="btn btn-xs btn-white new_user_statistics_btn"
                                        onclick="get_new_user_statistics('year')">年
                                </button>
                            </div>
                        </div>
                        <h5>新增用户</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins" id="count_new_user">0</h1>
                        <div class="stat-percent font-bold text-success" id="new_user_ratio"><span>-</span>
                        </div>
                        <small>用户</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <div class="pull-right">
                            <div class="btn-group">
                                <button id="active_user_statistics_day" type="button"
                                        class="btn btn-xs btn-white active_user_statistics_btn"
                                        onclick="get_active_user_statistics('day')">天
                                </button>
                                <button id="active_user_statistics_month" type="button"
                                        class="btn btn-xs btn-white active_user_statistics_btn"
                                        onclick="get_active_user_statistics('month')">月
                                </button>
                                <button id="active_user_statistics_year" type="button"
                                        class="btn btn-xs btn-white active_user_statistics_btn"
                                        onclick="get_active_user_statistics('year')">年
                                </button>
                            </div>
                        </div>
                        <h5>活跃用户</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins" id="count_active_user">0</h1>
                        <div class="stat-percent font-bold text-success" id="active_user_ratio"><span>-</span>
                        </div>
                        <small>用户</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>订单</h5>
                        <div class="pull-right">
                            <div class="btn-group">
                                <button id="order_statistics_chart_day" type="button"
                                        class="btn btn-xs btn-white order_statistics_chart_btn"
                                        onclick="get_order_statistics_chart('day')">天
                                </button>
                                <button id="order_statistics_chart_month" type="button"
                                        class="btn btn-xs btn-white order_statistics_chart_btn"
                                        onclick="get_order_statistics_chart('month')">月
                                </button>
                                <button id="order_statistics_chart_year" type="button"
                                        class="btn btn-xs btn-white order_statistics_chart_btn"
                                        onclick="get_order_statistics_chart('year')">年
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-10">
                                <div class="flot-chart">
                                    <div class="flot-chart-content" id="flot-dashboard-chart"></div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <ul class="stat-list">
                                    <li>
                                        <small><span class="current_text"></span>订单</small>
                                        <div class="stat-percent" id="current_order_count">0</div>
                                    </li>
                                    <li>
                                        <small><span class="last_text"></span>订单</small>
                                        <div class="stat-percent" id="last_order_count">0</div>
                                    </li>
                                    <li>
                                        <small><span class="current_text"></span>销售额</small>
                                        <div class="stat-percent" id="current_order_amount">0</div>
                                    </li>
                                    <li>
                                        <small><span class="last_text"></span>销售额</small>
                                        <div class="stat-percent" id="last_order_amount">0</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('javascript')
    <script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/datapicker/bootstrap-datepicker.js"></script>
    <script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/flot/jquery.flot.js"></script>
    <script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/flot/jquery.flot.symbol.js"></script>
    <script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/peity/jquery.peity.min.js"></script>
    <script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/easypiechart/jquery.easypiechart.js"></script>
    <script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/sparkline/jquery.sparkline.min.js"></script>
    <script src="https://cdn.bootcss.com/echarts/4.2.1-rc1/echarts-en.common.js"></script>
    <script>
        $(document).ready(function () {
            get_recharge_statistics('day');
            get_order_statistics('day');
            get_new_user_statistics('day');
            get_active_user_statistics('day');
            get_order_statistics_chart('day');
        });

        function get_recharge_statistics(type) {
            var URL = "{{ url('Admin/Statistics/recharge',[],config('crucis.http_secure')) }}";
            var data = {'type': type};
            var button_id_name = "#recharge_statistics_" + type;
            $(".recharge_statistics_btn").removeClass('active');
            $.post(URL, data, function (result) {
                $("#total_recharge").text(numFormat(result.data.total_recharge));
                $("#recharge_ratio span").text(result.data.recharge_ratio);
                // $("#recharge_ratio i").attr('class',"fa fa-arrow-"+result.data.recharge_ratio_type);
                $(button_id_name).addClass('active');
            }, 'json');
        }

        function get_order_statistics(type) {
            var URL = "{{ url('Admin/Statistics/order',[],config('crucis.http_secure')) }}";
            var data = {'type': type};
            var button_id_name = "#order_statistics_" + type;
            $(".order_statistics_btn").removeClass('active');
            $.post(URL, data, function (result) {
                $("#count_order").text(result.data.count_order);
                $("#order_ratio span").text(result.data.order_ratio);
                // $("#order_ratio i").attr('class',"fa fa-arrow-"+result.data.order_ratio_type);
                $(button_id_name).addClass('active');
            }, 'json');
        }

        function get_new_user_statistics(type) {
            var URL = "{{ url('Admin/Statistics/user',[],config('crucis.http_secure')) }}";
            var data = {'type': type, 'scope': 'new'};
            var button_id_name = "#new_user_statistics_" + type;
            $(".new_user_statistics_btn").removeClass('active');
            $.post(URL, data, function (result) {
                $("#count_new_user").text(result.data.count_user);
                $("#new_user_ratio span").text(result.data.user_ratio);
                // $("#new_user_ratio i").attr('class',"fa fa-arrow-"+result.data.new_user_ratio_type);
                $(button_id_name).addClass('active');
            }, 'json');
        }

        function get_active_user_statistics(type) {
            var URL = "{{ url('Admin/Statistics/user',[],config('crucis.http_secure')) }}";
            var data = {'type': type, 'scope': 'active'};
            var button_id_name = "#active_user_statistics_" + type;
            $(".active_user_statistics_btn").removeClass('active');
            $.post(URL, data, function (result) {
                $("#count_active_user").text(result.data.count_user);
                $("#active_user_ratio span").text(result.data.user_ratio);
                // $("#active_user_ratio i").attr('class',"fa fa-arrow-"+result.data.active_user_ratio_type);
                $(button_id_name).addClass('active');
            }, 'json');
        }

        function get_order_statistics_chart(type) {
            var URL = "{{ url('Admin/Statistics/order_chart',[],config('crucis.http_secure')) }}";
            var data = {'type': type};
            var button_id_name = "#order_statistics_chart_" + type;
            $(".order_statistics_chart_btn").removeClass('active');
            $.post(URL, data, function (result) {
                // 基于准备好的dom，初始化echarts实例
                var myChart = echarts.init(document.getElementById('flot-dashboard-chart'));
                option = {
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {
                            type: 'cross',
                            crossStyle: {
                                color: '#1c84c6'
                            }
                        }
                    },
                    toolbox: {
                        feature: {
                            magicType: {show: true, type: ['line', 'bar']},
                            restore: {show: true},
                            saveAsImage: {show: true}
                        }
                    },
                    legend: {
                        data: ['充值收入', '订单数']
                    },
                    xAxis: [
                        {
                            type: 'category',
                            data: result.data.chart_option.x_axis,
                            axisPointer: {
                                type: 'shadow'
                            }
                        }
                    ],
                    yAxis: [
                        {
                            type: 'value',
                            name: '订单数',
                            min: result.data.chart_option.y_axis.right.min,
                            max: result.data.chart_option.y_axis.right.max,
                            interval: result.data.chart_option.y_axis.right.interval,
                            axisLabel: {
                                formatter: '{value}'
                            }
                        },
                        {
                            type: 'value',
                            name: '收入',
                            min: result.data.chart_option.y_axis.left.min,
                            max: result.data.chart_option.y_axis.left.max,
                            interval: result.data.chart_option.y_axis.left.interval,
                            axisLabel: {
                                formatter: '{value} 元'
                            }
                        }
                    ],
                    series: [
                        {
                            name: '充值收入',
                            type: 'bar',
                            yAxisIndex: 1,
                            data: result.data.chart_option.series.recharge_order_amount
                        },
                        {
                            name: '订单数',
                            type: 'line',
                            data: result.data.chart_option.series.recharge_order_num
                        },
                    ]
                };
                // 使用刚指定的配置项和数据显示图表。
                myChart.setOption(option);
                //通过DOM id获取到echarts实例
                var myChart = echarts.getInstanceByDom(document.getElementById("flot-dashboard-chart"));
                window.onresize = function () {
                    myChart.resize();
                };
                $(button_id_name).addClass('active');
                $(".current_text").text(result.data.text.current);
                $(".last_text").text(result.data.text.last);
                $("#current_order_count").text(result.data.chart_option.detail.current_order_count);
                $("#last_order_count").text(result.data.chart_option.detail.last_order_count);
                $("#current_order_amount").text(result.data.chart_option.detail.current_order_amount);
                $("#last_order_amount").text(result.data.chart_option.detail.last_order_amount);
            }, 'json');
        }

        function numFormat(num) {
            num = num.toString().split(".");  // 分隔小数点
            var arr = num[0].split("").reverse();  // 转换成字符数组并且倒序排列
            var res = [];
            for (var i = 0, len = arr.length; i < len; i++) {
                if (i % 3 === 0 && i !== 0) {
                    res.push(",");   // 添加分隔符
                }
                res.push(arr[i]);
            }
            res.reverse(); // 再次倒序成为正确的顺序
            if (num[1]) {  // 如果有小数的话添加小数部分
                res = res.join("").concat("." + num[1]);
            } else {
                res = res.join("");
            }
            return res;
        }
    </script>
    <script>
        $('.input-daterange').datepicker({
            language: "zh-CN",
            autoclose: true,
        });
    </script>
@endsection