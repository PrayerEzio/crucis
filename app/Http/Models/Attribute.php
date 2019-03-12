<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $table = 'attributes';

    protected $fillable = ['name'];

    public function category()
    {
        return $this->belongsTo('App\Http\Models\AttributeCategory', 'category_id');
    }

    public function scopeCategory($query,$category_id)
    {
        return $query->where('category_id', $category_id);
    }
}
