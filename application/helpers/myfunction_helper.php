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
  if (strtotime(date("Y-m-d"))>$DATE_TODAY) {
    //配置您申请的appkey
    $appkey = "1ecfcdd80ba90fc5e839906bafe441f3";
    //************实时汇率查询换算************
    $url = "http://op.juhe.cn/onebox/exchange/currency";
    $params = array(
          "from" => "USD",//转换汇率前的货币代码
          "to" => "CNY",//转换汇率成的货币代码
          "key" => $appkey,//应用APPKEY(应用详细页查询)
    );
    $paramstring = http_build_query($params);
    $content = juhecurl($url,$paramstring);
    $result = json_decode($content,true);
    if($result){
        if($result['error_code']=='0'){
          $EXCHANGE_RATE=$result['result'][1]['exchange'];
          $DATE_TODAY=strtotime(date("Y-m-d"));
          $fp = fopen("/usr/local/exchange_rate.txt", "w");
          $flag=fwrite($fp,$EXCHANGE_RATE."\r\n".$DATE_TODAY."\r\n");
          if(!$flag){
            echo "写入文件失败";
            return false;
          }
          return $EXCHANGE_RATE;
        }else{
            return $result['error_code'].":".$result['reason'];
        }
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
