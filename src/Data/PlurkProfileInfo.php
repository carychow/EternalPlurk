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

class PlurkProfileInfo
{
	/**
	 * User's privacy settings. (Whole world can view the profile)
	 *
	 * @var	string
	 */
	const PRIVACY_WORLD = 'world';

	/**
	 * User's privacy settings. (Only friends can view the profile)
	 *
	 * @var	string
	 */
	const PRIVACY_ONLY_FRIENDS = 'only_friends';

	/**
	 * User's privacy settings. (Only the user can view own plurks)
	 *
	 * @var	string
	 */
	const PRIVACY_ONLY_ME = 'only_me';
	
	const KEY_ARE_FRIENDS = 'are_friends';
	const KEY_FANS_COUNT = 'fans_count';
	const KEY_FRIENDS_COUNT = 'friends_count';
	const KEY_HAS_READ_PERMISSION = 'has_read_permission';
	const KEY_IS_FAN = 'is_fan';
	const KEY_IS_FOLLOWING = 'is_following';
	const KEY_PLURKS = 'plurks';
	const KEY_PRIVACY = 'privacy';
	const KEY_USER_INFO = 'user_info';

	public $areFriends;
	public $fansCount;
	public $friendsCount;
	public $hasReadPermission;
	public $isFan;
	public $isFollowing;
	public $plurks;
	public $privacy;
	public $userInfo;
}
?>