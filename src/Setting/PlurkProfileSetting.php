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

class PlurkProfileSetting extends PlurkSetting
{
	const TYPE_GET_OWN_PROFILE = 1;
	const TYPE_GET_PUBLIC_PROFILE = 2;
	
	public $userId;
}
?>