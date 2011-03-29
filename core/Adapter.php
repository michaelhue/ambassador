<?php
/**
 * Ambassador: fetching data the easy way
 *
 * @license   MIT License
 * @author    Michael Hüneburg
 * @copyright Copyright 2011, Think + Craft (http://thinkandcraft.com)
 */

namespace ambassador\core;

/**
 * Adapter base class
 *
 * Every custom adapter must extend this class.
 */
class Adapter {

	/**
	 * Holds the default configuration for the adapter.
	 *
	 * @var array
	 */
	protected $_autoConfig = array();

	/**
	 * Holds the configuration for the adapter.
	 *
	 * @var array
	 */
	public $config = array();

	/**
	 * Constructor, applies configuration.
	 *
	 * @param array [$config]
	 * @return void
	 */
	public function __construct(array $config = array()) {
		$defaults = array(
			'cache' => '+1 hour',
			'timeout' => 5,
			'limit' => 10,
			'page' => 1
		);
		$this->config = $config + $this->_autoConfig + $defaults;
	}

	/**
	 * Makes a CURL request to `$url` with optional `$data`.
	 *
	 * @param string $url
	 * @param array [$data]
	 * @param array [$options] Options for the request. (Not yet implemented.)
	 * @return string
	 */
	protected function _request($url, array $data = array(), array $options = array()) {
		$defaults = array(
			'method' => 'GET'
		);
		$options += $defaults;

		if (!empty($data)) {
			$url .= '?' . http_build_query($data);
		}
		$context = stream_context_create(array('html' => $options));
		$response = @file_get_contents($url, false, $context); // Suppressing errors is not pretty!
		return $response;
	}

}

?>