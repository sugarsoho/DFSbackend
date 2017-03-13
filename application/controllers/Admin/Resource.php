<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Qiniu\Auth;

class Resource extends Admin_Controller {

	public function __construct() {
		parent::__construct();
		$this -> load -> model('resource_model', 'resource');
		$this -> load -> helper('url');
	}



	/**
	 * 发送uploadtoken的接口
	 */
	public function picutureadd(){
        $auth = new Auth(ACCESSKEY,SECRECTKEY);
        //用于设定回调地址（url）和回调地址需要返回的内容（body）
        $policy = array(
      	'returnUrl' => 'https://15580083.qcloud.la/Admin/resource/addPicture',
    	'returnBody' => '{"key": "$(key)","hash":"$(etag)"}',
      	);
        $upToken = $auth->uploadToken(BUCKET, null, 3600, $policy);
  		echo $upToken;
	}

	/**
	 * 添加图片信息到数据库
	 */
	public function addPicture(){
		//回调返回base64编码的内容,base64解码出来的是json格式
	    $upload_ret=$this -> input -> get('upload_ret');
	    if($result=base64_decode($upload_ret)){
	    	$picture_info=json_decode($result,true);
	    	$error=$this -> resource -> addData($picture_info);
	    	if($error){
	    		redirect('https://15580083.qcloud.la/Admin/resource/picturequery');
	    	}
	    	else {
	    		echo 'fail';
	    	}
	    }
	    
	}

	/**
	 * 获取资源列表
	 */
	public function picture_list(){
	    $data=$this-> resource -> get_all_picture();
	    echo json_encode($data);
	}

	/**
	 * 登录页面
	 */
	public function picturequery(){
	    $this-> load ->view('picturequery.html');
	}

	/**
	 * 登录页面
	 */
	public function pictureadd(){
	    $this-> load ->view('pictureadd.html');
	}


}