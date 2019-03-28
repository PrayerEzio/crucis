@extends('Admin.main')
@section('seo_title', "相册")
@section('body')
    <div class="wrapper wrapper-content animated fadeInRight blog">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{ isset($data->id) ? '编辑' : '新增' }}相片 <small></small></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form method="POST"
                              action="{{ isset($data->id) ? url('Admin/AlbumPicture',['id'=>$data->id],config('crucis.http_secure')) : url('Admin/AlbumPicture',[],config('crucis.http_secure')) }}"
                              class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="{{ isset($data->id) ? 'PUT' : 'POST' }}">
                            <input type="hidden" name="id" value="{{ $data->id or 0 }}">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">所属相册</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="album_id" id="album_id">
                                        <option value="">请选择</option>
                                        @foreach ($albums_list as $album)
                                            <option value="{{ $album->id }}">{{ $album->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">相片标题</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="title" value="{{ $data->title or '' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">相片副标题</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="sub_title" value="{{ $data->sub_title or '' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">相片</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="picture">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary" type="submit">保存内容</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        $(window).load(function(){
            $("#album_id").val({{ $data->album_id or '' }});
        });
    </script>
@endsection