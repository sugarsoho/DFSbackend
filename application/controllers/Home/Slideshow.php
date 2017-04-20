<?php
/*use \QCloud_WeApp_SDK\Helper\Util as Util;
use  \QCloud_WeApp_SDK\Auth\Constants as Constants;
use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;*/

class Slideshow extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this -> load -> model('product_model', 'product');
		$this -> load -> model('shop_model', 'shop');
		$this -> load -> model('class_model', 'class');
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




}
