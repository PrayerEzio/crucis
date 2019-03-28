@extends('Admin.main')

@section('body')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            @foreach($admin_list as $key => $admin)
                <div class="col-sm-4">
                    <div class="contact-box">
                        <a href="{{ url('Admin/Auth/admin_show',['id'=>$admin->id],config('crucis.http_secure')) }}">
                            <div class="col-sm-4">
                                <div class="text-center">
                                    <img alt="image" class="img-circle m-t-xs img-responsive" src="{{ $admin->avatar }}">
                                    <div class="m-t-xs font-bold">{{ $admin->position }}</div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <h3><strong>{{ $admin->nickname }}</strong></h3>
                                {{--<p><i class="fa fa-map-marker"></i> 上海市闵行区绿地科技岛广场A座2606室</p>--}}
                                <address>
                                    {{--<strong>Baidu, Inc.</strong><br>--}}
                                    E-mail:{{ $admin->email or '未填写' }}<br>
                                    Website:<a href="">{{ $admin->website or '未填写' }}</a><br>
                                    <abbr title="Phone">Tel:</abbr> {{ $admin->mobile or '未填写' }}
                                </address>
                            </div>
                            <div class="clearfix"></div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center link-block">{{ $admin_list->links() }}</div>
    </div>
@endsection
@section('javascript')
    <script>
        $(document).ready(function(){$(".contact-box").each(function(){animationHover(this,"pulse")})});
    </script>
@endsection