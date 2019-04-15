<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Admin\RegisterRequest;
use Laravel\Socialite\Facades\Socialite;
use Validator;
use Crypt;
use App\Http\Models\Admin;

class LoginController extends CommonController
{
    public function index()
    {
        return view('Admin.Login.login');
    }

    public function loginHandle(LoginRequest $request)
    {
        $input = $request->all();
        $adminModel = new Admin();
        $admin_info = $adminModel->where('email', $input['email'])->select('id', 'nickname', 'avatar', 'password', 'status')->first();
        if (empty($admin_info) || $input['password'] !== Crypt::decrypt($admin_info['password'])) {
            $errors[] = '账号密码错误.';
            return back()->withErrors($errors);
        }
        if (empty($admin_info['status'])) {
            $errors[] = '您的账号已被冻结,请联系管理员解冻.';
            return back()->withErrors($errors);
        }
        $admin_info_array = $admin_info->toArray();
        $admin_info_array = array_except($admin_info_array, ['password', 'status']);
        session(['admin_info' => $admin_info_array]);
        $admin_info->token = session('_token');
        $admin_info->save();
        return redirect()->action('Admin\IndexController@index');
    }

    public function register()
    {
        return view('Admin.Login.register');
    }

    public function registerHandle(RegisterRequest $request)
    {
        $input = $request->all();
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
        } else {
            $errors[] = '网络繁忙,请稍后再试.';
            return back()->withErrors($errors);
        }
    }
}
