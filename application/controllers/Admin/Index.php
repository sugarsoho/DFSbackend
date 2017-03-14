<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends Admin_Controller {

	/*后台管理员信息的数据结构
	public $admin_info = array('id',
							'admin_account',
							'admin_password',
							'worth',
							'reg_time',
							'admin_job',
							'admin_name',
							'admin_level',
							'admin_status');*/

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
	 * 添加商品
	 */
	public function addAdmin(){
		$admin_info = array('admin_account',
							'admin_password',
							'worth',
							'reg_time',
							'admin_job',
							'admin_name',
							'admin_level');
		$admin_info=$this-> input -> post($admin_info);
		$admin_info['reg_time']=date("YmdHis");
	    $data=$this-> admin -> addData($admin_info);
	    if($data){
	    	redirect('https://15580083.qcloud.la/Admin/index/adminquery');
	    }
	}

	/**
	 * 编辑商品
	 */
	public function editAdmin(){
		$admin_info = array('id',
							'admin_account',
							'admin_password',
							'worth',
							'admin_job',
							'admin_name',
							'admin_level');
		$admin_info=$this-> input -> post($admin_info);
		$admin_info['reg_time']=date("YmdHis");
	    $data=$this-> admin -> editData($admin_info);
	    if($data){
	    	redirect('https://15580083.qcloud.la/Admin/index/adminquery');
	    }
	}

	/**
	 * 删除商品 需传入主键id
	 */
	public function delAdmin(){
	    $map['id']=$this->input->get('id');
	    $result=$this-> admin -> delData($map);
	}

	/**
	 * 返回商品列表
	 */
	public function admin_list(){
	    $data=$this-> admin -> get_all_admin();
	    echo json_encode($data);
	}

	/**
	 * 获取商品详情
	 */
	public function admin_info(){
		$map['id']=$this -> input -> get('id');
	    $data=$this-> admin ->get_admin_info($map);
	    echo json_encode($data);
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
	public function welcome(){
	    $this-> load ->view('welcome.html');
	}



}