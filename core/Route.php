<?php
namespace Core;
use App\Controllers;
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
class Route extends BaseDataBase{
  # objeto privado: requisição
  private $req;
  public function __construct(){
    parent::__construct();
    // $this->run();
    $this->newrun();
  }

  private function newrun(){
    d::ulog(date(DATE_ATOM)." #IP: ". $_SERVER['REMOTE_ADDR']." #ROTA: ".$_SERVER['REQUEST_URI']);
    ($this->req['url']=parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))=="/"?Redirect::route(Config::$Pub['index']):NULL;
    $urlArray=explode("/", $this->req['url']);array_shift($urlArray);
    # se tiver barra no fim da rota
    (empty(end($urlArray))?array_pop($urlArray):NULL);
    $routeArray=$urlArray;

    #
    # transformando url em rota e definindo parametros #
    #
    foreach ($routeArray as $key => &$value) {
      if(is_numeric($value)){
        $this->req['params'][]=$value;
        $value="{}";
      }
    }
    $this->req['rota']=implode('/', $routeArray);
    #
    # agora a rota poderá ser utilizada para auth->thor()
    #

    #
    # trata/verifica login/identidade
    # 'url' para verificar escopo e realizar login se necessário
    #
    session_start();
    $auth=new BaseAuth();
    $session = $auth->thor($this->req['rota'], $urlArray);
    d::ulog($session);

    #
    # auth->thor() aproveita query e trás dados na rota [action, controller, ws]
    # se "rota não encontrada" ou "erro de DB" o "erro de Config" retorna NULL
    # se ocorrer algo com as permissões, a função anterior redireciona
    # se login feito retorna dados na rota e segue em frente
    # se escopo publico retorna Config::$Pub['prefixo'] e segue em frente
    #

    if ($session != NULL) {
      array_merge($this->req, $session);
      d::ulog($this->req);

      # instanciando o controler
      #
      // $controller = BaseController::newController($this->req['controller'], $this->req['action'], $this->req['rota']);
      // $action = $this->req['action'];
      // isset($this->req['params'])?$controller->$action($this->req['params']):$controller->$action();

    }else{
      echo file_get_contents("../system/administrator/static/nao_encontrada.html");
      // Redirect::route("/invalida");
    }
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
