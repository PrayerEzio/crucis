<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Models\Goods;
use App\Transformers\GoodsTransformer;

class GoodsController extends BaseController
{
    /**
     * 获取商品列表
     *
     * 注意Response结构,带分页meta信息
     *
     * @Get("/goods")
     * @Versions({"v1"})
     * @Request(headers={"Authorization": "Bearer+token"})
     * @Parameters({
     *     @Parameter("page", description="页码",required=false,default=1),
     * })
     * @Transaction({
     *     @Response(200, body="{goods_list}"),
     * })
     */
    public function index(Goods $goods)
    {
        $data = $goods->paginate(10);
        return $this->response->paginator($data,new GoodsTransformer());
    }

    /**
     * 获取商品详情
     *
     * @Get("/goods/{goods_sn}")
     * @Versions({"v1"})
     * @Request(headers={"Authorization": "Bearer+token"})
     * @Parameters({
     * })
     * @Transaction({
     *     @Response(200, body="{goods_info}"),
     * })
     */
    public function show($goods_sn,Goods $goods)
    {
        $data = $goods->goodsSn($goods_sn)->first();
        return $this->response->item($data,new GoodsTransformer());
    }

}
