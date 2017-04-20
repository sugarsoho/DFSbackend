<?php
/*use \QCloud_WeApp_SDK\Helper\Util as Util;
use  \QCloud_WeApp_SDK\Auth\Constants as Constants;
use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;*/

class Weapp extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this -> load -> model('product_model', 'product');
		$this -> load -> model('order_model', 'order');
		$this -> load -> model('shop_model', 'shop');
		$this -> load -> model('class_model', 'class');
		$this -> load -> model('user_model', 'user');
		$this -> load -> model('promotion_model', 'promotion');
		$this -> load -> helper('url');
		$this -> load -> helper('myfunction');
	}

	/**
	 * 获取目录列表
	 */
	public function class_list(){
	    $data=$this -> class ->getData('class');
	    echo json_encode($data);
	}

	/**
	 * 返回商品列表
	 */
	public function product_list(){
			$map['class_name']=$this-> input -> get('class_name');
			$map['status'] = 1;
	    $data=$this-> product -> getData('product', $map);
			$exchange_rate=get_exchange_rate();
			if($data){
				foreach ($data as $key => $value) {
					$product_info[$key]=$value;
				  $product_info[$key]['RMB']=$value['price']*$exchange_rate;
				}
				echo json_encode($product_info);
			}
	}

	/**
	 * 返回优惠券列表列表
	 */
	public function promotion_list(){
	    $data=$this-> promotion -> getData('promotion');
			echo json_encode($data);
	}

	/**
	 * 返回订单列表
	 */
	/*public function order_list(){
	    $uid=$this-> user -> getuid();
        $userinfo=$this-> user -> get($uid);
	    $data=$this -> order -> get_all_order($userinfo['openId']);
	    foreach ($data as $key => $value) {
	    	$order_list[$key]['order']=$value;
	    	$order_list[$key]['product']=$this -> product -> get_product_info($value['product_id']);
	    	$order_list[$key]['shop']=$this -> shop -> get_shop_info($value['shop_id']);
	    }
	    echo json_encode($order_list);
	}
*/
	/**
	 * 返回已完成订单列表
	 */
	// public function history_order_list(){
	//     $uid=$this-> user -> getuid();
	// 		$map['uid']=$uid;
	// 		$map['order_status']=3;
	//     $data=$this -> order -> getData($map);
	//     if($data){
	// 			$exchange_rate=get_exchange_rate();
	//     	foreach ($data as $key => $value) {
	// 				$order_list[$key]['order']=$value;
	// 				$product_info['id']=$value['product_id'];
	// 	    	$order_list[$key]['product']=$this -> product -> getInfo($product_info);
	// 				$order_list[$key]['product']['RMB']=$order_list[$key]['product']['price']*$exchange_rate;
	// 				$shop_info['id']=$value['shop_id'];
	// 	    	$order_list[$key]['shop']=$this -> shop -> getInfo($shop_info);
	// 	    }
	// 				echo json_encode($order_list);
	//     }
	// }
	//

	/**
	 * 返回用户购物车内的订单数目
	 */
	 public function getCartNumber(){
		 $uid=$this-> input -> get('uid');
		 if($uid==NULL) exit('用户未授权登录，请重新下载小程序，并授权登录');
		 $map['uid']=$uid;
		//测试用的数据
		//  $map['uid']=3;
		 $map['order_status']=0;
		 $data=$this -> order -> count('order', $map);
		 echo $data;
	 }

	/**
	 * 返回未完成订单列表
	 */
	public function cart_list(){
	    $uid=$this-> input -> get('uid');
			if($uid==NULL) exit('用户未授权登录，请重新下载小程序，并授权登录');
			$map['uid']=$uid;
			$map['order_status']=0;
	    $data=$this -> order -> getData('order', $map);
		if($data){
			$exchange_rate=get_exchange_rate();
			foreach ($data as $key => $value) {
		    	$order_list[$key]['order']=$value;
					$product_info['id']=$value['product_id'];
					$product_info['status'] = 1;
		    	$order_list[$key]['product']=$this -> product -> getInfo('product', $product_info);
					$order_list[$key]['product']['RMB']=$order_list[$key]['product']['price']*$exchange_rate;
					$shop_info['id']=$value['shop_id'];
		    	$order_list[$key]['shop']=$this -> shop -> getInfo('shop', $shop_info);
		  }
			echo json_encode($order_list);
	  }
	}


	/**
	 * 返回商品详情
	 */
	public function product_info(){
	    $map['id']=$this-> input -> get('product_id');
	    $data=$this-> product -> getInfo('product', $map);
			$exchange_rate=get_exchange_rate();
			$data['RMB']=$data['price']*$exchange_rate;
	    $data['banner_image_urls']=explode('|', $data['banner_image_urls']);
	    $map2['id']=$data['shop_id'];
	    $data['shop']=$this-> shop -> getInfo('shop', $map2);
	    $data['shop']['carousels']=explode('|', $data['shop']['carousels']);
	    echo json_encode($data);
	}

	/**
	 * 返回订单列表
	 */
	public function order_list(){
		$uid=$this-> input -> get('uid');
		$map['uid']=$uid;
		// $map['uid']=2;  //调试用
		$map['order_status !=']=0;
		//获取该用户所有订单
		//按用户order_id升序排列
		$order_sort='order_id DESC';
		$order_info=$this-> order -> getData('order',$map,'',$order_sort);
		if($order_info){
			//将相同order_id的订单）实际上是不同商品）合并到同一张订单。
			$order_number=0;
			$product_number=0;
			$order[$order_number]['order_id']=0;
			$exchange_rate=get_exchange_rate();
			foreach ($order_info as $key => $value) {
				if($order[$order_number]['order_id']!=$value['order_id']){
					$order_number += 1;
					$order[$order_number]['order_id'] = $value['order_id'];
					if($value['pickedup']==1)$order[$order_number]['order_status_string']='已提货';
					else if($value['bagged']==1)$order[$order_number]['order_status_string']='待提货';
					else if($value['paid'] == 1)$order[$order_number]['order_status_string']='已支付';
					else $order[$order_number]['order_status_string']='已预订';
					$product_number=0;
					$order[$order_number]['total_price']=0;
					$order[$order_number]['total_price_RMB']=0;
				}
				$order[$order_number]['total_price']+=$value['price'];
				$order[$order_number]['total_price_RMB']+=$value['price']*$exchange_rate;
				$order[$order_number]['order'][$product_number]=$value;
				$map2['id']=$value['product_id'];
				$product = $this -> product -> getInfo('product', $map2);
				if($product != NULL){
					$order[$order_number]['order'][$product_number]['product']=$product;
				}
				$product_number += 1;
			}
			unset($order[0]);
			echo json_encode(array_values($order));
		}

	}

	/**
	 * 返回订单详情
	 */
	public function order_info(){
			$map['order_id']=$this -> input ->get('order_id');
			$data=$this -> order -> getData('order', $map);
			$total_price=0;
			$product_number=0;
			$exchange_rate=get_exchange_rate();
			foreach ($data as $key => $value) {
				$order['order'][$key]=$value;
				$map2['id']=$value['product_id'];
				$product = $this -> product -> getInfo('product',$map2);
				if($product != NULL){
				$order['order'][$key]['product']=$product;
				}
				$total_price+=$value['price'];
			}
			$order['total_price']=$total_price;
			$order['total_price_RMB']=$total_price*$exchange_rate;
			echo json_encode($order);
	}

	/**
	 * 返回商铺列表
	 */
	public function shop_list(){
	    $this->display();
	}

	/**
	 * 测试接口
	 */
	public function getUid(){
		$uid=$this-> user -> getuid();
		if($uid != -1) echo $uid;
	}

	/**
	 * 测试接口
	 */
	public function test(){
		$uid=$this-> input -> get('uid');
		$map['uid']=$uid;
		// $map['uid']=2;  //调试用
		$map['order_status !=']=0;
		//获取该用户所有订单
		//按用户order_id升序排列
		$order_sort='order_id DESC';
		$order_info=$this-> order -> getData('order', $map, '', $order_sort);
		if($order_info){
			//将相同order_id的订单）实际上是不同商品）合并到同一张订单。
			$order_number=0;
			$product_number=0;
			$order[$order_number]['order_id']=0;
			$exchange_rate=get_exchange_rate();
			foreach ($order_info as $key => $value) {
				if($order[$order_number]['order_id']!=$value['order_id']){
					$order_number += 1;
					$order[$order_number]['order_id'] = $value['order_id'];
					if($value['pickedup']==1)$order[$order_number]['order_status_string']='已提货';
					else if($value['bagged']==1)$order[$order_number]['order_status_string']='待提货';
					else if($value['paid'] == 1)$order[$order_number]['order_status_string']='已支付';
					else $order[$order_number]['order_status_string']='已预订';
					$product_number=0;
					$order[$order_number]['total_price']=0;
					$order[$order_number]['total_price_RMB']=0;
				}
				$order[$order_number]['total_price']+=$value['price'];
				$order[$order_number]['total_price_RMB']+=$value['price']*$exchange_rate;
				$order[$order_number]['order'][$product_number]=$value;
				$map2['id']=$value['product_id'];
				$order[$order_number]['order'][$product_number]['product']=$this -> product -> getInfo('product', $map2);
				$product_number += 1;
			}
			unset($order[0]);
			echo json_encode(array_values($order));
		}
	}


}
