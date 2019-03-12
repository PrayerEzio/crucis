@extends('Admin.main')
@section('title', "首页-Sramer")
@section('body')
    <div class="wrapper wrapper-content  animated fadeInRight blog">
        <div class="row">
            @foreach($article_list as $article)
                @if ($loop->index%3 == 0)
                    <div class="col-lg-4">
                        @endif
                        <div class="ibox">
                            <div class="ibox-content">
                                <a href="{{ url('/Admin/Article/edit',['id'=>$article->id],config('crucis.http_secure')) }}" class="btn-link">
                                    <h2>
                                        {{ $article->title }}
                                    </h2>
                                </a>
                                <div class="small m-b-xs">
                                    <strong>{{ $article->author }}</strong> <span class="text-muted"><i class="fa fa-clock-o"></i> {{ $article->created_at->diffForHumans() }}</span>
                                </div>
                                <p>
                                    {{ $article->description }}
                                </p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>标签：</h5>
                                        @foreach($article->tag as $tag)
                                            <button class="btn btn-white btn-xs" type="button">{{ $tag }}</button>
                                        @endforeach
                                    </div>
                                    <div class="col-md-6">
                                        <div class="small text-right">
                                            <h5>操作：</h5>
                                            <a class="btn btn-info btn-xs" href="{{ url('/Admin/Article/edit',['id'=>$article->id],config('crucis.http_secure')) }}"><i class="fa fa-edit"></i> 编辑</a>
                                            <a class="btn btn-danger btn-xs" onclick="delete_article({{ $article->id }})"><i class="fa fa-trash"></i> 删除</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($loop->index%3 == 2)
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    <div class="dataTables_paginate paging_simple_numbers" id="editable_paginate">
        {{ $article_list->links() }}
    </div>
@endsection
@section('javascript')
    <script>
        function delete_article(id)
        {
            swal({
                title: "您确定要删除这条信息吗",
                text: "删除后将无法恢复，请谨慎操作！",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "删除",
                cancelButtonText: "取消",
                closeOnConfirm: false
            }, function () {
                var URL = '{{ url('Admin/Article/delete',[],config('crucis.http_secure')) }}';
                var data = {_method:"DELETE",id:id};
                $.post(URL, data, function (result) {
                    if (result.status == 200)
                    {
                        swal("删除成功！", result.message, "success");
                    }else {
                        swal("删除失败！", result.message, "error");
                    }
                });
            })
        }
    </script>
@endsection