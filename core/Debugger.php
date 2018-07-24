<?php
namespace Core;

/**
 * @developer   Michel Larrosa
 * @package     WS.Sistema
 * @version     Websailor-Alfa-2018
 * @copyright   Copyright (C) 2016 - 2018 Websailor®. All rights reserved.
 * @license     Creative Commons License version 4; see LICENSE.txt
 */
class Debugger{

  function __construct() {

  }
  static function b($value){
    // if(is_array($value)){
    //   echo "<pre>";
    //   echo $value;
    //   echo "</pre>";
    // }
    echo "<pre>";
    print_r($value);
    echo "</pre>";
  }
}
