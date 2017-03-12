<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends Admin_Controller {

	public function __construct() {
		parent::__construct();
		$this -> load -> model('admin_model', 'admin');
		$this -> load -> helper('url');
	}


	/**
	 * 登录页面
	 */
	public function check_login(){
		$data=$this -> input -> post(array('admin_account','admin_password'));
		$result=$this -> admin -> login($data);
		if($result){
			$this -> session -> set_userdata($result);
		}
		redirect('https://15580083.qcloud.la/Admin/index');
	}

	/**
	 * 登录页面
	 */
	public function index(){
		$admin_info=$this->session->userdata('admin_account','admin_password','admin_name','admin_job');
		if(!$admin_info){
			redirect('https://15580083.qcloud.la/Admin/index/login');
		}
	    $this-> parser ->parse('index.html',$admin_info);
	}



	/**
	 * 测试接口
	 */
	public function test(){
		$admin_info=$this->session->userdata('admin_account','admin_password');
        echo json_encode($admin_info);
	}

	/**
	 * 登录页面
	 */
	public function login(){
	    $this-> load ->view('login.html');
	}

	
	/**
	 * 登录页面
	 */
	public function adminquery(){
	    $this-> load ->view('adminquery.html');
	}

	/**
	 * 登录页面
	 */
	public function adminadd(){
	    $this-> load ->view('adminadd.html');
	}

	/**
	 * 登录页面
	 */
	public function adminedit(){
	    $this-> load ->view('adminedit.html');
	}

	/**
	 * 登录页面
	 */
	public function orderquery(){
	    $this-> load ->view('orderquery.html');
	}

	/**
	 * 登录页面
	 */
	public function picturequery(){
	    $this-> load ->view('picturequery.html');
	}

	/**
	 * 登录页面
	 */
	public function pictureadd(){
	    $this-> load ->view('pictureadd.html');
	}

	/**
	 * 登录页面
	 */
	public function productquery(){
	    $this-> load ->view('productquery.html');
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
	public function productedit(){
	    $this-> load ->view('productedit.html');
	}


	/**
	 * 登录页面
	 */
	public function shopquery(){
	    $this-> load ->view('shopquery.html');
	}

	/**
	 * 登录页面
	 */
	public function shopadd(){
	    $this-> load ->view('shopadd.html');
	}

	/**
	 * 登录页面
	 */
	public function shopedit(){
	    $this-> load ->view('shopedit.html');
	}

	/**
	 * 登录页面
	 */
	public function userquery(){
	    $this-> load ->view('userquery.html');
	}

	/**
	 * 登录页面
	 */
	public function welcome(){
	    $this-> load ->view('welcome.html');
	}



}