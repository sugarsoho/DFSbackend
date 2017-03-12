<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends Admin_Controller {

	public function __construct() {
		parent::__construct();
		$this -> load -> model('admin_model', 'admin');
		$this -> load -> helper('url');
	}


	/**
	 * 登录页面
	 */
	public function check_login(){
		$data=$this -> input -> post(array('admin_account','admin_password'));
		$result=$this -> admin -> login($data);
		if($result){
			$this -> session -> set_userdata($result);
		}
		redirect('https://15580083.qcloud.la/Admin/index');
	}

	/**
	 * 登录页面
	 */
	public function index(){
		$admin_info=$this->session->userdata('admin_account','admin_password','admin_name','admin_job');
		if(!$admin_info){
			redirect('https://15580083.qcloud.la/Admin/index/login');
		}
	    $this-> parser ->parse('index.html',$admin_info);
	}

	
	/**
	 * 返回商品列表
	 */
	public function product_list(){
		$shop_id=$this-> input -> get('shop_id');
	    $data=$this-> product -> get_all_product($shop_id);
	    echo json_encode($data);
	}

	/**
	 * 返回订单列表
	 */
	public function order_list(){
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

	/**
	 * 返回商品详情
	 */
	public function product_info(){
	    $product_id=$this-> input -> get('product_id');
	    $data=$this-> product -> get_product_info($product_id);
	    $shop_id=$data['shop_id'];
	    $data['shop']=$this-> shop -> get_shop_info($shop_id);
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
	 * 测试接口
	 */
	public function test(){
		$admin_info=$this->session->userdata('admin_account','admin_password');
        echo json_encode($admin_info);
	}

	/**
	 * 登录页面
	 */
	public function login(){
	    $this-> load ->view('login.html');
	}

	
	/**
	 * 登录页面
	 */
	public function adminquery(){
	    $this-> load ->view('adminquery.html');
	}

	/**
	 * 登录页面
	 */
	public function adminadd(){
	    $this-> load ->view('adminadd.html');
	}

	/**
	 * 登录页面
	 */
	public function adminedit(){
	    $this-> load ->view('adminedit.html');
	}

	/**
	 * 登录页面
	 */
	public function orderquery(){
	    $this-> load ->view('orderquery.html');
	}

	/**
	 * 登录页面
	 */
	public function picturequery(){
	    $this-> load ->view('picturequery.html');
	}

	/**
	 * 登录页面
	 */
	public function pictureadd(){
	    $this-> load ->view('pictureadd.html');
	}

	/**
	 * 登录页面
	 */
	public function productquery(){
	    $this-> load ->view('productquery.html');
	}

	/**
	 * 登录页面
	 */
	public function productadd(){
	    $this-> load ->view('productadd.html');
	}

	/**
	 * 登录页面
	 */
	public function productedit(){
	    $this-> load ->view('productedit.html');
	}


	/**
	 * 登录页面
	 */
	public function shopquery(){
	    $this-> load ->view('shopquery.html');
	}

	/**
	 * 登录页面
	 */
	public function shopadd(){
	    $this-> load ->view('shopadd.html');
	}

	/**
	 * 登录页面
	 */
	public function shopedit(){
	    $this-> load ->view('shopedit.html');
	}

	/**
	 * 登录页面
	 */
	public function userquery(){
	    $this-> load ->view('userquery.html');
	}

	/**
	 * 登录页面
	 */
	public function welcome(){
	    $this-> load ->view('welcome.html');
	}



}