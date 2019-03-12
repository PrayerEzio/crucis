<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsCategory extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'goods_category';

    public function goods()
    {
        return $this->hasMany('App\Http\Models\Goods');
    }

    public function scopeParent($query,$parent_id)
    {
        return $query->where('parent_id',$parent_id);
    }
}
