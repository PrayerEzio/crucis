<?php
/**
 * Copyright (c) 2018. Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan. 
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna. 
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus. 
 * Vestibulum commodo. Ut rhoncus gravida arcu. 
 */

namespace App\Transformers;
use App\Http\Models\PointLogs;
use League\Fractal\TransformerAbstract;
class PointLogsTransformer extends TransformerAbstract
{
    public function transform(PointLogs $pointLogs)
    {
        return [
            'id' => $pointLogs->id,
            'title' => $pointLogs->title,
            'user_id' => $pointLogs->user_id,
            'amount' => $pointLogs->amount,
            'created_at' => $pointLogs->created_at->diffForHumans(),
            'deleted_at' => $pointLogs->deleted_at,
        ];
    }
} 
