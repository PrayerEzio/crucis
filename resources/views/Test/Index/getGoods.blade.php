<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>{{ $data->name }}</title>
</head>
<body>
<style type="text/css">
    ul,li{ padding:0px; margin:0px;}
    #panel{ width:500px; margin:30px auto;}
    .goods_attr{ overflow:hidden;}
    .goods_attr .label {font: 12px/30px '宋体';color: #777;width: 50px;;padding-right: 10px;float: left; display:block;}
    .goods_attr ul {float:left;width:300px;}
    .goods_attr li{color:#333;overflow:hidden;position:relative;float:left;text-align:center; vertical-align:middle; border:1px solid #999;text-indent:0; cursor:pointer}
    .goods_attr li.b{border:1px dotted #CCC;color:#DDD; pointer:none;}
    .goods_attr li.b img {opacity:0.4;}
    .goods_attr li.sel{ border:1px solid #c80a28;color:#333;}
    .goods_attr li.text{margin:5px 10px 5px 0; height:23px;line-height:23px;text-indent:0;padding:0 23px;font-style:normal;}
    .goods_attr li.img{ margin-right:10px;width:35px;height:35px; line-height:35px;text-align:center;}
</style>
<div id="panel">
    <div id="panel_sku_list"><pre></pre></div>
    <div id="panel_sel">
    </div>
</div>
<script src="http://libs.baidu.com/jquery/1.9.0/jquery.min.js"></script>
<script type="text/javascript">
    /*
    属性集
    下面一共有4个属性
    属性item1 下面有 2个属性值 分别是 10,11
    （举个常见的例子 属性尺码 下有 S M L XL 4个属性值 ）
    */
    var keys = {
        @foreach($data['attribute_list'] as $key => $attribute)
            "{{ $key }}": [@foreach($attribute as $item)"{{ $item }}",@endforeach],
        @endforeach
    };
    //SKU，Stock Keeping Uint(库存量单位)
    var sku_list=[
        @foreach($data['products'] as $product)
            {
                'attrs':"{{ $product->attribute }}",'num':{{ $product->stock }},'id':{{ $product->id }}
            },
        @endforeach
    ];
    /**init start */
//显示html结构
    function show_attr_item(){
        var html='';
        for(k in keys){
            html+='<div class="goods_attr" > <span class="label">'+k+'</span>';
            html+='<ul>'
            for(k2 in keys[k]){
                _attr_id=keys[k][k2];
                html+='<li class="text" val="'+_attr_id+'" >';
                html+='<span>'+_attr_id+'</span>';
                html+='<s></s>';
                html+='</li>'
            }
            html+='</ul>';
            html+='</div>';
        }
        $('#panel_sel').html(html);
    }
    //显示数据
    function show_data(sku_list){
        var str="";
        for( k in sku_list){
            str+=sku_list[k]['id']+"\t"+sku_list[k]['attrs']+"\t"+sku_list[k]['num']+"\n";
        }
        $('#panel_sku_list pre').html(str);
    }

    show_data(sku_list);
    show_attr_item()

    /**init end */

//获取所有包含指定节点的路线
    function filterProduct(ids){
        var result=[];
        $(sku_list).each(function(k,v){
            _attr='|'+v['attrs']+'|';
            _all_ids_in=true;
            for( k in ids){
                if(_attr.indexOf('|'+ids[k]+'|')==-1){
                    _all_ids_in=false;
                    break;
                }
            }
            if(_all_ids_in){
                result.push(v);
            }

        });
        return result;
    }

    //获取 经过已选节点 所有线路上的全部节点
    // 根据已经选择得属性值，得到余下还能选择的属性值
    function filterAttrs(ids){
        var products=filterProduct(ids);
        //console.log(products);
        var result=[];
        $(products).each(function(k,v){
            result=result.concat(v['attrs'].split('|'));

        });
        return result;
    }

    //已选择的节点数组
    function _getSelAttrId(){

        var list=[];
        $('.goods_attr li.sel').each(function(){
            list.push($(this).attr('val'));
        });
        return list;
    }

    $('.goods_attr li').click(function(){
        if($(this).hasClass('b')){
            return ;//被锁定了
        }
        if($(this).hasClass('sel')){
            $(this).removeClass('sel');
        }else{
            $(this).siblings().removeClass('sel');
            $(this).addClass('sel');

        }
        var select_ids=_getSelAttrId();

        //已经选择了的规格
        var $_sel_goods_attr=$('li.sel').parents('.goods_attr');

        // step 1
        var all_ids=filterAttrs(select_ids);

        //获取未选择的
        var $other_notsel_attr=$('.goods_attr').not($_sel_goods_attr);

        //设置为选择属性中的不可选节点
        $other_notsel_attr.each(function(){
            set_block($(this),all_ids);

        });

        //step 2
        //设置已选节点的同级节点是否可选
        $_sel_goods_attr.each(function(){
            update_2($(this));
        });


    });

    function update_2($goods_attr){
        // 若该属性值 $li 是未选中状态的话，设置同级的其他属性是否可选
        var select_ids=_getSelAttrId();
        var $li=$goods_attr.find('li.sel');

        var select_ids2=del_array_val(select_ids,$li.attr('val'));

        var all_ids=filterAttrs(select_ids2);

        set_block($goods_attr,all_ids);
    }

    function set_block($goods_attr,all_ids){

//根据 $goods_attr下的所有节点是否在可选节点中（all_ids） 来设置可选状态
        $goods_attr.find('li').each(function(k2,li2){

            if($.inArray($(li2).attr('val'),all_ids)==-1){
                $(li2).addClass('b');
            }else{
                $(li2).removeClass('b');
            }

        });

    }
    function del_array_val(arr,val){
//去除 数组 arr中的 val ，返回一个新数组
        var a=[];
        for(k in arr){
            if(arr[k]!=val){
                a.push(arr[k]);
            }
        }
        return a;
    }
</script>
</body>
</html>