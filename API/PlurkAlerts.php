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

require_once('Plurk/Setting/PlurkAlertsSetting.php');
require_once('PlurkBase.php');

/**
 * Alerts resources of Plurk API.
 *
 * @link	http://www.plurk.com/API#alerts
 */
class PlurkAlerts extends PlurkBase
{
	// ------------------------------------------------------------------------------------------------------ //
	
	public function __construct(PlurkAlertsSetting $setting)
	{
		parent::__construct($setting);
	}
	
	public function execute()
	{
		switch($this->_setting->type)
		{
			case PlurkAlertsSetting::TYPE_GET_ACTIVE:			return $this->getActive();
			case PlurkAlertsSetting::TYPE_GET_HISTORY:			return $this->getHistory();
			case PlurkAlertsSetting::TYPE_ADD_ALL_AS_FAN:		return $this->addAsFan();
			case PlurkAlertsSetting::TYPE_ADD_AS_FAN:			return $this->addAllAsFan();
			case PlurkAlertsSetting::TYPE_ADD_ALL_AS_FRIENDS:	return $this->addAllAsFriends();
			case PlurkAlertsSetting::TYPE_ADD_AS_FRIEND:		return $this->addAsFriend();
			case PlurkAlertsSetting::TYPE_DENY_FRIENDSHIP:		return $this->denyFriendship();
			case PlurkAlertsSetting::TYPE_REMOVE_NOTIFICATION:	return $this->removeNotification();
			default:											return false;
		}
	}
	
	// ------------------------------------------------------------------------------------------------------ //

	/**
	 * Return a list of current active alerts.
	 * P.S. requires login
	 *
	 * @return	mixed	Returns an array of PlurkAlertInfo object on success or FALSE on failure.
	 */
	private function getActive()
	{
		$url = sprintf('%sAlerts/getActive', self::HTTP_URL);

		$this->setResultType(PlurkResponseParser::RESULT_ALERTS);
		return $this->sendRequest($url);
	}

	/**
	 * Return a list of past 30 alerts.
	 * P.S. requires login
	 *
	 * @return	mixed	Returns an array of PlurkAlertInfo object on success or FALSE on failure.
	 */
	private function getHistory()
	{
		$url = sprintf('%sAlerts/getHistory', self::HTTP_URL);

		$this->setResultType(PlurkResponseParser::RESULT_ALERTS);
		return $this->sendRequest($url);
	}

	/**
	 * Accept a user as fan.
	 * P.S. requires login
	 *
	 * @return	bool	Returns TRUE on success or FALSE on failure.
	 */
	private function addAsFan()
	{
		$url = sprintf('%sAlerts/addAsFan', self::HTTP_URL);
		$args = array('user_id' => $this->_setting->userId);

		$this->setResultType(PlurkResponseParser::RESULT_SUCCESS_TEXT);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Accept all friendship requests as fans.
	 * P.S. requires login
	 *
	 * @return	bool	Returns TRUE on success or FALSE on failure.
	 */
	private function addAllAsFan()
	{
		$url = sprintf('%sAlerts/addAllAsFan', self::HTTP_URL);

		$this->setResultType(PlurkResponseParser::RESULT_SUCCESS_TEXT);
		return $this->sendRequest($url);
	}

	/**
	 * Accept all friendship requests as friends.
	 * P.S. requires login
	 *
	 * @return	bool	Returns TRUE on success or FALSE on failure.
	 */
	private function addAllAsFriends()
	{
		$url = sprintf('%sAlerts/addAllAsFriends', self::HTTP_URL);

		$this->setResultType(PlurkResponseParser::RESULT_SUCCESS_TEXT);
		return $this->sendRequest($url);
	}

	/**
	 * Accept a user as friend.
	 * P.S. requires login
	 *
	 * @return	bool	Returns TRUE on success or FALSE on failure.
	 */
	private function addAsFriend()
	{
		$url = sprintf('%sAlerts/addAsFriend', self::HTTP_URL);
		$args = array('user_id' => $this->_setting->userId);

		$this->setResultType(PlurkResponseParser::RESULT_SUCCESS_TEXT);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Deny friendship to user.
	 * P.S. requires login
	 *
	 * @return	bool	Returns TRUE on success or FALSE on failure.
	 */
	private function denyFriendship()
	{
		$url = sprintf('%sAlerts/denyFriendship', self::HTTP_URL);
		$args = array('user_id' => $this->_setting->userId);

		$this->setResultType(PlurkResponseParser::RESULT_SUCCESS_TEXT);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Remove notification to user with id.
	 * P.S. requires login
	 *
	 * @return	bool	Returns TRUE on success or FALSE on failure.
	 */
	private function removeNotification()
	{
		$url = sprintf('%sAlerts/removeNotification', self::HTTP_URL);
		$args = array('user_id' => $this->_setting->userId);

		$this->setResultType(PlurkResponseParser::RESULT_SUCCESS_TEXT);
		return $this->sendRequest($url, $args);
	}

	// ------------------------------------------------------------------------------------------------------ //
}
?>