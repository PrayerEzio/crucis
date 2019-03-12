<?php
/**
 * Copyright (c) 2018. Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan. 
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna. 
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus. 
 * Vestibulum commodo. Ut rhoncus gravida arcu. 
 */

namespace App\Transformers;
use App\Http\Models\BalanceLogs;
use League\Fractal\TransformerAbstract;
class BalanceLogsTransformer extends TransformerAbstract
{
    public function transform(BalanceLogs $balanceLogs)
    {
        return [
            'id' => $balanceLogs->id,
            'title' => $balanceLogs->title,
            'user_id' => $balanceLogs->user_id,
            'amount' => $balanceLogs->amount,
            'created_at' => $balanceLogs->created_at->diffForHumans(),
            'deleted_at' => $balanceLogs->deleted_at,
        ];
    }
} 
