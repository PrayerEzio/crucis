<?php
/**
 * Copyright (c) 2019. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace App\Transformers;
use App\Http\Models\ReportCategory;
use League\Fractal\TransformerAbstract;
class ReportCategoryTransformer extends TransformerAbstract
{
    public function __construct()
    {

    }

    public function transform(ReportCategory $model)
    {
        $field_array = ['id','name','parent_id','sort','status'];
        $result = [];
        foreach ($field_array as $item)
        {
            $result[$item] = $model->$item;
        }
        $result['created_at'] = $model->created_at->diffForHumans();
        return $result;
    }
} 
