<?php
/**
 * Copyright (c) 2019. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Models\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ResetPasswordController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * 重置密码
     *
     * 重置登录密码
     *
     * @Post("/reset_password")
     * @Versions({"v1"})
     * @Parameters({
     *     @Parameter("phone", description="手机号",required=true),
     *     @Parameter("code", description="短信验证码",required=true),
     *     @Parameter("password", description="密码",required=true),
     * })
     * @Transaction({
     *     @Request({"phone": "15013845571", "code": "456345", "password": "123456"}),
     *     @Response(200, body={"status_code":500,"message":"{error_message}"}),
     *     @Response(200, body={"status_code":200,"message":"注册成功","token":"{token}"}),
     * })
     */
    public function reset(Request $request,User $user)
    {
        //验证短信验证码
        $sms_code = $this->getSmsCode($request->phone,"reset_password");
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

        $result = $user->where('phone',$request->phone)->update(['password' => bcrypt($request->password)]);

        if ($result == true) {
            return $this->response->array([
                "message" => "修改密码成功",
                "status_code" => 200,
            ]);
        } else {
            return $this->response->array([
                "message" => "修改密码失败",
                "status_code" => 500,
            ]);
        }
    }

    protected function validator(array $data) {
        return Validator::make($data, [
            'phone' => 'required|regex:/^1[0-9]{10}$/',
            'password' => 'required|min:6|max:12',
        ]);
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only(
            'phone', 'password'
        );
    }
}
