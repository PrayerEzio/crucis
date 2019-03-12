<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'addresses';

    public function user()
    {
        return $this->belongsTo('App\Http\Models\User', 'user_id');
    }

    /*public function province()
    {
        return $this->belongsTo('App\Http\Models\Region','province_id','id');
    }

    public function city()
    {
        return $this->belongsTo('App\Http\Models\Region','city_id','id');
    }

    public function district()
    {
        return $this->belongsTo('App\Http\Models\Region','district_id','id');
    }*/

    public function scopeUserId($query,$user_id)
    {
        return $query->where('user_id',$user_id);
    }

    public function scopeStatus($query,$status)
    {
        return $query->where('status',$status);
    }
}
