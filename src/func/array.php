<?php

// 修复value 的 null值为''
function fix_null($a){
  if(is_array($a)){
    $r = [];
    foreach ($a as $k=>$v) {
      if(is_array($v)){
        $r[$k] = $v ? fix_null($v) : '';
      }else{
        $r[$k] = $v;
      }
    }
    return $r;
  }else{
    return $a ? $a : '';
  }
}


//数组key 转小写
function arr2low(array $a=[]){
  $ret = [];
  foreach ($a as $k=>$v) {
    $ret[strtolower($k)] = is_array($v) ? self::arr2low($v) : $v;
  }
  return $ret;
}
//缓存键名
function getCacheKey($map=null,$pre='g'){
    $key = '_'.serialize($map);
    return $pre.$key;
}
//数组key 转大写
function arr2up(array $a=[]){
  $ret = [];
  foreach ($a as $k=>$v) {
    $ret[strtoupper($k)] = is_array($v) ? self::arr2up($v) : $v;
  }
  return $ret;
}
function arrHandle(array $a=[],$add=true){
  $ret = [];
  foreach ($a as $k=>$v) {
    if($add) $ret[$k] = '<![CDATA['.(string)$v.']]';
    else  $ret[$k] = preg_replace('/^<!\[CDATA\[.*\]\]$/', '', (string)$v);
  }
  return $ret;
}

//将数组的某个键作为索引key
function changeArrayKey($arr = null,$k='id'){
    $r = [];
    foreach ($arr as $v) {
        $r[$v[$k]] = $v;
    }
    return $r;
}
//取出数组的某一列
function getArrColumn($arr,$val_f='',$key_f=''){
    if(version_compare(PHP_VERSION,'5.5.0','>=')){
        return array_column($arr, $val_f,$key_f); //php5.5+
    }else{
        $r = [];
        foreach ($arr as $v) {
            if($val_f && isset($v[$val_f])){
                if($key_f && isset($v[$key_f])){
                    $r[$v[$key_f]] = $v[$val_f];
                }else{
                    $r[] = $v[$val_f];
                }
            }
        }
        return $r;
    }
}