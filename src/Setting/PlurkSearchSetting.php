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

class PlurkSearchSetting extends PlurkSetting
{
	const TYPE_SEARCH_PLURK = 1;
	const TYPE_SEARCH_USER = 2;
	
	public $query;
	public $offset;
	
	public function __construct()
	{
		$this->offset = 0;
	}
}
?>