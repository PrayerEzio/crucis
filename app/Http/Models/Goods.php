<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goods extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'goods';

    public function category()
    {
        return $this->belongsTo('App\Http\Models\GoodsCategory', 'category_id');
    }

    public function products()
    {
        return $this->hasMany('App\Http\Models\Product','goods_id','id');
    }

    public function pictures()
    {
        return $this->hasMany('App\Http\Models\GoodsPicture','goods_id','id');
    }

    public function comments()
    {
        return $this->hasMany('App\Http\Models\GoodsComment','goods_id','id');
    }

    public function scopeGoodsSn($query,$goods_sn)
    {
        return $query->where('goods_sn',$goods_sn);
    }

    public function scopeStatus($query,$status)
    {
        return $query->where('status',$status);
    }
}
