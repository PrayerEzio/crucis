<?php
/**
 * Copyright (c) 2019. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan. 
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna. 
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus. 
 * Vestibulum commodo. Ut rhoncus gravida arcu. 
 */

namespace App\Transformers;
use App\Http\Models\Product;
use League\Fractal\TransformerAbstract;
class ProductTransformer extends TransformerAbstract
{
    public function transform(Product $model)
    {
        return [
            'product_sn' => $model->product_sn,
            'stock' => $model->stock,
            'price' => $model->price,
            'mkt_price' => $model->mkt_price,
            'attributes' => $model->attributes,
            'goods' => $model->goods,
            'created_at' => $model->created_at->diffForHumans(),
            'deleted_at' => $model->deleted_at,
        ];
    }
} 
