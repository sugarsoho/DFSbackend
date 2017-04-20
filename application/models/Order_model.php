<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {


	public function likeSearch($string){
		$this->db->like('phone', $string);
		$this->db->or_like('order_id', $string);
		$data=$this->db->get('order');
		return $data->result_array();
	}


	public function page($map, $order_sort, $currentPage){
		$currentPage = ($currentPage - 1) * 20;
		$this -> db -> limit($currentPage, 20);
		$this -> db	-> where($map);
		$data=$this -> db	-> get('order');
		return $data->result_array();
	}

	/**
	 * 订单完成,将订单表里状态为1的订单改为2.
	 */
	public function finish($map){
	    $data=$this -> db
	    		-> where($map)
	    		-> get('order');
	    $order=$data->row_array();
	    $order['order_status']=2;
	    $order['finished_time']=date('YmdHis');
	    return $result=$this -> db -> replace('order', $order);
	}


}
