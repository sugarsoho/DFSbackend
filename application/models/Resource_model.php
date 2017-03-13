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
	 * get_all_picture
	 */
	public function get_all_picture($map=''){
	    if($map!='')
	    {
	    	$data=$this -> db
	    		-> where($map)
	    		-> get('resource');
	    }
	    else $data=$this-> db ->get('resource');
	    return $data->result();
	    $this->display();
	}


}
