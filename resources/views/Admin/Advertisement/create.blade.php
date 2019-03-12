@extends('Admin.main')
@section('title', "首页-Sramer")
@section('css')
@endsection()
@section('body')
    <div class="wrapper wrapper-content  animated fadeInRight blog">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{ isset($data->id) ? '编辑' : '新增' }}广告 <small></small></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form method="POST" action="{{ isset($data->id) ? url('Admin/Advertisement',['id'=>$data->id],config('crucis.http_secure') : url('Admin/Advertisement',[],config('crucis.http_secure')) }}" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ isset($data->id) ? method_field('PUT') : '' }}
                            <div class="form-group">
                                <label class="col-sm-2 control-label">广告位</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="position">
                                        <option value="banner">首页banner</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">标题</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="title" value="{{ $data->title or '' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">副标题</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="sub_title" value="{{ $data->sub_title or '' }}"> <span class="help-block m-b-none"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">跳转链接</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="url" value="{{ $data->url or '' }}"> <span class="help-block m-b-none"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">图片</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="image" value="{{ $data->image or '' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">排序</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="sort" value="{{ $data->sort or 0 }}"> <span class="help-block m-b-none"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">状态</label>
                                <div class="col-sm-10">
                                    <div class="col-sm-10">
                                        <input type="checkbox" id="status" name="status"
                                        @if(isset($data->status))
                                            @if($data->status == 1)
                                                checked
                                            @endif
                                        @endif
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary" type="submit">保存</button>
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
@endsection