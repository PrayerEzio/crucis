<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $table = 'product_attribute';

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo('App\Http\Models\Product', 'product_id');
    }

    public function attribute()
    {
        return $this->belongsTo('App\Http\Models\Attribute','attribute_id');
    }
}
