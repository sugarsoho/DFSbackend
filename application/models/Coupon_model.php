<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Coupon_model extends CI_Model {


	/**
	 * [getData description]
	 * @param  [array] $map   [查询字段]
	 * @param  [string] $field [返回字段]
	 * @return [array]        []
	 */
	public function getData($map='',$field='',$if_array=true){
		if ($field=='') {
			//当返回字段为空，查询字段不为空时
			if ($map!='') {
				$data=$this -> db
							-> where($map)
							-> get('coupon');
			}
			//当当返回字段为空，查询字段为空时
			else{
				$data=$this -> db
							-> get('coupon');
			}
		}else{
			//当返回字段不为空，查询字段不为空时
			if ($map!='') {
				$data=$this -> db
							-> select($field)
							-> where($map)
							-> get('coupon');
			}
			//当返回字段不为空，查询字段为空时
			else{
				$data=$this -> db
							-> select($field)
							-> get('coupon');
			}
		}
		if($if_array)	return $data->result_array();
		else return $data->result();
	}

	public function getInfo($map){
		$data=$this -> db -> where($map) -> get('coupon');
		return $data -> row_array();
	}


	/**
	 * 添加数据
	 */
	public function addData($data){
		if (empty(self::getData($data))) {
			return $result=$this -> db -> insert('coupon',$data);
		}
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
	}





}
