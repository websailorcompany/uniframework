<?php
namespace Core;
use Core\BaseDataBase;
use Core\Debugger as d;
/**
* @developer 	Michel Larrosa
* @package    WS.Sistema
* @version    Websailor-Alfa-2018
* @copyright  Copyright (C) 2016 - 2018 Websailor®. All rights reserved.
* @license    Creative Commons License version 4; see LICENSE.txt
*/
class BaseModel extends BaseDataBase{
  public function __construct(){
    parent::__construct();
  }
  public static function newModel($model, $Action){
    $objController = "App\\Models\\" . $model;
    return new $objController($Action);
  }

  //usado pelas classes filhas
  public function run($action){
    return $this->$action();
  }

  public function pageModeler($includeModules=TRUE){
    if($includeModules){
      ## coleta o template e modulos para a atual rota (dentro db)
      $select = "SELECT t.template, lower(cmp.nome) as componente, pos.posicao, m.modulo
      FROM paginas as p, visibilidade as v, composicao as c, modulos as m ,posicoes as pos, templates as t, componentes as cmp
      WHERE p.rota = '{$_SESSION['rota']}' AND v.categorias = {$_SESSION['categoria']}
      AND t.id = p.template
      AND c.paginas = p.id
      AND m.id = c.modulos
      AND m.id = v.modulos
      AND pos.id = c.posicoes
      AND cmp.id = m.componente";
      // SELECT t.template, lower(cmp.nome) as componente, pos.posicao, m.modulo
      // FROM paginas as p
      // JOIN visibilidade as v ON v.categorias = 1
      // JOIN composicao as c ON c.paginas = p.id
      // JOIN modulos as m ON m.id = v.modulos AND m.id = c.modulos
      // JOIN posicoes as pos ON pos.id = c.posicoes
      // JOIN templates as t ON t.id = p.template
      // JOIN componentes as cmp ON cmp.id = m.componente
      // WHERE p.rota = '/ws-admin'

      $exec=$this->execQuery($select);
      if ($exec['status']) {
        // d::b($exec);
        if ($exec['numRows']>0) {
          ##### TEMPLATE
          $templateFolder=$exec['result'][0]['template'];;
          $fileaddress = SITE . "/templates/{$templateFolder}/template.phtml";
          if(file_exists($fileaddress)){
            $view['template'] = file_get_contents($fileaddress);
          }else{
            //transformar em log
            $view['template']=NULL;
          }

          ##### MODULOS
          // coleta quais modulos irão no template (dentro db)
          $module_data = $exec['result'];
          foreach ($module_data as &$modInfo) {
            array_shift($modInfo);
            $view['modInfo'][$modInfo['modulo']] = $modInfo;
            array_pop($view['modInfo'][$modInfo['modulo']]);
          }


        }
      }else{
        // redirecionar para página de erro
        // query errado
      }

    }else{
      $query="SELECT t.template from templates as t, paginas as p WHERE p.rota = '{$_SESSION['rota']}'";
      $exec=$this->execQuery($query);
      $template=$exec['result'][0]['template'];
      $fileaddress = SITE . "/templates/{$template}/template.phtml";
      if(file_exists($fileaddress)){
        $view['template'] = file_get_contents($fileaddress);
      }else{
        //transformar em log
        $view['template']=NULL;
      }
    }
    return $view;
  }
  /* coleta os layouts (das pastas view)
  * não coleta dados somente layout
  * esse $modules deve ser objeto
  */
  public function modViews($modules){
    if(is_array($modules)){
      foreach ($modules as $modName => $info){
        $fileaddress = __DIR__."/../app/Views/modViews/".strtolower($info['componente'])."/".$modName.".phtml";
        if (file_exists($fileaddress)){
          $mods[$modName]= file_get_contents($fileaddress);
        }else{
          $mods[$modName]=$fileaddress;
        }
      }
      return $mods;
    }else{
      return "erro, argumento não é vetor";
    }
  }

/*
 * coleta os dados somente
 */
  public function modModels($modules) {
    if(is_array($modules)){
      foreach ($modules as $modName => $info){
        $fileaddress = __DIR__."/../app/Models/modModels/".strtolower($info['componente'])."/".$modName.".php";
        if (file_exists($fileaddress)){
          $mods[$modName] = require($fileaddress);
          unset($r);
        }else{
          $mods[$modName]=$fileaddress;
        }
      }
      return $mods;
    }else{
      return "erro, argumento não é vetor";
    }
  }
}
