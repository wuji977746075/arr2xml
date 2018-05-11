<?php
/**
 * Author      : rainbow <977746075@qq.com>
 * DateTime    : 2018-05-10 17:29:00
 * Description : [util main]
 */

/**
 * 自定义语言变量
 * @param $str  字符串
 * @param $dif  分割符
 * @param $add  链接符
 * @return string is8n字符串
 * add by zhouhou
 */
function LL($str='',$dif=' ',$add = ''){
    return implode($add,array_map('lang',explode($dif, trim($str))));
}

// 获取CDN图标 - country[60,107] service[35]
function getCdnIcon($type,$size=60,$name,$ext='png'){
    return ITBOYE_CDN.$type.DS.$size.DS.$name.'.'.$ext;
}
/**
 * lang() alias 方法别名
 * @param [type] $name [description]
 * @param array  $vars [description]
 * @param string $lang [description]
 */
function L($name, $vars = [], $lang = '')
{
    return \think\Lang::get($name, $vars, $lang);
}
/**
 * 缺少参数函数别名
 * @Author
 * @DateTime 2016-12-13T10:20:27+0800
 * @param    [type]                   $name [description]
 */
function Llack($name){
    return lang('lack_parameter',["param"=>$name]);;
}
function Linvalid($name,$throw=false){
    $msg = lang('invalid_parameter',["param"=>$name]);
    if($throw){
        throw new \Exception(Linvalid("group_id"), \app\src\base\enum\ErrorCode::Invalid_Parameter);
    }
    return $msg;
}
function returnErr($msg,$trans=false){
    if($trans) \think\Db::rollback();
    return ['status'=>false,'info'=>$msg];
}
function returnSuc($data){
    return ['status'=>true,'info'=>$data];
}
//添加到记录test_log表
function addTestLog($get='',$post='',$ext=''){
    $model = db('test_log');
    $get  = $get  ? var_export($get,true) :'null';
    $post = $post ? var_export($post,true):'null';
    $ext  = $ext  ? var_export($ext,true) :'null';
    $entry = [
        'get' =>$get,
        'post'=>$post,
        'ext' =>$ext,
    ];
    return $model ->insertGetId($entry);
}

/**
 * 封装tp的url函数并添加ret_url参数
 * @param $uri
 * @param string $vars
 * @return string
 */
function byUrl($uri,$vars=''){
    return url($uri,$vars).'?ret_url='.__SELF__;
}
/*
    获取当前服务器的IP
*/
function get_client_ip()
{
    if ($_SERVER['REMOTE_ADDR']) {
    $cip = $_SERVER['REMOTE_ADDR'];
    } elseif (getenv("REMOTE_ADDR")) {
    $cip = getenv("REMOTE_ADDR");
    } elseif (getenv("HTTP_CLIENT_IP")) {
    $cip = getenv("HTTP_CLIENT_IP");
    } else {
    $cip = "unknown";
    }
    return $cip;
}

/**
 * 获取图片地址
 * @param $id
 * @param int $size
 * @return string
 */
function getImgUrl($id,$size=0){
    return config('picture_url').$id.($size  ? '&size='.$size:'');
}
 /**
  * 模板helper - 图片
 */
function imgTag($id,$size=120,$click=false,$tooltip=false){
    $size = $size ? $size : 120;
    $str = "<img src='".getImgUrl($id,$size)."' ";
    $style = " style ='width:".$size."px;";
    if($click){//新窗口打开
        $str .= " onclick=\"javascript:window.open('".getImgUrl($id)."');\" alt='点击新窗口查看原图' ";
        $style .= "cursor:pointer;";
    }
    if($tooltip){ //bootstrap-tooltip
        $str .= " title='点击查看原图' data-toggle='tooltip' ";
     }
     return $str.$style."' />";
 }
/**
 * 模板helper - 图片
 * @Author
 * @DateTime 2017-01-06T11:26:05+0800
 * @param    [type]  $id      [图片id]
 * @param    integer $size    [显示大小]
 * @param    boolean $click   [是否点击打开新窗口显示原图]
 * @param    boolean $tooltip [bootstrap-tooltip 或 自定义tooltip]
 * @return   [type]  [description]
 */
function imgTooltip($id,$size=120,$click=false,$tooltip=false){
    $size = $size ? $size : 120;
    $str = "<img src='".getImgUrl($id,$size)."' ";
    $style = " style ='width:".$size."px;";

    if($tooltip){//bootstrap-tooltip
        if($click){
            //自带js打开
            $style .= "cursor:pointer;";
            $str .= " onclick=\"javascript:window.open('".getImgUrl($id)."');\"  alt='" .(is_string($click) ? $click : "点击新窗口查看原图") ."' ";
        }
        $str .= " title='" .(is_string($tooltip) ? $tooltip : "点击查看原图") ."' data-toggle='tooltip' ";
    }else{ //自定义tooltip
        if($click){
            //自定义js打开 - 见模板
            $str .= " class='img-click'  alt='" .(is_string($click) ? $click : "点击新窗口查看原图") ."' ";
            $style .= "cursor:pointer;";
        }
        $str .= " data-src='".getImgUrl($id)."' ";

    }
    return $str.$style."' />";
}