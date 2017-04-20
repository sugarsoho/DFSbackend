<?php

header("Access-Control-Allow-Origin:*");

class Shop extends Home_Controller {

	public function __construct() {
		parent::__construct();
		$this -> load -> model('shop_model', 'shop');
		$this -> load -> model('shopadmin_model', 'shopadmin');
		$this -> load -> model('order_model', 'order');
		$this -> load -> model('product_model', 'product');
		$this -> load -> model('coupon_model', 'coupon');
		$this -> load -> model('user_model', 'user');
		$this -> load -> helper('url');
	}

	public function login(){
		$check = array('shopadmin_account' ,'shopadmin_password');
		$shopadmin=$this-> input -> get($check);
		$result['shopadmin']=$this -> shopadmin -> check($shopadmin);
		$this->session->set_tempdata($result, NULL, 7200);
		if($result['shopadmin']==NULL){
			echo 'Account doesn\'t exist';
		}else{
			echo 0;
		}
	}



	public function check_login(){
		// if(empty($_SESSION['shopadmin'])){
		// 	exit ('Please login again.');
		// }
		// return $_SESSION['shopadmin'];
		$shop['shop_id']=1;
		return $shop;
	}

	public function logout(){
		$result=$this->session->sess_destroy();
		if($result)	echo 0;
	}

	public function likeSearch(){
		$string=$this -> input -> get('string');
		$order_info=$this-> order -> likeSearch($string);
		$order_number=0;
		$product_number=0;
		$order[$order_number]['order_id']=0;
		foreach ($order_info as $key => $value) {
			if($order[$order_number]['order_id']!=$value['order_id']){
				$order_number += 1;
				$order[$order_number]['order_id'] = $value['order_id'];
				$order[$order_number]['uid'] = $value['uid'];
				$userinfo=$this -> user -> get($value['uid']);
				$order[$order_number]['nickname']=$userinfo['nickname'];
				$map2['uid']=$value['uid'];
				$order[$order_number]['coupon']=$this -> coupon -> getInfo('coupon', $map2);
				$product_number=0;
			}
			$order[$order_number]['order'][$product_number]=$value;
			$map3['id']=$value['product_id'];
			$product = $this -> product -> getInfo('product', $map3);
			if($product != NULL){
				$order[$order_number]['order'][$product_number]['product']=$product;
			}
			$product_number += 1;
		}
		array_splice($order,0,1);
		echo json_encode($order);

	}



	public function order_list(){
		$shopadmin=self::check_login();
		//获取当前页面
		$currentPage = $this -> input -> get('currentPage');
		//获取该商店所有订单
		//按order_id降序排列
		$map['shop_id']=$shopadmin['shop_id'];
		$map['order_status !=']=0;
		$order_sort='order_id DESC';
		$order_info=$this-> order -> getData('order', $map, '', $order_sort);
		$order_number=0;
		$product_number=0;
		$orderList[$order_number]['order_id']=0;
		foreach ($order_info as $key => $value) {
			if($orderList[$order_number]['order_id']!=$value['order_id']){
				$order_number += 1;
				$orderList[$order_number]['order_id'] = $value['order_id'];
				$orderList[$order_number]['uid'] = $value['uid'];
				$userinfo=$this -> user -> get($value['uid']);
				$orderList[$order_number]['nickname']=$userinfo['nickname'];
				$map2['uid']=$value['uid'];
				$orderList[$order_number]['coupon']=$this -> coupon -> getInfo('coupon', $map2);
				$product_number=0;
			}
			$orderList[$order_number]['order'][$product_number]=$value;
			$map3['id']=$value['product_id'];
			$product = $this -> product -> getInfo('product', $map3);
			if($product != NULL){
				$orderList[$order_number]['order'][$product_number]['product'] = $product;
			}
			$product_number += 1;
		}
		$page = ceil($order_number / 20);
		//从前面窃夺所有多余的部分，再切掉后面多余的部分
		$length = ($currentPage - 1) * 20 ;
		array_splice($orderList,0,$length+1);
		array_splice($orderList,20);
		$data = array('currentPage' => $currentPage,
	 								'page' => $page,
									'orderList' => $orderList);
		echo json_encode($data);
	}

	public function order_info(){
		$shopadmin=self::check_login();
		$map['order_id']=$this -> input ->get('order_id');
		$data=$this -> order -> getData('order', $map);
		$total_price=0;
		foreach ($data as $key => $value) {
			$order['order'][$key]=$value;
			$order['uid']=$value['uid'];
			$order['transaction_id'] = $value['transaction_id'];
			$order['phone']=$value['phone'];
			$map2['id']=$value['product_id'];
			$order['order'][$key]['product']=$this-> product -> getInfo('product', $map2);
			$total_price+=$value['price'];
		}
		$map3['uid']=$order['uid'];
		$order['coupon']=$this -> coupon -> getInfo('coupon', $map3);
		$userinfo=$this-> user -> get($map3['uid']);
		$order['nickname']=$userinfo['nickname'];
		$order['total_price']=$total_price;
		echo json_encode($order);
	}

	public function payLog()
	{
		$shopadmin = self::check_login();
		$map['paid'] = 1;
		$map['shop_id']=$shopadmin['shop_id'];
		$pay_log = $this -> order -> getData('order', $map);

	}



	public function baggedChange(){
		$shopadmin=self::check_login();
		$map['order_id']=$this -> input -> get('order_id');
		$order=$this -> order -> getInfo('order', $map);
		$order_change['bagged']=1-$order['bagged'];
		$result=$this -> order -> editMultiData('order', $map, $order_change);
		if(sizeof($result)==0){
			echo "fail";
		}else{
			echo "success";
		}
	}

	public function pickedupChange(){
		$shopadmin=self::check_login();
		$map['order_id']=$this -> input -> get('order_id');
		$order=$this -> order -> getInfo('order', $map);
		$order_change['pickedup']=1-$order['pickedup'];
		$order_change['order_status']=3-$order['order_status'];
		$result=$this -> order -> editMultiData('order', $map, $order_change);
		if(sizeof($result)==0){
			echo "fail";
		}else{
			echo "success";
		}
	}

	public function paidChange(){
		$shopadmin=self::check_login();
		$map['order_id']=$this -> input -> get('order_id');
		$order=$this -> order -> getInfo('order', $map);
		$order_change['paid'] = 1 - $order_change['paid'];
		$order_change['pay_time'] = date('YmdHis');
		$result=$this -> order -> editMultiData('order', $map, $order_change);
		if(sizeof($result)==0){
			echo "fail";
		}else{
			echo "success";
		}
	}

	public function couponChange(){
		$shopadmin=self::check_login();
		$map['uid']=$this -> input -> get('uid');
		$data=$this -> coupon -> getInfo('coupon', $map);
		$data['coupon_status']=1-$data['coupon_status'];
		$result=$this -> coupon -> editData('coupon', $data);
		if(!$result){
			echo "fail";
		}else{
			echo "success";
		}
	}

	public function inventory_list(){
		$shopadmin=self::check_login();
		$map['shop_id']=$shopadmin['shop_id'];
		$map['status'] = 1;
		$data=$this -> product -> getData('product', $map);
		foreach ($data as $key => $value) {
			$inventory[$key]['item']=$value['name_en'];
			$inventory[$key]['SKU_ID']=$value['SKU_ID'];
			$inventory[$key]['max']=$value['buying_limitation'];
			$map2['product_id']=$value['id'];
			$map2['order_status']=1;
			$inventory[$key]['ordered']=$this -> order -> count('order', $map2);
			$map2['order_status']=2;
			$inventory[$key]['pickedup']=$this -> order -> count('order', $map2);
			$inventory[$key]['stock']=$value['stock'];
		}
		echo json_encode($inventory);
	}

	/**
	 * 删除单张订单
	 */
	public function deleteOrder(){
		$order_id=$this-> input -> get('order_id');
		$map_order['order_id']=$order_id;
		//获取要删除的订单数据
		$order_info=$this -> order -> getData('order', $map_order);
		foreach ($order_info as $key => $value) {
			$map_product['id']=$value['product_id'];
			$product_info=$this -> product -> getInfo('product', $map_product);
			$product_info['stock']+=$value['number'];
			$change_inventory=$this -> product -> editData('product', $product_info);
		}
		$result=$this-> order -> delData('order', $map_order);
		if($result){
			echo 'success';
		}
		else{
			echo 'fail';
		}
	}


	public function client_FAQs(){
		$this-> load -> view('FAQs.html');
	}

	public function client_inventory(){
		$this-> load -> view('inventory.html');
	}

	public function client_list(){
		$result=self::check_login();
		$this-> load -> view('list.html');
	}

	public function client_login(){
		$this-> load -> view('login.html');
	}

	public function client_order(){
		$this-> load -> view('order.html');
	}

}
