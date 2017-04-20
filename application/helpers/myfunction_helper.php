<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function get_exchange_rate(){
  $fp = fopen("/usr/local/exchange_rate.txt", "r");
  if ($fp) {
    if (!feof($fp)) {
      $DATE_TODAY=(int)fgets($fp);
      $EXCHANGE_RATE=(float)fgets($fp);
      fclose($fp);
    }
  }
  if (date('Ymd')>$DATE_TODAY) {
    $result = getExchangeRate();
    if($result){
          $EXCHANGE_RATE=$result['rate'];
          $DATE_TODAY=date('Ymd');
          $fp = fopen("/usr/local/exchange_rate.txt", "w");
          $flag=fwrite($fp,$DATE_TODAY."\r\n".$EXCHANGE_RATE."\r\n");
          if(!$flag){
            echo "写入文件失败";
            return false;
          }
          return $EXCHANGE_RATE;
    }else{
        return $error="请求失败";
    }
  }else{
    return $EXCHANGE_RATE;
  }
}

/**
 * 请求接口返回内容
 * @param  string $url [请求的URL地址]
 * @param  string $params [请求的参数]
 * @param  int $ipost [是否采用POST形式]
 * @return  string
 */
function juhecurl($url,$params=false,$ispost=0){
    $httpInfo = array();
    $ch = curl_init();

    curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
    curl_setopt( $ch, CURLOPT_USERAGENT , 'JuheData' );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 60 );
    curl_setopt( $ch, CURLOPT_TIMEOUT , 60);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    if( $ispost )
    {
        curl_setopt( $ch , CURLOPT_POST , true );
        curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
        curl_setopt( $ch , CURLOPT_URL , $url );
    }
    else
    {
        if($params){
            curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
        }else{
            curl_setopt( $ch , CURLOPT_URL , $url);
        }
    }
    $response = curl_exec( $ch );
    if ($response === FALSE) {
        //echo "cURL Error: " . curl_error($ch);
        return false;
    }
    $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
    $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
    curl_close( $ch );
    return $response;
}

/**
 * 发送HTTP请求方法
 * @param  string $url    请求URL
 * @param  array  $params 请求参数
 * @param  string $method 请求方法GET/POST
 * @return array  $data   响应数据
 */
function http($url, $params='', $method = 'GET', $header = array(), $multi = false){
    $opts = array(
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER     => $header
    );
    switch(strtoupper($method)){
        case 'GET':
            $opts[CURLOPT_URL] =$params==null?$url:$url . '?' . http_build_query($params);
            break;
        case 'POST':
            //判断是否传输文件
            $params = $multi ? $params : http_build_query($params);
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $params;
            break;
        default:
            throw new Exception('不支持的请求方式！');
    }
    $ch = curl_init();
    curl_setopt_array($ch, $opts);
    $data  = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if($error) throw new Exception('请求发生错误：' . $error);
    return  $data;
}

/**
 * 使用curl获取远程数据
 * @param  string $url url连接
 * @return string      获取到的数据
 */
function curl_get_contents($url){
    $ch=curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);                //设置访问的url地址
    curl_setopt($ch,CURLOPT_HEADER,1);               //是否显示头部信息
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);               //设置超时
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);   //用户访问代理 User-Agent
    curl_setopt($ch, CURLOPT_REFERER,$_SERVER['HTTP_HOST']);        //设置 referer
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);          //跟踪301
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        //返回结果
    $r=curl_exec($ch);
    curl_close($ch);
    return $r;
}


function getExchangeRate(){
  $data=array(
      'appid'=>'wx2faf4041dff17d0c',
      'mch_id'=>'1421711502',
      'fee_type'=>'USD',
      'date'=>date('Ymd'),
      );
  $sign=makeSign($data);
  $data['sign']=$sign;
  $xml=toXml($data);
  $url = 'https://api.mch.weixin.qq.com/pay/queryexchagerate';//接收xml数据的文件
  $header[] = "Content-type: text/xml";//定义content-type为xml,注意是数组
  $ch = curl_init ($url);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 兼容本地没有指定curl.cainfo路径的错误
  curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
  $response = curl_exec($ch);
  if(curl_errno($ch)){
      // 显示报错信息；终止继续执行
      die(curl_error($ch));
  }
  curl_close($ch);
  $result=toArray($response);
  // 显示错误信息
  if ($result['return_code']=='FAIL') {
      error_log(date('YmdHis')."-[".json_encode($result)."]"."\n",3,"/tmp/exchange_rate.txt");
      return fail;
  }
  $TencentApi['rate'] = $result['rate']/100000000;
  $TencentApi['date'] = $result['rate_time'];
  return $TencentApi;
}

/**
 * 输出xml字符
 * @throws WxPayException
**/
function toXml($data){
    if(!is_array($data) || count($data) <= 0){
        throw new WxPayException("数组数据异常！");
    }
    $xml = "<xml>";
    foreach ($data as $key=>$val){
        if (is_numeric($val)){
            $xml.="<".$key.">".$val."</".$key.">";
        }else{
            $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
        }
    }
    $xml.="</xml>";
    return $xml;
}

/**
 * 生成签名
 * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
 */
function makeSign($data){
    // 去空
    $data=array_filter($data);
    //签名步骤一：按字典序排序参数
    ksort($data);
    $string_a=http_build_query($data);
    $string_a=urldecode($string_a);
    //签名步骤二：在string后加入KEY
    $string_sign_temp=$string_a."&key=xinshengxuan2016xinshengxuan2016";
    //签名步骤三：MD5加密
    $sign = md5($string_sign_temp);
    // 签名步骤四：所有字符转为大写
    $result=strtoupper($sign);
    return $result;
}

/**
 * 将xml转为array
 * @param  string $xml xml字符串
 * @return array       转换得到的数组
 */
function toArray($xml){
    //禁止引用外部xml实体
    libxml_disable_entity_loader(true);
    $result= json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    return $result;
}
