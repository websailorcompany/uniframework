<?php

/* se faz necessária uma repetição em alguns casos
 * por conta de terminar ou não em '/'
 */

require("../system/modelo/routes.php");
require("../system/sigma/routes.php");
require("../system/uni/routes.php");

$route[]=['/logout', 'WSController', 'logout'];

 //
 // ### WEBSERVICE
 // $route[] = ['/ws/getfile/{id}', 'WSController@getfile'];
 //
 // // sites possivelmente suportados no futuro
 // $route[] = ['/site/apa/', 'ApaController@index'];
 // $route[] = ['/site/apa/posts', 'ApaController@posts'];
 // $route[] = ['/site/apa/showpost/{id}', 'ApaController@showpost'];
 //
 // $route[] = ['/site', 'SmmaController@index'];
 // $route[] = ['/site/smma/', 'SmmaController@index'];
 // $route[] = ['/site/smma/posts', 'SmmaController@posts'];
 // $route[] = ['/site/smma/showpost/{id}', 'SmmaController@showpost'];

 // $route[] = ['/', 'HomeController@index'];
 // $route[] = ['/posts', 'PostsController@index'];
 // $route[] = ['/posts/', 'PostsController@index'];
 // $route[] = ['/post/{id}/show', 'PostsController@show'];
 // $route[] = ['/post/{id}/show/', 'PostsController@show'];

 // Rotas estáticas com requisição tipo GET síncrona, resosta comum.
 // Rotas por requisição assíncrona, resposta em JSON.
return $route;
