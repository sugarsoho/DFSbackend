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
		$this -> load -> helper('url');
		$this -> load -> helper('myfunction');
	}

	/**
	 * 获取目录列表
	 */
	public function class_list(){
	    $data=$this -> class ->getData();
	    echo json_encode($data);
	}

	/**
	 * 返回商品列表
	 */
	public function product_list(){
			$map['class_name']=$this-> input -> get('class_name');
	    $data=$this-> product -> getData($map);
			$exchange_rate=get_exchange_rate();
			foreach ($data as $key => $value) {
				$product_info[$key]=$value;
			  $product_info[$key]['RMB']=$value['price']*$exchange_rate;
			}
	    echo json_encode($product_info);
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
	public function history_order_list(){
	    $uid=$this-> user -> getuid();
			$map['uid']=$uid;
			$map['order_status']=3;
	    $data=$this -> order -> getData($map);
	    if($data){
				$exchange_rate=get_exchange_rate();
	    	foreach ($data as $key => $value) {
					$order_list[$key]['order']=$value;
					$product_info['id']=$value['product_id'];
		    	$order_list[$key]['product']=$this -> product -> getData($product_info);
					$order_list[$key]['product']['RMB']=$order_list[$key]['product']['price']*$exchange_rate;
					$shop_info['id']=$value['shop_id'];
		    	$order_list[$key]['shop']=$this -> shop -> getData($shop_info);
		    }
					echo json_encode($order_list);
	    }
	}

	/**
	 * 返回未完成订单列表
	 */
	public function unfinished_order_list(){
	    $uid=$this-> user -> getuid();
			$map['uid']=$uid;
			$map['order_status']=0;
	    $data=$this -> order -> getData($map);
		if($data){
			$exchange_rate=get_exchange_rate();
			foreach ($data as $key => $value) {
		    	$order_list[$key]['order']=$value;
					$product_info['id']=$value['product_id'];
		    	$order_list[$key]['product']=$this -> product -> getData($product_info);
					$order_list[$key]['product']['RMB']=$order_list[$key]['product']['price']*$exchange_rate;
					$shop_info['id']=$value['shop_id'];
		    	$order_list[$key]['shop']=$this -> shop -> getData($shop_info);
		  }
			echo json_encode($order_list);
	  }
	}


	/**
	 * 返回商品详情
	 */
	public function product_info(){
	    $map['id']=$this-> input -> get('product_id');
	    $data=$this-> product -> getData($map);
			$exchange_rate=get_exchange_rate();
			$data['RMB']=$data['price']*$exchange_rate;
	    $data['banner_image_urls']=explode('|', $data['banner_image_urls']);
	    $map2['id']=$data['shop_id'];
	    $data['shop']=$this-> shop -> getData($map2);
	    $data['shop']['carousels']=explode('|', $data['shop']['carousels']);
	    echo json_encode($data);
	}

	/**
	 * 返回订单详情
	 */
	public function order_info(){
	    $order_id=$this-> input -> get('order_id');
	    $data=$this -> order -> getData($order_id);
			$product_info['id']=$data['product_id'];
	    $data['product']=$this-> product -> getData($product_info);
			$shop_info['id']=$data['shop_id'];
	    $data['shop']=$this-> shop -> getData($shop_info);
	    echo json_encode($data);
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
	public function test(){
        /*$uid=$this-> user -> getuid();
        $userinfo=$this-> user -> get($uid);*/
	}


}
