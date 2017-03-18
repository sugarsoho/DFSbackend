<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Resource_model extends CI_Model {

	/**
	 * 添加数据到数据库
	 */
	public function addData($data){
	    $result=$this -> db -> insert('resource',$data);
	    if(!$result){
	    	exit ('添加数据到数据库失败');
	    }
	    else return true;
	}

	/**
	 * [get_info description]
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
							-> get('resource');
			}
			//当当返回字段为空，查询字段为空时
			else{
				$data=$this -> db
							-> get('resource');
			}
		}else{
			//当返回字段不为空，查询字段不为空时
			if ($map!='') {
				$data=$this -> db
							-> select($field)
							-> where($map)
							-> get('resource');
			}
			//当返回字段不为空，查询字段为空时
			else{
				$data=$this -> db
							-> select($field)
							-> get('resource');
			}
		}
		return $data->result_array();
	}


}
