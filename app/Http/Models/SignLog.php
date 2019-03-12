<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class SignLog extends Model
{
    protected $table = 'sign_logs';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\Http\Models\User', 'user_id');
    }

    public function sign()
    {
        return $this->belongsTo('App\Http\Models\Sign', 'sign_id');
    }

    public function scopeUserId($query,$user_id)
    {
        return $query->where('user_id',$user_id);
    }

    public function scopeSignId($query,$sign_id)
    {
        return $query->where('sign_id',$sign_id);
    }
}
