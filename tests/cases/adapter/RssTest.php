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
require_once 'adapter/Rss.php';

use ambassador\adapter\Rss;

class MockRss extends Rss {

	protected function _request($url, array $data = array(), array $options = array()) {
		return compact('url', 'data', 'options');
	}

}

class RssTest extends \PHPUnit_Framework_TestCase {

	public function testRequest() {
		$adapter = new MockRss(array(
			'feed' => 'http://example.org/feed.xml'
		));
		
		$expected = array(
			'url' => 'http://example.org/feed.xml',
			'data' => array(),
			'options' => array()
		);
		$result = $adapter->request();
		$this->assertEquals($expected, $result);
	}

	public function testNormalize() {
		$adapter = new MockRss();
		$xml = '<?xml version="1.0" encoding="utf-8"?>
		<rss version="2.0">
			<channel>
				<title>Mock Feed</title>
				<link>http://example.org/feed.xml</link>
				<description>Mock feed for the RSS adapter test.</description>
				<language>en-en</language>
				<copyright>Copyright 2011, Think + Craft</copyright>
				<pubDate>Sun, 26 Dec 2010 00:36:00</pubDate>
				<item>
					<title>Second entry</title>
					<description>Description for second entry.</description>
					<link>http://example.org/posts/second-entry</link>
					<author>John Doe</author>
					<guid>http://example.org/posts/2</guid>
					<pubDate>Sun, 26 Dec 2010 00:36:00</pubDate>
				</item>
				<item>
					<title>First entry</title>
					<description>Description for first entry.</description>
					<link>http://example.org/posts/first-entry</link>
					<author>Jane Doe</author>
					<guid>http://example.org/posts/1</guid>
					<pubDate>Sat, 25 Dec 2010 12:00:00</pubDate>
				</item>
			</channel>
		</rss>';
		
		$expected = array(
			array(
				'id' => 'http://example.org/posts/2',
				'url' => 'http://example.org/posts/second-entry',
				'date' => 1293320160,
				'title' => 'Second entry',
				'body' => 'Description for second entry.',
				'author' => 'John Doe'
			),
			array(
				'id' => 'http://example.org/posts/1',
				'url' => 'http://example.org/posts/first-entry',
				'date' => 1293274800,
				'title' => 'First entry',
				'body' => 'Description for first entry.',
				'author' => 'Jane Doe'
			)
		);
		$result = $adapter->normalize($xml);
		$this->assertEquals($expected, $result);
	}
	
}

?>