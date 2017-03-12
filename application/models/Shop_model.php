<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shop_model extends CI_Model {

	/**
	 * 获取商铺信息
	 */
	public function get_shop_info($shop_id){
	    $data=$this -> db
	    		-> where('id',$shop_id)
	    		-> get('shop');
	    $shop=$data->row_array();
	    $shop['carousels']=explode('|', $shop['carousels']);
	    return $shop;
	}

	/**
	 * 添加数据
	 */
	public function addData($data){
	    return $result=$this -> db -> insert('shop',$data);
	}

	/**
	 * 编辑数据
	 */
	public function editData($data){
	    return $result=$this -> db ->replace('shop',$data);
	}




}
