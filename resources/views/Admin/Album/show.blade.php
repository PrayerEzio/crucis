@extends('Admin.main')
@section('title', "相册-Sramer")
@section('css')
    <link href="{{ asset('assets/Admin',config('crucis.http_secure')) }}/css/plugins/blueimp/css/blueimp-gallery.min.css" rel="stylesheet">
    <style>
        .lightBoxGallery img {
            margin: 5px;
            width: 160px;
        }
    </style>
@endsection()
@section('body')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{ $data->name }}</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="typography.html#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="{{ url('Admin/AlbumPicture/create',[],config('crucis.http_secure')) }}">新增相片</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="lightBoxGallery">
                                    @foreach($data->picture as $item)
                                        {{--<a href="{{ $item->picture }}" title="{{ $item->title }}" data-gallery=""><img src="{{ $item->picture }}"></a>--}}
                                        <div class="file-box" id="item_{{ $item->id }}">
                                            <div class="file">
                                                <span class="corner"></span>
                                                <div class="image" style="background-color: #4d4d4d">
                                                    <a href="{{ $item->picture }}" title="{{ $item->title }}" data-gallery="">
                                                        <img alt="image" class="img-responsive text-center" src="{{ $item->picture }}" style="height: 100px;width: auto;margin: 0 auto">
                                                    </a>
                                                </div>
                                                <div class="file-name">
                                                    <div class="text-center">{{ $item->title }}</div>
                                                    <small>创建时间：{{ $item->created_at }}</small>
                                                    <div class="hr-line-dashed-10"></div>
                                                    <div class="small text-center">
                                                        <button class="btn btn-info btn-xs" onclick="window.location.href='{{ url("/Admin/AlbumPicture/{$item->id}/edit",[],config('crucis.http_secure')) }}'"><i class="fa fa-edit"></i> 编辑</button>
                                                        <button class="btn btn-danger btn-xs" onclick="delete_picture({{ $item->id }})"><i class="fa fa-trash"></i> 删除</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div id="blueimp-gallery" class="blueimp-gallery">
                                <div class="slides"></div>
                                <h3 class="title"></h3>
                                <a class="prev">‹</a>
                                <a class="next">›</a>
                                <a class="close">×</a>
                                <a class="play-pause"></a>
                                <ol class="indicator"></ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
    <script>
        function delete_picture(id)
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
                var URL = '{{ url('Admin/AlbumPicture',[],config('crucis.http_secure')) }}/'+id;
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