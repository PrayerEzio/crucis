@extends('Admin.main')
@section('title', "首页-Sramer")
@section('body')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>属性分类列表
                            <small></small>
                        </h5>
                        <div class="ibox-tools">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="table_data_tables.html#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li>
                                    <a href="{{ url('/Admin/Attribute/addCategory',[],config('crucis.http_secure')) }}"><i class="fa fa-plus"></i> 新增</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>属性分类</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list as $item)
                                <tr>
                                    <td class="center">{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <a class="btn btn-success" href="{{ url('/Admin/Attribute/attributeList',['id'=>$item->id],config('crucis.http_secure')) }}"><i class="fa fa-barss"></i> 查看属性</a>
                                        <a class="btn btn-info" href="{{ url('/Admin/Attribute/editCategory',['id'=>$item->id],config('crucis.http_secure')) }}"><i class="fa fa-edit"></i> 编辑</a>
                                        <a class="btn btn-danger" onclick="delete_attribute_category({{ $item->id }})"><i class="fa fa-trash"></i> 删除</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>属性分类</th>
                                <th>操作</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        function delete_attribute_category(id)
        {
            swal({
                title: "您确定要删除这条信息吗",
                text: "删除后将无法恢复，请谨慎操作！",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "删除",
                cancelButtonText: "取消",
                closeOnConfirm: false
            }, function () {
                var URL = '{{ url('Admin/Attribute/deleteAttributeCategory',[],config('crucis.http_secure')) }}';
                var data = {_method:"DELETE",id:id};
                $.post(URL, data, function (result) {
                    if (result.status == 200)
                    {
                        swal("删除成功！", result.message, "success");
                    }else {
                        swal("删除失败！", result.message, "error");
                    }
                });
            })
        }
    </script>
@endsection
