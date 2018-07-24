<?php
namespace Core;
use DOMDocument;
/**
 * @developer   Michel Larrosa
 * @package     WS.Sistema
 * @version     Websailor-Alfa-2018
 * @copyright   Copyright (C) 2016 - 2018 Websailor®. All rights reserved.
 * @license     Creative Commons License version 4; see LICENSE.txt
 */
 /**
 * Renderizador do UNI agora como classe de MVC
 * Preparado para Pwaction
 */
class BaseRenderer{
  private $template;
  private $unimodel;
  private $interfaceConfigs;
  private $modules;
  private $script_start;
  // private $modulesFinder; será uma função

  function __construct($template, $interfaceConfigs){
    renderViewTemplateDD($template);

    // set which module will be in wich position of template
    // if the position does not exist, module will be ignored
    $this->interfaceConfigs = $interfaceConfigs;
  }

  //put the modules on the template
  // based on the setPageConfigs
  protected function renderViewTemplateDD($template){
    // Iniciamos o "contador"
    list($usec, $sec) = explode(' ', microtime());
    $script_start = (float) $sec + (float) $usec;

    // $template recebe string assim como o renderizador original
    if(file_exists(__DIR__."/../public/templates/{$template}/template.phtml")){
      $this->template = __DIR__."/../public/templates/{$template}/template.phtml";
      $this->unimodel = new DOMDocument('1.0', 'utf-8'); // $unimodel->formatOutput = true;
			libxml_use_internal_errors(true); //TOTALMENTE NECESSÁRIO, ÚTIL DESABILITAR SOMENTE PARA VER ERROS HUMANOS
			$this->unimodel->loadHTMLFile($this->template);
    }else{
      echo "Error: template rendering troubles!<br>";
    }
  }
  /* get the module model from file or DB
   * get the data from the Model Class
   * put the data on the modules
   * based on the modules function
   */
   // antigo modMaze
  function renderModule($moduleModel, $data, $configs){ //single or array
    // requisitar os dado

    $modFile = "componentes/" . strtoupper($componente). "/" . $level ."/". $modulo .".php";
    if(file_exists($modFile)){
      ob_start();
      // Imprime a página, mas ela não irá aparecer, porque será guardada no buffer.
      require($modFile);
      // Pega a guardada pelo buffer e salva na variável "$modReturn".
      $modReturn = ob_get_contents();
      // Limpa o buffer.
      ob_end_clean();
      // retorna
      return $modReturn;
  }

  // throw the allready populed template to the request
  // used staticaly
  function throwViewTemplateDD(){ //single or array
    //complementa o libxml_use_internal_errors, liberando a cache
    libxml_clear_errors();
    #
    $this->unimodel->normalizeDocument();
    echo $this->unimodel->saveHTML();
    // Terminamos o "contador" e exibimos
    list($usec, $sec) = explode(' ', microtime());
    $script_end = (float) $sec + (float) $usec;
    $elapsed_time = round($script_end - $this->script_start, 5);
    // Exibimos uma mensagem
    echo 'Elapsed time: '. $elapsed_time. ' secs. Memory usage: '. round(((memory_get_peak_usage(true) / 1024) / 1024), 2). 'Mb';
  }
}
