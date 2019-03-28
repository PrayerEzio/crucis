@extends('Admin.main')
@section('seo_title', "管理组列表")
@section('body')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            @foreach($role_list as $role)
                <div class="col-sm-4">
                    <div class="ibox">
                        <div class="ibox-title">
                        <span class="pull-right">
                            <a href="{{ url('Admin/Auth/role_edit',['id'=>$role->id],config('crucis.http_secure')) }}"><i class="fa fa-edit"></i> 编辑</a>
                            <a href="javascript:delete_role({{ $role->id }});"><i class="fa fa-trash"></i> 删除</a>
                        </span>
                            <h5>{{ $role->display_name }}</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="team-members">
                                {{--@foreach($role->role_admin_list as $admin)
                                    <a href="#"><img alt="member" class="img-circle" src="{{ $admin->avatar }}"></a>
                                @endforeach--}}
                            </div>
                            <h4>部门简介</h4>
                            <p>
                                {{ $role->description }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        function delete_role(id)
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
                var URL = '{{ url('Admin/Auth/role_delete',[],config('crucis.http_secure')) }}';
                var data = {_method:"DELETE",id:id};
                $.post(URL, data, function (result) {
                    if (result.status == 200)
                    {
                        swal("删除成功！", result.message, "success");
                        window.location.reload();
                    }else {
                        swal("删除失败！", result.message, "error");
                    }
                });
            })
        }
    </script>
@endsection