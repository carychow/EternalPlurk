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
 * @since		1.0.1
 */

require_once('PlurkOAuthSetting.php');

class PlurkTopSetting extends PlurkOAuthSetting
{
	const SORTING_HOT = 0;
	const SORTING_NEW = 1;
	
	const TYPE_GET_COLLECTIONS = 1;
	const TYPE_GET_DEFAULT_COLLECTION = 2;
	const TYPE_GET_PLURKS = 3;
	
	public $collectionName;
	public $offset;
	public $sorting;
}
?>