<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;

use Illuminate\Routing\Controller as BaseController;

use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cache;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        //
    }

    protected function getSmsCode($phone,$type="register")
    {
        return Cache::get("sms_code_{$type}_{$phone}");
    }

    //获取请求的方法
    protected function requestMethod()
    {
        $request = new Request();
        return strtoupper($request->method());
    }
}