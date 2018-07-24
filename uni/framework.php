<?php
/*
 * @package    UNI.Sistema
 *
 * @copyright  Copyright (C) 2016 - 2017 Websailor®. All rights reserved.
 * @license    GNU General Public License version 1 or later; see LICENSE.txt
 * @Developer 	Michel Larrosa [suporte AT michel DOT eng DOT br]
*/

/*
 * somente descomente para debuggar
*/
error_reporting(E_ALL);
ini_set('display_errors', true);
/* */

defined('_UNIEXEC') or die;

header('Cache-Control: no-cache, must-revalidate');

header('Content-Type: text/html; charset=UTF-8');

ini_set('default_charset','UTF-8');

mb_internal_encoding('UTF-8');

session_start();

require_once UNIPATH_CONFIGURATION . '/Unfigurations.php';

date_default_timezone_set ( 'America/Sao_Paulo' );

require_once('uniData.php');

require_once('uni.php');

require_once('uniFace.php');

require_once('uniFile.php');

require_once UNIPATH_CONFIGURATION . '/Unvironment.php';
