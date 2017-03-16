<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Coupon_model extends CI_Model {



	/**
	 * 获取所有优惠券的数据
	 */
	public function get_all_coupon($map=''){
		if($map!='')
	    {
	    	$data=$this -> db
	    		-> where($map)
	    		-> get('coupon');
	    }
	    else $data=$this-> db ->get('coupon');
	    return $data->result();
	}


	/**
	 * 获取优惠券信息
	 */
	public function get_coupon_info($map){
	     $data=$this -> db
	    		-> where($map)
	    		-> get('coupon');
	    $coupon=$data->row_array();
	    return $coupon;
	}

	/**
	 * 添加数据
	 */
	public function addData($data){
	    return $result=$this -> db -> insert('coupon',$data);
	}

	/**
	 * 编辑数据
	 */
	public function editData($data){
	    return $result=$this -> db ->replace('coupon',$data);
	}

	/**
	 * 删除数据
	 */
	public function delData($map){
	    return $result=$this -> db ->delete('coupon',$map);
	    $this->display();
	}





}
