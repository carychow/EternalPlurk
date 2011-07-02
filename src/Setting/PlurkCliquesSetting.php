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

class PlurkCliquesSetting extends PlurkOAuthSetting
{
	const TYPE_GET_CLIQUES = 1;
	const TYPE_GET_CLIQUE = 2;
	const TYPE_CREATE_CLIQUE = 3;
	const TYPE_RENAME_CLIQUE = 4;
	const TYPE_ADD = 5;
	const TYPE_REMOVE = 6;
	
	public $cliqueName;
	public $newName;
	public $userId;
}
?>