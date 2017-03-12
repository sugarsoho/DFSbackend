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




}
