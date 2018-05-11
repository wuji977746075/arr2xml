<?php
// require nusoap_client
//  util:throws
//  xml:arr2xml

 // soap/curl_soap : soap1.2
function curl_soap($fun,array $req=[]){
  $config = ['KEY' => '','URL'=>''];

  $url = $config['URL'];
  $key = $config['KEY'];
  $xml_str = arr2xml($req,'ROOT',''); // curl xml
  // 1.
  $xml_str = str_replace(['<','>'], ['&lt;','&gt;'], $xml_str);
  $str = '<?xml version="1.0" encoding="utf-8"?><soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope"><soap12:Body><'.$fun.' xmlns="http://www.bsoft.com.cn"><xml>'.$xml_str.'</xml></'.$fun.'></soap12:Body></soap12:Envelope>';
  $ret = curl_post_xml($str,$url);
  $fun_str = $fun.'Result';
  $ret = preg_replace('/^(.*)<'.$fun_str.'>(.*)<\/'.$fun_str.'>(.*)$/','$2',$ret);
  $ret = str_replace(['&lt;','&gt;'],['<','>'],$ret);
  // 2.
  // $ret = soap($fun,['xml'=>$xml_str],$url);

  return $ret;
}
function soap($fun,$req,$url){
  try{
    // nusoap / curl
    $soap = new \nusoap_client($url,true);
    $soap->soap_defencoding = 'UTF-8';
    $soap->decode_utf8 = false;
    $err = $soap->getError();
    $err && throws('<p><b>nusoap error: ' . $err . '</b></p>');
    $ret = $soap->call($fun,[$req]);
  }catch(\Exception $e){
    throws($e->getMessage());
  }
  $ret = $ret[lcfirst($fun).'Result'];
  return $ret;
}
//curl post xml 请求CURLOPT_POSTFIELDS xml格式
function curl_post_xml($xml,$url,$second=5) {
  //初始化curl
  $ch = curl_init();
  $options = [
    CURLOPT_URL            =>$url,
    CURLOPT_TIMEOUT        =>$second,
    // CURLOPT_PROXY          =>'8.8.8.8',
    // CURLOPT_PROXYPORT      =>8080,
    CURLOPT_SSL_VERIFYPEER =>FALSE,
    CURLOPT_SSL_VERIFYHOST =>FALSE,
    CURLOPT_HTTPHEADER     =>['Content-Type:text/xml;charset=utf-8','Content-Length:'.strlen($xml)],
    CURLOPT_POST           =>TRUE,
    CURLOPT_POSTFIELDS     =>$xml,
    CURLOPT_HEADER         =>0,
    CURLOPT_RETURNTRANSFER =>TRUE,//结果装string
  ];
  // Note:
  // As with curl_setopt(), passing an array to CURLOPT_POST will encode the data as multipart/form-data, while passing a URL-encoded string will encode the data as application/x-www-form-urlencoded.
  curl_setopt_array($ch,$options);
  //运行curl
  $data = curl_exec($ch);
  //返回结果
  if($data) {
    curl_close($ch);
    return $data;
  } else {
    $error = curl_errno($ch);
    if($error == 28) throws('timeout,please retry later');
    else throws('CURL_ERROR : '.$error);
    // echo "curl出错，错误码: $error"."<br>";
    // echo "<a href='http://curl.haxx.se/libcurl/c/libcurl-errors.html'>错误原因查询</a></br>";
    // curl_close($ch);
    // return false;
  }
}