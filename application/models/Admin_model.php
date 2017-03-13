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
	 * 获取所有商品的数据
	 */
	public function get_all_admin($map=''){
		if($map!='')
	    {
	    	$data=$this -> db
	    		-> where($map)
	    		-> get('admin');
	    }
	    else $data=$this-> db ->get('admin');
	    return $data->result();
	}

	/**
	 * 获取单个商品详情
	 */
	public function get_admin_info($map){
	    $data=$this -> db
	    		-> where($map)
	    		-> get('admin');
	    $admin=$data->row_array();
	    return $admin;
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

	/**
	 * 删除数据
	 */
	public function delData($map){
	    return $result=$this -> db ->delete('admin',$map);
	    $this->display();
	}

}
