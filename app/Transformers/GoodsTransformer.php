<?php
/**
 * Copyright (c) 2018. Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan. 
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna. 
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus. 
 * Vestibulum commodo. Ut rhoncus gravida arcu. 
 */

namespace App\Transformers;
use App\Http\Models\Goods;
use League\Fractal\TransformerAbstract;
class GoodsTransformer extends TransformerAbstract
{
    public function transform(Goods $goods)
    {
        return [
            'goods_sn' => $goods->goods_sn,
            'category_id' => $goods->category_id,
            'category' => $goods->category,
            'name' => $goods->name,
            'sub_title' => $goods->sub_title,
            'picture' => $goods->picture,
            'more_picture' => $goods->pictures()->get(),
            'product' => $goods->products()->get(),
            'sales_volume' => $goods->sales_volume,
            'seo_title' => $goods->seo_title,
            'seo_keywords' => $goods->seo_keywords,
            'seo_description' => $goods->seo_description,
            'description' => $goods->description,
            'detail' => $goods->detail,
            'is_virtual' => $goods->is_virtual,
            'tag' => $goods->tag,
            'created_at' => $goods->created_at->diffForHumans(),
            'deleted_at' => $goods->deleted_at,
        ];
    }
} 
