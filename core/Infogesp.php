<?php
namespace Core;
/**
* @developer 	Michel Larrosa
* @package    WS.Sistema
* @version    Websailor-Alfa-2018
* @copyright  Copyright (C) 2016 - 2018 Websailor®. All rights reserved.
* @license    Creative Commons License version 4; see LICENSE.txt
*/

class Documento{
  private $timeline;
  private $owner;
  function __construct($owner){
    # verifica usuario owner e depois
    $this->owner = $owner;
    $this->timeline = new Timeline("documentTimeline");
  }
}
class Processo{
  private $docList;
  private $timeline;
  function __construct($argument){
    # code...
  }
}


class Infogesp{

  function __construct($owner){
    $this->owner = $owner;
    $processo = new Processo();
  }
  public function criaDoc($value=''){
    # code...
  }
}
