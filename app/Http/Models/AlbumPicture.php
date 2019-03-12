<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlbumPicture extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'albums_picture';

    public function albums()
    {
        return $this->belongsTo('App\Http\Models\Albums', 'albums_id');
    }
}
