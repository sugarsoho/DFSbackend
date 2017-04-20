<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shopadmin_model extends CI_Model {

	public function check($map){
		if ($map!='') {
			$result=$this-> db -> where($map)->get('shopadmin');
			return $result->row_array();
		}
		else return NULL;
	}



}
