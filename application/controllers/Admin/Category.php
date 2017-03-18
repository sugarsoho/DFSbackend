<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends Admin_Controller {

		/*目录数据结构
		$class_info = array('class_id',
							'class_name',
							'class_url');*/

	public function __construct() {
		parent::__construct();
		$this -> load -> model('class_model', 'class');
		$this -> load -> helper('url');
	}

	/**
	 * 添加商铺
	 */
	public function addClass(){
		$class_info = array('class_name',
							'class_url');
		$class_info=$this-> input -> post($class_info);
	    $data=$this-> class -> addData($class_info);
	    if($data){
	    	redirect('https://15580083.qcloud.la/Admin/Category/classquery');
	    }
	}

	/**
	 * 编辑商铺
	 */
	public function editClass(){
		$class_info = array('class_id',
							'class_name',
							'class_url');
		$class_info=$this-> input -> post($class_info);
	    $data=$this-> class -> editData($class_info);
	    if($data){
	    	redirect('https://15580083.qcloud.la/Admin/Category/classquery');
	    }
	}

	/**
	 * 删除商铺 需传入主键id
	 */
	public function delClass(){
	    $map['class_id']=$this->input->get('class_id');
	    $result=$this-> class -> delData($map);
	}

	/**
	 * 返回商铺列表
	 */
	public function class_list(){
	    $data=$this-> class -> getData();
	    echo json_encode($data);
	}

	/**
	 * 获取商铺详情
	 */
	public function class_info(){
		$map['class_id']=$this -> input -> get('class_id');
	    $data=$this-> class ->getData($map);
	    echo json_encode($data);
	}


	/**
	 * 登录页面
	 */
	public function classquery(){
	    $this-> load ->view('classquery.html');
	}

	/**
	 * 登录页面
	 */
	public function classadd(){
	    $this-> load ->view('classadd.html');
	}

	/**
	 * 登录页面
	 */
	public function classedit(){
		$map['class_id']=$this-> input -> get('class_id');
		$class_info=$this -> class -> getData($map);
	    $this-> parser ->parse('classedit.html',$class_info);
	}


	/**
	 * 测试接口
	 */
	public function test(){
        /*$uid=$this-> user -> getuid();
        $userinfo=$this-> user -> get($uid);*/
	}


}
