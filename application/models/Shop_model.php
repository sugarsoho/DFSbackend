<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shop_model extends CI_Model {



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
							-> get('shop');
			}
			//当当返回字段为空，查询字段为空时
			else{
				$data=$this -> db
							-> get('shop');
			}
		}else{
			//当返回字段不为空，查询字段不为空时
			if ($map!='') {
				$data=$this -> db
							-> select($field)
							-> where($map)
							-> get('shop');
			}
			//当返回字段不为空，查询字段为空时
			else{
				$data=$this -> db
							-> select($field)
							-> get('shop');
			}
		}
		return $data->result_array();
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
	}





}
