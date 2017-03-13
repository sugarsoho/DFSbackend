<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

	/**
	 * 获取所有商品的数据
	 */
	public function get_all_product($map=''){
		if($map!='')
	    {
	    	$data=$this -> db
	    		-> where($map)
	    		-> get('product');
	    }
	    else $data=$this-> db ->get('product');
	    return $data->result();
	}

	/**
	 * 获取单个商品详情
	 */
	public function get_product_info($map){
	    $data=$this -> db
	    		-> where($map)
	    		-> get('product');
	    $product=$data->row_array();
	    return $product;
	}

	/**
	 * 添加数据
	 */
	public function addData($data){
	    return $result=$this -> db -> insert('product',$data);
	}

	/**
	 * 编辑数据,$data必须含有主键
	 */
	public function editData($data){
	    return $result=$this -> db ->replace('product',$data);
	}

	/**
	 * 删除数据
	 */
	public function delData($map){
	    return $result=$this -> db ->delete('product',$map);
	    $this->display();
	}

}
