<?php
/**
 * Ambassador: fetching data the easy way
 *
 * @license   MIT License
 * @author    Michael Hüneburg
 * @copyright Copyright 2011, Think + Craft (http://thinkandcraft.com)
 */

require_once 'tests/mocks/adapter/MockTumblr.php';

class TumblrTest extends \PHPUnit_Framework_TestCase {

	public function testRequest() {
		$adapter = new MockTumblr(array(
			'name' => 'foo',
			'type' => 'all',
			'filter' => 'text',
			'limit' => 10,
			'page' => 1
		));
		
		$expected = array(
			'url' => 'http://foo.tumblr.com/api/read',
			'data' => array('num' => 10, 'offset' => 0, 'filter' => 'text', 'type' => 'all'),
			'options' => array()
		);
		$result = $adapter->request();
		$this->assertEquals($expected, $result);
	}

	public function testNormalize() {
		$this->markTestIncomplete();
	
		$adapter = new MockTumblr();
		$xml = '<?xml version="1.0" encoding="UTF-8"?>
		<tumblr version="1.0">
			<tumblelog name="demo" timezone="US/Eastern" title="Demo">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</tumblelog>
			<posts start="0" total="7">
				<post id="236" url="http://demo.tumblr.com/post/236" url-with-slug="http://demo.tumblr.com/post/236/it-does-not-matter-how-slow-you-go-so-long-as-you" type="quote" date-gmt="2006-11-08 19:27:00 GMT" date="Wed, 08 Nov 2006 14:27:00" unix-timestamp="1163014020" format="html" reblog-key="iKvmNy9T" slug="it-does-not-matter-how-slow-you-go-so-long-as-you">
					<quote-text>It does not matter how slow you go so long as you do not stop.</quote-text>
					<quote-source>Wisdom of &lt;a href="http://en.wikipedia.org/wiki/Confucius"&gt;Confucius&lt;/a&gt;</quote-source>
					<tag>wisdom</tag>
				</post>
				<post id="459265350" url="http://demo.tumblr.com/post/459265350" url-with-slug="http://demo.tumblr.com/post/459265350/passing-through-times-square-by-mareen-fischinger" type="photo" date-gmt="2006-11-08 19:26:00 GMT" date="Wed, 08 Nov 2006 14:26:00" unix-timestamp="1163013960" format="html" reblog-key="gOMUPmdx" slug="passing-through-times-square-by-mareen-fischinger" width="1280" height="853">
					<photo-caption>&lt;p&gt;Passing through Times Square by &lt;a href="http://www.mareenfischinger.com/"&gt;Mareen Fischinger&lt;/a&gt;&lt;/p&gt;</photo-caption>
					<photo-url max-width="1280">http://demo.tumblr.com/photo/1280/459265350/1/tumblr_kzjlfiTnfe1qz4rgh</photo-url>
					<photo-url max-width="500">http://26.media.tumblr.com/tumblr_kzjlfiTnfe1qz4rgho1_500.jpg</photo-url>
					<photo-url max-width="400">http://29.media.tumblr.com/tumblr_kzjlfiTnfe1qz4rgho1_400.jpg</photo-url>
					<photo-url max-width="250">http://25.media.tumblr.com/tumblr_kzjlfiTnfe1qz4rgho1_250.jpg</photo-url>
					<photo-url max-width="100">http://24.media.tumblr.com/tumblr_kzjlfiTnfe1qz4rgho1_100.jpg</photo-url>
					<photo-url max-width="75">http://27.media.tumblr.com/tumblr_kzjlfiTnfe1qz4rgho1_75sq.jpg</photo-url>
					<tag>Mareen Fischinger</tag>
					<tag>New York City</tag>
					<tag>Times Square</tag>
				</post>
				<post id="234" url="http://demo.tumblr.com/post/234" url-with-slug="http://demo.tumblr.com/post/234/my-favorite-web-site" type="link" date-gmt="2006-11-08 19:25:00 GMT" date="Wed, 08 Nov 2006 14:25:00" unix-timestamp="1163013900" format="html" reblog-key="as2i9gTb" slug="my-favorite-web-site">
					<link-text>My favorite web site</link-text>
					<link-url>http://</link-url>
					<link-description>&lt;p&gt;Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.&lt;/p&gt;</link-description>
				</post>
				<post id="233" url="http://demo.tumblr.com/post/233" url-with-slug="http://demo.tumblr.com/post/233/jack-hey-you-know-what-sucks-lindsey" type="conversation" date-gmt="2006-11-08 19:24:00 GMT" date="Wed, 08 Nov 2006 14:24:00" unix-timestamp="1163013840" format="html" reblog-key="5eI0YaaG" slug="jack-hey-you-know-what-sucks-lindsey">
					<conversation-text>Jack: Hey, you know what sucks?&#13;
Lindsey: vaccuums&#13;
Jack: Hey, you know what sucks in a metaphorical sense?&#13;
Lindsey: black holes&#13;
Jack: Hey, you know what just isn\'t cool?&#13;
Lindsey: lava?</conversation-text>
					<conversation>
						<line name="Jack" label="Jack:">Hey, you know what sucks?&#13;</line>
						<line name="Lindsey" label="Lindsey:">vaccuums&#13;</line>
						<line name="Jack" label="Jack:">Hey, you know what sucks in a metaphorical sense?&#13;</line>
						<line name="Lindsey" label="Lindsey:">black holes&#13;</line>
						<line name="Jack" label="Jack:">Hey, you know what just isn\'t cool?&#13;</line>
						<line name="Lindsey" label="Lindsey:">lava?</line>
					</conversation>
					<tag>funny</tag>
				</post>
				<post id="459260683" url="http://demo.tumblr.com/post/459260683" url-with-slug="http://demo.tumblr.com/post/459260683/allison-weiss-fingers-crossed" type="audio" date-gmt="2006-11-07 19:23:00 GMT" date="Tue, 07 Nov 2006 14:23:00" unix-timestamp="1162927380" format="html" reblog-key="wEe8GcU4" slug="allison-weiss-fingers-crossed" audio-plays="496539">
					<audio-caption>&lt;p&gt;&lt;strong&gt;&lt;a href="http://allisonweiss.tumblr.com/"&gt;Allison Weiss&lt;/a&gt; —&lt;/strong&gt; Fingers Crossed&lt;/p&gt;</audio-caption>
					<audio-player>&lt;embed type="application/x-shockwave-flash" src="http://demo.tumblr.com/swf/audio_player.swf?audio_file=http://www.tumblr.com/audio_file/459260683/tumblr_ksc4i2SkVU1qz8ouq&amp;color=FFFFFF" height="27" width="207" quality="best"&gt;&lt;/embed&gt;</audio-player>
					<id3-artist>Allison Weiss</id3-artist>
					<id3-album>...Was Right All Along</id3-album>
					<id3-year>2009</id3-year>
					<id3-track>2 of 10</id3-track>
					<id3-title>Fingers Crossed</id3-title>
				</post>
				<post id="232" url="http://demo.tumblr.com/post/232" url-with-slug="http://demo.tumblr.com/post/232/an-example-post" type="regular" date-gmt="2006-11-07 19:22:00 GMT" date="Tue, 07 Nov 2006 14:22:00" unix-timestamp="1162927320" format="html" reblog-key="jaHD5AfB" slug="an-example-post">
					<regular-title>An example post</regular-title>
					<regular-body>&lt;p&gt;An example body.&lt;/p&gt;</regular-body>
				</post>
			</posts>
		</tumblr>';
		
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