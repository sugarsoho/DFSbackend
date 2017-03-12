<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends Admin_Controller {
	
	/*商品信息的数据结构
	public $product_info = array('id',
							'name',
							'price',
							'worth',
							'desc',
							'detail',
							'class',
							'enter_banner',
							'order_banner',
							'banner_image_urls',
							'shop_id',
							'time' => date("YmdHis"));*/

	public function __construct() {
		parent::__construct();
		$this -> load -> model('product_model', 'product');
		$this -> load -> helper('url');
		
	}


	/**
	 * 添加商品
	 */
	public function addProduct(){
		$product_info = array('name',
							'price',
							'worth',
							'desc',
							'detail',
							'class',
							'enter_banner',
							'order_banner',
							'banner_image_urls',
							'shop_id');
		$product_info=$this-> input -> post($product_info);
		$product_info['time']=date("YmdHis");
	    $data=$this-> product -> addData($product_info);
	    if(!$data){
	    	redirect('https://15580083.qcloud.la/Admin/index/productquery');
	    }
	}

	/**
	 * 编辑商品
	 */
	public function editProduct(){
		$product_info = array('id',
							'name',
							'price',
							'worth',
							'desc',
							'detail',
							'class',
							'enter_banner',
							'order_banner',
							'banner_image_urls',
							'shop_id');
		$product_info=$this-> input -> post($product_info);
		$product_info['time']=date("YmdHis");
	    $data=$this-> product -> editData($product_info);
	    if(!$data){
	    	redirect('https://15580083.qcloud.la/Admin/index/productquery');
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