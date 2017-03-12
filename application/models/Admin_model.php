<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

	public function login($data){
		$result=$this-> db -> where($data)->get('admin');
		if($admin_info=$result->row_array()){
            return $admin_info;
		}
		else{
			exit('用户名或密码错误');
		}
	}

	/**
	 * 添加数据
	 */
	public function addData($data){
	    return $result=$this -> db -> insert('admin',$data);
	}

	/**
	 * 编辑数据
	 */
	public function editData($data){
	    return $result=$this -> db ->replace('admin',$data);
	}

}
