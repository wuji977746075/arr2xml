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