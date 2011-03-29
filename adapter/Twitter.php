<?php
/**
 * Ambassador: fetching data the easy way
 *
 * @license   MIT License
 * @author    Michael Hüneburg
 * @copyright Copyright 2011, Think + Craft (http://thinkandcraft.com)
 */

namespace ambassador\adapter;

use ambassador\core\Adapter;
use ambassador\core\AdapterInterface;

/**
 * Twitter Adapter for Ambassador
 *
 * Fetches data from a user's public timeline on Twitter. 
 */
class Twitter extends Adapter implements AdapterInterface {

	/**
	 * Default configuration for this adapter.
	 *
	 * @var array
	 */
	public $_autoConfig = array(
		'name' => null,
		'retweets' => false
	);

	/**
	 * Makes a request to this adapter's source to fetch new data.
	 *
	 * @param void
	 * @return mixed
	 */
	public function request() {
		$data = array(
			'screen_name' => $this->config['name'],
			'include_rts' => $this->config['retweets'],
			'count'       => $this->config['limit'],
			'page'        => $this->config['page']
		);
		return $this->_request("http://api.twitter.com/1/statuses/user_timeline.json", $data);
	}

	/**
	 * Normalizes the response of this adapter.
	 *
	 * @param string $input
	 * @return array
	 */
	public function normalize($input) {
		$json = json_decode($input);
		$items = array();
		
		foreach ($json as $tweet) {
			$items[] = array(
				'id' => (integer) $tweet->id,
				'date' => strtotime($tweet->created_at),
				'url' => "http://twitter.com/{$tweet->user->screen_name}/status/{$tweet->id}",
				'body' => $tweet->text,
				'source' => $tweet->source,
				'truncated' => (boolean) $tweet->truncated
			);
		}
		return $items;
	}

}

?>