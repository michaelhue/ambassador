<?php
/**
 * Ambassador: fetching data the easy way
 *
 * @license   MIT License
 * @author    Michael Hüneburg
 * @copyright Copyright 2011, Think + Craft (http://thinkandcraft.com)
 */

require_once 'core/Adapter.php';

use ambassador\core\Adapter;

class AdapterTest extends \PHPUnit_Framework_TestCase {

	public function testConfig() {
		$adapter = new Adapter(array('foo' => 'bar'));
		$this->assertNotEmpty($adapter->config['foo']);
		
		$result = $adapter->config['foo'];
		$expected = 'bar';
		$this->assertEquals($expected, $result);
	}
	
}

?>