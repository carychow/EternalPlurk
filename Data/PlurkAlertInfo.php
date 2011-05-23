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

class PlurkAlertInfo
{
	/**
	 * Value of friendship request in API response.
	 *
	 * @var	string
	 */
	const TYPE_FRIENDSHIP_REQUEST = 'friendship_request';

	/**
	 * Value of friendship pending in API response.
	 *
	 * @var	string
	 */
	const TYPE_REIENDSHIP_PENDING = 'friendship_pending';

	/**
	 * Value of new fan notification (does not require actions from the user) in API response.
	 *
	 * @var	string
	 */
	const TYPE_NEW_FAN = 'new_fan';

	/**
	 * Value of friendship accepted notification (does not require actions from the user) in API response.
	 *
	 * @var	string
	 */
	const TYPE_FRIENDSHIP_ACCEPTED = 'friendship_accepted';

	/**
	 * Value of new friend notification (does not require actions from the user) in API response.
	 *
	 * @var	string
	 */
	const TYPE_NEW_FRIEND = 'new_friend';

	const KEY_TYPE = 'type';
	const KEY_POSTED = 'posted';
	const KEY_FROM_USER = 'from_user';
	const KEY_TO_USER = 'to_user';
	const KEY_NEW_FAN = 'new_fan';
	const KEY_FRIEND_INFO = 'friend_info';
	const KEY_NEW_FRIEND = 'new_friend';

	public $_type;
	public $_posted;
	public $_user;
}
?>