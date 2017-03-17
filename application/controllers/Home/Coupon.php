<?php

class Coupon extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this -> load -> model('user_model', 'user');
		$this -> load -> model('coupon_model', 'coupon');
	}

	/**
	 * 获取当前用户的优惠券状态
	 */
	public function coupon_status(){
		$uid=$this->user->getuid();
		$map['uid']=$uid;
	  $coupon_status=$this -> coupon ->getData($map);
	  echo json_encode($coupon_status);
	}

}
