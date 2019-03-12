<?php
/**
 * Copyright (c) 2018. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PointLogs extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'point_logs';

    public function user()
    {
        return $this->belongsTo('App\Http\Models\User', 'user_id');
    }

    public function scopeUserId($query,$user_id)
    {
        return $query->where('user_id',$user_id);
    }
}
