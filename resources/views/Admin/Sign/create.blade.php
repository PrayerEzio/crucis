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
                        <h5>{{ isset($data->id) ? '编辑' : '新增' }}签到 <small></small></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form method="POST"
                              action="{{ isset($data->id) ? url('Admin/Sign',['id'=>$data->id],config('crucis.http_secure')) : url('Admin/Sign',[],config('crucis.http_secure')) }}"
                              class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ isset($data->id) ? method_field('PUT') : '' }}
                            <div class="form-group">
                                <label class="col-sm-2 control-label">图片</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="image" value="{{ $data->image or '' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">金币奖励</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="balance" value="{{ $data->balance or 0 }}"> <span class="help-block m-b-none"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">积分奖励</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="point" value="{{ $data->point or 0 }}"> <span class="help-block m-b-none"></span>
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