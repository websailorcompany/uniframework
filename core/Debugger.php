<?php
namespace Core;
use App\Config;

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
  static function ulog($msg){
    $filename=Config::$logfile;
    if(is_string($msg)||is_numeric($msg)){
      file_put_contents($filename , $msg."\n", FILE_APPEND );
    }else{
      file_put_contents($filename , print_r($msg, true)."\n", FILE_APPEND );
    }
  }
}
