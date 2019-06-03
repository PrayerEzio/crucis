<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Attribute;
use App\Http\Models\AttributeCategory;
use App\Http\Models\GoodsCategory;
use Illuminate\Http\Request;

class AjaxController extends CommonController
{
    public function getGoodsCategoryList(Request $request, GoodsCategory $goodsCategory)
    {
        $data = $goodsCategory->get();
        if ($request->ajax()) {
            return response([
                'status' => 200,
                'message' => __('Operation succeed.'),
                'data' => $data,
            ]);
        }
    }
    
    public function getAttributesList(Request $request, AttributeCategory $attributeCategory)
    {
        $data = $attributeCategory->find($request->id);
        $data['attributes'] = $data->attributes;
        if ($request->ajax()) {
            return response([
                'status'  => 200,
                'message' => __('Operation succeed.'),
                'data' => $data,
            ]);
        }
    }
}
