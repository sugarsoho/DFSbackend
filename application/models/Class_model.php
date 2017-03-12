<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Class_model extends CI_Model {

	/**
	 * 获取类别数据
	 */
	public function get_all_class(){
	    $data=$this -> db
	    		-> get('class');
	    return $data->result();
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




}
