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

require_once(dirname(__FILE__) . '/../Setting/PlurkFriendsFansSetting.php');
require_once('PlurkBase.php');

/**
 * Friends and Fans resources of Plurk API.
 *
 * @link	http://www.plurk.com/API#following
 */
class PlurkFriendsFans extends PlurkBase
{
	// ------------------------------------------------------------------------------------------ //
	
	public function __construct(PlurkFriendsFansSetting $setting)
	{
		parent::__construct($setting);
	}
	
	public function execute()
	{
		switch($this->_setting->type)
		{
			case PlurkFriendsFansSetting::TYPE_GET_FRIENDS_BY_OFFSET:	return $this->getFriendsByOffset();
			case PlurkFriendsFansSetting::TYPE_GET_FANS_BY_OFFSET:		return $this->getFansByOffset();
			case PlurkFriendsFansSetting::TYPE_GET_FOLLOWING_BY_OFFSET:	return $this->getFollowingByOffset();
			case PlurkFriendsFansSetting::TYPE_BECOME_FRIEND:			return $this->becomeFriend();
			case PlurkFriendsFansSetting::TYPE_REMOVE_AS_FRIEND:		return $this->removeAsFriend();
			case PlurkFriendsFansSetting::TYPE_BECOME_FAN:				return $this->becomeFan();
			case PlurkFriendsFansSetting::TYPE_SET_FOLLOWING:			return $this->setFollowing();
			case PlurkFriendsFansSetting::TYPE_GET_COMPLETION:			return $this->getCompletion();
			default:													return false;
		}		
	}
	
	// ------------------------------------------------------------------------------------------ //

	/**
	 * Returns user's friend list in chucks of 10 friends at a time.
	 *
	 * @return	mixed	Returns an array of PlurkUserInfo object on success or FALSE on failure.
	 */
	private function getFriendsByOffset()
	{
		$url = sprintf('%sFriendsFans/getFriendsByOffset', self::HTTP_URL);
		$args = array(
			'user_id'	=> $this->_setting->userId,
			'offset'	=> (int)$this->_setting->offset,
			'limit'		=> (int)$this->_setting->limit
		);

		$this->setResultType(PlurkResponseParser::RESULT_USERS);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Returns user's fans list in chucks of 10 fans at a time.
	 *
	 * @return	mixed	Returns an array of PlurkUserInfo object on success or FALSE on failure.
	 */
	private function getFansByOffset()
	{
		$url = sprintf('%sFriendsFans/getFansByOffset', self::HTTP_URL);
		$args = array(
			'user_id'	=> $this->_setting->userId,
			'offset'	=> (int)$this->_setting->offset,
			'limit'		=> (int)$this->_setting->limit
		);

		$this->setResultType(PlurkResponseParser::RESULT_USERS);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Returns users that the current logged in user follows as fan - in chucks of 10 fans at a time.
	 * P.S. requires login
	 *
	 * @return	mixed	Returns an array of PlurkUserInfo object on success or FALSE on failure.
	 */
	private function getFollowingByOffset()
	{
		$url = sprintf('%sFriendsFans/getFollowingByOffset', self::HTTP_URL);
		$args = array(
			'offset'	=> (int)$this->_setting->offset,
			'limit'		=> (int)$this->_setting->limit
		);

		$this->setResultType(PlurkResponseParser::RESULT_USERS);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Create a friend request to friend_id. User with friend_id has to accept a friendship.
	 * P.S. requires login
	 *
	 * @return	bool	Returns TRUE on success or FALSE on failure.
	 */
	private function becomeFriend()
	{
		$url = sprintf('%sFriendsFans/becomeFriend', self::HTTP_URL);
		$args = array('friend_id' => $this->_setting->friendId);

		$this->setResultType(PlurkResponseParser::RESULT_SUCCESS_TEXT);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Create a friend request to friend_id. User with friend_id has to accept a friendship.
	 * P.S. requires login
	 *
	 * @return	bool	Returns TRUE on success or FALSE on failure.
	 */
	private function removeAsFriend()
	{
		$url = sprintf('%sFriendsFans/removeAsFriend', self::HTTP_URL);
		$args = array('friend_id' => $this->_setting->friendId);

		$this->setResultType(PlurkResponseParser::RESULT_SUCCESS_TEXT);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Become fan. To stop being a fan of someone, use setFollowing().
	 * P.S. requires login
	 *
	 * @return	bool	Returns TRUE on success or FALSE on failure.
	 */
	private function becomeFan()
	{
		$url = sprintf('%sFriendsFans/becomeFan', self::HTTP_URL);
		$args = array('fan_id' => $this->_setting->fanId);

		$this->setResultType(PlurkResponseParser::RESULT_SUCCESS_TEXT);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Update following. A user can befriend someone, but can unfollow them. This request is also used to stop
	 * following someone as a fan.
	 * P.S. requires login
	 *
	 * @return	bool	Returns TRUE on success or FALSE on failure.
	 */
	private function setFollowing()
	{
		$url = sprintf('%sFriendsFans/setFollowing', self::HTTP_URL);
		$args = array(	'user_id'	=>	$this->_setting->userId,
						'follow'	=>	($this->_setting->follow) ? 'true' : 'false');

		$this->setResultType(PlurkResponseParser::RESULT_SUCCESS_TEXT);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Returns a JSON object of the logged in users friends (nick name and full name). This information can be
	 * used to construct auto-completion for private plurking. Notice that a friend list can be big, depending
	 * on how many friends a user has, so this list should be lazy-loaded in your application.
	 *
	 * @return	mixed	Returns an array of PlurkUserInfo object on success or FALSE on failure.
	 */
	private function getCompletion()
	{
		$url = sprintf('%sFriendsFans/getCompletion', self::HTTP_URL);

		$this->setResultType(PlurkResponseParser::RESULT_USERS);
		return $this->sendRequest($url);
	}

	// ------------------------------------------------------------------------------------------ //
}
?>