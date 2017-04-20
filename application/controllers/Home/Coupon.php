<?php
header("Access-Control-Allow-Origin:*");

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
		$uid=$this-> input -> get('uid');
		if($uid==NULL) exit('用户未授权登录，请重新下载小程序，并授权登录');
		$map['uid']=$uid;
	  $coupon_status=$this -> coupon ->getInfo($map);
	  echo json_encode($coupon_status);
	}

	public function couponChange(){
		$uid=$this-> input -> get('uid');
		if($uid==NULL) exit('用户未授权登录，请重新下载小程序，并授权登录');
		$map['uid']=$uid;
		$data=$this -> coupon -> getInfo($map);
		if($data['coupon_status']==0)	$data['coupon_status']=1;
		else $data['coupon_status']=0;
		$result=$this -> coupon -> editData($data);
		if(!$result){
			echo "fail";
		}else{
			echo "success";
		}
	}

}
