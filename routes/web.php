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