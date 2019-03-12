<?php
/**
 * Copyright (c) 2018. Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan. 
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna. 
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus. 
 * Vestibulum commodo. Ut rhoncus gravida arcu. 
 */

namespace App\Transformers;
use App\Http\Models\Order;
use League\Fractal\TransformerAbstract;
class OrderTransformer extends TransformerAbstract
{
    public function transform(Order $model)
    {
        return [
            'order_sn' => $model->order_sn,
            'user_id' => $model->user_id,
            'amount' => $model->amount,
            'address' => $model->address,
            'product' => $model->products,
            'created_at' => $model->created_at->format('Y-m-d H:i:s'),
            'status_name' => $model->getStatusName($model),
            'status' => $model->status,
        ];
    }
} 
