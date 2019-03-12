<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'albums';

    public function admin()
    {
        return $this->belongsTo('App\Http\Models\Admin', 'admin_id');
    }

    public function picture()
    {
        return $this->hasMany('App\Http\Models\AlbumPicture','album_id','id');
    }

    public function scopeAdminId($query,$admin_id)
    {
        return $query->where('admin_id',$admin_id);
    }
}
