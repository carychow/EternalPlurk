<?php
/**
 * @file
 * The classes of EternalPlurk.\n
 * Copyright (C) 2011 Cary Chow\n
 * License: http://creativecommons.org/licenses/by-sa/3.0/\n
 * Website: http://www.plurk.com/carychow
 *
 * @package		EternalPlurk
 * @author		Cary Chow <carychowhk@gmail.com>
 * @version		1.0
 * @since		1.0
 */

/**
 * A strategy interface of Plurk API request.
 */
interface PlurkStrategy
{
	// ------------------------------------------------------------------------------------------------------ //

	/**
	 * URL of Plurk API via HTTP.
	 *
	 * @var	string
	 */
	const HTTP_URL = 'http://www.plurk.com/API/';

	/**
	 * URL of Plurk API via HTTPS.
	 *
	 * @var	string
	 */
	const HTTPS_URL = 'https://www.plurk.com/API/';

	// ------------------------------------------------------------------------------------------------------ //

	/**
	 * Gets the error message
	 *
	 * @return	string	Error message of last response.
	 */
	public function getErrMsg();

	/**
	 * Execute the strategy.
	 *
	 * @return	mixed	Returns an object on success, or FALSE on failure.
	 */
	public function execute();

	// ------------------------------------------------------------------------------------------------------ //
}
?>