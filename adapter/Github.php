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
 * Github Adapter for Ambassador
 *
 * Fetches a user's public repositories on GitHub.
 */
class Github extends \ambassador\core\Adapter {

	/**
	 * Default configuration for this adapter.
	 *
	 * @var array
	 */
	public $_autoConfig = array(
		'name' => null
	);

	/**
	 * Makes a request to this adapter's source to fetch new data.
	 *
	 * @param void
	 * @return mixed
	 */
	public function request() {
		return $this->_request("http://github.com/api/v2/json/repos/show/{$this->config['name']}");
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
		
		foreach ($json->repositories as $repo) {
			$items[] = array(
				'id' => $repo->url,
				'date' => strtotime($repo->created_at),
				'url' => $repo->url,
				'title' => $repo->name,
				'body' => $repo->description,
				'pushed' => strtotime($repo->pushed_at),
				'website' => $repo->homepage,
				'watchers' => $repo->watchers,
				'forks' => $repo->forks,
				'issues' => $repo->open_issues
			);
		}
		return $items;
	}

}

?>