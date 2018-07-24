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
 *
 */
class WSController extends BaseController{

  public function __construct($action){
    $this->action=$action;
    parent::__construct('WSModel', $action);
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
}
