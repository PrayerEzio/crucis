<?php
/**
 * Copyright (c) 2019. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace App\Transformers;
use App\Http\Models\Room;
use League\Fractal\TransformerAbstract;
class RoomTransformer extends TransformerAbstract
{
    public function __construct($token)
    {
        $this->token = $token;
    }

    public function transform(Room $room)
    {
        $field_array = ['id','title','cipher','cover','numbers','time_limit','ssrc','sip_addr','camera','sdk_type','ws_server_url','pull_url','status','music'];
        $result = [];
        foreach ($field_array as $item)
        {
            $result[$item] = $room->$item;
        }
        if ($room->is_mainten) $result['status'] = 2;
        $result['created_at'] = $room->created_at->diffForHumans();
        $result['play_token'] = $this->token;
        return $result;
    }
} 
