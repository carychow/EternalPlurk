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

require_once('PlurkSetting.php');

class PlurkAlertsSetting extends PlurkSetting
{
	const TYPE_GET_ACTIVE = 1;
	const TYPE_GET_HISTORY = 2;
	const TYPE_ADD_AS_FAN = 3;
	const TYPE_ADD_ALL_AS_FAN = 4;
	const TYPE_ADD_ALL_AS_FRIENDS = 5;
	const TYPE_ADD_AS_FRIEND = 6;
	const TYPE_DENY_FRIENDSHIP = 7;
	const TYPE_REMOVE_NOTIFICATION = 8;
	
	public $userId;
}
?>