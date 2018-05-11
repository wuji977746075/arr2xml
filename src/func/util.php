<?php
/**
 * Author      : rainbow <977746075@qq.com>
 * DateTime    : 2018-05-10 17:29:00
 * Description : [util main]
 */
// echo

// code : 0:suc 1:err
function throws($msg,$code=1){
  // * ErrorException code=0
  throw new \Exception($msg,$code ? $code : 1);
}

function suc($data,$msg) {
  ret(0,$msg,$data);
}

function err($msg='',$code=1) {
  ret($code,$msg,[]);
}

function ret($code,$msg,$data) {
  $ret = [
    'code' =>$code,
    'msg'  =>$msg,
    'data' =>$data,
  ];
  // xml
  // header('content-type:html/xml,charset=utf-8'); // 下载
  header('content-type:text/xml,charset=utf-8'); // 显示
  echo $ret;
  // json
  // echo json_encode($ret);
  die();
}
function getAddressPos($address='',$ak=''){
    $req = 'http://api.map.baidu.com/geocoder/v2/?address='.urlencode($address).'&output=json&ak='.$ak;
    $r = json_decode(file_get_contents($req),true);
    if($r['status'] !== 0){
       throws(isset($r['msg']) ? '非法地址:'.$r['msg'] : $r['message']);
    }
    return $r['result']['location'];
}
function _param($name){
  // ** get为false类型值将触发post取值
  return ifset(_get($name),_post($name));
}
function _post($name){
  return ifset($_POST[$name]);
}
function _get($name){
  return ifset($_GET[$name]);
}
function checkArrKey($arr,$k){
  return ifset($arr[$k],throws('未定义'.$k));
}

// $a / null
function ifset($a,$df=null){
  // if(ifphp('7')){ //php7+
  //   return $a ?? $df; //parseError
  // }else{
    return isset($a) ? $a : $df;
  // }
}
function iftrue($exp1,$exp2){
  // ? : 为语句的结果。如果想通过引用返回一个变量将不起作用，
  if(ifphp('5.3')){ // php5.3+
    return $exp1 ?: $exp2;
  }else{
    return $exp1 ? $exp1 : $exp2;
  }
}
function ifphp($v,$flag='>='){
  return version_compare(PHP_VERSION,$v,$flag);
}
function xml2arr($xmlstr,$flag="_LIST") {
  return (new \rainb\util\Xml(['flag'=>$flag]))->xml2arr($xmlstr);
}
function arr2xml($arr,$root='ROOT',$head='<?xml version="1.0" encoding="UTF-8"?>') {
  return (new \rainb\util\Xml)->arr2xml($arr,$root,$head);
}
/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @param boolean $adv 是否进行高级模式获取（有可能被伪装）
 * @return mixed
 */
function get_client_ip($type = 0,$adv=false) {
    $type       =  $type ? 1 : 0;
    static $ip  =   NULL;
    if ($ip !== NULL) return $ip[$type];
    if($adv){
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos    =   array_search('unknown',$arr);
            if(false !== $pos) unset($arr[$pos]);
            $ip     =   trim($arr[0]);
        }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip     =   $_SERVER['HTTP_CLIENT_IP'];
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip     =   $_SERVER['REMOTE_ADDR'];
        }
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u",ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}

/**
 * 生成假数据对象列表
 * eg:
 * $map = ['id'=>['numberBetween',[1,99]],'name'=>['firstName',[]]];
 * getFaker($map,rand(1,5));
 * return faker object list
 */
//require '../vendor/faker/autoload.php';
function getFaker(array $rules,$count=1){
    vendor('faker.autoload');
    $faker = \Faker\Factory::create('zh_CN');
    $r = [];
    for ($i=0; $i < $count; $i++) {
        $map = [];
        foreach ($rules as $k => $v) {
            $map[$k] = call_user_func_array([$faker,$v[0]], $v[1]);
        }
        $r[] = $map;
    }
    return $r;
}
/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 */
function format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}