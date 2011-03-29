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

class TwitterTest extends \PHPUnit_Framework_TestCase {

	public function testRequest() {
		$adapter = new MockTwitter(array(
			'name' => 'foo', 'retweets' => false, 'limit' => 10, 'page' => 1
		));
		
		$expected = array(
			'url' => 'http://api.twitter.com/1/statuses/user_timeline.json',
			'data' => array('screen_name' => 'foo', 'include_rts' => false, 'count' => 10, 'page' => 1),
			'options' => array()
		);
		$result = $adapter->request();
		$this->assertEquals($expected, $result);
	}

	public function testNormalize() {
		$adapter = new MockTwitter();
		$json = '[
			{
				"coordinates":null,
				"favorited":false,
				"created_at":"Wed Jul 14 05:56:17 +0000 2010",
				"truncated":false,
				"entities":{"urls":[],"hashtags": [],"user_mentions": []},
				"text":"Another great workout tonight, this time a 45 min run, speed 5.5, incline randomising between 0 and 8. Now to relax with some Knight Rider",
				"contributors":null,
				"annotations":null,
				"id":18498353208,
				"geo":null,
				"in_reply_to_user_id":null,
				"place":{
					"name":"San Francisco",
					"country_code":"US",
					"country":"The United States of America",
					"attributes":{},
					"url":"http://api.twitter.com/1/geo/id/5a110d312052166f.json",
					"id":"5a110d312052166f",
					"bounding_box":{
						"coordinates":[[[-122.51368188,37.70813196],[-122.35845384,37.70813196],[-122.35845384,37.83245301],[-122.51368188,37.83245301]]],
						"type":"Polygon"
					},
					"full_name":"San Francisco, CA",
					"place_type": "city"
				},
				"in_reply_to_screen_name":null,
				"user": {
					"name":"Matt Harris",
					"profile_sidebar_border_color":"C0DEED",
					"profile_background_tile":false,
					"profile_sidebar_fill_color":"DDEEF6",
					"created_at":"Sat Feb 17 20:49:54 +0000 2007",
					"profile_image_url":"http://a1.twimg.com/profile_images/554181350/matt_normal.jpg",
					"location":"San Francisco",
					"profile_link_color":"0084B4",
					"follow_request_sent":false,
					"url":"http://themattharris.com",
					"favourites_count":101,
					"contributors_enabled":false,
					"utc_offset":-28800,
					"id":777925,
					"profile_use_background_image":true,
					"profile_text_color":"333333",
					"protected":false,
					"followers_count":1173,
					"lang":"en",
					"notifications":false,
					"time_zone":"Tijuana",
					"verified":false,
					"profile_background_color":"C0DEED",
					"geo_enabled":true,
					"description":"Developer Advocate at Twitter. Also a hacker and British expat who is married to @cindyli and lives in San Francisco.",
					"friends_count":302,
					"statuses_count":2963,
					"profile_background_image_url":"http://s.twimg.com/a/1278960292/images/themes/theme1/bg.png",
					"following":false,
					"screen_name":"themattharris"
				},
				"source":"web",
				"in_reply_to_status_id":null
			}
		]';

		$expected = array(
			array(
				'id' => 18498353208,
				'date' => 1279086977,
				'url' => 'http://twitter.com/themattharris/status/18498353208',
				'body' => 'Another great workout tonight, this time a 45 min run, speed 5.5, incline randomising between 0 and 8. Now to relax with some Knight Rider',
				'source' => 'web',
				'truncated' => false
			)
		);
		$result = $adapter->normalize($json);
		$this->assertEquals($expected, $result);
	}
	
}

?>