<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeCategory extends Model
{
    protected $table = 'attribute_category';

    protected $fillable = ['name'];

    public function attributes()
    {
        return $this->hasMany('App\Http\Models\Attribute','category_id','id');
    }
}
