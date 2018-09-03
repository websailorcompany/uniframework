<?php
namespace App\Controllers;
use System\Admin;
use Core\BaseAuth;
use Core\Debugger as d;
use Core\BaseDataBase;
use Core\BaseController;
use Core\Redirect;
use App\Config;
/**
systema
administrador
registrado
cidadao
 */
class WSController extends BaseController{

  public function __construct($action){
    parent::__construct('WSModel', $action);
    $this->action=$action;
  }
  public function index(){
    $model = $this->useModel();
    // d::b($model);
    $display = new \Core\BaseRenderer();
    $display->setPage($model['page']);
    $display->setModViews($model['modViews']);
    $display->setModModels($model['modModels']);
    $display->renderModules();

    // $display->setMenu($model['page']['menu']);
    // $display->renderMenu();

    $display->renderView();
    $display->showView();
  }
  public function paginas(){
    $model = $this->useModel();
    $display = new \Core\BaseRenderer();
    $display->setPage($model['page']);
    $display->setModViews($model['modViews']);
    $display->setModModels($model['modModels']);
    $display->renderModules();
    $display->renderView();
    $display->showView();
  }
  public function categorias(){
    $model = $this->useModel();
    $display = new \Core\BaseRenderer();
    $display->setPage($model['page']);
    $display->setModViews($model['modViews']);
    $display->setModModels($model['modModels']);
    $display->renderModules();
    $display->renderView();
    $display->showView();
  }
  public function componentes(){
    $model = $this->useModel();
    $display = new \Core\BaseRenderer();
    $display->setPage($model['page']);
    $display->setModViews($model['modViews']);
    $display->setModModels($model['modModels']);
    $display->renderModules();
    $display->renderView();
    $display->showView();
  }
  public function modulos(){
    $model = $this->useModel();
    $display = new \Core\BaseRenderer();
    $display->setPage($model['page']);
    $display->setModViews($model['modViews']);
    $display->setModModels($model['modModels']);
    $display->renderModules();
    $display->renderView();
    $display->showView();
  }
  public function usuarios(){
    $model = $this->useModel();
    $display = new \Core\BaseRenderer();
    $display->setPage($model['page']);
    $display->setModViews($model['modViews']);
    $display->setModModels($model['modModels']);
    $display->renderModules();
    $display->renderView();
    $display->showView();
  }
  public function rotas(){
    $model = $this->useModel();
    $display = new \Core\BaseRenderer();
    $display->setPage($model['page']);
    $display->setModViews($model['modViews']);
    $display->setModModels($model['modModels']);
    $display->renderModules();
    $display->renderView();
    $display->showView();
  }
  public function joblogin(){
    $page = __DIR__ . "/../Views/loginViews/joblogin.phtml";
    $this->geral_login($page);
  }

  public function admlogin(){
    $page = __DIR__ . "/../../public/login/form_4/index.html";
    $this->geral_login($page);
  }
  public function reglogin(){
    $page = __DIR__ . "/../Views/loginViews/reglogin.phtml";
    $this->geral_login($page);
  }
  public function geral_login($page=""){ // nessa versão o login é o mesmo, a diferença são as categorias do logado
    // se tem post tenta executar o login
    if (isset($_POST['usermail']) && isset($_POST['password'])){
      $auth = new BaseAuth();
      $auth->execLogin($_POST['usermail'], $_POST['password']);
    }else{ // senão abre a página de login
      if(file_exists($page)) {
        echo file_get_contents($page);
      }else {
        echo "página não visualizável<br>";
      }
    }
  }
  public function logout(){
    $auth= new BaseAuth();
    $auth->execLogout();
  }
}
