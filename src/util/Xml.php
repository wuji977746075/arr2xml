<?php
/**
 * Author      : rainbow <977746075@qq.com>
 * DateTime    : 2018-05-10 15:26:40
 * Description : [xml array converter]
 */

namespace rainb\util;
use rainb\util\Base;

class Xml extends Base{
  protected $config = [
      'flag'  => '_LIST',//二维数组标志符
      'cdata' => true,//转换xml是否加cdata
    ];
  public function __construct(array $config=[]){
    parent::__construct($config);
  }
  public function __get($name) {
    if (array_key_exists($name, $this->config)) {
       return $this->config[$name];
    }
    throws('No such config :'.$name);
  }
}