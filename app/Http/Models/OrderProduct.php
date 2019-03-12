<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'order_products';

    protected $guarded = [];

    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo('App\Http\Models\Order', 'order_id');
    }

    public function products()
    {
        return $this->belongsTo('App\Http\Models\Product','product_id','id');
    }

    public function attributes()
    {
        return $this->belongsToMany('App\Http\Models\Attribute','product_attribute','product_id','attribute_id', 'product_id');
    }
}
