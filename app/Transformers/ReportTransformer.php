<?php
/**
 * Copyright (c) 2019. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace App\Transformers;
use App\Http\Models\Report;
use League\Fractal\TransformerAbstract;
class ReportTransformer extends TransformerAbstract
{
    public function __construct()
    {

    }

    public function transform(Report $model)
    {
        $field_array = ['id','category_id','body','sort','status'];
        $result = [];
        foreach ($field_array as $item)
        {
            $result[$item] = $model->$item;
        }
        $result['category'] = $model->category()->first();
        $result['created_at'] = $model->created_at->diffForHumans();
        return $result;
    }
} 
