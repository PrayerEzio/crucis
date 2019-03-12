@extends('Admin.main')
@section('title', "相册-Sramer")
@section('body')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12 animated fadeInRight">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>相册列表</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="typography.html#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="{{ url('Admin/Album/create',[],config('crucis.http_secure')) }}">创建相册</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="lightBoxGallery">
                                    @foreach($list as $item)
                                        <div class="file-box" id="item_{{ $item->id }}">
                                            <div class="file">
                                                <a href="{{ url("/Admin/Album/{$item->id}",[],config('crucis.http_secure')) }}">
                                                    <span class="corner"></span>
                                                    <div class="image" style="background-color: #4d4d4d">
                                                        <img alt="image" class="img-responsive text-center" src="{{ $item->image }}" style="height: 100px;width: auto;margin: 0 auto">
                                                    </div>
                                                    <div class="file-name">
                                                        <div class="text-center">{{ $item->name }}</div>
                                                        <small>所有者：{{ $item->admin->nickname }}</small>
                                                        <br/>
                                                        <small>创建时间：{{ $item->created_at }}</small>
                                                        <div class="hr-line-dashed-10"></div>
                                                        <div class="small text-center">
                                                            <a class="btn btn-info btn-xs" href="{{ url("/Admin/Album/{$item->id}/edit",[],config('crucis.http_secure')) }}"><i class="fa fa-edit"></i> 编辑</a>
                                                            <a class="btn btn-danger btn-xs" onclick="delete_album({{ $item->id }})"><i class="fa fa-trash"></i> 删除</a>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        function delete_album(id)
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
                var URL = '{{ url('Admin/Album',[],config('crucis.http_secure')) }}/'+id;
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