<?php
// $Id$
/**
 * Initialization page
 * @author Ryan McCue <cubegames@gmail.com>
 * @package Lilina
 * @version 1.0
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

/** */
define('LILINA_PATH', dirname(__FILE__));
define('LILINA_INCPATH', LILINA_PATH . '/inc');

$settings	= array();

require_once(LILINA_INCPATH . '/core/install-functions.php');
lilina_check_installed();

require_once(LILINA_INCPATH . '/core/conf.php');
lilina_level_playing_field();

require_once(LILINA_INCPATH . '/core/plugin-functions.php');
$timer_start = lilina_timer_start();

require_once(LILINA_INCPATH . '/core/version.php');

Locale::load_default_textdomain();

require_once(LILINA_INCPATH . '/core/feed-functions.php');
require_once(LILINA_INCPATH . '/core/file-functions.php');
require_once(LILINA_INCPATH . '/core/skin.php');

/** Load in different methods */
require_once(LILINA_INCPATH . '/core/class-itemupdater.php');

do_action('init');
//Templates::load();
$controller = new Controller();
$controller->dispatch();
?>
