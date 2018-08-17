<?php
namespace Core;
use Core\Session;
/**
 * @developer   Michel Larrosa
 * @package     WS.Sistema
 * @version     Websailor-Alfa-2018
 * @copyright   Copyright (C) 2016 - 2018 Websailor®. All rights reserved.
 * @license     Creative Commons License version 4; see LICENSE.txt
 */
class Redirect{
    # $with para redirecionar deixando dados na session
    public static function route($url, $with = []){
      if (count($with) > 0){
        foreach ($with as $key => $value){
          Session::set($key, $value);
        }
      }
      return header("location:$url");
    }
}
