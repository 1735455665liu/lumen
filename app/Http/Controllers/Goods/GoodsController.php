<?php
namespace App\Http\Controllers\Goods;

use App\Model\cart;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Model\username;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Request;
use App\Model\goodslist;
use App\Model\order;
use App\Model\order_detail;
class GoodsController extends BaseController
{
    //添加购物车接口
    public function cart(){
        $data=$_POST;
        if(!isset($data)){
            $response=[
                'error'=>50001,
                'msg'=>'禁止非法操作'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
                $arr=[
                    'goods_id'=>$data['goods_id'],
                    'goods_name'=>$data['goods_name'],
                    'self_price'=>$data['self_price'],
                    'buy_number'=>1,
                    'user_id'=>$_GET['uid'],
                    'create_time'=>time(),
                    'update_time'=>time()
                ];
           $GoodsId=cart::insertGetId($arr);
            if($GoodsId){
                $response=[
                    'error'=>0,
                    'msg'=>'添加购物车成功'
                ];
                die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }else{
            $response=[
                'error'=>40006,
                'msg'=>'添加购物车失败'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }


    }
    //商品列表接口
    public function goods(){
        $goodsInfo=goodslist::all();
        $json=json_encode($goodsInfo);
        return $json;

    }
    //商品详情接口
    public function goodslist(){
        $goods_id=$_POST['goods_id'];
        if(!isset($goods_id)){
            die('禁止非法操作');
        }

        $GoodsInfo=goodslist::where(['goods_id'=>$goods_id])->first();
        $json=json_encode($GoodsInfo);
        return $json;
    }
    //生成订单接口
    public function order(){

        $user_id=$_GET['uid'];//获取用户id
        $order_on=$this->Getorder($user_id);//生成订单号
        $CartInfo=cart::get()->toArray();//获取购物车所有数据


        $order_aumout=0;//获取商品总价格
        foreach ($CartInfo as $k=>$v){
            $order_aumout+=$v['self_price']*$v['buy_number'];
        }
        $arr=[
          'user_id'=>$user_id,
            'order_no'=>$order_on,
            'order_amout'=>$order_aumout,
            'create_time'=>time(),
            'update_time'=>time()
        ];
        $orderInfo=order::insertGetId($arr); //加入订单表



        foreach ($CartInfo as $key=>$val){
            $arr=[
                'goods_name'=>$val['goods_name'],
                'goods_price'=>$val['self_price'],
                'buy_number'=>$val['buy_number'],
                'goods_id'=>$val['goods_id'],
                'user_id'=>$user_id,
                'order_id'=>$orderInfo,
                'create_time'=>time()
        ];
        $orderDetail=order_detail::insertGetId($arr);
        }
        if($orderDetail){
            $response=[
              'error'=>0,
              'msg'=>'加入订单成功'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }else{
            $response=[
                'error'=>40008,
                'msg'=>'加入订单失败'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }

    }
    //查询购物车列表接口
    public function cartlist(){
        $cartInfo=cart::get();
        $Json=json_encode($cartInfo);
        return $Json;
    }
    //生成订单号
    public function Getorder($user_id){
            $user_id=$user_id.time().rand().Str::random(6);
            return $user_id;


        }
        //订单列表展示
    public function orderlist(){
        $orderDetail=order::all();
        $orderJson=json_encode($orderDetail);
        return $orderJson;
    }
}
