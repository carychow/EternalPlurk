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
 * @version		1.0.2
 * @since		1.0
 */

class PlurkPlurkSearchInfo
{
	const KEY_HAS_MORE = 'has_more';
	const KEY_ERROR = 'error';
	const KEY_LAST_OFFSET = 'last_offset';
	const KEY_USERS = 'users';
	const KEY_PLURKS = 'plurks';
	
	public $hasMore;
	public $error;
	public $lastOffset;
	public $users;
	public $plurks;
}
?>