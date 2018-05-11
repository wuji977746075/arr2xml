<?php
/**
 * Author      : rainbow <977746075@qq.com>
 * DateTime    : 2018-05-11 10:48:03
 * Description : [Description]
 */

namespace rainb\util;
// use

abstract class Base {
  protected $config;
  public function __construct(array $config=[]){
    $config && $this->config = array_merge($this->config,$config);
  }
}