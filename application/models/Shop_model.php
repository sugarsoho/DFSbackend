<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shop_model extends CI_Model {



	/**
	 * 获取所有商铺的数据
	 */
	public function get_all_shop($map=''){
		if($map!='')
	    {
	    	$data=$this -> db
	    		-> where($map)
	    		-> get('shop');
	    }
	    else $data=$this-> db ->get('shop');
	    return $data->result();
	}


	/**
	 * 获取商铺信息
	 */
	public function get_shop_info($map){
	     $data=$this -> db
	    		-> where($map)
	    		-> get('shop');
	    $shop=$data->row_array();
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

	/**
	 * 删除数据
	 */
	public function delData($map){
	    return $result=$this -> db ->delete('shop',$map);
	    $this->display();
	}





}
