<?php
namespace Core;
use Core\BaseRenderer;
use Core\Session;
/**
 * @developer   Michel Larrosa
 * @package    WS.Sistema
 * @version    Websailor-Alfa-2018
 * @copyright  Copyright (C) 2016 - 2018 Websailor®. All rights reserved.
 * @license    Creative Commons License version 4; see LICENSE.txt
 */
class BaseController extends BaseRenderer{
  // protected $view;
  // private $viewPath;
  // private $layoutPath;
  // private $pageTitle;
  private $model;
  private $action;
  #
  public function __construct($model, $action){
    $this->model=$model;
    $this->action=$action;
    // echo "## BaseController:<br>";
    $objModeler= "App\\Models\\" . $this->model;
    $this->model = new $objModeler;
  }
  public static function newController($controller, $Action, $route){
    Session::set('rota', $route);
    $objController = "App\\Controllers\\" . $controller;
    return new $objController($Action);
  }
  protected function useModel($alternativeAction=NULL){
    // echo "## BaseController->useModel():<br>";
    if($alternativeAction)
     return $this->model->run($alternativeAction);
    return $this->model->run($this->action);
  }
  public function run($action){ //usado pelas classes filhas
    return $this->$action();
  }
  public function runPage($action){ //usado pelas classes filhas
    $model = $this->useModel();
    $display = new \Core\BaseRenderer();
    $display->setPage($model['page']);
    $display->setModViews($model['modViews']);
    $display->setModModels($model['modModels']);
    $display->renderModules();
    $display->renderView();
    $display->showView();
  }

  protected function setPageTitle($pageTitle){
    $this->pageTitle = $pageTitle;
  }
  protected function getPageTitle($separator = null){
    if($separator){
      echo $this->pageTitle . " " . $separator . " ";
    }
  }
}
