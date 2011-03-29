<?php
/**
 * Ambassador: fetching data the easy way
 *
 * @license   MIT License
 * @author    Michael Hüneburg
 * @copyright Copyright 2011, Think + Craft (http://thinkandcraft.com)
 */

if (!defined('AMBASSADOR_DIR')) {
	define('AMBASSADOR_DIR', dirname(__FILE__));
}

/**
 * Loads the base class and registers the autoloader.
 */
require_once AMBASSADOR_DIR . '/core/Ambassador.php';
spl_autoload_register('ambassador\core\Ambassador::autoload');

/**
 * Default configuration for the base class.
 */
use ambassador\core\Ambassador;

Ambassador::config(array(
	'cache_dir' => AMBASSADOR_DIR . '/cache'
));

?>