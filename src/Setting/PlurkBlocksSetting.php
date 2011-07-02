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
 * @since		1.0
 */

require_once('PlurkOAuthSetting.php');

class PlurkBlocksSetting extends PlurkOAuthSetting
{
	const TYPE_GET = 1;
	const TYPE_BLOCK = 2;
	const TYPE_UNBLOCK = 3;
	
	public $offset;
	public $userId;
	
	public function __construct()
	{
		$this->offset = 0;
	}
}
?>