@extends('Admin.main')
@section('title', "首页-Sramer")
@section('body')
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name">Crucis</h1>
            </div>
            <h3>欢迎注册 Crucis</h3>
            <p>创建一个Crucis新账户</p>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @if(is_object($errors))
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        @elseif(is_array($errors))
                            @foreach ($errors as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        @else
                            <li>{{ $errors }}</li>
                        @endif
                    </ul>
                </div>
            @endif
            <form class="m-t" role="form" method="post" action="">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="请输入邮箱" required="true" name="email">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="请输入密码" required="true" name="password">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="请再次输入密码" required="true" name="password_confirmation">
                </div>
                <div class="form-group text-left">
                    <div class="checkbox i-checks">
                        <label class="no-padding">
                            <input type="checkbox" required="true" name="register_protocol"><i></i> 我同意注册协议</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">注 册</button>
                <p class="text-muted text-center"><small>已经有账户了？</small><a href="{{ url('Admin/Login/index',[],config('crucis.http_secure')) }}">点此登录</a>
                </p>
            </form>
        </div>
    </div>
@endsection