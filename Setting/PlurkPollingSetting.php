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

require_once('PlurkSetting.php');

class PlurkPollingSetting extends PlurkSetting
{
	const TYPE_GET_PLURKS = 1;
	const TYPE_GET_UNREAD_COUNT = 2;
	
	public $offset;
	public $limit;
	
	public function __construct()
	{
		$this->offset = 'now';
		$this->limit = 50;
	}
}
?>