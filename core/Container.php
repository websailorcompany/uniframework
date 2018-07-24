<?php
namespace Core;
/**
 * @developer   Michel Larrosa
 * @package     WS.Sistema
 * @version     Websailor-Alfa-2018
 * @copyright   Copyright (C) 2016 - 2018 Websailor®. All rights reserved.
 * @license     Creative Commons License version 4; see LICENSE.txt
 */
 
 class Container{

   public static function newController($controller){
     $objController = "App\\Controllers\\" . $controller;
     return new $objController;
   }
 }
