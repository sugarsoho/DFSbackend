<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shop_model extends MY_Model {

	/**
	 * 删除数据
	 */
	public function delData($table='', $map){
		$data['status'] = 0;
	  return $result=$this -> db ->update($table, $data ,$map);
	}





}
