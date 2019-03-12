<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomJoin extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * @var string
     */
    protected $table = 'room_join';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'room_id',
        'status'
    ];

    /**
     * @param $room_id
     * @return mixed
     */
    public function memberNum($room_id)
    {
        return $this->where([
            'room_id' => $room_id,
            'status' => 0
        ])->count();
    }

    public function user()
    {
        return $this->belongsTo('App\Http\Models\User', 'user_id');
    }
}
