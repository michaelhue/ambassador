<?php
/**
 * Ambassador: fetching data the easy way
 *
 * @license   MIT License
 * @author    Michael Hüneburg
 * @copyright Copyright 2011, Think + Craft (http://thinkandcraft.com)
 */

namespace ambassador\adapter;

/**
 * Tumblr Adapter for Ambassador
 *
 * Configuration:
 * - name (required): Name of the Tumblr blog.
 * - type (optional): Restricts the response to a post type. Must be one of `text`, 
 *   `quote`, `photo`, `link`, `chat`, `video`, or `audio`.
 * - filter (optional): Filter to run on the text content. Possible values are `none` 
 *   or `text`. Defaults to `none`.
 * - limit (optional)
 * - page (optional)
 */
class Tumblr extends \ambassador\core\Adapter {

	/**
	 * Default configuration for this adapter.
	 *
	 * @var array
	 */
	public $_autoConfig = array(
		'name' => null,
		'type' => '',
		'filter' => 'none'
	);

	/**
	 * Makes a request to this adapter's source to fetch new data.
	 *
	 * @param void
	 * @return mixed
	 */
	public function request() {
		$config = $this->config;
		$data = array(
			'num' => $config['limit'],
			'offset' => ($config['page']-1) * $config['limit'],
			'filter' => $config['filter'],
			'type' => $config['type']
		);
		return $this->_request("http://{$config['name']}.tumblr.com/api/read", $data);
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
		
		foreach ($xml->posts->children() as $post) {
			$item = array(
				'id'     => (integer) $post['id'],
				'url'    => (string) $post['url-with-slug'],
				'date'   => (integer) $post['unix-timestamp'],
				'type'   => (string) $post['type'],
				'format' => (string) $post['format'],
				'tags'   => (array) $post->tag,
			);
			switch ($item['type']) {
				case 'regular':
					$item['title'] = (string) $post->{'regular-title'};
					$item['body'] = (string) $post->{'regular-body'};
				break;
				
				case 'photo':
					$item['body'] = (string) $post->{'photo-caption'};
					$item['link'] = (string) $post->{'photo-link-url'};
					
					foreach ($post->{'photo-url'} as $photo) {
						$item['photo'][(integer) $photo['max-width']] = (string) $photo;
					}
				break;
				
				case 'link':
					$item['title'] = (string) $post->{'link-text'};
					$item['body']  = (string) $post->{'link-description'};
					$item['link']  = (string) $post->{'link-url'};
				break;
				
				case 'quote':
					$item['quote']  = (string) $post->{'quote-text'};
					$item['source'] = (string) $post->{'quote-source'};
				break;
				
				case 'conversation':
				
				break;
				
				case 'audio':
				
				break;
				
				case 'video':
				
				break;
			}
			if (!empty($item['body'])) {
				$item['text'] = strip_tags($item['body']);
			}
			$items[] = $item;
		}
		return $items;
	}

}

?>