<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
$home_private_group = function (){
    Route::group(['prefix' => 'Github'],function(){
        Route::post('/webhook','GithubController@webhook')->name('Home.Github.webhook');
    });
    Route::group(['prefix' => 'Wechat'],function(){
        Route::post('/vail','WechatController@vail')->name('Home.Wechat.vail');
    });
    Route::group(['prefix' => 'Test'],function(){
        Route::get('/index','TestController@index')->name('Home.Test.index');
    });
    Route::group(['prefix' => 'Pay'],function(){
        Route::get('/wechat','PayController@wechat')->name('Home.Pay.wechat');
        Route::get('/wechat_notify','PayController@wechat_notify')->name('Home.Pay.wechat_notify');
        Route::post('/wechat_notify','PayController@wechat_notify')->name('Home.Pay.wechat_notify');
    });
    /*Route::group(['prefix' => 'Order'],function(){
        Route::get('/checkout','OrderController@checkout')->name('Home.Order.checkout');
        Route::post('/create','OrderController@create')->name('Home.Order.create');
        Route::get('/getList','OrderController@getList')->name('Home.Order.getList');
        Route::get('/detail/{sn}','OrderController@detail')->name('Home.Order.detail');
        Route::get('/payOrder/{sn}','OrderController@payOrder')->name('Home.Order.payOrder');
        Route::post('/payOrder/{sn}','OrderController@payOrder')->name('Home.Order.payOrder');
        Route::delete('/cancelOrder/{sn}','OrderController@cancelOrder')->name('Home.Order.cancelOrder');
    });
    Route::group(['prefix' => 'Member'],function(){
        $controller = 'Member';
        Route::get('/index',"{$controller}Controller@index")->name("Home.{$controller}.index");
        Route::post('/index',"{$controller}Controller@index")->name("Home.{$controller}.update");
        Route::get('/wallet',"{$controller}Controller@wallet")->name("Home.{$controller}.wallet");
        Route::get('/collect_list',"{$controller}Controller@collectList")->name("Home.{$controller}.collect_list");
        Route::get('/address_list',"{$controller}Controller@addressList")->name("Home.{$controller}.address_list");
        Route::get('/reset_password',"{$controller}Controller@resetPassword")->name("Home.{$controller}.reset_password");
        Route::get('/logout',"{$controller}Controller@logout")->name("Home.{$controller}.logout");
    });
    Route::group(['prefix' => 'Ajax'],function(){
        Route::post('/saveAddress','AjaxController@saveAddress')->name('Home.Ajax.saveAddress');
        Route::post('/getOrderDetail','AjaxController@getOrderDetail')->name('Home.Ajax.getOrderDetail');
    });*/
};

$admin_private_group = function(){
    Route::get('/','IndexController@index');
    Route::get('/logout','IndexController@logout');
    Route::group(['prefix' => 'Index'],function(){
        Route::get('/','IndexController@index');
        Route::get('/index','IndexController@index');
        Route::get('/about_us','IndexController@about_us');
        Route::get('/billboard','IndexController@billboard');
    });
    Route::group(['prefix' => 'Statistics'], function () {
        $controller = 'Statistics';
        Route::get('/index', "{$controller}Controller@index");
        Route::post('/recharge', "{$controller}Controller@recharge");
        Route::post('/order', "{$controller}Controller@order");
        Route::post('/order_chart', "{$controller}Controller@order_chart");
        Route::post('/user', "{$controller}Controller@user");
    });
    Route::group(['prefix' => 'Auth'],function(){
        $controller = 'Auth';
        Route::get('/admin_list',"{$controller}Controller@admin_list");
        Route::get('/permission_list',"{$controller}Controller@permission_list");
        Route::get('/permission_create',"{$controller}Controller@permission_create");
        Route::post('/permission_create',"{$controller}Controller@permission_create");
        Route::get('/permission_edit/{id}',"{$controller}Controller@permission_edit");
        Route::post('/permission_edit/{id}',"{$controller}Controller@permission_edit");
        Route::delete('/permission_delete',"{$controller}Controller@permission_delete");
        Route::get('/role_list',"{$controller}Controller@role_list");
        Route::get('/role_create',"{$controller}Controller@role_create");
        Route::post('/role_create',"{$controller}Controller@role_create");
        Route::get('/role_edit/{id}',"{$controller}Controller@role_edit");
        Route::post('/role_edit/{id}',"{$controller}Controller@role_edit");
        Route::delete('/role_delete',"{$controller}Controller@role_delete");
        Route::get('/admin_show/{id}',"{$controller}Controller@admin_show");
        Route::post('/admin_store/{id}',"{$controller}Controller@admin_store");
        Route::post('/admin_avatar_upload',"{$controller}Controller@admin_avatar_upload");
    });
    Route::group(['prefix' => 'Article'],function(){
        $controller = 'Article';
        Route::get('/index',"{$controller}Controller@index");
        Route::get('/add',"{$controller}Controller@add");
        Route::post('/add',"{$controller}Controller@add");
        Route::get('/edit/{id}',"{$controller}Controller@edit");
        Route::post('/edit/{id}',"{$controller}Controller@edit");
        Route::get('/addCate',"{$controller}Controller@addCate");
        Route::post('/addCate',"{$controller}Controller@addCate");
        Route::get('/addCate/{id}',"{$controller}Controller@addCate");
        Route::post('/addCate/{id}',"{$controller}Controller@addCate");
        Route::get('/editCate/{id}',"{$controller}Controller@editCate");
        Route::post('/editCate/{id}',"{$controller}Controller@editCate");
        Route::get('/cateList',"{$controller}Controller@cateList");
        Route::delete('/delete',"{$controller}Controller@delete");
        Route::delete('/deleteCate',"{$controller}Controller@deleteCate");
        Route::get('/{slug}',"{$controller}Controller@show");
    });
    Route::group(['prefix' => 'Goods'],function(){
        $controller = 'Goods';
        Route::get('/addGoods',"{$controller}Controller@addGoods");
        Route::post('/addGoods',"{$controller}Controller@addGoods");
        Route::get('/editGoods/{id}',"{$controller}Controller@editGoods");
        Route::post('/editGoods/{id}',"{$controller}Controller@editGoods");
        Route::get('/addGoodsPicture/{goods_id}',"{$controller}Controller@addGoodsPicture");
        Route::post('/addGoodsPicture/{goods_id}',"{$controller}Controller@addGoodsPicture");
        Route::get('/editGoodsPicture/{id}',"{$controller}Controller@editGoodsPicture");
        Route::post('/editGoodsPicture/{id}',"{$controller}Controller@editGoodsPicture");
        Route::get('/addCategory',"{$controller}Controller@addCategory");
        Route::post('/addCategory',"{$controller}Controller@addCategory");
        Route::get('/addCategory/{id}',"{$controller}Controller@addCategory");
        Route::post('/addCategory/{id}',"{$controller}Controller@addCategory");
        Route::get('/editCategory/{id}',"{$controller}Controller@editCategory");
        Route::post('/editCategory/{id}',"{$controller}Controller@editCategory");
        Route::get('/goodsCategoryList',"{$controller}Controller@goodsCategoryList");
        Route::get('/goodsList/{id}',"{$controller}Controller@goodsList");
        Route::get('/goodsList',"{$controller}Controller@goodsList");
        Route::get('/goodsPictureList/{goods_id}',"{$controller}Controller@goodsPictureList");
        Route::get('/goodsPictureList',"{$controller}Controller@goodsPictureList");
        Route::delete('/deleteGoods',"{$controller}Controller@deleteGoods");
        Route::delete('/deleteGoodsPicture',"{$controller}Controller@deleteGoodsPicture");
        Route::delete('/deleteGoodsCategory',"{$controller}Controller@deleteGoodsCategory");
    });
    Route::group(['prefix' => 'Attribute'],function(){
        $controller = 'Attribute';
        Route::get('/addAttribute',"{$controller}Controller@addAttribute");
        Route::post('/addAttribute',"{$controller}Controller@addAttribute");
        Route::get('/editAttribute/{id}',"{$controller}Controller@editAttribute");
        Route::post('/editAttribute/{id}',"{$controller}Controller@editAttribute");
        Route::get('/addCategory',"{$controller}Controller@addCategory");
        Route::post('/addCategory',"{$controller}Controller@addCategory");
        Route::get('/editCategory/{id}',"{$controller}Controller@editCategory");
        Route::post('/editCategory/{id}',"{$controller}Controller@editCategory");
        Route::get('/attributeCategoryList',"{$controller}Controller@attributeCategoryList");
        Route::get('/attributeList/{id}',"{$controller}Controller@attributeList");
        Route::delete('/deleteAttribute',"{$controller}Controller@deleteAttribute");
        Route::delete('/deleteAttributeCategory',"{$controller}Controller@deleteAttributeCategory");
    });
    Route::group(['prefix' => 'Order'],function(){
        $controller = 'Order';
        Route::get('/orderList',"{$controller}Controller@orderList")->name("Admin.{$controller}.orderList");
        Route::get('/detail/{sn}',"{$controller}Controller@detail")->name("Admin.{$controller}.detail");
        Route::delete('/cancelOrder/{sn}',"{$controller}Controller@cancelOrder")->name("Admin.{$controller}.cancelOrder");
        Route::post('/nextStatus',"{$controller}Controller@nextStatus")->name("Admin.{$controller}.nextStatus");
    });
    Route::group(['prefix' => 'SystemLog'],function(){
        $controller = 'SystemLog';
        Route::get('/index',"{$controller}Controller@index")->name("Admin.{$controller}.index");
        Route::post('/detail/{id}',"{$controller}Controller@detail")->name("Admin.{$controller}.detail");
    });
    Route::group(['prefix' => 'System'],function(){
        $controller = 'System';
        Route::get('/phpinfo',"{$controller}Controller@phpinfo")->name("Admin.{$controller}.phpinfo");
        Route::get('/tz',"{$controller}Controller@tz")->name("Admin.{$controller}.tz");
    });
    Route::group(['prefix' => 'Ajax'],function(){
        $controller = 'Ajax';
        Route::post('/getAttributesList',"{$controller}Controller@getAttributesList")->name("Admin.{$controller}.getOrderDetail");
    });
    Route::resource('User', 'UserController');
    Route::resource('Advertisement', 'AdvertisementController');
    Route::resource('Feedback', 'FeedbackController');
    Route::resource('Report', 'ReportController');
    Route::resource('Sign', 'SignController');
    Route::resource('Room', 'RoomController');
    Route::resource('Album', 'AlbumController');
    Route::resource('AlbumPicture', 'AlbumPictureController');
};

$admin_public_group = function(){
    Route::group(['prefix' => 'Login'],function(){
        Route::get('/','LoginController@index')->name('admin.login.index');
        Route::post('/','LoginController@index');
        Route::get('/index','LoginController@index');
        Route::get('/register','LoginController@register');
        Route::post('/index','LoginController@index');
        Route::post('/register','LoginController@register');
        Route::get('/github', 'LoginController@redirectToProvider');
        Route::get('/github/callback', 'LoginController@handleProviderCallback');
    });
};

$auth_public_group = function(){
//    Route::get('/wechat/login','WechatController@login');
    Route::get('/oauth/callback/driver/{driver}', 'OAuthAuthorizationController@handleProviderCallback');
    Route::get('/oauth/redirect/driver/{driver}', 'OAuthAuthorizationController@redirectToProvider');
};

//Route::group(['prefix' => '','namespace' => 'Home'],$home_private_group);

Route::group(['prefix' => '', 'namespace' => 'Admin', 'middleware' => ['admin.login', 'admin.permission']], $admin_private_group);

Route::group(['prefix' => 'Auth','namespace' => 'Auth'],$auth_public_group);

Route::group(['prefix' => 'auth','namespace' => 'Auth'],$auth_public_group);

Route::group(['prefix' => 'Admin','namespace' => 'Admin'],$admin_public_group);

Route::group(['prefix' => 'admin','namespace' => 'Admin'],$admin_public_group);

Route::group(['prefix' => 'Admin','namespace' => 'Admin','middleware' => ['admin.login','admin.permission']],$admin_private_group);

Route::group(['prefix' => 'admin','namespace' => 'Admin','middleware' => ['admin.login','admin.permission']],$admin_private_group);