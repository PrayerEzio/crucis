@extends('Admin.main')
@section('seo_title', "相册")
@section('body')
    <div class="wrapper wrapper-content animated fadeInRight blog">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{ isset($data->id) ? '编辑' : '新增' }}相册 <small></small></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form method="POST"
                              action="{{ isset($data->id) ? url('Admin/Album',['id'=>$data->id],config('crucis.http_secure')) : url('Admin/Album',[],config('crucis.http_secure')) }}"
                              class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="{{ isset($data->id) ? 'PUT' : 'POST' }}">
                            <input type="hidden" name="id" value="{{ $data->id or 0 }}">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">相册名称</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" value="{{ $data->name or '' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">封面图</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="image">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">排序</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="sort" value="{{ $data->sort or 0 }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">状态</label>
                                <div class="col-sm-10">
                                    <div class="col-sm-10">
                                        <input type="checkbox" id="status" name="status"
                                        @if(isset($data->is_private))
                                            @if($data->is_private == 0)
                                               checked
                                            @endif
                                        @else
                                           checked
                                        @endif
                                        >
                                    </div>
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