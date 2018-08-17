<?php
namespace Core;
use Core\Redirect;
use Core\Session;
use Core\BaseDataBase;
// use Core\BaseAuth;
use Core\Debugger as d;
use App\Config;
/**
 * @developer   Michel Larrosa
 * @package     WS.Sistema
 * @version     Websailor-Alfa-2018
 * @copyright   Copyright (C) 2016 - 2018 Websailor®. All rights reserved.
 * @license     Creative Commons License version 4; see LICENSE.txt
 */
class Route{
  private $routes;
  public function __construct(array $routes){
      $this->routes = $routes;
      // d::b($routes);
      $this->run();
  }
  private function getUrl(){
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  }
  private function getQuery(){
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
  }


  private function run(){
    $url = $this->getUrl();

    $urlArray = explode('/', $url);
    $param = array();
    foreach($this->routes as $route){
      $routeArray = explode('/', $route[0]);
      for($i=0; $i<count($routeArray); $i++){
        if((strpos($routeArray[$i], "{") !==false) && (count($urlArray)==count($routeArray))) {
          $routeArray[$i] = $urlArray[$i]; //coloca valores nas variaveis {$}
          $param[str_replace(array('{', '}'), "", $routeArray[$i])] = $urlArray[$i];
          // explicando o indice associativo acima:
          // se $routeArray[$i] for {id}, setamos $param['id'];
        }
      }

      $rota_instanciada = implode($routeArray, '/');
      // rota é um modelo, url é como uma instância desse modelo;
      // url instância é igual a alguma rota mas com valores;
      // verifica se a url é rota válida (instância de alguma rota);
      if($url == $rota_instanciada){
        $found = true;
        $rota = $route[0];
        $controller = $route[1];
        $action = $route[2];
        break;
      }
    }
    if(isset($found)){
      session_start();
      #
      # tratamento de login
      #
      $auth=new BaseAuth();
      $auth->verificaLogin($rota, $url);
      #
      # se ocorrer algo com as permissões, a função anterior redireciona
      #
      # instanciando o controler
      #
      $controller = BaseController::newController($controller, $action, $rota);
      switch (count($param)) {
        case 1:
          $controller->$action($param[0]);
          break;
        case 2:
          $controller->$action($param[0], $param[1]);
          break;
        case 3:
          $controller->$action($param[0], $param[1], $param[2]);
          break;
        default:
          $controller->$action();
          break;
      }
    }else{
      echo file_get_contents("../system/administrator/static/nao_encontrada.html");
      return;
    }
  }

// private function findRoute(){
//   # code...
// }
// private function knowRoute(){
//   # code...
// }
// private function authRoute(){
//   # code...
// }

// transforma as rotas do formato laravel(@) para o formato zend(,)
// ['/posts', 'PostsController@index'] para ['/posts', 'PostsController', 'index']
// esta função está obsoleta, usaremos diretamente o formato zend(,)
/*
  private function setRoutes($routes){
    foreach ($routes as $rout) {
      $explode = explode('@', $rout[1]);
      $newRoutes[] = [$rout[0], $explode[0], $explode[1], $rout[2]];
    }
    $this->routes = $newRoutes;
  }
*/
} // FIM-DA-CLASSE
