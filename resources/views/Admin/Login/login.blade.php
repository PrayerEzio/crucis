<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Crucis后台管理系统</title>
    <meta name="keywords" content="Crucis后台管理系统">
    <meta name="description" content="Crucis是一个简洁优雅的后台管理系统">
    <link href="{{ asset('assets/Admin',config('crucis.http_secure')) }}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets/Admin',config('crucis.http_secure')) }}/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="{{ asset('assets/Admin',config('crucis.http_secure')) }}/css/animate.min.css" rel="stylesheet">
    <link href="{{ asset('assets/Admin',config('crucis.http_secure')) }}/css/style.css" rel="stylesheet">
    <link href="{{ asset('assets/Admin',config('crucis.http_secure')) }}/css/login.css" rel="stylesheet">
    <script src="https://ssl.captcha.qq.com/TCaptcha.js"></script>
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
                    {{--<ul class="m-b">
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势一</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势二</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势三</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势四</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势五</li>
                    </ul>--}}
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
                <form method="post" action="" id="loginForm">
                    <h4 class="no-margins">登录：</h4>
                    <p class="m-t-md">登录到 <strong>Crucis</strong> 管理后台</p>
                    {{ csrf_field() }}
                    <input type="text" class="form-control uname" placeholder="用户名" name="email"/>
                    <input type="password" class="form-control pword m-b" placeholder="密码" name="password"/>
                    <input type="hidden" name="ticket" id="ticket"/>
                    <input type="hidden" name="randstr" id="randstr"/>
                    {{--<a href="">忘记密码了？</a>--}}
                    <div class="btn btn-success btn-block"
                         id="TencentCaptcha"
                         data-appid="2056888306"
                         data-cbfn="callback"
                    >登录
                    </div>
                </form>
            </div>
        </div>
        <div class="signup-footer">
            <div class="pull-left">
                &copy; {{ date('Y',time()) }} All Rights Reserved. Crucis
            </div>
        </div>
    </div>
</body>
<script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/jquery.min.js"></script>
<script>
    window.callback = function (res) {
        // res（用户主动关闭验证码）= {ret: 2, ticket: null}
        // res（验证成功） = {ret: 0, ticket: "String", randstr: "String"}
        if (res.ret === 0) {
            $("#ticket").val(res.ticket);
            $("#randstr").val(res.randstr);
            $("#loginForm").submit();
        }
    }
</script>
</html>