<?php
/*use \QCloud_WeApp_SDK\Helper\Util as Util;
use  \QCloud_WeApp_SDK\Auth\Constants as Constants;
use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;*/

class Slideshow extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this -> load -> model('product_model', 'product');
		$this -> load -> model('class_model', 'class');
		$this -> load -> model('slideshow_model', 'slideshow');

	}

	/**
	 * 获取目录列表
	 */
	public function getSlideShow(){
		$data = $this -> slideshow -> getData('slideshow');
		$slideshow = array();
		foreach ($data as $key => $value) {
			$map['status'] = 1;
			$map['id'] = $value['product_id'];
			$product = $this -> product -> getInfo('product', $map);
			$value['price'] = $product['price'];
			$value['enter_banner'] = $product['enter_banner'];
			if($value['recommend'] == 1) $slideshow['special'][] = $value;
			else $slideshow[$product['class_name']][] = $value;
		}
		echo json_encode($slideshow);
	}




}
