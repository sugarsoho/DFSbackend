<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Admin_Controller {

	public function __construct() {
		parent::__construct();
		$this -> load -> model('user_model', 'user');
		$this -> load -> helper('url');
	}


	/**
	 * 登录页面
	 */
	public function userquery(){
	    $this-> load ->view('userquery.html');
	}


	/**
	 * 返回商品列表
	 */
	public function user_list(){
	    $data=$this-> user -> get_all_user();
	    echo json_encode($data);
	}

	/**
	 * 测试接口
	 */
	public function test(){
        /*$uid=$this-> user -> getuid();
        $userinfo=$this-> user -> get($uid);*/
	}


}