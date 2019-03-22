<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Crucis 后台主题UI框架 - 登录</title>
    <meta name="keywords" content="Crucis后台主题,后台bootstrap框架,会员中心主题,后台HTML,响应式后台">
    <meta name="description" content="Crucis是一个完全响应式，基于Bootstrap3最新版本开发的扁平化主题，她采用了主流的左右两栏式布局，使用了Html5+CSS3等现代技术">
    <link href="{{ asset('assets/Admin',config('crucis.http_secure')) }}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets/Admin',config('crucis.http_secure')) }}/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="{{ asset('assets/Admin',config('crucis.http_secure')) }}/css/animate.min.css" rel="stylesheet">
    <link href="{{ asset('assets/Admin',config('crucis.http_secure')) }}/css/style.css" rel="stylesheet">
    <link href="{{ asset('assets/Admin',config('crucis.http_secure')) }}/css/login.css" rel="stylesheet">
    <!--[if lt IE 8]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <script>
        if(window.top!==window.self){window.top.location=window.location};
    </script>
    <base target="_self">
</head>
<body class="signin">
    <div class="signinpanel">
        <div class="row">
            <div class="col-sm-7">
                <div class="signin-info">
                    <div class="logopanel m-b">
                        <h1>[ Crucis ]</h1>
                    </div>
                    <div class="m-b"></div>
                    <h4>欢迎使用 <strong>Crucis 管理后台</strong></h4>
                    <ul class="m-b">
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势一</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势二</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势三</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势四</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势五</li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-5">
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
                <form method="post" action="">
                    <h4 class="no-margins">登录：</h4>
                    <p class="m-t-md">登录到Crucis 管理后台</p>
                    {{ csrf_field() }}
                    <input type="text" class="form-control uname" placeholder="用户名" name="email"/>
                    <input type="password" class="form-control pword m-b" placeholder="密码" name="password"/>
                    <a href="">忘记密码了？</a>
                    <button class="btn btn-success btn-block">登录</button>
                </form>
            </div>
        </div>
        <div class="signup-footer">
            <div class="pull-left">
                &copy; 2015 All Rights Reserved. Crucis
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(document).ready(function(){$(".i-checks").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",})});
    </script>
</body>
</html>