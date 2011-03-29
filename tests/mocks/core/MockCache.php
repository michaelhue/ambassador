<?php
/**
 * Ambassador: fetching data the easy way
 *
 * @license   MIT License
 * @author    Michael Hüneburg
 * @copyright Copyright 2011, Think + Craft (http://thinkandcraft.com)
 */

require_once 'core/Cache.php';

class MockCache extends ambassador\core\Cache {

	public $cached = array();

	public function __construct($dir) {
		$this->_dir = $dir;
	}
	
	public function write($file, $data) {
		$this->cached[$file] = array(
			'time' => time(),
			'data' => $data
		);
		return true;
	}
	
	public function read($file) {
		if (isset($this->cached[$file])) {
			return $this->cached[$file];
		}
		return false;
	}
	
	public function clear($file) {
		unset($this->cached[$file]);
		return true;
	}

}

?>