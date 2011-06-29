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

require_once(dirname(__FILE__) . '/../Setting/PlurkPollingSetting.php');
require_once('PlurkBase.php');

/**
 * Polling resources of Plurk API.
 *
 * @link	http://www.plurk.com/API#polling
 */
class PlurkPolling extends PlurkBase
{
	// ------------------------------------------------------------------------------------------------------ //
	
	public function __construct(PlurkPollingSetting $setting)
	{
		parent::__construct($setting);
	}
	
	public function execute()
	{
		switch($this->_setting->type)
		{
			case PlurkPollingSetting::TYPE_GET_PLURKS:			return $this->getPlurks();
			case PlurkPollingSetting::TYPE_GET_UNREAD_COUNT:	return $this->getUnreadCount();
			default:											return false;
		}		
	}

	// ------------------------------------------------------------------------------------------------------ //
	
	/**
	 * You should use this call to find out if there any new plurks posted to the user's timeline. It's much 
	 * more efficient than doing it with /API/Timeline/getPlurks, so please use it :)
	 * P.S. requires login
	 * 
	 * @param	mixed	$offset	Return plurks newer than $offset.  It can be a DataTime object or a string
	 * 							formatted as 2009-6-20T21:55:34.
	 * @param	int		$limit	How many plurks should be returned? Default is 50.
	 * @return	mixed			Returns a PlurkPlurksUsersInfo object on success or FALSE on failure.
	 */
	private function getPlurks()
	{
		$url = sprintf('%sPolling/getPlurks', self::HTTP_URL);
		$offset = $this->_setting->offset;
		$time = ($offset instanceof DateTime) ? $offset : new DateTime($offset);
		$args = array(
			'offset'	=>	$time->format('Y-m-d\TH:i:s'),
			'limit'		=>	$this->_setting->limit
		);

		$this->setResultType(PlurkResponseParser::RESULT_PLURKS_USERS);
		return $this->sendRequest($url, $args);
	}
	
	/**
	 * Use this call to find out if there are unread plurks on a user's timeline.
	 * P.S. requires login
	 * 
	 * @return	mixed	Returns a PlurkUnreadCountInfo object on success or FALSE on failure.
	 */
	private function getUnreadCount()
	{
		$url = sprintf('%sPolling/getUnreadCount', self::HTTP_URL);

		$this->setResultType(PlurkResponseParser::RESULT_UNREAD_COUNT);
		return $this->sendRequest($url);
	}
	
	// ------------------------------------------------------------------------------------------------------ //
}
?>