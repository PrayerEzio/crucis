<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsPicture extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'goods_pictures';

    public function goods()
    {
        return $this->belongsTo('App\Http\Models\Goods', 'goods_id');
    }
}
