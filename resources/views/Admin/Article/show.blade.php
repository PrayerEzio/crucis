@extends('Admin.main')
@section('title', "首页-Sramer")
@section('body')
    <div class="wrapper wrapper-content  animated fadeInRight article">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="pull-right">
                            @foreach($article['tag'] as $tag)
                                <button class="btn btn-white btn-xs" type="button">{{ $tag }}</button>
                            @endforeach
                        </div>
                        <div class="text-center article-title">
                            <h1>
                                {{ $article->title }}
                            </h1>
                        </div>
                        <p>
                            {!! $article->body !!}
                        </p>
                        <hr>
                        {{--<div class="row">
                            <div class="col-lg-12">
                                <h2>评论：</h2>
                                @foreach($article->comments as $comment)
                                <div class="social-feed-box">
                                    <div class="social-avatar">
                                        <a href="" class="pull-left">
                                            <img alt="image" src="img/a1.jpg">
                                        </a>
                                        <div class="media-body">
                                            <a href="#">
                                                    逆光狂胜蔡舞娘
                                                </a>
                                            <small class="text-muted">17 小时前</small>
                                        </div>
                                    </div>
                                    <div class="social-body">
                                        <p>
                                            好东西，我朝淘宝准备跟进，1折开卖
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection