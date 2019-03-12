@extends('Admin.main')
@section('title', "首页-Sramer")
@section('body')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>商品列表
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
                                <div class="col-sm-6 m-b-xs">
                                </div>
                                <div class="col-sm-3 m-b-xs">
                                    <input type="text" placeholder="请输入商品编号" class="input-sm form-control" name="goods_sn" value="{{ $input['goods_sn'] or '' }}"> <span
                                            class="input-group-btn"/>
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
                                    <th>#</th>
                                    <th>商品编号</th>
                                    <th>商品名称</th>
                                    <th>所属分类</th>
                                    <th>上传时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $goods)
                                    <tr id="item_{{ $goods->id }}">
                                        <td class="center">{{ $goods->id }}</td>
                                        <td>{{ $goods->goods_sn }}</td>
                                        <td>{{ $goods->name }}</td>
                                        <td>{{ $goods->category->name }}</td>
                                        <td>{{ $goods->created_at }}</td>
                                        <td>
                                            <a class="btn btn-info" href="{{ url('Admin/Goods/editGoods',['id'=>$goods->id],config('crucis.http_secure')) }}"><i class="fa fa-edit"></i> 编辑</a>
                                            {{--<a class="btn btn-warning" href="{{ url('Admin/Goods/goodsPictureList',['goods_id'=>$goods->id],config('crucis.http_secure')) }}"><i class="fa fa-file-picture-o"></i> 图片列表</a>--}}
                                            <a class="btn btn-danger" onclick="delete_goods({{ $goods->id }})"><i class="fa fa-trash"></i> 删除</a>
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
        function delete_goods(id)
        {
            swal({
                title: "您确定要删除这条商品吗",
                text: "删除后将无法恢复，请谨慎操作！",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确定",
                cancelButtonText: "取消",
                closeOnConfirm: false
            }, function () {
                var URL = '{{ url('Admin/Goods/deleteGoods',[],config('crucis.http_secure')) }}';
                var data = {_method:"DELETE",id:id};
                $.post(URL, data, function (result) {
                    if (result.status == 200)
                    {
                        $("#item_"+id).remove();
                        swal("商品删除成功！", result.message, "success");
                    }else {
                        swal("商品删除失败！", result.message, "error");
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