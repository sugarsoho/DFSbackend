<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;

class Login extends CI_Controller {
    public function index() {
        $result = LoginService::login();
        // notes: do not echo anything
        if ($result['code'] === 0) {
        // 微信用户信息：`$result['data']['userInfo']`
        	$this -> load -> model('user_model', 'user');
          $this -> load -> model('coupon_model', 'coupon');
        	$uid['uid']=$this -> user -> add_user($result);
          $coupon=$this -> coupon -> addData($uid);
		    }
    }

    public function test(){
    	echo '123321';
    }
}
