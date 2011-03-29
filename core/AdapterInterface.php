<?php
/**
 * Ambassador: fetching data the easy way
 *
 * @license   MIT License
 * @author    Michael Hüneburg
 * @copyright Copyright 2011, Think + Craft (http://thinkandcraft.com)
 */

namespace ambassador\core;

/**
 * Interface for Adapters
 *
 * This is the Interface each Adapter must implement. Currently defines the two essential 
 * methods `request` and `normalize` which are called by the `Ambassador` class to get and
 * handle the data for each adapter.
 */
interface AdapterInterface {

	/**
	 * Makes a request to the adapter source to retrieve new data.
	 * 
	 * @param void
	 * @return mixed
	 */
	public function request();

	/**
	 * Normalizes the request response data.
	 *
	 * @param mixed $input The raw input which will be normalized.
	 * @return array Returns the input in a normalized multi-dimensional array.
	 */
	public function normalize($input);

}

?>