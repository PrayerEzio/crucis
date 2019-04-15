<?php

namespace App\Http\Controllers\Auth;

use App\Http\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWT;

class WechatController extends Controller
{
    private $app_id = "wx4c07b4cc012de4af";

    private $app_secret = "e3ed8d3deab1a3234f1526923b289602";

    public function __construct()
    {

    }

    public function login(Request $request,User $user)
    {
        $code = trim($request->code);
        $state = trim($request->state);
        if($code && $state)
        {
            //通过code获取用户信息
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->app_id}&secret={$this->app_secret}&code={$code}&grant_type=authorization_code";
            $info = json_decode(get_url($url));
            $access_token = $info->access_token;
            $refresh_token = $info->refresh_token;
            $openid = $info->openid;
            session('wechat_openid',encrypt($openid));
            $unionid = $info->unionid;
            //检查此用户是否已经注册过
            $user = $user->where(["openid"=>$openid,"access_source"=>"wechat"])->first();
            if(!empty($user_data))
            {
                //更新用户微信网页授权access_token
                $user->access_token = $access_token;
                $user->refresh_token = $refresh_token;
                $user->access_source = "wechat";
                $user->userId($user_data->id)->save();
            } else {
                //未关注
                if($state == 'STATEuserinfo')
                {
                    $get_userinfo_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
                    $user_info = json_decode(get_url($get_userinfo_url));
                }else{
                    //已关注
                    $get_user_url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
                    $user_info = json_decode(get_url($get_user_url));
                }
                $user->nickname = $user_info->nickname;
                $user->openid = $user_info->openid;
                $user->gender = $user_info->sex;
                /*$user->country = $user_info->country;
                $user->province = $user_info->province;
                $user->city = $user_info->city;
                $user->usercity = $user_info->city;
                $user->unionid = $user_info->unionid;*/
                $user->avatar = $user_info->headimgurl;
                $user->access_token = $access_token;
                $user->refresh_token = $refresh_token;
                $user->access_source = "wechat";
                $user->save();
            }
            //授权
            $token = JWTAuth::fromUser($user);
            $redirect_uri = build_url(url()->full(),['token'=>$token]);
            redirect("{$redirect_uri}");
        }else{
            $redirect_uri = $request->redirect_uri;
            $c_url = url()->full();
            $scope = 'snsapi_userinfo';
            $re_url = urlencode($c_url);
            $sq_url ="https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->app_id}&redirect_uri={$re_url}&response_type=code&scope={$scope}&state={$redirect_uri}#wechat_redirect";
            return redirect($sq_url);
        }
    }

    public function refresh_token()
    {
        $refresh_token = "";//TODO:
        $url = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid={$this->app_id}&grant_type=refresh_token&refresh_token={$refresh_token}";
        $info = json_decode(get_url($url));
        $access_token = $info->access_token;
        $refresh_token = $info->refresh_token;
        $openid = $info->openid;
    }
}
