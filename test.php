<?php
require_once __DIR__ . '/vendor/autoload.php';
use rainb\util\Xml;

header('content-type:text/xml;charset:utf-8');
$a = [
  'name'=>'kkk',
  'list'=>[
    ['id'=>'p','id2'=>'p2'],
    ['id'=>NULL]
  ]
];
echo (new Xml)->arr2xml($a);