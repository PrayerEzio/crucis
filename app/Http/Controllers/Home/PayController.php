<?php

namespace App\Http\Controllers\Home;

use App\Http\Models\Order;
use App\Http\Models\User;
use App\Http\Services\JWTService;
use App\Http\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yansongda\Pay\Log;
use Yansongda\Pay\Pay;
use Illuminate\Support\Facades\Route;

class PayController extends Controller
{
    protected $wechat_config = [
        'appid' => '', // APP APPID
        'app_id' => '', // 公众号 APPID
        'miniapp_id' => '', // 小程序 APPID
        'mch_id' => '',
        'key' => '',
        'notify_url' => '',
        //'cert_client' => './cert/wechat/apiclient_cert.pem', // optional，退款等情况时用到
        //'cert_key' => './cert/wechat/apiclient_key.pem',// optional，退款等情况时用到
        'log' => [ // optional
            'file' => '../logs/wechat.log',
            'level' => 'debug', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'single', // optional, 可选 daily.
            'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
        'http' => [ // optional
            'timeout' => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ],
        'mode' => 'normal', // optional, dev/hk/normal;当为 `hk` 时，为香港 gateway。
    ];

    public function __construct()
    {
        $this->wechat_config['appid'] = config('pay.wechat.APP_ID');
        $this->wechat_config['app_id'] = config('pay.wechat.APP_ID');
        $this->wechat_config['mch_id'] = config('pay.wechat.MCH_ID');
        $this->wechat_config['key'] = config('pay.wechat.API_KEY');
        $this->wechat_config['notify_url'] = config('crucis.app_url').'/Pay/wechat_notify';
    }

    public function wechat(Request $request,JWTService $JWTService,User $user,Order $order)
    {
        //获取订单和token 进行订单确认
        $order_sn = $request->order_sn;
        $token = $request->token;
        $payload = $JWTService->decode($token);
        $user = $user->userId($payload['sub'])->first();
        if (empty($user)) return 404;
        $order_info = $order->orderSn($order_sn)->userId($user->id)->first();
        if (empty($order_info)) return 404;
        if ($order_info->status != 1) return 403;
        $wechat_order = [
            'appid' => $this->wechat_config['appid'],
            'out_trade_no' => $order_info->order_sn,
            'total_fee' => $order_info->amount*100, // **单位：分**
            'body' => "充值金币",
            'scene_info' => json_encode([
                'h5_info'=> [
                    'type' => 'Wap',
                    'wap_url' => config('crucis.h5_url'),
                    'wap_name' => '推币机充值金币',
                ]
            ]),
        ];
        echo Pay::wechat($this->wechat_config)->wap($wechat_order);
    }

    public function wechat_notify(Request $request,Order $order,User $user,UserService $userService)
    {
        $pay = Pay::wechat($this->wechat_config);
        try{
            $data = $pay->verify(); // 是的，验签就这么简单！
            Log::debug('Wechat notify', $data->all());
            if (!$data['result_code'] == 'SUCCESS' || !$data['return_code'] == 'SUCCESS') {
                system_log('Wechat h5 pay notify.', json_encode($data), Route::currentRouteAction(), 9, 'pay', $request->ip());
                return $pay->success();
            }
            $amount = $data['total_fee']/100;
            $user_info = $user->openId($data['openid'],'wechat')->first();
            $order_info = $order->orderSn($data['out_trade_no'])->status(1)->userId($user_info->id)->where('amount',$amount)->orderType('recharge')->first();
            if (!$user_info || !$order_info) {
                system_log('Wechat h5 pay notify.', json_encode($user_info).json_encode($order_info).json_encode($data), Route::currentRouteAction(), 9, 'pay', $request->ip());
                return $pay->success();
            }
            $userService->addBalance($user_info->id,$amount,'金币充值');
            $order_info->status = 5;
            $order_info->save();
        } catch (\Exception $e) {
            system_log('Wechat h5 pay notify.', json_encode($e->getLine().$e->getMessage()), Route::currentRouteAction(), 9, 'pay', $request->ip());
        }
        return $pay->success();
    }
}
