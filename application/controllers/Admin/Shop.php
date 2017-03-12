<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends Admin_Controller {

	public function __construct() {
		parent::__construct();
		$this -> load -> model('shop_model', 'shop');
		$this -> load -> helper('url');
		$shop_info = array('id',
							'name',
							'city',
							'area',
							'address',
							'contact_phone',
							'carousels',
							'class');
	}

	/**
	 * 添加商铺
	 */
	public function addShop(){
		$shop_info=$this-> input -> post($shop_info);
	    $data=$this-> shop -> addData($shop_info);
	    if(!$data){
	    	redirect('https://15580083.qcloud.la/Admin/index/shopquery');
	    }
	}

	/**
	 * 编辑商铺
	 */
	public function editShop(){
		$shop_info=$this-> input -> post($shop_info);
	    $data=$this-> shop -> editData($shop_info);
	    if(!$data){
	    	redirect('https://15580083.qcloud.la/Admin/index/shopquery');
	    }
	}


	/**
	 * 测试接口
	 */
	public function test(){
        /*$uid=$this-> user -> getuid();
        $userinfo=$this-> user -> get($uid);*/
	}


}