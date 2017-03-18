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
			$field='stock,buying_limitation';
			//获取库存及限购数目
			$inventory=$this-> product -> getData($map,$field);
			//检查用户购买数目是否超过库存及限购数目
			if($data['number']>$inventory['stock']) $data['number']=$inventory['stock'];
			if($data['number']>$inventory['buying_limitation']) $data['number']=$inventory['buying_limitation'];
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
      $map['id']=$id;
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
