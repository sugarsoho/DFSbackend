<?php

class Shop extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this -> load -> model('shop_model', 'shop');
		$this -> load -> model('shopadmin_model', 'shopadmin');
	}

	

}
