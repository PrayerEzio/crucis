@extends('Admin.main')
@section('title', "首页-Sramer")
@section('css')
    <link href="{{ asset('assets/Admin',config('crucis.http_secure')) }}/css/plugins/blueimp/css/blueimp-gallery.min.css" rel="stylesheet">
    <style>
        .lightBoxGallery img {
            margin: 5px;
            width: 160px;
        }
    </style>
@endsection()
@section('body')
    <div class="wrapper wrapper-content  animated fadeInRight blog">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>反馈意见<small></small></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form method="POST"
                              action="{{ isset($data->id) ? url('Admin/Feedback',['id'=>$data->id],config('crucis.http_secure')) : url('Admin/Feedback',[],config('crucis.http_secure')) }}"
                              class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ isset($data->id) ? method_field('PUT') : '' }}
                            <div class="form-group">
                                <label class="col-sm-2 control-label">用户</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="{{ $data->user->nickname }} [{{ $data->user->id }}]" disabled="disabled">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">内容</label>
                                <div class="col-sm-10">
                                    {{ $data->content }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">图片</label>
                                <div class="col-sm-10">
                                    <div class="lightBoxGallery">
                                    @foreach($data->pictures as $item)
                                        <div class="file-box" id="item_{{ $item->id }}">
                                            <div class="file">
                                                <span class="corner"></span>
                                                <div class="image" style="background-color: #4d4d4d">
                                                    <a href="{{ $item->url }}" data-gallery="">
                                                        <img alt="image" class="img-responsive text-center" src="{{ $item->url }}" style="height: 100px;width: auto;margin: 0 auto">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                            {{--<div class="form-group">
                                <label class="col-sm-2 control-label">状态</label>
                                <div class="col-sm-10">
                                    <div class="col-sm-10">
                                        <input type="checkbox" id="status" name="status"
                                        @if(isset($data->status))
                                            @if($data->status == 1)
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
                            </div>--}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="blueimp-gallery" class="blueimp-gallery">
        <div class="slides"></div>
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
    </div>
@endsection
@section('javascript')
    <script src="{{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
@endsection