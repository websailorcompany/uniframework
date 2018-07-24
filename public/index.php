<?php
/**
* @developer 	Michel Larrosa
* @package    WS.Sistema
* @version    Websailor-Alfa-2018-(Infogesp)
* @copyright  Copyright (C) 2016 - 2018 Websailor®. All rights reserved.
* @license    Creative Commons License version 4; see LICENSE.txt
*/
header('Content-Type: text/html; charset=UTF-8');
ini_set('default_charset','UTF-8');
setlocale(LC_ALL,'pt_BR.UTF8');
mb_internal_encoding('UTF8');
mb_regex_encoding('UTF8');
// curso-microframework-MVC-composer-rotasPHP
// https://www.youtube.com/playlist?list=PLSYIyzca1f9wGynWlC-SH2lVBkE8S81A0
// https://medium.com/trainingcenter/mvc-framework-usando-a-arquitetura-sem-c%C3%B3digo-de-terceiros-bf95a744c66d

// header('Server: Ubuntu 12.4');
// header('charset: ANSI');
// header('Date: Sat, 15 Nov 2017 17:18:11 GMT');
// header('Content-Length: 20');
// header('Status: 201');
/*
 * somente descomente para debuggar
*/
error_reporting(E_ALL);
ini_set('display_errors', true);
define('_WS_EXEC', 1);
define('SITE', __DIR__);
/* */
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../core/bootstrap.php';
//
// $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// $query_string = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
// echo "<strong>PATH: </strong>" . $path . "<br>";
// echo "<strong>QUERY STRING: </strong>" . $query_string . "<br>";
