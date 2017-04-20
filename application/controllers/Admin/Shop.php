<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends Admin_Controller {

		/*商店数据结构
		$shop_info = array('id',
							'name',
							'city',
							'area',
							'address',
							'contact_phone',
							'carousels');*/

	public function __construct() {
		parent::__construct();
		$this -> load -> model('shop_model', 'shop');
		$this -> load -> helper('url');
	}

	/**
	 * 添加商铺
	 */
	public function addShop(){
		$shop_info = array('name',
							'city',
							'area',
							'address',
							'contact_phone',
							'carousels');
		$shop_info=$this-> input -> post($shop_info);
	    $data=$this-> shop -> addData($shop_info);
	    if($data){
	    	redirect('https://15580083.qcloud.la/Admin/shop/shopquery');
	    }
	}

	/**
	 * 编辑商铺
	 */
	public function editShop(){
		$shop_info = array('id',
							'name',
							'city',
							'area',
							'address',
							'contact_phone',
							'carousels');
		$shop_info=$this-> input -> post($shop_info);
	    $data=$this-> shop -> editData($shop_info);
	    if($data){
	    	redirect('https://15580083.qcloud.la/Admin/shop/shopquery');
	    }
	}

	/**
	 * 删除商铺 需传入主键id
	 */
	public function delShop(){
	    $map['id']=$this->input->get('id');
	    $result=$this-> shop -> delData($map);
	}

	/**
	 * 返回商铺列表
	 */
	public function shop_list(){
	    $data=$this-> shop -> getData();
	    echo json_encode($data);
	}

	/**
	 * 获取商铺详情
	 */
	public function shop_info(){
		$map['id']=$this -> input -> get('id');
	    $data=$this-> shop ->getData($map);
	    echo json_encode($data);
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
		$map['id']=$this -> input -> get('id');
		$shop_info=$this -> shop -> getInfo($map);
	    $this-> parser ->parse('shopedit.html',$shop_info);
	}


	/**
	 * 测试接口
	 */
	public function test(){
        /*$uid=$this-> user -> getuid();
        $userinfo=$this-> user -> get($uid);*/
	}


}
