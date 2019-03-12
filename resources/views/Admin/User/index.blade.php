@extends('Admin.main')
@section('title', "首页-Sramer")
@section('body')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>会员列表
                            <small></small>
                        </h5>
                        <div class="ibox-tools">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="table_data_tables.html#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li>
                                    <a href="{{ url('/Admin/User/create',[],config('crucis.http_secure')) }}"><i class="fa fa-plus"></i> 新增</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>昵称</th>
                                <th>手机</th>
                                <th>余额</th>
                                <th>积分</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list as $item)
                                <tr id="item_{{ $item->id }}">
                                    <td class="center">{{ $item->id }}</td>
                                    <td>{{ $item->nickname or '' }}</td>
                                    <td>{{ $item->phone or '' }}</td>
                                    <td>{{ $item->balance }}</td>
                                    <td>{{ $item->point }}</td>
                                    <td>{{ $item->status == 1 ? '正常' : '冻结' }}</td>
                                    <td>
                                        <a class="btn btn-info" href="{{ url("/Admin/User/{$item->id}/edit",[],config('crucis.http_secure')) }}"><i class="fa fa-edit"></i> 编辑</a>
                                        <a class="btn btn-danger" onclick="delete_user({{ $item->id }})"><i class="fa fa-trash"></i> 删除</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>昵称</th>
                                <th>邮箱</th>
                                <th>手机</th>
                                <th>余额</th>
                                <th>状态</th>
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
        function delete_user(id)
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
                var URL = '{{ url('Admin/User',[],config('crucis.http_secure')) }}/'+id;
                var data = {_method:"DELETE",id:id};
                $.post(URL, data, function (result) {
                    if (result.status == 200)
                    {
                        $("#item_"+id).remove();
                        swal("删除成功！", result.message, "success");
                    }else {
                        swal("删除失败！", result.message, "error");
                    }
                });
            })
        }
    </script>
@endsection