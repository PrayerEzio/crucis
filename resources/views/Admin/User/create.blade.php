@extends('Admin.main')
@section('title', "首页-Sramer")
@section('body')
    <div class="wrapper wrapper-content animated fadeInRight blog">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{ isset($data->id) ? '编辑' : '新增' }}会员 <small></small></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form method="POST" action="{{ isset($data->id) ? url('Admin/User',['id'=>$data->id],config('crucis.http_secure') : url('Admin/User',[],config('crucis.http_secure')) }}" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="{{ isset($data->id) ? 'PUT' : 'POST' }}">
                            <input type="hidden" name="id" value="{{ $data->id or 0 }}">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">昵称</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nickname" value="{{ $data->nickname or '' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">头像</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="avatar">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">邮箱</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="email" value="{{ $data->email or '' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">手机</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="phone" value="{{ $data->phone or '' }}">
                                </div>
                            </div>
                            {{--<div class="form-group">
                                <label class="col-sm-2 control-label">店铺名称</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="store_name" value="{{ $data->store_name or '' }}">
                                </div>
                            </div>--}}
                            <div class="form-group">
                                <label class="col-sm-2 control-label">余额</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="balance" value="{{ $data->balance or '' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">积分</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="point" value="{{ $data->point or '' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">密码</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="password" value="{{ $data->passwrod or '' }}">
                                </div>
                            </div>
                            @isset($data->address)
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">地址列表</label>
                                    <div class="col-sm-10">
                                        <div id="address_list">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>姓名</th>
                                                    <th>手机</th>
                                                    <th>省份</th>
                                                    <th>城市</th>
                                                    <th>区/县</th>
                                                    <th>地址</th>
                                                    <th>标签</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($data->address as $key => $address)
                                                    <tr>
                                                        <td>{{ $address->name }}</td>
                                                        <td>{{ $address->phone }}</td>
                                                        <td>{{ $address->province }}</td>
                                                        <td>{{ $address->city }}</td>
                                                        <td>{{ $address->district }}</td>
                                                        <td>{{ $address->address }}</td>
                                                        <td>{{ $address->tag }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                            @endisset
                            <div class="form-group">
                                <label class="col-sm-2 control-label">状态</label>
                                <div class="col-sm-10">
                                    <div class="col-sm-10">
                                        <input type="checkbox" id="status" name="status"
                                        @if(isset($data->status))
                                            @if($data->status == 1)
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