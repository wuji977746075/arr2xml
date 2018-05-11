<?php
require_once __DIR__ . '/vendor/autoload.php';

// test xml
// // header('content-type:text/xml;charset:utf-8');
// $arr = [
//   'name'=>'kkk',
//   'list'=>[
//     ['id'=>'p','id2'=>'p2'],
//     ['id'=>NULL]
//   ]
// ];
// $xml = '<RES><HOS_ID><![CDATA[123456]]></HOS_ID><DEPT_ID><![CDATA[49]]></DEPT_ID><REG_DOCTOR_LIST><DOCTOR_ID><![CDATA[YS49]]></DOCTOR_ID><NAME><![CDATA[妇科专家六诊室普通号]]></NAME><JOB_TITLE><![CDATA[医师]]></JOB_TITLE><REG_LIST><REG_DATE><![CDATA[2018-05-11]]></REG_DATE><REG_WEEKDAY><![CDATA[星期五]]></REG_WEEKDAY><REG_TIME_LIST><REG_ID><![CDATA[20180511-49-2]]></REG_ID><TIME_FLAG><![CDATA[2]]></TIME_FLAG><REG_STATUS><![CDATA[1]]></REG_STATUS><TOTAL><![CDATA[99]]></TOTAL><OVER_COUNT><![CDATA[99]]></OVER_COUNT><REG_LEVEL><![CDATA[1]]></REG_LEVEL><REG_FEE><![CDATA[1000]]></REG_FEE><TREAT_FEE><![CDATA[0]]></TREAT_FEE><ISTIME><![CDATA[0]]></ISTIME></REG_TIME_LIST><REG_TIME_LIST><REG_ID><![CDATA[20180511-49-2]]></REG_ID><TIME_FLAG><![CDATA[2]]></TIME_FLAG><REG_STATUS><![CDATA[1]]></REG_STATUS><TOTAL><![CDATA[99]]></TOTAL><OVER_COUNT><![CDATA[99]]></OVER_COUNT><REG_LEVEL><![CDATA[1]]></REG_LEVEL><REG_FEE><![CDATA[1000]]></REG_FEE><TREAT_FEE><![CDATA[0]]></TREAT_FEE><ISTIME><![CDATA[0]]></ISTIME></REG_TIME_LIST></REG_LIST></REG_DOCTOR_LIST></RES>';

// echo '<textarea style="width:50%;height:50%"">';
// // 不支持接连3层无key值
// echo arr2xml($arr);
// // 不支持xml节点属性
// // var_dump(xml2arr($xml));
// echo '</textarea>';