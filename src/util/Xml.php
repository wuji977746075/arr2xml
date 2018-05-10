<?php
/**
 * Author      : rainbow <977746075@qq.com>
 * DateTime    : 2018-05-10 15:26:40
 * Description : [xml array converter]
 */

namespace rainb\util;
// use

class Xml {

  /**
   *xml转成数组
   * 会去掉最外层标签
   */
  function xml2arr($xmlstr) {
    // addTestLog($xmlstr,'','');
    //禁止引用外部xml实体
    // libxml_disable_entity_loader(true);
    $ret = json_decode(json_encode(simplexml_load_string($xmlstr, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    return $this->fix_list_one($this->fix_null($ret));
  }
  // 修复返回列表(_LIST)成员为1是bug
  // @params : $flag :2维数组key后缀
  function fix_list_one($a,$flag='_LIST') {
    if(is_array($a)){ // []
      foreach ($a as $k=> &$v) {
        if(is_array($v)){ // k=>[]
          $v = $this->fix_list_one($v);//自内而外递归
          if(substr($k, -5) == $flag){ // xx_LIST=>[]
            $one = false;
            foreach ($v as $kk=>$vv) {
              if(!is_numeric($kk)){ //检测到2维数组
                $one = true;
                break;
              }
            }
            $one && $v = [$v];
          }
        }else{ // k=>v
        }
      }
    }
    return $a;
  }
  // 修复null值为''
  function fix_null($a){
    if(is_array($a)){
      $r = [];
      foreach ($a as $k=>$v) {
        if(is_array($v)){
          $r[$k] = $v ? $this->fix_null($v) : '';
        }else{
          $r[$k] = $v;
        }
      }
      return $r;
    }else{
      return $a ? $a : '';
    }
  }

  // 数组或字符串 转xml
  function arr2xml($arr,$root='ROOT',$head='<?xml version="1.0" encoding="UTF-8"?>') {
      $xml = $head.($this->arr_to_xml($arr,$root,true));
      return $xml;
  }
  // 数组或字符串 转xml
  function arr_to_xml($arr,$root="ROOT",$plus=true){
    $s    = "";
    $root = strtoupper($root);
    $pre  = "<$root>";$last = "</$root>";
    if(is_array($arr)){
      foreach ($arr as $k =>$v) {// 0=>[] or k=>[] or k=>v
        $k    = strtoupper($k);
        $temp = is_numeric($k);
        if($temp && is_array($v)){ // 0=>[]
            $plus = false;
            $s .= $this->arr_to_xml($v,$root);
        }else{
          if(is_array($v)){ // k=>[]
            $s .= $this->arr_to_xml($v,$k);
          }else{ // k=>v
            $s .= "<$k><![CDATA[".$v."]]></$k>";
          }
        }
      }
    }else{
      $s = $arr;
    }
    $s = $plus ? $pre.$s.$last : $s;
    return $s;
  }
}