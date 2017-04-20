<?php
/*use \QCloud_WeApp_SDK\Helper\Util as Util;
use  \QCloud_WeApp_SDK\Auth\Constants as Constants;
use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;*/

class Banner extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this -> load -> model('banner_model', 'banner');
	}

	/**
	 * 获取目录列表
	 */
	public function getBanner(){
		$banner = $this -> banner -> getData('banner');
		echo json_encode($banner);
	}




}
