<?php
/**
 * Ambassador: fetching data the easy way
 *
 * @license   MIT License
 * @author    Michael Hüneburg
 * @copyright Copyright 2011, Think + Craft (http://thinkandcraft.com)
 */

namespace ambassador\core;

use \Exception;

class Cache {

	/**
	 * Holds the path to the cache directory.
	 *
	 * @var string
	 */
	protected $_dir = null;

	/**
	 * Constructor, checks if the cache directory exists and is writable.
	 *
	 * @param string $dir Path to cache directory.
	 * @return void
	 */
	public function __construct($dir) {
		if (!is_dir($dir)) {
			throw new Exception("Could not initialize cache: Directory '{$dir}' does not exist.");
		}
		if (!is_writable($dir)) {
			throw new Exception("Could not initialize cache: Directory '{$dir}' not writable.");
		}
		$this->_dir = $dir;
	}

	/**
	 * Reads the cached data from `$file`.
	 *
	 * @param string $file
	 * @return array|boolean
	 */
	public function read($file) {
		$filename = $this->_dir . '/' . $file;
		
		if (!file_exists($filename) || !is_readable($filename)) {
			return false;
		}
		if ($contents = file_get_contents($filename)) {
			return unserialize($contents);
		}
		return false;
	}

	/**
	 * Writes `$data` to `$file`.
	 *
	 * @param string $file
	 * @param array|object
	 * @return boolean
	 */
	public function write($file, $data) {
		$filename = $this->_dir . '/' . $file;
		$contents = array(
			'time' => time(), 'data' => $data
		);
		if (file_put_contents($filename, serialize($contents))) {
			return true;
		}
		return false;
	}
	
	/**
	 * Clears the cache by deleting `$file`.
	 *
	 * @param string $file
	 * @return boolean
	 */
	public function clear($file) {
		$filename = $this->_dir . '/' . $file;
		return unlink($filename);
	}

}

?>