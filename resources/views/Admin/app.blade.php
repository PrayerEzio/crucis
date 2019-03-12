<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>Crucis后台管理系统</title>
    <meta name="keywords" content="Crucis后台,管理系统,后台管理系统">
    <meta name="description" content="Crucis后台管理系统">
    <!--[if lt IE 8]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <![endif]-->
    <link rel="shortcut icon" href="favicon.ico">
    <link href="{{ asset('assets/Admin',config('crucis.http_secure')) }}/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link href="{{ asset('assets/Admin',config('crucis.http_secure')) }}/css/animate.min.css" rel="stylesheet">
    <link href="{{ asset('assets/Admin',config('crucis.http_secure')) }}/css/style.min.css" rel="stylesheet">
</head>
<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
    <div type="hidden" class="default-value"></div>
    <input type="hidden" id="token" value="{{ session('_token') }}">
    <div id="wrapper">
        @include('Admin._layout.leftNav')
        <!--右侧部分开始-->
        <div id="page-wrapper" class="gray-bg dashbard-1">
            @include('Admin._layout.rightTop')
            <div class="row J_mainContent" id="content-main">
                <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="{{ url('Admin/Index/about_us',[],config('crucis.http_secure')) }}" frameborder="0" data-id="{{ url('Admin/Index/about_us',[],config('crucis.http_secure')) }}" seamless></iframe>
            </div>
            @include('Admin._layout.footer')
        </div>
        <!--右侧部分结束-->
        @include('Admin._layout.rightSidebar')
        {{--@include('Admin._layout.miniChat')--}}
    </div>
</body>
<script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/jquery.min.js?v=2.1.4"></script>
<script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/bootstrap.min.js?v=3.3.5"></script>
<script src=" {{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src=" {{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src=" {{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/layer/layer.min.js"></script>
<script src=" {{ asset('assets/Admin',config('crucis.http_secure')) }}/js/hplus.min.js?v=4.0.0"></script>
<script src=" {{ asset('assets/Admin',config('crucis.http_secure')) }}/js/contabs.min.js"></script>
<script src=" {{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/pace/pace.min.js"></script>
<script>
    $('.default-value').data('room-id',1);
    $('.default-value').data('user-id',{{ session('admin_info.id') }});
</script>
<script>
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
</script>
@yield('javascript')
</html>