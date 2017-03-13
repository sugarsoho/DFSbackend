<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Class_model extends CI_Model {

	/**
	 * 获取所有商品的数据
	 */
	public function get_all_class($map=''){
		if($map!='')
	    {
	    	$data=$this -> db
	    		-> where($map)
	    		-> get('class');
	    }
	    else $data=$this-> db ->get('class');
	    return $data->result();
	}

	/**
	 * 获取单个商品详情
	 */
	public function get_class_info($map){
	    $data=$this -> db
	    		-> where($map)
	    		-> get('class');
	    $class=$data->row_array();
	    return $class;
	}

	/**
	 * 添加数据
	 */
	public function addData($data){
	    return $result=$this -> db -> insert('class',$data);
	}

	/**
	 * 编辑数据
	 */
	public function editData($data){
	    return $result=$this -> db ->replace('class',$data);
	}

	/**
	 * 删除数据
	 */
	public function delData($map){
	    return $result=$this -> db ->delete('class',$map);
	    $this->display();
	}





}
