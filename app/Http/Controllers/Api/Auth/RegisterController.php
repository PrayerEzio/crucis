<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Models\User;
use App\Http\Services\UserService;
use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterController extends BaseController {
    use RegistersUsers;
    use Helpers;

    /**
     * 手机注册
     *
     * 注册一个新的用户
     *
     * @Post("/register")
     * @Versions({"v1"})
     * @Parameters({
     *     @Parameter("phone", description="注册手机号",required=true),
     *     @Parameter("code", description="短信验证码",required=true),
     *     @Parameter("password", description="密码",required=true),
     * })
     * @Transaction({
     *     @Request({"phone": "15013845571", "code": "456345", "password": "123456"}),
     *     @Response(200, body={"status_code":500,"message":"{error_message}"}),
     *     @Response(200, body={"status_code":200,"message":"注册成功","token":"{token}"}),
     * })
     */
    public function register(Request $request) {
        //验证短信验证码
        $sms_code = $this->getSmsCode($request->phone,"register");
        if ($sms_code != $request->code)
        {
            return $this->response->array([
                "message" => "短信验证码不正确",
                "status_code" => 500,
            ]);
        }
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return $this->response->array([
                "message" => "验证失败",
                "status_code" => 500,
            ]);
        }

        $user = $this->create($request->all());
        $user_sn = str_pad($user->id,5,"0",STR_PAD_LEFT);
        $user->nickname = "用户1".$user_sn;
        $user->user_sn = chr(rand(97, 122)).$user_sn;
        if ($user->save()) {

            $token = JWTAuth::fromUser($user);
            //添加邀请关系日志
            $share_code = $request->state;
            if ($share_code) {
                $user_model = new User();
                $inviter = $user_model->where('user_sn',$share_code)->first();
                $userService = new UserService();
                $userService->addInvitationLog($inviter['id'],$user->id);
            }

            return $this->response->array([
                "token" => $token,
                "message" => "注册成功",
                "status_code" => 200,
            ]);
        } else {
            return $this->response->array([
                "message" => "系统繁忙,请稍后再试.",
                "status_code" => 500,
            ]);
        }
    }

    protected function validator(array $data) {
        return Validator::make($data, [
            'phone' => 'required|unique:users|regex:/^1[0-9]{10}$/',
            'password' => 'required|min:6|max:12',
        ]);
    }

    protected function create(array $data) {
        return User::create([
            'nickname' => "手机用户",
            'avatar' => 'http://img.91ysml.net/demo/eyJpdiI6IitpTkp1WFlFd2VyXC8xS2NcLzNMWjFFQT09IiwidmFsdWUiOiI2RFBwMVRFZUN4WDlQYnV1TkR4QXJwVnRkUWk5VDd1dXJ1XC91MWI1MGZYQT0iLCJtYWMiOiI2ZjZkN2E3OGMyMzlmZDUwODExODYwNmQ3ODM2NDBkZTkwYzQ4ZDc4MWMzOTQ4MDRkZjNjNzgwZjg5YTFmZjk1In0=.png',
            'phone' => $data['phone'],
            'password' => bcrypt($data['password']),
            'access_source' => 'phone',
            'status' => 1,
        ]);
    }
}