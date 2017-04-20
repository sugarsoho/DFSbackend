<?php
header("Access-Control-Allow-Origin:*");

class Wechatpay extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this -> load -> model('user_model', 'user');
		$this -> load -> model('order_model', 'order');
		$this -> load -> model('coupon_model', 'coupon');
		$this -> load -> model('paylog_model', 'paylog');
		$this -> load -> model('refundlog_model', 'refundlog');
		$this -> load -> helper('myfunction');
	}
	/**
	 * [callPay 唤起支付]
	 * @return [json] [唤起支付需要的参数]
	 * @uid
	 * @order_id 合并订单号
	 */
	public function callPay(){
		//先拿到用户的openid
		$uid = $this -> input -> get('uid');
		if($uid==NULL) exit('未授权登录，请重试');
		$user_info = $this -> user -> get($uid);
		//再计算订单总价
		$amount = 0;
		$order_id = $this -> input -> get('order_id');
		$map['order_id']=$order_id;
		$order_info = $this -> order -> getData('order', $map);
		foreach ($order_info as $key => $value) {
			$amount += $value['price'];
		}
		$amount = $amount*100;
		$pay_body = array('openid' => $user_info['openId'],
	 										'amount' => 1,
											'currency' => 'USD',
											'reference' => $order_id,
											'ipn_url' => 'http://139.199.170.78/Test/Wechatpay/notify_pay');
		$pay_parameters = self::getPayParameters($pay_body);
		if($pay_parameters == false) exit('支付失败，请重试');
		echo $pay_parameters;
	}

	public function notify_pay(){
		$field = array('id' ,
	 								'amount',
									'status',
									'currency',
									'time',
									'reference',
									'notify_id');
		//获取返回数据
		$data = $this -> input -> post($field);
		error_log(date('YmdHis')."-[".json_encode($data)."]"."\n",3,"/tmp/notify_pay.log");
		if($data['status']=='success'){
			$order_change['transaction_id'] = $data['id'];
			$order_change['paid'] = 1;
			$order_change['order_status']=1;
			$order_change['pay_time'] = date('YmdHis');
			$map['order_id'] = $data['reference'];
			$result = $this-> order -> editMultiData('order', $map, $order_change);
			$data['transaction_id'] = $data['id'];
			unset($data['id']);
			$result1 = $this -> paylog -> addData('paylog',$data);
			$result2 = self::getCoupon($data['amount'], $data['reference']);
		}
		else{
			error_log(date('YmdHis')."-[".json_encode($data)."]"."\n",3,"/tmp/notify_pay.log");
		}
	}

	public function getPayParameters($pay_body){
		$url = 'https://dev.citconpay.com/payment/pay_wxmini';
		$header = array('Authorization: Bearer 00000000000000000000000000000002');
		$result = http($url , $pay_body , 'POST' , $header );
		error_log(date('YmdHis')."-[".$result."]"."\n",3,"/tmp/notify_pay.log");
		$error = json_decode($result, true);
		if($error['result']=='success')return $result;
		else return false;
	}

	public function refund(){
		$data['transaction_id'] = $this -> input -> get('transaction_id');
		if($data['transaction_id'] == ' '||$data['transaction_id'] == ''){
			exit('transaction_id wrong');
		}
		else{
			$data['amount'] = $this -> input -> get('amount');
			//$data['amount'] = $data['amount']*100;
			$data['amount'] = 1;
			$data['currency'] = 'USD';
			$map['transaction_id'] = $data['transaction_id'];
			$error = $this -> order -> getData('order', $map);
			if ($error == NULL){
				echo 'transaction_id wrong';
			}
			else {
				$result = self::getRefundParameters($data);
				if($result != false){
					$order_change['refund'] = 1;
					$order_change['refund_time'] = date('YmdHis');
					$error1 = $this -> order -> editMultiData('order', $map, $order_change);
					if ($error1 == NULL){
						echo 'fail to change refund status';
					}
					else {
						$result['notify_id'] = $result['id'];
						unset($result['id']);
						unset($result['refunded']);
						$error2 = $this -> refundlog -> addData('refundlog', $result);
						if($error2 != false){
							echo 'success';
						}
						else{
							echo 'refund success; fail to record refundlog';
						}
					}
				}
			}
		}
	}

	public function getRefundParameters($refund_body){
		$url = 'https://dev.citconpay.com/payment/refund';
		$header = array('Authorization: Bearer 00000000000000000000000000000002');
		$result = http($url , $refund_body , 'POST' , $header );
		error_log(date('YmdHis')."-[".$result."]"."\n",3,"/tmp/notify_pay.log");
		$error = json_decode($result,true);
		if($error['status'] == 'success') {
			return $error;
		}
		else return false;
	}


	public function getCoupon($amount, $reference)
	{
		if($amount >= 0.1){
			$map['order_id'] = $reference;
			$order = $this -> order -> getInfo('order', $map);
			$map1['uid'] = $order['uid'];
			$coupon = $this -> coupon -> getInfo('coupon', $map1);
			$coupon['coupon_status'] = 1;
			$result = $this -> coupon -> editData('coupon', $coupon);
			return true;
		}
		return false;
	}



}
