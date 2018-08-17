<?php
namespace Core;

/**
 * @developer   Michel Larrosa
 * @package     WS.Sistema
 * @version     Websailor-Alfa-2018
 * @copyright   Copyright (C) 2016 - 2018 Websailor®. All rights reserved.
 * @license     Creative Commons License version 4; see LICENSE.txt
 */

class Session
{
    public static function set($key, $value){
        $_SESSION[$key] = $value;
    }

    public static function get($key){
        if(isset($_SESSION[$key]))
            return $_SESSION[$key];

        return false;
    }

    public static function destroy($keys){
        if(is_array($keys))
            foreach($keys as $key)
                unset($_SESSION[$key]);

        unset($_SESSION[$keys]);
    }
}
