<?php
namespace Storage;
/**
 * @package    UNI.Sistema
 * @version    Alfa-2018
 * @copyright  Copyright (C) 2016 - 2017 Websailor®. All rights reserved.
 * @license    GNU General Public License version 1 or later; see LICENSE.txt
 * @Developer 	Michel Larrosa [suporte AT michel DOT eng DOT br]
 */

defined('_WS_EXEC') or die;

Class DBConf{
	public static $SGDB = 'mysql';
	public static $USER = 'websailor';
	public static $HOST = 'localhost';
	public static $PASS = "debian";
	public static $DB = "websailor";
	public static $PORT = "3306";					// pgsql:5432			//mysql:3306
  public static $DB_prefix= "uni_";
  public static $DB_charset = "utf8_general_ci";  //utf8_general_ci //padrão novo

  public static function getDBConfigs(){
    $r = array();
    $r["SGDB"] = $this->SGDB;
  	$r["USER"] = $this->USER;
  	$r["HOST"] = $this->HOST;
  	$r["PASS"] = $this->PASS;
  	$r["DB"] = $this->DB;
  	$r["PORT"] = $this->PORT;
    $r["DB_prefix"]= $this->DB_prefix;
    $r["DB_charset"] = $this->DB_charset;

    return $r;
  }
}
