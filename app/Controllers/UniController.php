<?php
namespace App\Controllers;
use Core\BaseController;
use Core\Debugger;
use Core\Timing;
/**
 *
 */

class UniController extends BaseController{
  private $auth;
  public function __construct($action){
    // echo "## UniControler:<br>";
    $this->action=$action;
    $this->auth= FALSE;
    // echo "## UniControler call parent:<br>";
    parent::__construct('UniModel', $action);
  }

  public function index(){
    // $time = new Timing();
    // $time->starts();
    $model = $this->useModel();
    $display = new \Core\BaseRenderer();
    $display->setPage($model['page']);
    $display->setModViews($model['modViews']);
    $display->setModModels($model['modModels']);
    $display->renderModules();
    $display->renderView();
    $display->showView();

    ##### debuging #####
    // Debugger::p_r( $model['modModels'] );

    // $time->ends();
    // $time->plots();
  }
  public function login($url="http://mvcframework.dev/uni"){
    //usar session
    echo "login<br>";
    echo "<a href=".$url."><button>redirecionar</button></a><br>";
  }
  public function show(){

  }
  public function teste(){

  }
  public function webservice(){
    //necessario principalmente para webservices
  }
}
