<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//接管路由
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    //登录
    $api->post('login', 'App\Http\Controllers\Api\Auth\LoginController@login');
    //登出
    $api->post('logout', 'App\Http\Controllers\Api\Auth\LoginController@logout');
    //注册
    $api->post('register', 'App\Http\Controllers\Api\Auth\RegisterController@register');
    //重置密码
    $api->post('reset_password', 'App\Http\Controllers\Api\Auth\ResetPasswordController@reset');
    //获取地址列表
    $api->get('address','App\Http\Controllers\Api\V1\AddressController@index')->middleware(['jwt.refresh']);
    //新建地址
    $api->post('address','App\Http\Controllers\Api\V1\AddressController@store')->middleware(['jwt.refresh']);
    //获取单条地址
    $api->get('address/{id}','App\Http\Controllers\Api\V1\AddressController@show')->middleware(['jwt.refresh']);
    //编辑地址
    $api->post('address/{id}','App\Http\Controllers\Api\V1\AddressController@update')->middleware(['jwt.refresh']);
    //删除地址
    $api->delete('address/{id}','App\Http\Controllers\Api\V1\AddressController@destroy')->middleware(['jwt.refresh']);
    //支付-微信公众号
    $api->post('pay/mpwechat','App\Http\Controllers\Api\V1\PayController@mpwechat')->middleware(['jwt.refresh']);
    //支付回调-微信
    $api->post('pay/wechat_notify','App\Http\Controllers\Api\V1\PayController@wechat_notify');
    //获取订单列表
    $api->get('order','App\Http\Controllers\Api\V1\OrderController@index')->middleware(['jwt.refresh']);
    //获取订单详情
    $api->get('order/{order_sn}','App\Http\Controllers\Api\V1\OrderController@show')->middleware(['jwt.refresh']);
    //通用上传接口
    $api->post('upload','App\Http\Controllers\Api\V1\UploadController@index')->middleware(['jwt.refresh']);
    //获取商品列表
    $api->get('goods','App\Http\Controllers\Api\V1\GoodsController@index');
    //获取商品详情
    $api->get('goods/{goods_sn}','App\Http\Controllers\Api\V1\GoodsController@show');
    //获取产品列表
    $api->get('product','App\Http\Controllers\Api\V1\ProductController@index');
    //获取产品详情
    $api->get('product/{product_sn}','App\Http\Controllers\Api\V1\ProductController@show');
    //发送短信验证码
    $api->post('send_sms','App\Http\Controllers\Api\V1\SmsController@index');
});
