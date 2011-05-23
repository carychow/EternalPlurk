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
 * The base class of all Plurk exceptions.
 */
class PlurkException extends Exception
{
	// ------------------------------------------------------------------------------------------------------ //

	/**
	 * Creates a new PlurkException object.
	 * 
	 * @param	string	$msg	Error message.
	 */
	public function __construct($msg = '')
	{
		parent::__construct($msg);
	}

	// ------------------------------------------------------------------------------------------------------ //
}
?>