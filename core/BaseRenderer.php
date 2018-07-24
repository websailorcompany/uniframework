<?php
namespace Core;
use Core\Timing;
use Core\Debugger as d;
use DOMDocument;
use DOMElement;
/**
 * @developer   Michel Larrosa
 * @package     WS.Sistema
 * @version     Websailor-Alfa-2018
 * @copyright   Copyright (C) 2016 - 2018 Websailor®. All rights reserved.
 * @license     Creative Commons License version 4; see LICENSE.txt
 */
class BaseRenderer{
  private $DDpage;
  private $template;
  private $modInfo;
  private $modModels;
  private $modViews;
  private $menuInfos;
  private $modules;
  private $menu;
  public $viewConf;
  private $timing;
  // private $modulesFinder; // será uma função

  public function __construct(){
    //
  }
  public function setPage($PageConf){
    $this->template = $PageConf['template'];
    $this->modInfo = $PageConf['modInfo'];
  }
  public function setModViews($modViews){
    $this->modViews = $modViews;
  }
  public function setModModels($modModels){
    $this->modModels = $modModels;
  }
  public function setMenu($menuInfos){
    $this->menuInfos = $menuInfos;
  }
  public function renderMenu(){
    libxml_use_internal_errors(true); //TOTALMENTE NECESSÁRIO, ÚTIL DESABILITAR SOMENTE PARA VER ERROS HUMANOS
    // $this->$menuInfos; //array numerico
    // $this->menuView;
    // $this->menuBody
    if($this->menuInfos!=NULL){
      // d::b($this->menuInfos);
      $menu = new DOMDocument("1.0", "utf-8");
      $menu->formatOutput = true;
      if ($menu->loadHTML(utf8_decode($this->menuInfos['view'])) != FALSE) {
        foreach($this->menuInfos['data'] as $key => $data){
          $item_body= new DOMDocument("1.0", "utf-8");
          $item_body->formatOutput = true;
          if ($item_body->loadHTML(utf8_decode($this->menuInfos['body'])) != FALSE) {
            $item_nome = $item_body->getElementById('menuname');
            // $item_nome->appendChild($item_body->createElement("spam", utf8_decode($data['nome'])));

            $item = $item_body->getElementsByTagName("li")[0];
            // $item = $item_body->getElementById("conteudo");
            // d::b($item);

            if($menu->importNode($item, TRUE)){
              d::b($menu);
              $menulist = $menu->getElementById('ws-menu');
              // $menulist = $menu->getElementById('ws-only-menu-div');
              if($menulist) {
                d::b($item);
                $menulist->appendChild($item);
              }
            }
            // foreach($this->modModels[$modName] as $id => $conteudo){
            //   $HTML_string = "<div id={$modName}__{$id}>".utf8_decode($conteudo)."</div>";
            //   $HTML_doc = new DOMDocument("1.0", "utf-8");
            //   if ($HTML_doc->loadHTML($HTML_string) != FALSE) {
            //     $HTML_conteudo = $HTML_doc->getElementById($modName."__".$id);
            //     if ($HTML_conteudo != NULL) {
            //       $HTML_conteudo = $modulo->importNode($HTML_conteudo, TRUE);
            //       if ($HTML_conteudo != FALSE) {
            //         $elemento = $modulo->getElementById($id);
            //         if ($elemento != NULL) {
            //           $elemento->appendChild($HTML_conteudo);
            //         }
            //       }
            //     }
            //   }
            // }
          }else{
            echo "load menu[body] problemas";
          }
        }
      }else{
        echo "load menu[view] problemas";
      }
      //complementa o libxml_use_internal_errors, liberando a cache
      libxml_clear_errors();

      $menu->normalizeDocument();
      $menu->formatOutput = true;
      $this->menu = $menu->saveHTML();
      echo $menu->saveHTML();
    }
  }

  /*
   * put the data on the modules
   * based on the modules function
   */
   public function renderModules(){ // ALFA somente renderiza todos
     libxml_use_internal_errors(true); //TOTALMENTE NECESSÁRIO, ÚTIL DESABILITAR SOMENTE PARA VER ERROS HUMANOS
     foreach($this->modViews as $modName => $view){
        $modulo= new DOMDocument("1.0", "utf-8");
        $modulo->loadHTML(utf8_decode($view));
        if($this->modModels[$modName]!=NULL){
          foreach($this->modModels[$modName] as $id => $conteudo){
            $HTML_string = "<div id={$modName}__{$id}>".utf8_decode($conteudo)."</div>";
            $HTML_doc = new DOMDocument("1.0", "utf-8");
            if ($HTML_doc->loadHTML($HTML_string) != FALSE) {
              $HTML_conteudo = $HTML_doc->getElementById($modName."__".$id);
              if ($HTML_conteudo != NULL) {
                $HTML_conteudo = $modulo->importNode($HTML_conteudo, TRUE);
                if ($HTML_conteudo != FALSE) {
                  $elemento = $modulo->getElementById($id);
                  if ($elemento != NULL) {
                    $elemento->appendChild($HTML_conteudo);
                  }
                }
              }
            }
          }
        }
      //complementa o libxml_use_internal_errors, liberando a cache
      libxml_clear_errors();
      $modulo->normalizeDocument();
      $modulo->formatOutput = true;
      $this->modules[$modName]=$modulo->saveHTML();
    }
  }

  //dispara o módulo
  function throwModule($moduleNames){
    # echo $this->modules[$module];
  }




  // put the modules on the template
  // based on the PageConfigs
  function renderView(){
    $page = new DOMDocument("1.0", "utf-8");
    $page->formatOutput = true;
    //TOTALMENTE NECESSÁRIO, ÚTIL DESABILITAR SOMENTE PARA VER ERROS HUMANOS
    libxml_use_internal_errors(true);
    $page->loadHTML($this->template);
    ##### renderizando modulos nas posições do template
    foreach($this->modules as $modName => $modulo){
      $mod= new DOMDocument("1.0", "utf-8");
      $mod->formatOutput = true;
      if($mod->loadHTML($modulo)) {
        if ($modConteudo=$mod->getElementById("conteudo")) {
          if ($modConteudo=$page->importNode($modConteudo, TRUE)) {
            if ($posicao = $page->getElementById($this->modInfo[$modName]['posicao'])) {
              $posicao->appendChild($modConteudo);
            }else {
              echo "não existe tal posição: {$this->modInfo[$modName]['posicao']}";
            }
          }
        }
      }
    }
    //complementa o libxml_use_internal_errors, liberando a cache
    libxml_clear_errors();
    $page->normalizeDocument();
    $this->DDpage = $page->saveHTML();
  }

  public function showView(){
    echo $this->DDpage;
  }

}
