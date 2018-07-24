<?php
/**
 * @package    UNI.Sistema
 *
 * @copyright  Copyright (C) 2016 - 2017 Websailor®. All rights reserved.
 * @license    GNU General Public License version 1 or later; see LICENSE.txt
 * @Developer 	Michel Larrosa [suporte AT michel DOT eng DOT br]
 */

$template = 'AdminLTE-2.3.7/';//procurar no banco de dados
define('LAYOUT_ADM', 'administrador/templates/' . $template);

// $dominio= $_SERVER['HTTP_HOST'];
// $url = "http://" . $dominio. $_SERVER['REQUEST_URI'];
define('URLATUAL', "http://" . $_SERVER['HTTP_HOST'] );
// verificar quais pastas estão após o PUBLIC_HTML
define('URLADMINLAYOUT', URLATUAL . 'sistemas/UNI/' );
?>