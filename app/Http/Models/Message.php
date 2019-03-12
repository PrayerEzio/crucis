<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * @var string
     */
    protected $table = 'message';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'room_id',
        'status',
        'content',
        'created_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * 获取最近24小时内的消息
     * @param $room_id
     * @param $pageSize
     * @return \Illuminate\Support\Collection
     */
    public function getLatestMessage($room_id, $pageSize)
    {
        return $this->leftJoin('admins' , 'message.user_id' , '=' , 'admins.id')
        ->select('message.content' , 'message.created_at' , 'admins.id as admin_id' , 'admins.nickname as nickname')
        ->where('message.room_id' , '=' , $room_id)
//        ->take($pageSize)
        ->get();

    }
}
