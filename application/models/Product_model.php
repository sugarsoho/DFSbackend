<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

	/**
	 * [getData description]
	 * @param  [array] $map   [查询字段]
	 * @param  [string] $field [返回字段]
	 * @return [array]        []
	 */
	public function getData($map='',$field=''){
		// $map['status'] = 1;
		if ($field=='') {
			//当返回字段为空，查询字段不为空时
			if ($map!='') {
				$data=$this -> db
							-> where($map)
							-> get('product');
			}
			//当当返回字段为空，查询字段为空时
			else{
				$data=$this -> db
							-> get('product');
			}
		}else{
			//当返回字段不为空，查询字段不为空时
			if ($map!='') {
				$data=$this -> db
							-> select($field)
							-> where($map)
							-> get('product');
			}
			//当返回字段不为空，查询字段为空时
			else{
				$data=$this -> db
							-> select($field)
							-> get('product');
			}
		}
		return $data->result_array();
	}

	public function getInfo($map){
		// $map['status'] = 1;
		$data=$this -> db -> where($map) -> get('product');
		return $data -> row_array();
	}

	/**
	 * [getData description]
	 * @param  [array] $map   [查询字段]
	 * @param  [string] $field [返回字段]
	 * @return [array]        []
	 */
	public function getData_Object($map='',$field='',$if_array=true){
		// $map['status'] = 1;
		if ($field=='') {
			//当返回字段为空，查询字段不为空时
			if ($map!='') {
				$data=$this -> db
							-> where($map)
							-> get('product');
			}
			//当当返回字段为空，查询字段为空时
			else{
				$data=$this -> db
							-> get('product');
			}
		}else{
			//当返回字段不为空，查询字段不为空时
			if ($map!='') {
				$data=$this -> db
							-> select($field)
							-> where($map)
							-> get('product');
			}
			//当返回字段不为空，查询字段为空时
			else{
				$data=$this -> db
							-> select($field)
							-> get('product');
			}
		}
		if($if_array)	return $data->result_array();
		else return $data->result();
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
		$data['status'] = 0;
	  return $result=$this -> db ->update('product', $data ,$map);
	}

}
