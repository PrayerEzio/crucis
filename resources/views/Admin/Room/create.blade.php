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
                        <h5>{{ isset($data->id) ? '编辑' : '新增' }}房间 <small></small></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form method="POST" action="{{ isset($data->id) ? url('Admin/Room',['id'=>$data->id],config('crucis.http_secure') : url('Admin/Room',[],config('crucis.http_secure')) }}" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ isset($data->id) ? method_field('PUT') : '' }}
                            <div class="form-group">
                                <label class="col-sm-2 control-label">房间编号</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="id" value="{{ $data->id or '' }}" disabled="disabled"> <span class="help-block m-b-none"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">房间标题</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="title" value="{{ $data->title or '' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">房间图片</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="cover" value="{{ $data->cover or '' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">背景音乐</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="music" value="{{ $data->music or '' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">摄像头编号</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="camera" value="{{ $data->camera or '' }}" disabled="disabled"> <span class="help-block m-b-none"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">推流地址</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="pull_url" value="{{ $data->pull_url or '' }}" disabled="disabled"> <span class="help-block m-b-none"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">websocket服务器地址</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="ws_server_url" value="{{ $data->ws_server_url or '' }}" disabled="disabled"> <span class="help-block m-b-none"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">sdk类型</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="sdk_type" value="{{ $data->sdk_type or '' }}" disabled="disabled"> <span class="help-block m-b-none"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">sip地址</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="sip_addr" value="{{ $data->sip_addr or '' }}" disabled="disabled"> <span class="help-block m-b-none"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">ssrc</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="ssrc" value="{{ $data->ssrc or '' }}" disabled="disabled"> <span class="help-block m-b-none"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">时间限制</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="time_limit" value="{{ $data->time_limit or '' }}" disabled="disabled"> <span class="help-block m-b-none"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">状态</label>
                                <div class="col-sm-10">
                                    <div class="col-sm-10">
                                        <input type="checkbox" id="status" name="status"
                                        @if(isset($data->is_mainten))
                                            @if($data->is_mainten == 0)
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