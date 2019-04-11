<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Models\User;
use App\Http\Services\UserService;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class OAuthAuthorizationController extends Controller
{
    public function redirectToProvider(Request $request,$driver) {
        return Socialite::driver($driver)->redirect($request->share_code);
    }

    public function handleProviderCallback(Request $request,$driver) {
        $socialite_data = Socialite::driver($driver)->user();
        $user_model = new User();
        if ($driver == 'github') {
            $union_id = $socialite_data->id;
        } else {
            $union_id = $socialite_data->unionid;
        }
        $user = $user_model->Socialite($driver, $union_id)->first();
        if (empty($user))
        {
            $user = $this->create($driver,$socialite_data);
        }
        if ($user) {
            $token = JWTAuth::fromUser($user);
            //添加邀请关系日志
            $share_code = $request->state;
            if ($share_code) {
                $user_model = new User();
                $inviter = $user_model->where('user_sn',$share_code)->first();
                if ($inviter)
                {
                    $userService = new UserService();
                    $userService->addInvitationLog($inviter['id'],$user->id);
                }
            }
            $url = config('crucis.h5_url')."?token={$token}";
        } else {
            $url = config('crucis.h5_url')."?error_code=401&error_message={$driver}_unauthentication";
        }
        return redirect($url);
    }

    protected function create($driver,$socialite_data) {
        $socialite_user = $socialite_data->user;
        $user = new User();
        switch ($driver)
        {
            case 'github':
                $user->nickname = $socialite_data->nickname;
                $user->email = $socialite_data->email;
                $user->avatar = $socialite_data->avatar;
                $user->open_id = $socialite_user['node_id'];
                $user->unionid = $socialite_user['id'];
                $user->access_source = $driver;
                $user->access_token = $socialite_data->token;
                $user->refresh_token = $socialite_data->refreshToken;
                $user->gender = 1;
                $user->password = $socialite_user['id'];
                $user->status = 1;
                $user->save();
                break;
            case 'wechat_mp':
                dd($socialite_user);
                break;
            case 'wechat':
                $user->nickname = $socialite_data->nickname;
                $user->email = $socialite_data->email;
                $user->avatar = $socialite_data->avatar;
                $user->open_id = $socialite_data->openid;
                $user->unionid = $socialite_data->unionid;
                $user->access_source = $driver;
                $user->access_token = $socialite_data->token;
                $user->refresh_token = $socialite_data->refreshToken;
                $user->gender = $socialite_user['sex'];
                $user->password = $socialite_data->unionid;
                $user->status = 1;
                $user->save();
                break;
            case 'qq':
                $user->nickname = $socialite_data->nickname;
                $user->email = $socialite_data->email;
                $user->avatar = $socialite_data->avatar;
                $user->open_id = $socialite_data->openid;
                $user->unionid = $socialite_data->unionid;
                $user->access_source = $driver;
                $user->access_token = $socialite_data->token;
                $user->refresh_token = $socialite_data->refreshToken;
                $user->gender = $socialite_user['gender'] == '男' ? 1 : 2;
                $user->password = $socialite_data->unionid;
                $user->status = 1;
                $user->save();
                break;
            default:
                return false;
                break;
        }
        $user_sn = str_pad($user->id,5,"0",STR_PAD_LEFT);
        $user->user_sn = strtoupper(chr(rand(97, 122))).$user_sn;
        $user->save();
        $result = $user;
        return $result;
    }
}
