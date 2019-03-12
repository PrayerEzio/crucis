<?php
/**
 * Copyright (c) 2018. Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan. 
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna. 
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus. 
 * Vestibulum commodo. Ut rhoncus gravida arcu. 
 */

namespace App\Transformers;
use App\Http\Models\Region;
use League\Fractal\TransformerAbstract;
class RegionTransformer extends TransformerAbstract
{
    public function transform(Region $region)
    {
        return [
            'id' => $region->id,
            'name' => $region->name,
            'first_letter' => $region->first_letter,
            'level' => $region->level,
            'is_hot' => $region->is_hot,
            'parent_id' => $region->parent_id,
            'is_special' => $region->is_special,
        ];
    }
} 
