<?php
/**
 * Ambassador: fetching data the easy way
 *
 * @license   MIT License
 * @author    Michael Hüneburg
 * @copyright Copyright 2011, Think + Craft (http://thinkandcraft.com)
 */

require_once 'core/Adapter.php';
require_once 'core/AdapterInterface.php';
require_once 'adapter/Twitter.php';

use ambassador\adapter\Twitter;

class MockTwitter extends Twitter {

	protected function _request($url, array $data = array(), array $options = array()) {
		return compact('url', 'data', 'options');
	}

}

?>