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
	}

	/**
	 * 订单加车接口
	 */
	public function addCart(){
	    $data=$this-> input -> get(array('product_id','shop_id','price','number'));
			$map['id']=$data['product_id'];
			//获取库存及限购数目
			$product_info=$this-> product -> getData($map);
			//库存为0时，拒绝添加购物车请求
			if ($product_info['stock']==0) {
				error_log(date('YmdHis')."-[".$product_info['name']."]".'inventory_empty'."\n",3,"/tmp/inventory-empty.log");
				exit ('该商品库存已空');
			}
			//检查用户购买数目是否超过库存及限购数目
			if($data['number']>$product_info['stock']) $data['number']=$product_info['stock'];
			if($data['number']>$product_info['buying_limitation']) $data['number']=$product_info['buying_limitation'];
			//修改商品库存
			$product_info['stock']-=$data['number'];
			$change_inventory=$this -> product -> editData($product_info);
			//添加订单信息到订单表
	    $uid=$this-> user -> getuid();
	    $data['uid']=$uid;
	    $data['order_id']=time();
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
	    $uid=$this-> user -> getuid();
      $map['uid']=$uid;
      $map['order_status']=0;
			$order_status['order_status']=1;
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
	 * 清空购物车
	 */
	public function deleteOrder(){
			$id=$this -> input -> get('id');
      $map_order['id']=$id;
			//先恢复库存
			$order_info=$this -> order -> getData($map_order);
			$map_product['id']=$order_info['product_id'];
			$product_info=$this -> product -> getData($map_product);
			$product_info['stock']+=$order_info['number'];
			$change_inventory=$this -> product -> editData($product_info);
      $result=$this-> order -> delData($map);
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
	    $uid=$this-> user -> getuid();
      $map['uid']=$uid;
      $map['order_status']=0;
			$order_info=$this -> order -> getData($map_order);

      $result=$this-> order -> delData($map);
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
	public function test(){

	}


}
