<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'regions';

    public $timestamps = false;

    public function scopeParentId($query,$parent_id)
    {
        return $query->where('parent_id',$parent_id);
    }

    public function scopeActive($query)
    {
        return $query->where('status',1);
    }

    public function scopeHot($query)
    {
        return $query->where('is_hot',1);
    }

    public function scopeSpecial($query)
    {
        return $query->where('is_special',1);
    }
}
