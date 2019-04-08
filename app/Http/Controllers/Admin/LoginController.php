<?php

namespace App\Http\Controllers\Admin;

use App\Http\Services\TencentCaptchaService;
use Laravel\Socialite\Facades\Socialite;
use Validator;
use Crypt;
use App\Http\Models\Admin;
use Illuminate\Http\Request;

class LoginController extends CommonController
{
    public function index(Request $request, TencentCaptchaService $captchaService)
    {
        if ($input = $request->all()) {
            $rule = [
                'email' => 'required',
                'password' => 'required',
            ];
            $message = [
                'email.required' => '请输入您的邮箱.',
                'password.required' => '请输入您的密码.',
            ];
            $validator = Validator::make($input,$rule,$message);
            if ($validator->fails()) {
                return back()->withErrors($validator->errors());
            }
            $captcha_result = $captchaService->auth($input['ticket'], $input['randstr'], $request->ip());
            if ($captcha_result['response'] != 1) {
                return back()->withErrors($captcha_result['err_msg']);
            }
            $adminModel = new Admin();
            $admin_info = $adminModel->where('email',$input['email'])->select('id','nickname','avatar','password','status')->first();
            if (empty($admin_info) || $input['password'] !== Crypt::decrypt($admin_info['password'])) {
                $errors[] = '账号密码错误.';
                return back()->withErrors($errors);
            }
            if (empty($admin_info['status'])) {
                $errors[] = '您的账号已被冻结,请联系管理员解冻.';
                return back()->withErrors($errors);
            }
            $admin_info_array = $admin_info->toArray();
            $admin_info_array = array_except($admin_info_array,['password','status']);
            session(['admin_info'=>$admin_info_array]);
            $admin_info->token = session('_token');
            $admin_info->save();
            return redirect()->action('Admin\IndexController@index');
        }else {
            return view('Admin.Login.login');
        }
    }

    public function register(Request $request)
    {
        if ($input = $request->all()) {
            $rule = [
                'email' => 'required|email|unique:admins,email',
                'password' => 'required|confirmed|between:8,32',
                'register_protocol' => 'accepted'
            ];
            $message = [
                'email.required' => '请输入您的邮箱.',
                'email.email' => '您输入的邮箱地址不正确.',
                'email.unique' => '您输入的邮箱已经被注册.',
                'password.required' => '请输入您的密码.',
                'password.confirmed' => '两次输入的密码不一致.',
                'password.between' => '密码长度必须在8到32位之间.',
                'register_protocol.accepted' => '请同意我们的注册协议.'
            ];
            $validator = Validator::make($input,$rule,$message);
            if ($validator->fails()) {
                return back()->withErrors($validator->errors());
            }
            $admin_user['nickname'] = $input['email'];
            $admin_user['email'] = $input['email'];
            $admin_user['password'] = Crypt::encrypt($input['password']);
            $admin_user['register_ip'] = $request->getClientIp();
            $admin_user['is_super_admin'] = 0;
            $admin_user['status'] = 1;
            $admin = Admin::create($admin_user);
            if ($admin) {
                //TODO:发送注册成功通知.
                return redirect()->action('Admin\IndexController@index');
            }else {
                $errors[] = '网络繁忙,请稍后再试.';
                return back()->withErrors($errors);
            }
        }else {
            return view('Admin.Login.register');
        }
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('github')->user();
        dump(session());
        dd($user);
        // $user->token;
    }
}
