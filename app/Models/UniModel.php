<?php
namespace App\Models;
use Core\BaseModel;
use Core\Debugger as d;
/**
 *
 */

class UniModel extends BaseModel{
  public function __construct(){
    parent::__construct();
  }
  public function index(){
    #
    # cada página tem um numero que gera o template e as configurações
    #
    $model['page'] = $this->pageModeler(2);
    #
    # os dados de cada modulo deverá ser minerado aqui individualmente
    #
    $model['modViews'] = $this->modViews($model['page']['modInfo']);
    $model['modModels']=$this->modModels($model['page']['modInfo']);;

    return $model;
  }
  public function login(){
    $dataModel = $this->pageModeler(5); //$pageCode = 5
    // $this->modModeler(array("show_users")); //$nomeMod[0] = "show_users";
    #
    # os dados de cada modulo deverá ser minerado aqui individualmente
    #
    return $dataModel;
  }
}
