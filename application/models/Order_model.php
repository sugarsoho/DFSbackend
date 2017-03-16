<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

	/**
	 * 获取所有订单的数据
	 */
	public function get_all_order($map){
	    $data=$this -> db
	    		-> where($map)
	    		-> get('order');
	    return $data->result_array();
	}

	/**
	 * 获取订单详情
	 */
	public function get_order_info($map){
	    $data=$this -> db
	    		-> where($map)
	    		-> get('order');
	    $order=$data->row_array();
	    return $order;
	}

	/**
	 * 下单
	 */
	public function place_order($data){
	    $result=$this-> db -> insert('order', $data);
	    return $result;
	}

	public function changeStatus($map,$order_status){
		return $result=$this -> db -> update('order', $order_status,$map);
	}

	/**
	 * 订单完成,将订单表里状态为1的订单改为2.
	 */
	public function finish($map){
	    $data=$this -> db
	    		-> where($map)
	    		-> get('order');
	    $order=$data->row_array();
	    $order['order_status']=3;
	    $order['finished_time']=date('YmdHis');
	    return $result=$this -> db -> replace('order', $order);
	}

	/**
	 * 清空购物车
	 */
	public function delData($map){
	    return $result=$this -> db ->delete('order',$map);
	    $this->display();
	}


}
