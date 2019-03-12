<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => \App\Http\Models\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => env('APP_URL').env('GITHUB_REDIRECT'),
    ],

    'wechat' => [
        'client_id' => env('WECHAT_CLIENT_ID'),
        'client_secret' => env('WECHAT_CLIENT_SECRET'),
        'redirect' => env('APP_URL').env('WECHAT_REDIRECT'),
    ],

    'mpwechat' => [
        'client_id' => env('WECHAT_CLIENT_ID'),
        'client_secret' => env('WECHAT_CLIENT_SECRET'),
        'redirect' => env('APP_URL').env('WECHAT_MP_REDIRECT'),
    ],

    'qq' => [
        'client_id' => env('QQ_CLIENT_ID'),
        'client_secret' => env('QQ_CLIENT_SECRET'),
        'redirect' => env('APP_URL').env('QQ_REDIRECT'),
    ],
];
