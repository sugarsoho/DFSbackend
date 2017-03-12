<?php
/*use \QCloud_WeApp_SDK\Helper\Util as Util;
use  \QCloud_WeApp_SDK\Auth\Constants as Constants;
use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;*/

class Order extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this -> load -> model('order_model', 'order');
		$this -> load -> model('user_model', 'user');
		$this -> load -> helper('url');
	}

	/**
	 * 订单加车接口
	 */
	public function addCart(){
	    $data=$this-> input -> get(array('product_id','shop_id','price','number'));
	    $uid=$this-> user -> getuid();
        $userinfo=$this-> user -> get($uid);
	    $data['openid']=$userinfo['openId'];
	    $data['order_id']=time();
	    $data['start_time']=date('YmdHis');
	    $result=$this -> order -> place_order($data);
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
        $userinfo=$this-> user -> get($uid);
        $map['openid']=$userinfo['openId'];
        $map['order_status']=0;
        $result=$this-> order -> confirm($map);
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
	public function emptyCart(){
	    $uid=$this-> user -> getuid();
        $userinfo=$this-> user -> get($uid);
        $map['openid']=$userinfo['openId'];
        $map['order_status']=1;
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