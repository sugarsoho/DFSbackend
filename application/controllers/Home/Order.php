<?php
/*use \QCloud_WeApp_SDK\Helper\Util as Util;
use  \QCloud_WeApp_SDK\Auth\Constants as Constants;
use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;*/

class Order extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this -> load -> model('order_model', 'order');
		$this -> load -> model('user_model', 'user');
		$this -> load -> model('product_model', 'product');
		$this -> load -> helper('url');
		$this -> load -> helper('myfunction');
	}

	/**
	 * 订单加车接口
	 */
	public function addCart(){
	    $data=$this-> input -> get(array('product_id','shop_id','price','number'));
	    $uid=$this-> input -> get('uid');
			if($uid==NULL) exit('用户未授权登录，请重新下载小程序，并授权登录');
			$map['id']=$data['product_id'];
			//获取库存及限购数目
			$product_info=$this-> product -> getInfo($map);

			//库存为0时，拒绝添加购物车请求
			if ($product_info['stock']==0) {
				error_log(date('YmdHis')."-[".$product_info['name']."]".'inventory_empty'."\n",3,"/tmp/inventory-empty.log");
				exit ('该商品库存已空');
			}

			//检查用户购买数目是否超过库存及限购数目
			if($data['number']>$product_info['stock']) $data['number']=$product_info['stock'];
			if($data['number']>$product_info['buying_limitation']) $data['number']=$product_info['buying_limitation'];

			//将$data['price']=$data['price']*$data['number'];
			$data['price']=$data['price']*$data['number'];

			/**
			 * 修改商品库存被调整至下单环节
			 * $product_info['stock']-=$data['number'];
			 * $change_inventory=$this -> product -> editData($product_info);
			 */

			//添加订单信息到订单表
	    $data['uid']=$uid;
	    // $data['order_id']=time();
	    $data['start_time']=date('YmdHis');
	    $result=$this -> order -> addData($data);
	    if($result){
	    	echo 'success';
	    }
	    else{
	    	echo 'fail';
	    }
	}

	/**
	 * 在购物车内确认订单的接口
	 */
	public function confirmOrder(){
			$phone=$this-> input -> get('phone');
	    $uid=$this-> input -> get('uid');
			if($uid==NULL) exit('用户未授权登录，请重新下载小程序，并授权登录');
      $map['uid']=$uid;
      $map['order_status']=0;
			//修改库存
			$order_info=$this -> order -> getData($map);
			foreach ($order_info as $key => $value) {
				$map2['id']=$value['product_id'];
				$product_info=$this-> product -> getInfo($map2);
				//库存多于该订单需要的商品时的处理，减少库存
				if($product_info['stock']>=$value['number']){
					$product_info['stock']-=$value['number'];
					$change_inventory=$this -> product -> editData($product_info);
				}
				//当库存不足时该如何处理？？
				else {
					error_log(date('YmdHis')."-[".$product_info['name']."]".'inventory_empty'."\n",3,"/tmp/inventory-empty.log");
				}
			}
			$order_status['order_status']=1;
			//用同一时间戳给多个商品打上同一订单index,再加上用户的电话
			$order_status['order_id']=time();
			$order_status['phone']=$phone;
      $result=$this-> order -> editMultiData($map,$order_status);
      if($result){
        echo 'success';
      }
      else{
      	echo 'fail';
      }
	}

	/**
	 * 核销接口
	 */
	/*public function order_finish(){
	    $order_id=$this-> input -> get('order_id');
	    $result=$this -> order -> finish($order_id);
	    if($result){
	    	echo 'success';
	    }
	    else{
	    	echo 'fail';
	    }
	}*/

	/**
	 * 删除购物车某样商品
	 */
	public function deleteOrder(){
			$id=$this -> input -> get('id');
      $map_order['id']=$id;
			//先恢复库存（不在购物车修改库存了）
			// $order_info=$this -> order -> getInfo($map_order);
			// $map_product['id']=$order_info['product_id'];
			// $product_info=$this -> product -> getInfo($map_product);
			// $product_info['stock']+=$order_info['number'];
			// $change_inventory=$this -> product -> editData($product_info);
      $result=$this-> order -> delData($map_order);
	    if($result){
	    	echo 'success';
	    }
	    else{
	    	echo 'fail';
	    }
	}

	/**
	 * 清空购物车
	 */
	public function emptyCart(){
	    $uid=$this-> input -> get('uid');
			if($uid==NULL) exit('用户未授权登录，请重新下载小程序，并授权登录');
      $map_order['uid']=$uid;
      $map_order['order_status']=0;
			// 不在购物车删除订单了
			// $order_info=$this -> order -> getData($map_order);
			// foreach ($order_info as $key => $value) {
			// 	$map_product['id']=$value['product_id'];
			// 	$product_info=$this -> product -> getInfo($map_product);
			// 	$product_info['stock']+=$value['number'];
			// 	$change_inventory=$this -> product -> editData($product_info);
			// }
      $result=$this-> order -> delData($map_order);
	    if($result){
	    	echo 'success';
	    }
	    else{
	    	echo 'fail';
	    }
	}



	/**
	 * 测试接口
	 */
	public function combineOrder(){
			// $phone=$this-> input -> get('phone');
	    $uid=$this-> input -> get('uid');
			if($uid==NULL) exit('用户未授权登录，请重新下载小程序，并授权登录');
      $map['uid']=$uid;
      $map['order_status']=0;
			//修改库存
			$order_info=$this -> order -> getData($map);
			foreach ($order_info as $key => $value) {
				$map2['id']=$value['product_id'];
				$product_info=$this-> product -> getInfo($map2);
				//库存多于该订单需要的商品时的处理，减少库存
				if($product_info['stock']>=$value['number']){
					$product_info['stock']-=$value['number'];
					$change_inventory=$this -> product -> editData($product_info);
				}
				//当库存不足时该如何处理？？
				else {
					error_log(date('YmdHis')."-[".$product_info['name']."]".'inventory_empty'."\n",3,"/tmp/inventory-empty.log");
				}
			}
			// $order_status['order_status']=1; //成功回调后才修改订单状态
			//用同一时间戳给多个商品打上同一订单index,再加上用户的电话
			$order_status['order_id']=time();
			// $order_status['phone']=$phone;
      $result=$this-> order -> editMultiData($map,$order_status);
      if($result != NULL){
        echo $order_status['order_id'];
      }
      else{
      	echo 0;
      }
	}

	public function test()
	{
		echo get_exchange_rate();
	}

}
