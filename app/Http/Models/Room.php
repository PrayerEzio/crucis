<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Room extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'room';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'timer_id',
        'title',
        'created_at',
        'updated_at',
        'is_private',
        'cipher',
        'cover',
        'music',
    ];

    static public function getStatusName($room)
    {
        if (empty($room)) return '';
        switch ($room->status)
        {
            case 0:
                $status_name = '空闲';
                break;
            case 1:
                $status_name = '有人占用';
                break;
            case 2:
                $status_name = '机器坏了';
                break;
            case 3:
                $status_name = '有人占用';
                break;
            default:
                $status_name = '异常状态';
                break;
        }
        return $status_name;
    }
}
