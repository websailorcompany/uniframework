<?php
namespace Core;
use Core\BaseDataBase;
use Core\Debbuger;
use Core\Timing;
/**
 * @developer   Michel Larrosa
 * @package     WS.Sistema
 * @version     Websailor-Alfa-2018
 * @copyright   Copyright (C) 2016 - 2018 Websailor®. All rights reserved.
 * @license     Creative Commons License version 4; see LICENSE.txt
 */
class Timeline extends BaseDataBase{
  private $configs;
  private $type;
  //[documentTimeline][proccessTimeline][peopleTimeLine]
  function __construct(){
    parent::__construct('sqlite');
  }

}
