<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Request;
use App\Model\username;
class app_token
{
    public function handle($request, Closure $next)
    {
        $token=$request->input('token');
        $uid=$request->input('uid');
        $key='laravelapp_token';
        $redis_token=Redis::get($key);
        $userInfo=username::where(['id'=>$uid])->first();
        if($userInfo){
            if($token==$redis_token){
                $response=[
                    'name'=>$userInfo['name'],
                    'email'=>$userInfo['email'],
                    'msg'=>'ok'
                ];
                die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }else{
                $response=[
                    'error'=>40009,
                    'msg'=>'验证token有误'
                ];
                die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }
        }else{
            $response=[
                'error'=>40008,
                'msg'=>'信息未找到'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
    }
}
