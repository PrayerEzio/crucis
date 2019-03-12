<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlayLog extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'play_logs';

    public function user()
    {
        return $this->belongsTo('App\Http\Models\User', 'user_id');
    }

    public function scopeUserId($query,$user_id)
    {
        return $query->where('user_id',$user_id);
    }

    public function scopePlayId($query,$play_id)
    {
        return $query->where('play_id',$play_id);
    }
}
