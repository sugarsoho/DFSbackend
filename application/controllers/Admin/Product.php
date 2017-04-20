<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends Admin_Controller {

	/*商品信息的数据结构
	public $product_info = array('id',
							'name',
							'brand_name',
							'price',
							'worth',
							'desc',
							'stock',
							'buying_limitation',
							'class_name',
							'enter_banner',
							'order_banner',
							'banner_image_urls',
							'shop_id',
							'time' => date("YmdHis"));*/

	public function __construct() {
		parent::__construct();
		$this -> load -> model('product_model', 'product');
		$this -> load -> model('order_model', 'order');
		$this -> load -> helper('url');

	}


	/**
	 * 添加商品
	 */
	public function addProduct(){
		$product_info = array(
								'name',
								'name_en',
								'brand_name',
								'price',
								'worth',
								'SKU_ID',
								'desc',
								'stock',
								'buying_limitation',
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
								'name_en',
								'brand_name',
								'price',
								'worth',
								'SKU_ID',
								'desc',
								'stock',
								'buying_limitation',
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
			$map1['product_id'] = $map['id'];
			$map1['order_status'] = 0;
			$result1 = $this -> order -> delData($map1);
	}



	/**
	 * 返回商品列表
	 */
	public function product_list(){
		$map['status'] = 1;
	    $data=$this-> product -> getData($map);
	    echo json_encode($data);
	}

	/**
	 * 获取商品详情
	 */
	public function product_info(){
		$map['id']=$this -> input -> get('id');
	    $data=$this-> product ->getData($map);
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
		$product_info=$this -> product -> getInfo($map);
	  $this-> parser ->parse('productedit.html',$product_info);
	}

	/**
	 * 测试接口
	 */
	public function test(){
		$map['id']=$this-> input ->get('id');
		$product_info=$this -> product -> getData($map);
		echo json_encode($product_info);
	}


}
