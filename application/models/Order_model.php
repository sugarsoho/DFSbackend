<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

	/**
	 * 获取所有订单的数据
	 */
	public function get_all_order($openid,$order_status){
		$where = array('openid' => $openid,'order_status' => $order_status );
	    $data=$this -> db
	    		-> where($where)
	    		-> get('order');
	    return $data->result_array();
	}

	/**
	 * 获取订单详情
	 */
	public function get_order_info($id){
	    $data=$this -> db
	    		-> where('id' , $id)
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

	/**
	 * 确认订单，将订单表里对应用户状态为0的订单改为1.
	 */
	public function confirm($map){
		$order['order_status']=1;
	    return $result=$this -> db -> update('order', $order,$map);
	}

	/**
	 * 订单完成,将订单表里状态为1的订单改为2.
	 */
	public function finish($order_id){
	    $data=$this -> db
	    		-> where('id' , $order_id)
	    		-> get('order');
	    $order=$data->row_array();
	    $order['order_status']=2;
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
