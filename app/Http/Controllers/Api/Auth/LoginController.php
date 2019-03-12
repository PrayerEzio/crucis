<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Models\User;
use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    use Helpers;

    /**
     * 手机登录
     *
     * 手机密码登录
     *
     * @Post("/login")
     * @Versions({"v1"})
     * @Parameters({
     *     @Parameter("phone", description="手机号",required=true),
     *     @Parameter("password", description="密码",required=true),
     * })
     * @Transaction({
     *     @Request({"phone": "15013845571", "password": "123456"}),
     *     @Response(401, body={"status_code":401,"message":"Bad Credentials"}),
     *     @Response(200, body={"status_code":200,"message":"User Authenticated","token":"{token}"}),
     * })
     */
    public function login(Request $request) {

        $user = User::where('phone', $request->phone)->first();

        if ($user && Hash::check($request->get('password'), $user->password)) {
            $token = JWTAuth::fromUser($user);
            return $this->sendLoginResponse($request, $token);
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function sendLoginResponse(Request $request, $token) {
        $this->clearLoginAttempts($request);

        return $this->authenticated($token);
    }

    public function authenticated($token) {
        return $this->response->array([
            'token' => $token,
            'status_code' => 200,
            'message' => 'User Authenticated',
        ]);
    }

    public function sendFailedLoginResponse() {
        //throw new UnauthorizedHttpException("Bad Credentials");
        return $this->response->array([
            'status_code' => 401,
            'message' => '密码错误',
        ]);
    }

    /**
     * 登出
     *
     * 退出登录
     *
     * @Post("/logout")
     * @Versions({"v1"})
     * @Parameters({
     * })
     * @Transaction({
     *     @Response(200, body={"status_code":200,"message":"退出成功"}),
     * })
     */
    public function logout() {
        Auth::guard('api')->logout();
        return $this->response->array([
            'status_code' => 200,
            'message' => '退出成功',
        ]);
    }
}