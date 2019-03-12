<?php
/**
 * Copyright (c) 2019. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'reports';

    protected $fillable = ['category_id', 'user_id', 'body', 'status', 'sort'];

    public function category()
    {
        return $this->belongsTo('App\Http\Models\ReportCategory', 'category_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Http\Models\User', 'user_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
