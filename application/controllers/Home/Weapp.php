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
	}

	/**
	 * 获取目录列表
	 */
	public function class_list(){
	    $data=$this -> class ->get_all_class();
	    echo json_encode($data);
	}

	/**
	 * 返回商品列表
	 */
	public function product_list(){
		$map['class_name']=$this-> input -> get('class_name');
	    $data=$this-> product -> get_all_product($map);
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
	public function history_order_list(){
	    $uid=$this-> user -> getuid();
        $userinfo=$this-> user -> get($uid);
	    $data=$this -> order -> get_all_order($userinfo['openId'],2);
	    foreach ($data as $key => $value) {
	    	$order_list[$key]['order']=$value;
	    	$order_list[$key]['product']=$this -> product -> get_product_info($value['product_id']);
	    	$order_list[$key]['shop']=$this -> shop -> get_shop_info($value['shop_id']);
	    }
	    if($data){
	    	echo json_encode($order_list);
	    }
	    
	}

	/**
	 * 返回未完成订单列表
	 */
	public function unfinished_order_list(){
	    $uid=$this-> user -> getuid();
        $userinfo=$this-> user -> get($uid);
	    $data=$this -> order -> get_all_order($userinfo['openId'],0);
	    foreach ($data as $key => $value) {
	    	$order_list[$key]['order']=$value;
	    	$order_list[$key]['product']=$this -> product -> get_product_info($value['product_id']);
	    	$order_list[$key]['shop']=$this -> shop -> get_shop_info($value['shop_id']);
	    }
	    if($data){
	    	echo json_encode($order_list);
	    }
	}


	/**
	 * 返回商品详情
	 */
	public function product_info(){
	    $map['id']=$this-> input -> get('product_id');
	    $data=$this-> product -> get_product_info($map);
	    $data['banner_image_urls']=explode('|', $data['banner_image_urls']);
	    $data['detail']=explode('|', $data['detail']);
	    $map2['id']=$data['shop_id'];
	    $data['shop']=$this-> shop -> get_shop_info($map2);
	    $data['shop']['carousels']=explode('|', $data['shop']['carousels']);
	    echo json_encode($data);
	}

	/**
	 * 返回订单详情
	 */
	public function order_info(){
	    $order_id=$this-> input -> get('order_id');
	    $data=$this -> order -> get_order_info($order_id);
	    $data['product']=$this-> product -> get_product_info($data['product_id']);
	    $data['shop']=$this-> shop -> get_shop_info($data['shop_id']);
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