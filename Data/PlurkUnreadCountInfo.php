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

class PlurkUnreadCountInfo
{
	const KEY_ALL = 'all';
	const KEY_MY = 'my';
	const KEY_RESPONDED = 'responded';
	const KEY_PRIVATE = 'private';
	
	public $all;
	public $my;
	public $responded;
	public $private;
}
?>