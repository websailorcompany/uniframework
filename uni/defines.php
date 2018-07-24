<?php
/**
 * @package    UNI.Sistema
 *
 * @copyright  Copyright (C) 2016 - 2017 Websailor®. All rights reserved.
 * @license    GNU General Public License version 1 or later; see LICENSE.txt
 * @Developer 	Michel Larrosa [suporte AT michel DOT eng DOT br]
 */

defined('_UNIEXEC') or die;

// Global definitions
$parts = explode(DIRECTORY_SEPARATOR, UNIPATH_BASE); //fazer echo adiante
$tfolder = explode("/", $_SERVER['REQUEST_URI']);
array_pop($tfolder);
 

// Defines.
define('UNIPATH', implode(DIRECTORY_SEPARATOR, $tfolder));
define('UNIPATH_ROOT', implode(DIRECTORY_SEPARATOR, $parts));
define('UNIPATH_SITE', UNIPATH_ROOT);
define('UNIPATH_ADM', UNIPATH_ROOT . DIRECTORY_SEPARATOR . 'administrador');
define('UNIPATH_LIBRARIES',     UNIPATH_ROOT . DIRECTORY_SEPARATOR . 'bibliotecas');
define('UNIPATH_FRAMEWORK',     UNIPATH_ROOT . DIRECTORY_SEPARATOR . 'framework');
define('UNIPATH_CONFIGURATION', UNIPATH_ROOT . DIRECTORY_SEPARATOR . 'configs');

// define('UNIPATH_PLUGINS',       UNIPATH_ROOT . DIRECTORY_SEPARATOR . 'plugins');
// define('UNIPATH_INSTALLATION',  UNIPATH_ROOT . DIRECTORY_SEPARATOR . 'installation');
// define('UNIPATH_THEMES',        UNIPATH_BASE . DIRECTORY_SEPARATOR . 'templates');
// define('UNIPATH_CACHE',         UNIPATH_BASE . DIRECTORY_SEPARATOR . 'cache');
// define('UNIPATH_MANIFESTS',     UNIPATH_ADM . DIRECTORY_SEPARATOR . 'manifests');
define('UNIPATH_ADM_TEMPLATE', UNIPATH_ADM . DIRECTORY_SEPARATOR . 'templates');

?>
