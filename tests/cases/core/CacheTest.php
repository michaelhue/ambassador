<?php
/**
 * Ambassador: fetching data the easy way
 *
 * @license   MIT License
 * @author    Michael Hüneburg
 * @copyright Copyright 2011, Think + Craft (http://thinkandcraft.com)
 */

require_once 'core/Cache.php';

use ambassador\core\Cache;

class CacheTest extends \PHPUnit_Framework_TestCase {

	public function setUp() {
		$this->cache = new Cache('tests/tmp');
	}
	
	public function tearDown() {
		if (file_exists('tests/tmp/cache')) {
			unlink('tests/tmp/cache');
		}
	}

	public function testNonExistingCacheDirectory() {
		$result = '';
		try {
			$cache = new Cache('tests/tmp/invalid');
		} catch (Exception $e) {
			$result = $e->getMessage();
		}
		
		$expected = "Could not initialize cache: Directory 'tests/tmp/invalid' does not exist.";
		$this->assertEquals($expected, $result);
	}

	public function testWrite() {
		$this->cache->write('cache', array('foo' => 'bar'));
		$this->assertFileExists('tests/tmp/cache');
		
		$expected = serialize(array(
			'time' => time(), 'data' => array('foo' => 'bar')
		));
		$result = file_get_contents('tests/tmp/cache');
		$this->assertEquals($expected, $result);
	}

	public function testRead() {
		$contents = array(
			'time' => time(), 'data' => array('foo' => 'bar')
		);
		file_put_contents('tests/tmp/cache', serialize($contents));
		
		$result = $this->cache->read('cache');
		$this->assertEquals($contents, $result);
	}

	public function testClear() {
		file_put_contents('tests/tmp/cache', '');

		$this->cache->clear('cache');
		$this->assertFileNotExists('tests/tmp/cache');
	}
	
}

?>