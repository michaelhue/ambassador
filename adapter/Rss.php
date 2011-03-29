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
 * Rss Adapter for Ambassador
 *
 * Allows any valid RSS feed to be fetched by Ambassador.
 *
 * Configuration:
 * - feed (required): URL of the RSS feed.
 * - limit (optional)
 * - cache (optional)
 */
class Rss extends Adapter implements AdapterInterface {

	/**
	 * Default configuration for this adapter.
	 *
	 * @var array
	 */
	public $_autoConfig = array(
		'feed' => null
	);

	/**
	 * Makes a request to this adapter's source to fetch new data.
	 *
	 * @param void
	 * @return mixed
	 */
	public function request() {
		return $this->_request($this->config['feed']);
	}

	/**
	 * Normalizes the response of this adapter.
	 *
	 * @param string $input
	 * @return array
	 */
	public function normalize($input) {
		$xml = simplexml_load_string($input);
		$items = array();

		foreach ($xml->channel->item as $post) {
			$item = array(
				'id'     => (string) $post->guid,
				'url'    => (string) $post->link,
				'date'   => (integer) strtotime($post->pubDate),
				'title'  => (string) $post->title,
				'body'   => (string) $post->description,
				'author' => (string) $post->author
			);
			$items[] = $item;
		}
		return array_slice($items, 0, $this->config['limit']);
	}

}

?>