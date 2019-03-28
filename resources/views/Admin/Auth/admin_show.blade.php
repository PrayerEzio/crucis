@extends('Admin.main')
@section('seo_title', "管理员列表")
@section('body')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>编辑管理员资料</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="post" action="{{ url('Admin/Auth/admin_store',['id'=>$admin_info->id],config('crucis.http_secure')) }}" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-sm-2 control-label">头像</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="avatar" value="{{ $admin_info->avatar }}">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">昵称</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="请输入昵称" name="nickname" value="{{ $admin_info->nickname }}">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">邮箱</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="请输入邮箱地址" name="email" value="{{ $admin_info->email }}">
                                    {{--<span class="help-block m-b-none">帮助文本，可能会超过一行，以块级元素显示</span>--}}
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">密码</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" placeholder="请输入密码" name="password" value="">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">职位头衔</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="请输入职位头衔" name="position" value="{{ $admin_info->position }}">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">管理组</label>
                                <div class="col-sm-10">
                                    @foreach($role_list as $item)
                                        <label class="checkbox-inline i-checks">
                                            <input type="checkbox" class="role" name="role[]" value="{{ $item->name }}" @isset($admin_info) @if($admin_info->hasRole($item->name)) checked @endif @endisset>{{ $item->display_name }}</label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">状态</label>
                                <div class="col-sm-10">
                                    <input type="checkbox" id="status" name="status" {{ $admin_info->status == 1 ? 'checked' : ''}}/>
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