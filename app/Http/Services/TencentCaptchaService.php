<?php
/**
 * Copyright (c) 2019. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace App\Http\Services;

class TencentCaptchaService
{
    protected $app_id;

    protected $app_secret_key;

    public function __construct()
    {
        $this->app_id = config('captcha.tencent.app_id');
        $this->app_secret_key = config('captcha.tencent.secret_key');
    }

    public function auth($ticket, $rand_str, $ip)
    {
        $apiurl = 'https://ssl.captcha.qq.com/ticket/verify';
        $param = [
            'aid' => $this->app_id,
            'AppSecretKey' => $this->app_secret_key,
            'Ticket' => $ticket,
            'Randstr' => $rand_str,
            'UserIP' => $ip,
        ];
        $result = get_api($apiurl, $param);
        return $result;
    }
}