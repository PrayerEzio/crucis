<?php
/**
 * Copyright (c) 2019. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

return [
    'app_url' => env('APP_URL', 'http://www.crucis.cn'),
    'point_exchange_rate' => 20,
    'inviter_reward' => 10,
    'coin_exchange_rate' => 10,
    'http_secure' => env('HTTP_SECURE',false),
    'github_webhook_branch' => env('GITHUB_WEBHOOK_BRANCH','master'),
    'root_path' => env('ROOT_PATH','/data/wwwroot/default'),
];