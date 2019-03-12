<?php
/**
 * Copyright (c) 2019. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Models\Order;
use App\Http\Models\SystemLog;
use App\Http\Models\User;
use App\Http\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Yansongda\Pay\Log;
use Yansongda\Pay\Pay;

class PayController extends BaseController
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
        $this->wechat_config['notify_url'] = config('crucis.app_url').'/api/pay/wechat_notify';
    }

    /**
     * 微信公众号支付.
     *
     *
     * 在微信浏览器内使用微信公众号支付
     *
     * @Post("/pay/mpwechat")
     * @Versions({"v1"})
     * @Request(headers={"Authorization": "Bearer+token"})
     * @Parameters({
     *     @Parameter("order_sn", description="订单号",required=true),
     * })
     * @Transaction({
     *     @Response(200, body={"status_code":500,"message":"{error_message}"}),
     *     @Response(200, body={
    "message": "SUCCESS",
    "status_code": 200,
    "data": {
    "appId": "wx80e857a88d4ddf03",
    "timeStamp": "1548313643",
    "nonceStr": "qCwWdjcARptSeC0m",
    "package": "prepay_id=wx24150723976468f0740207aa3816927854",
    "signType": "MD5",
    "paySign": "EC9509503185D391AD325F3EF14F0B16"
    }
    }),
     * })
     */
    public function mpwechat(Request $request,User $user,Order $order)
    {
        //获取订单和token 进行订单确认
        $order_sn = $request->order_sn;
        $user_id = $this->getUserInfo()->id;
        $user = $user->userId($user_id)->first();
        if (empty($user) || empty($user->open_id) || $user->access_source != 'wechat') return $this->response->array(["message" => "没有找到相关信息!", "status_code" => 500]);
        $order_info = $order->orderSn($order_sn)->userId($user->id)->first();
        if (empty($order_info)) return $this->response->array(["message" => "没有找到相关信息!", "status_code" => 500]);
        if ($order_info->status != 1) return $this->response->array(["message" => "没有找到相关信息!", "status_code" => 500]);
        $wechat_order = [
            'appid' => $this->wechat_config['appid'],
            'out_trade_no' => $order_sn,
            'total_fee' => $order_info->amount*100, // **单位：分**
            'body' => "充值金币",
            'openid' => $user->open_id,
        ];
        system_log('Wechat h5 pay.', json_encode($wechat_order), "App\Http\Controllers\Api\V1\PayController@mpwechat", 0, 'system',$request->ip());
        return $this->response->array(["message" => "SUCCESS", "status_code" => 200, "data"=>Pay::wechat($this->wechat_config)->mp($wechat_order)]);
    }

    public function wechat_notify(Request $request,Order $order,User $user,UserService $userService)
    {
        $system_log_type = "App\Http\Controllers\Api\V1\PayController@wechat_notify";
        $pay = Pay::wechat($this->wechat_config);
        try{
            $data = $pay->verify(); // 是的，验签就这么简单！
            Log::debug('Wechat notify', $data->all());
            if (!$data['result_code'] == 'SUCCESS' || !$data['return_code'] == 'SUCCESS') {
                system_log('Wechat h5 pay notify.', json_encode($data), $system_log_type, 9, 'pay',$request->ip());
                return $pay->success();
            }
            system_log('Wechat h5 pay notify.', json_encode($data), $system_log_type, 0, 'pay',$request->ip());
            $amount = $data['total_fee']/100;
            $user_info = $user->openId($data['openid'],'wechat')->first();
            $order_info = $order->orderSn($data['out_trade_no'])->status(1)->userId($user_info->id)->where('amount',$amount)->orderType('recharge')->first();
            if (!$user_info || !$order_info) {
                system_log('Wechat h5 pay notify.', json_encode($user_info).json_encode($order_info).json_encode($data), $system_log_type, 9, 'pay',$request->ip());
                return $pay->success();
            }
            $userService->addBalance($user_info->id,$amount,'金币充值');
            $order_info->status = 5;
            $order_info->save();
        } catch (\Exception $e) {
            system_log('Wechat mp pay notify.', json_encode($e->getLine().$e->getMessage()), $system_log_type, 9, 'pay',$request->ip());
        }
        return $pay->success();
    }
}
