<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

	/**
	 * [getData description]
	 * @param  [array] $map   [查询字段]
	 * @param  [string] $field [返回字段]
	 * @return [array]        []
	 */
	public function getData($map='',$field=''){
		if ($field=='') {
			//当返回字段为空，查询字段不为空时
			if ($map!='') {
				$data=$this -> db
							-> where($map)
							-> get('order');
			}
			//当当返回字段为空，查询字段为空时
			else{
				$data=$this -> db
							-> get('order');
			}
		}else{
			//当返回字段不为空，查询字段不为空时
			if ($map!='') {
				$data=$this -> db
							-> select($field)
							-> where($map)
							-> get('order');
			}
			//当返回字段不为空，查询字段为空时
			else{
				$data=$this -> db
							-> select($field)
							-> get('order');
			}
		}
		return $data->result_array();
	}

	/**
	 * 添加数据
	 */
	public function addData($data){
	    return $result=$this-> db -> insert('order', $data);
	}

	public function editMultiData($map,$data){
		return $result=$this -> db -> update('order', $data,$map);
	}

	/**
	 * 编辑数据,$data数组中必须带有主键
	 */
	public function editData($data){
	    return $result=$this -> db ->replace('order',$data);
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
	}


}
