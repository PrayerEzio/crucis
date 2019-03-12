<?php

namespace App\Http\Controllers\Admin;

use Laravel\Socialite\Facades\Socialite;
use Validator;
use Crypt;
use App\Http\Models\Admin;
use Illuminate\Http\Request;

use App\Http\Requests;

class LoginController extends CommonController
{
    public function index(Request $request)
    {
        if ($input = $request->all())
        {
            $rule = [
                'email' => 'required',
                'password' => 'required',
            ];
            $message = [
                'email.required' => '请输入您的邮箱.',
                'password.required' => '请输入您的密码.',
            ];
            $validator = Validator::make($input,$rule,$message);
            if ($validator->fails())
            {
                return back()->withErrors($validator->errors());
            }
            $adminModel = new Admin();
            $admin_info = $adminModel->where('email',$input['email'])->select('id','nickname','avatar','password','status')->first();
            if (empty($admin_info) || $input['password'] !== Crypt::decrypt($admin_info['password']))
            {
                $errors[] = '账号密码错误.';
                return back()->withErrors($errors);
            }
            if (empty($admin_info['status']))
            {
                $errors[] = '您的账号已被冻结,请联系管理员解冻.';
                return back()->withErrors($errors);
            }
            $admin_info_array = $admin_info->toArray();
            unset($admin_info_array['password']);
            unset($admin_info_array['status']);
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
        if ($input = $request->all())
        {
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
            if ($validator->fails())
            {
                return back()->withErrors($validator->errors());
            }
            $admin_user['nickname'] = $input['email'];
            $admin_user['email'] = $input['email'];
            $admin_user['password'] = Crypt::encrypt($input['password']);
            $admin_user['register_ip'] = $request->getClientIp();
            $admin_user['is_super_admin'] = 0;
            $admin_user['status'] = 1;
            $admin_user['avatar'] = "//img.91ysml.net/demo/eyJpdiI6IlllRGxGakpBSWltblNzZEJVcHdVSmc9PSIsInZhbHVlIjoiS1BWMDJHenJ0Q3g4d2M0SVcyclJHRWJ1RWx5NXlUeDlTS0hOV0ozT2dUanhXRzRuS0g1TDE0Vjh0cDVZZmdzSyIsIm1hYyI6Ijg4YTU0NDIxMDg3ZTc3ZDM5OTM1MjgyOTE1YjY4MzgzMGU1NDZjYTY2MWRmNDljOGM2NGJiMDM5ZWZlMmY5YWIifQ==.png";
            $admin = Admin::create($admin_user);
            if ($admin)
            {
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
