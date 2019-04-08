<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('seo_title','Crucis管理后台')</title>
    <meta name="keywords" content="@yield('seo_keywords','Crucis后台管理系统,后台管理系统')">
    <meta name="description" content="@yield('seo_description','Crucis是一个简洁优雅的后台管理系统')">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('assets/Admin',config('crucis.http_secure')) }}/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link href="{{ asset('assets/Admin',config('crucis.http_secure')) }}/css/animate.min.css" rel="stylesheet">
    <link href="{{ asset('assets/Admin',config('crucis.http_secure')) }}/css/style.min.css" rel="stylesheet">
    <!-- Data Tables -->
    <link href="{{ asset('assets/Admin',config('crucis.http_secure')) }}/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="{{ asset('assets/Admin',config('crucis.http_secure')) }}/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <!-- toastr Alert -->
    <link href="{{ asset('assets/Admin',config('crucis.http_secure')) }}/css/plugins/toastr/toastr.min.css" rel="stylesheet">
    <link href="{{ asset('assets/Admin',config('crucis.http_secure')) }}/css/plugins/switchery/switchery.css" rel="stylesheet">
    <link href="{{ asset('assets/Admin',config('crucis.http_secure')) }}/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="{{ asset('assets/Vendor',config('crucis.http_secure')) }}/layui/css/layui.css" rel="stylesheet">
    <base target="_self">
    @yield('css')
</head>
<body class="gray-bg">
    @yield('body')
</body>
<script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/jquery.min.js"></script>
<script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/bootstrap.min.js"></script>
<script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/content.min.js?v=1.0.0"></script>
<script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/jeditable/jquery.jeditable.js"></script>
<script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/toastr/toastr.min.js"></script>
<script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/sweetalert/sweetalert.min.js"></script>
<script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/prettyfile/bootstrap-prettyfile.js" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/iCheck/icheck.min.js"></script>
<script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/switchery/switchery.js"></script>
<script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/cropper/cropper.min.js"></script>
<script src="{{ asset('assets/Vendor',config('crucis.http_secure')) }}/layui/layui.js"></script>
<script>
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
</script>
<script type="text/javascript">
    $(function(){
        var shortCutFunction = '{{ session('alert.0') }}';
        var title = '{{ session('alert.1') }}';
        var msg = '{{ session('alert.2') }}';
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "progressBar": true,
            "positionClass": "toast-top-center",
            "onclick": null,
            "showDuration": "400",
            "hideDuration": "1000",
            "timeOut": "7000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        if (shortCutFunction !== '')
        {
            toastr[shortCutFunction](msg,title);
        }
    });
</script>
<script>
    $(document).ready(function(){$(".dataTables-example").dataTable()});
</script>
<script>
    $( 'input[type="file"]' ).prettyFile();
</script>
<script>
    $(document).ready(function () {
        $(".i-checks").iCheck({checkboxClass: "icheckbox_square-green", radioClass: "iradio_square-green",});
        initSwitchery("status","#1AB394");
    });
    function initSwitchery(id,color)
    {
        var i = document.querySelector("#"+id), t = (new Switchery(i, {color: color}));
    }
</script>
@yield('javascript')
</html>