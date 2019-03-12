<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Models\SystemLog;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class BaseController extends Controller
{
    use Helpers;

    public function __construct()
    {
        $this->now_time = time();
    }

    protected function getUserInfo()
    {
        $this->user = auth('api')->user();
        if (!$this->user)
        {
            return $this->response->errorUnauthorized();
        }
        return $this->user;
    }

    protected function getSystemSetting($name)
    {
        switch ($name)
        {
            case 'point_exchange_rate':
            case 'inviter_reward':
            case 'coin_exchange_rate':
                return config("crucis.{$name}");break;
            default:
                return false;break;
        }
    }
}
