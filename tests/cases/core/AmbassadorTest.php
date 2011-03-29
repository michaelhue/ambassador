<?php
/**
 * Ambassador: fetching data the easy way
 *
 * @license   MIT License
 * @author    Michael Hüneburg
 * @copyright Copyright 2011, Think + Craft (http://thinkandcraft.com)
 */

require_once 'core/Ambassador.php';
require_once 'tests/mocks/core/MockAdapter.php';
require_once 'tests/mocks/core/MockCache.php';

use ambassador\core\Ambassador;

class AmbassadorTest extends \PHPUnit_Framework_TestCase {

	public function setUp() {
		Ambassador::config(array(
			'classes' => array('cache' => 'MockCache')
		));
	}

	public function testFetchNoCache() {
		Ambassador::add('test', 'MockAdapter', array('cache' => false));
		$expected = array(array('id' => 1, 'date' => 1285884000));
		$result = Ambassador::fetch('test');
		$this->assertEquals($expected, $result);
	}

	public function testSort() {
		$data = array(
			array('id' => 1, 'title' => 'c'),
			array('id' => 2, 'title' => 'b'),
			array('id' => 3, 'title' => 'a')
		);
		
		$expected = $data;
		$result = Ambassador::sort($data, 'id', 'asc');
		$this->assertEquals($expected, $result);
		
		$expected = $data;
		$result = Ambassador::sort($data, 'title', 'desc');
		$this->assertEquals($expected, $result);
		
		$expected = $data;
		$result = Ambassador::sort($data, 'invalid_key', 'asc');
		$this->assertEquals($expected, $result);
		
		$expected = array(
			array('id' => 3, 'title' => 'a'),
			array('id' => 2, 'title' => 'b'),
			array('id' => 1, 'title' => 'c')
		);
		$result = Ambassador::sort($data, 'id', 'desc');
		$this->assertEquals($expected, $result);

		$result = Ambassador::sort($data, 'title', 'asc');
		$this->assertEquals($expected, $result);
	}

}

?>