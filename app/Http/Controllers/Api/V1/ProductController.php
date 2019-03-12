<?php
/**
 * Copyright (c) 2019. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Models\Product;
use App\Transformers\ProductTransformer;

class ProductController extends BaseController
{
    /**
     * 获取产品列表
     *
     * 注意Response结构,带分页meta信息
     *
     * @Get("/product")
     * @Versions({"v1"})
     * @Request(headers={"Authorization": "Bearer+token"})
     * @Parameters({
     *     @Parameter("page", description="页码",required=false,default=1),
     * })
     * @Transaction({
     *     @Response(200, body="{product_list}"),
     * })
     */
    public function index(Product $product)
    {
        $data = $product->where('status',1)->orderBy('sort','desc')->with('goods')->orderBy('sort','desc')->where('status',1)->with('attributes')->paginate(10);
        return $this->response->paginator($data,new ProductTransformer());
    }

    /**
     * 获取产品详情
     *
     * @Get("/product/{product_sn}")
     * @Versions({"v1"})
     * @Request(headers={"Authorization": "Bearer+token"})
     * @Parameters({
     * })
     * @Transaction({
     *     @Response(200, body="{product_info}"),
     * })
     */
    public function show($product_sn,Product $product)
    {
        $data = $product->productSn($product_sn)->first();
        return $this->response->item($data,new ProductTransformer());
    }

}
