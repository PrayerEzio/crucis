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
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'users';

    protected $fillable = ['nickname', 'email', 'phone', 'password', 'register_ip', 'status'];

    protected $hidden = [
        'password', 'token',
    ];

    public function scopeUserId($query,$user_id)
    {
        return $query->where('id',$user_id);
    }

    public function scopeOpenId($query,$open_id,$access_source)
    {
        return $query->where([['open_id',$open_id],['access_source',$access_source]]);
    }

    public function scopeSocialite($query,$source,$unionid)
    {
        return $query->where([['access_source',$source],['unionid',$unionid]]);
    }

    public function orders()
    {
        return $this->hasMany('App\Http\Models\Order','user_id','id');
    }

    public function address()
    {
        return $this->hasMany('App\Http\Models\Address','user_id','id');
    }

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }
}