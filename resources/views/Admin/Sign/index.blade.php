@extends('Admin.main')
@section('title', "首页-Sramer")
@section('css')
    <link href="{{ asset('assets/Admin',config('crucis.http_secure')) }}/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
@endsection
@section('body')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>每日签到列表
                            <small></small>
                        </h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>星期</th>
                                    <th>图片</th>
                                    <th>金币奖励</th>
                                    <th>积分奖励</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($list as $item)
                                        <tr>
                                            <td class="center">{{ $item->id }}</td>
                                            <td>
                                                <div class="image">
                                                    <img alt="image" style="height: 40px" class="img-responsive" src="{{ $item->image }}">
                                                </div>
                                            </td>
                                            <td>{{ $item->balance }}</td>
                                            <td>{{ $item->point }}</td>
                                            <td>
                                                <a class="btn btn-info" href="{{ url("/Admin/Sign/{$item->id}/edit",[],config('crucis.http_secure')) }}"><i class="fa fa-edit"></i> 编辑</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="dataTables_paginate paging_simple_numbers" id="editable_paginate">
                                {{ $list->appends($input)->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
@endsection