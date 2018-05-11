<?php
// 是否为 手机号码
function ismobile($mobile=''){
  $reg = '/^1[0-9]{10}$/';
  return preg_match($reg, $mobile);
}
// 是否为 正常的uid
function isuid($uid=''){
  $info = (new UcenterMemberLogic)->getInfo(['id'=>$uid,'status'=>1]);
  return $info;
}
// 是否为 身份证号
function isidcard($card_no=''){
  return IdCardRegex::isIdCard($card_no);
}
// 是否为 性别
function issex($sex=''){
  return in_array($sex,[0,1,2]);
}
// 是否为 中文姓名
function ischinesename($name){
  return preg_match('/^([\xe4-\xe9][\x80-\xbf]{2}){2,4}$/', $name);
}
// 是否为 年(1000-2999)-月-日
function isdatetime($name){
  return preg_match('/^[1-2][0-9]{3}-[012][0-9]{1}-[0123][0-9]{1}$/', $name);
}