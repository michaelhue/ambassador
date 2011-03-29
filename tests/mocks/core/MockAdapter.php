<?php
/**
 * Ambassador: fetching data the easy way
 *
 * @license   MIT License
 * @author    Michael Hüneburg
 * @copyright Copyright 2011, Think + Craft (http://thinkandcraft.com)
 */

namespace ambassador\adapter;

require_once 'core/Adapter.php';

use ambassador\core\Adapter;

class MockAdapter extends Adapter {

	public $_autoConfig = array(
		'name' => null
	);

	public function request() {
		return array(
			array(
				'id' => 1,
				'date' => strtotime('2010-10-01')
			)
		);
	}

	public function normalize($input) {
		return $input;
	}

}

?>