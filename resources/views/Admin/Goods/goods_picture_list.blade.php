@extends('Admin.main')

@section('body')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>商品图片列表
                            <small></small>
                        </h5>
                        <div class="ibox-tools">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="table_data_tables.html#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li>
                                    <a href="{{ url('Admin/Goods/addGoodsPicture',['goods_id'=>$goods_id],config('crucis.http_secure')) }}"><i class="fa fa-plus"></i> 新增</a>
                                </li>
                                <li>
                                    <a href="{{ url('Admin/Goods/goodsList',[],config('crucis.http_secure')) }}"><i class="fa fa-plus"></i> 返回</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>图片预览</th>
                                    <th>排序</th>
                                    <th>上传时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $goods_picture)
                                    <tr>
                                        <td class="center">{{ $goods_picture->id }}</td>
                                        <td>
                                            <img src="{{ $goods_picture->url }}" height="100px">
                                        </td>
                                        <td>{{ $goods_picture->sort }}</td>
                                        <td>{{ $goods_picture->created_at }}</td>
                                        <td>
                                            <a class="btn btn-info" href="{{ url('Admin/Goods/editGoodsPicture',['id'=>$goods_picture->id],config('crucis.http_secure')) }}"><i class="fa fa-edit"></i> 编辑</a>
                                            <a class="btn btn-danger" onclick="delete_goods_picture({{ $goods_picture->id }})"><i class="fa fa-trash"></i> 删除</a>
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
        function delete_goods_picture(id)
        {
            swal({
                title: "您确定要删除这条商品图片吗",
                text: "删除后将无法恢复，请谨慎操作！",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确定",
                cancelButtonText: "取消",
                closeOnConfirm: false
            }, function () {
                var URL = '{{ url('Admin/Goods/deleteGoodsPicture',[],config('crucis.http_secure')) }}';
                var data = {_method:"DELETE",id:id};
                $.post(URL, data, function (result) {
                    if (result.status == 200)
                    {
                        swal("商品图片删除成功！", result.message, "success");
                    }else {
                        swal("商品图片删除失败！", result.message, "error");
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