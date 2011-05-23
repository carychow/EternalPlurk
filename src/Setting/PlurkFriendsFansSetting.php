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

class PlurkFriendsFansSetting extends PlurkSetting
{
	const TYPE_GET_FRIENDS_BY_OFFSET = 1;
	const TYPE_GET_FANS_BY_OFFSET = 2;
	const TYPE_GET_FOLLOWING_BY_OFFSET = 3;
	const TYPE_BECOME_FRIEND = 4;
	const TYPE_REMOVE_AS_FRIEND = 5;
	const TYPE_BECOME_FAN = 6;
	const TYPE_SET_FOLLOWING = 7;
	const TYPE_GET_COMPLETION = 8;
	
	public $userId;
	public $offset;
	public $friendId;
	public $fanId;
	public $follow;
	
	public function __construct()
	{
		$this->offset = 0;
	}
}
?>