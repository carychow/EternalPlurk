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
 * @version		2.0
 * @since		2.0
 */

require_once('PlurkSetting.php');

class PlurkOAuthSetting extends PlurkSetting
{
	// ------------------------------------------------------------------------------------------ //
	
	const TYPE_START_AUTH = -1;
	const TYPE_PARSE_CALLBACK = -2;
	
	// ------------------------------------------------------------------------------------------ //
	
	/**
	 * Consumer key.
	 * 
	 * @var	string
	 */
	public $consumerKey;
	
	/**
	 * Consumer secret.
	 * 
	 * @var	string
	 */
	public $consumerSecret;
	
	public $oAuthToken;
	public $oAuthTokenSecret;
	
	// ------------------------------------------------------------------------------------------ //
}
?>