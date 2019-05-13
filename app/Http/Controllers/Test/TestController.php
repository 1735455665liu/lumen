<?php

namespace App\Http\Controllers\Test;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Model\username;
use Illuminate\Support\Facades\DB;
class TestController extends BaseController{
    //对称加密
    public function getdncrypt(){
        $file=file_get_contents('php://input');
        $bas64=base64_decode($file);
        $json=json_decode($bas64);
//        var_dump($bas64);die;
        $encryptMethod = 'aes-256-cbc';
        $iv='bbbbbbbbbbbbbbbq';
        $dencrypt = openssl_decrypt($bas64, $encryptMethod, 'secret',1, $iv);
        var_dump($dencrypt);

    }
    //非对称加密
    public function getnocrypt(){
        $file=file_get_contents('php://input');//接受数据
        $base64=base64_decode($file);   //base64解密
        //读取公钥
        $public=openssl_get_publickey('file://'.storage_path('openssl/public.pem'));
        //公钥解密            //要解密的数据      //写入数据的参数  //读取公钥
        openssl_public_decrypt($base64,$json_public,$public);
        echo'<pre>';print_r($json_public);echo'<pre>';
    }
    //非对称加密签名
    public function sign(){
        //验证签名 openssl_verify()
        $str_sign=$_GET['sign'];
        echo '<pre>';print_r($str_sign);echo '<pre>';echo '<hr>';
        $file=file_get_contents('php://input');
        $base=base64_decode($file);
//        echo '<pre>';print_r($base);echo '<pre>';echo '<hr>';
        //读取公钥
        $public=openssl_get_publickey('file://'.storage_path('openssl/public.pem'));
        $error=openssl_verify($str_sign,$base,$public);
        if($error!=1){
            echo'签名有误';
            exit;
        }else{
            echo '验证成功';
        }
    }
    //执行注册
    public  function regdo(){
        $file=file_get_contents('php://input');
        $base=base64_decode($file);
        //读公钥
        $public=openssl_get_publickey('file://'.storage_path('openssl/public.pem'));
        openssl_public_decrypt($base,$value,$public);
//        var_dump($value);
        $arr=json_decode($value);
        $data=[
            'name'=>$arr->name,
            'pass'=>$arr->pass,
            'email'=>$arr->email
        ];
//        echo '<pre>';print_r($data);echo '<pre>';
            $id=username::insertGetId($data);
            if($id){
                $response=[
                  'error'=>0,
                  'msg'=>'添加成功'
                ];
           var_dump($response);
            }else{
                $response=[
                    'error'=>40001,
                    'msg'=>'添加失败'
                ];
                var_dump($response);
            }


    }
}