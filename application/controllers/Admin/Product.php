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
							'SKU_ID',
							'desc',
							'detail',
							'class_name',
							'enter_banner',
							'order_banner',
							'banner_image_urls',
							'shop_id');
		$product_info=$this-> input -> post($product_info);
		$product_info['time']=date("YmdHis");
	    $data=$this-> product -> addData($product_info);
	    if($data){
	    	redirect('https://15580083.qcloud.la/Admin/product/productquery');
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
							'SKU_ID',
							'desc',
							'detail',
							'class_name',
							'enter_banner',
							'order_banner',
							'banner_image_urls',
							'shop_id');
		$product_info=$this-> input -> post($product_info);
		$product_info['time']=date("YmdHis");
	    $data=$this-> product -> editData($product_info);
	    if($data){
	    	redirect('https://15580083.qcloud.la/Admin/product/productquery');
	    }
	}

	/**
	 * 删除商品 需传入主键id
	 */
	public function delProduct(){
	    $map['id']=$this->input->get('id');
	    $result=$this-> product -> delData($map);
	    $this->display();
	}


	
	/**
	 * 返回商品列表
	 */
	public function product_list(){
	    $data=$this-> product -> get_all_product();
	    echo json_encode($data);
	}

	/**
	 * 获取商品详情
	 */
	public function product_info(){
		$map['id']=$this -> input -> get('id');
	    $data=$this-> product ->get_product_info($map);
	    echo json_encode($data);
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
	public function productquery(){
	    $this-> load ->view('productquery.html');
	}

	
	/**
	 * 获取需要编辑的产品id，返回该商品信息
	 */
	public function productedit(){
		$map['id']=$this-> input ->get('id');
		$product_info=$this -> product -> get_product_info($map);
	    $this-> parser ->parse('productedit.html',$product_info);
	}

	/**
	 * 测试接口
	 */
	public function test(){
        /*$uid=$this-> user -> getuid();
        $userinfo=$this-> user -> get($uid);*/
	}


}