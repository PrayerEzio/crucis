<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertisement extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'advertisements';

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopePosition($query,$position)
    {
        return $query->where('position',$position);
    }
}
