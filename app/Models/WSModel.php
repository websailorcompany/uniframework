<?php
namespace App\Models;
use Core\BaseModel;
use Core\Debugger as d;
/**
 *
 */

class WSModel extends BaseModel{
  public function __construct(){
    parent::__construct();
  }
  public function index(){

    $model['page'] = $this->pageModeler();
    // d::b($model['page']);
    $model['modViews'] = $this->modViews($model['page']['modInfo']);
    // d::b($model['modViews']);
    $model['modModels']=$this->modModels($model['page']['modInfo']);;
    // d::b($model['modModels']);
    return $model;
  }
  public function paginas(){
    $model['page'] = $this->pageModeler();
    $model['modViews'] = $this->modViews($model['page']['modInfo']);
    $model['modModels']=$this->modModels($model['page']['modInfo']);
    return $model;
  }
  public function categorias(){
    $model['page'] = $this->pageModeler();
    $model['modViews'] = $this->modViews($model['page']['modInfo']);
    $model['modModels']=$this->modModels($model['page']['modInfo']);
    return $model;
  }
  public function componentes(){
    $model['page'] = $this->pageModeler();
    $model['modViews'] = $this->modViews($model['page']['modInfo']);
    $model['modModels']=$this->modModels($model['page']['modInfo']);
    return $model;
  }
  public function modulos(){
    $model['page'] = $this->pageModeler();
    $model['modViews'] = $this->modViews($model['page']['modInfo']);
    $model['modModels']=$this->modModels($model['page']['modInfo']);
    return $model;
  }
  public function usuarios(){
    $model['page'] = $this->pageModeler();
    $model['modViews'] = $this->modViews($model['page']['modInfo']);
    $model['modModels']=$this->modModels($model['page']['modInfo']);
    return $model;
  }
  public function rotas(){
    $model['page'] = $this->pageModeler();
    $model['modViews'] = $this->modViews($model['page']['modInfo']);
    $model['modModels']=$this->modModels($model['page']['modInfo']);
    return $model;
  }


} #FIM-DA-CLASSE
