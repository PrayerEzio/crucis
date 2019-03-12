<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Sign extends Model
{
    protected $table = 'sign';

    public function logs()
    {
        return $this->hasMany('App\Http\Models\SignLog','sign_id','id');
    }
}
