<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Services\ChuanglanSmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SmsController extends BaseController
{
    public function index(Request $request,ChuanglanSmsService $chuanglanSmsService)
    {
        $phone = $request->phone;
        if (!is_mobile_number($phone)) return $this->response->array(["message" => '请输入正确的手机号!', "status_code" => 500,]);
        switch ($request->type)
        {
            case "register":
                $code = mt_rand(100000,999999);
                $message = "您的注册短信验证码是{$code},三分钟内有效,请妥善保管.";
                break;
            case "reset_password":
                $code = mt_rand(100000,999999);
                $message = "您的修改密码短信验证码是{$code},三分钟内有效,请妥善保管.";
                break;
            default:
                return $this->response->array(["message" => '系统错误!', "status_code" => 500,]);
                break;
        }
        Cache::set("sms_code_{$request->type}_{$phone}",$code,3);
        $result = $chuanglanSmsService->sendSMS($phone,$message);
        $result = json_decode($result,true);
        if ($result['code'] == 0 && empty($result['errorMsg']))
        {
            return $this->response->array([
                'status_code' => 200,
                'message' => 'success',
            ]);
        } else {
            return $this->response->array([
                "message" => '服务器繁忙',
                "status_code" => 500,
            ]);
        }
    }
}
