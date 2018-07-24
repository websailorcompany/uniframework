<?php
namespace Core;

/**
 * @developer   Michel Larrosa
 * @package     WS.Sistema
 * @version     Websailor-Alfa-2018
 * @copyright   Copyright (C) 2016 - 2018 Websailor®. All rights reserved.
 * @license     Creative Commons License version 4; see LICENSE.txt
 */
class Timing{
  private $script_start;
  private $script_end;
  private $elapsed_time;
  function __construct(){

  }
  function starts(){
    // Iniciamos o "contador"
    list($usec, $sec) = explode(' ', microtime());
    $this->script_start = (float) $sec + (float) $usec;
  }
  function ends(){
    // Terminamos o "contador" e exibimos
    list($usec, $sec) = explode(' ', microtime());
    $script_end = (float) $sec + (float) $usec;
    $this->elapsed_time = round($script_end - $this->script_start, 5);
  }
  function plots(){
    // Exibimos uma mensagem
    echo 'Elapsed time: '. $this->elapsed_time. ' secs. Memory usage: '. round(((memory_get_peak_usage(true) / 1024) / 1024), 2). 'Mb';
  }
}
