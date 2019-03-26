@extends('Admin.main')
@section('title', "首页-Sramer")
@section('css')
    <link href=" {{ asset('assets/Admin',config('crucis.http_secure')) }}/css/plugins/jsTree/style.min.css" rel="stylesheet">
@endsection
@section('body')
    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>产品分类 <small></small></h5>
                    <div class="ibox-tools">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="table_data_tables.html#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li>
                                <a href="{{ url('Admin/Goods/addCategory',[],config('crucis.http_secure')) }}"><i
                                            class="fa fa-plus"></i> 新增</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="ibox-content">
                    <div id="jstree1">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src=" {{ asset('assets/Admin',config('crucis.http_secure')) }}/js/plugins/jsTree/jstree.min.js"></script>
    <script>
        $(document).ready(
            getGoodsCategoryList()
        );
        $('#jstree1').on('changed.jstree', function (e, data) {
            var i, j, r = [];
            for(i = 0, j = data.selected.length; i < j; i++) {
                r.push(data.instance.get_node(data.selected[i]).text);
            }
        });
        function getGoodsCategoryList() {
            var URL = '{{ url('Ajax/getGoodsCategoryList',[],config('crucis.http_secure')) }}';
            var data = {};
            $.post(URL, data, function (result) {
                if (result.status == 200) {
                    for(item in result.data)
                    {
                        if (result.data[item]['parent_id'] == 0)
                        {
                            result.data[item]['parent'] = '#';
                        }else {
                            result.data[item]['parent'] = result.data[item]['parent_id'];
                        }
                        result.data[item]['text'] = result.data[item]['name'];
                        result.data[item]['state'] = {
                            opened    : true  // is the node open
                        };
                    }
                    $("#jstree1").jstree({ 'core' : {
                            'data' : result.data,
                            "check_callback" : true
                        },
                        "plugins" : ["contextmenu"],
                        "contextmenu":{
                            "items":{
                                "create":null,
                                "rename":null,
                                "remove":null,
                                "ccp":null,
                                "新建分类":{
                                    "label":"新建分类",
                                    "icon" :"fa fa-plus",
                                    "action":function(data){
                                        var inst = jQuery.jstree.reference(data.reference),
                                            obj = inst.get_node(data.reference);
                                        window.location.href='/Admin/Goods/addCategory/'+obj.id;
                                    }
                                },
                                "删除菜单":{
                                    "label":"删除菜单",
                                    "icon" :"fa fa-trash",
                                    "action":function(data){
                                        var inst = jQuery.jstree.reference(data.reference),
                                            obj = inst.get_node(data.reference);
                                        delete_cate(obj.id);
                                    }
                                },
                                "编辑菜单":{
                                    "label":"编辑菜单",
                                    "icon" :"fa fa-edit",
                                    "action":function(data){
                                        var inst = jQuery.jstree.reference(data.reference),
                                            obj = inst.get_node(data.reference);
                                        window.location.href='/Admin/Goods/editCategory/'+obj.id;
                                    }
                                }

                            }
                        },
                    });
                } else {
                    return false;
                }
            }, 'json');
        }
    </script>
    <script>
        function delete_cate(id)
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
                var URL = '{{ url('Admin/Goods/deleteGoodsCategory',[],config('crucis.http_secure')) }}';
                var data = {_method:"DELETE",id:id};
                $.post(URL, data, function (result) {
                    if (result.status == 200)
                    {
                        swal({
                            title: "删除成功！",
                            text: result.message,
                            type: "success",
                        },function ()
                        {
                            location.reload();
                        });
                    }else {
                        swal({
                            title: "删除失败！",
                            text: result.message,
                            type: "error",
                        });
                    }
                });
            })
        }
    </script>
@endsection
