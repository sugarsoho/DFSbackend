<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Admin_Controller {

	public function __construct() {
		parent::__construct();
		$this -> load -> model('user_model', 'user');
		$this -> load -> helper('url');
	}


	/**
	 * 测试接口
	 */
	public function test(){
        /*$uid=$this-> user -> getuid();
        $userinfo=$this-> user -> get($uid);*/
	}


}