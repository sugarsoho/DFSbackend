<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

	/**
	 * 获取所有商品的数据
	 */
	public function get_all_product($class_name){
	    $data=$this -> db
	    		-> where('class_name',$class_name)
	    		-> get('product');
	    return $data->result();
	}

	/**
	 * 获取单个商品详情
	 */
	public function get_product_info($product_id){
	    $data=$this -> db
	    		-> where('id' , $product_id)
	    		-> get('product');
	    $product=$data->row_array();
	    $product['banner_image_urls']=explode('|', $product['banner_image_urls']);
	    $product['detail']=explode('|', $product['detail']);
	    return $product;
	}

	/**
	 * 添加数据
	 */
	public function addData($data){
	    return $result=$this -> db -> insert('product',$data);
	}

	/**
	 * 编辑数据
	 */
	public function editData($data){
	    return $result=$this -> db ->replace('product',$data);
	}

}
