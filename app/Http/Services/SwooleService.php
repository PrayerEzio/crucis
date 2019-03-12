<?php
namespace App\Http\Services;
use App\Http\Models\Admin;
use App\Http\Models\Message;
use App\Http\Models\Room;
use App\Http\Models\RoomJoin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;
use Mockery\CountValidator\Exception;
use Symfony\Component\Process\Process;

class SwooleService
{
    private $serv;
    
    public function __construct(Admin $admin,Message $message,Room $room,RoomJoin $roomJoin)
    {
        $this->admin = $admin;
        $this->message = $message;
        $this->room = $room;
        $this->roomJoin = $roomJoin;
    }

    public function httpServer()
    {
        $websocket_server = new \swoole_websocket_server('0.0.0.0', config('swoole.port'));
        $websocket_server->set(
            array(
                'daemonize' => false,      // 是否是守护进程.
                'max_request' => 10000,    // 最大连接数量.
                'dispatch_mode' => 5,
                'debug_mode' => 1,
                // 心跳检测的设置，自动踢掉掉线的fd
                'heartbeat_check_interval' => 5,
                'heartbeat_idle_time' => 600,
            )
        );
        $websocket_server->on('open', array($this, 'httpServerOnOpen'));
        $websocket_server->on('message', array($this, 'httpServerOnMessage'));
        $websocket_server->on('close', array($this, 'httpServerOnClose'));
        $websocket_server->start();
    }

    public function httpServerOnOpen($server, $frame)
    {
        //todo
    }

    public function httpServerOnMessage($server, $frame)
    {
        $data = json_decode($frame->data, true);
        $user = $this->admin->whereToken($data['token'])->whereStatus(1)->first();
        switch ($data['type']) {
            case 'connect':
                Redis::zadd("room:{$data['room_id']}", intval($user->id), $frame->fd);
//                    同时使用hash标识fd在哪个房间
                Redis::hset('room', $frame->fd, $data['room_id']);
//                    加入房间提示
//                    获取这个房间的用户总数
//                    +1 是代表群主
                $memberInfo = [
                    'online' => Redis::zcard("room:{$data['room_id']}"),
                    'all' => $this->roomJoin->where(['room_id' => $data['room_id'], 'status' => 0])->count() + 1
                ];
                $this->sendMessageToGroup($server, $data['room_id'], $user->id, $memberInfo,
                    'join');
                break;
            case 'message':
//                    入库
                $message = [
                    'content' => $data['message'],
                    'user_id' => intval($user->id),
                    'room_id' => $data['room_id'],
                    'created_at' => time()
                ];
                $this->message->fill($message)->save();
//                Message::create($message);
                $this->sendMessageToGroup($server, $data['room_id'], $user->id, $data['message']);
                break;
            case 'close':
//                    移除
                Redis::zrem("room:{$data['room_id']}", $frame->fd);
                break;
        }
    }

    public function httpServerOnClose($server, $fd)
    {
        $room_id = Redis::hget('room', $fd);
        $user_id = intval(Redis::zscore("room:{$room_id}", $fd));
        Redis::zrem("room:{$room_id}", $fd);
        $message = [
            'online' => Redis::zcard("room:{$room_id}"),
            'all' => $this->roomJoin->where(['room_id' => $room_id, 'status' => 0])->count() + 1
        ];
        $this->sendMessageToGroup($server, $room_id, $user_id, $message, 'leave');
    }

    private function sendMessageToGroup($server,$room_id,$user_id,$message,$type = 'message')
    {
        $user = $this->admin->find($user_id,['id','nickname','avatar']);
        if (!$user)
        {
            return false;
        }
        $message = json_encode([
            'message' => is_string($message) ? nl2br($message) : $message,
            'type' => $type,
            'user' => $user,
            'user_type' => 'admin',
            'time' => Carbon::now()->toDateTimeString(),
        ]);
        $member = Redis::zrange("room:{$room_id}",0,-1);
        foreach ($member as $fd)
        {
            try {
                $server->push($fd,$message);
            }catch (\Exception $exception)
            {
                break;
            }
        }
    }
}