<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->post('/getdncrypt','Test\TestController@getdncrypt');      //对称签名
$router->post('/getnocrypt','Test\TestController@getnocrypt');      //非对称加密
$router->post('/sign','Test\TestController@sign');      //非对称加密签名
$router->post('/regdo','Test\TestController@regdo');      //注册
$router->post('/logindo','Test\TestController@logindo');      //登录
$router->get('/getToken','Test\TestController@getToken');      //token
$router->get('/ajax','Test\TestController@ajax');      //ajax
$router->post('/appreg','Test\TestController@appreg');      //ajax
$router->post('/applogin','Test\TestController@applogin');      //applogin
$router->get('/apptoken',[
    'as'=>'profile',
    'user'=>'Test\TestController@apptoken',
    'middleware'=>'checklogin'
]);//apptoken

$router->post('/cart','Goods\GoodsController@cart');      //购物车接口
$router->post('/goods','Goods\GoodsController@goods');      //商品列表
$router->post('/goodslist','Goods\GoodsController@goodslist');      //商品列表
$router->post('/cart','Goods\GoodsController@cart');      //商品列表
$router->post('/cartlist','Goods\GoodsController@cartlist');      //商品列表
$router->post('/order','Goods\GoodsController@order');      //生成订单
$router->post('/orderlist','Goods\GoodsController@orderlist');      //生成订单
$router->post('/Alireturn','Pay\AliPayController@Alireturn');      //同步通知
$router->get('/notify','Pay\AliPayController@notify');      //异步通知
$router->get('/test','Pay\AliPayController@test');      //测试公钥
$router->get('/pay','Pay\AliPayController@pay');      //去支付
