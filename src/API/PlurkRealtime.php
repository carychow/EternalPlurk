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

require_once(dirname(__FILE__) . '/../Setting/PlurkRealtimeSetting.php');
require_once('PlurkBase.php');

/**
 * Real time notifications resources of Plurk API.
 *
 * @link	http://www.plurk.com/API#realtime
 */
class PlurkRealtime extends PlurkBase
{
	// ------------------------------------------------------------------------------------------ //
	
	public function __construct(PlurkRealtimeSetting $setting)
	{
		parent::__construct($setting);
	}
	
	public function execute()
	{
		switch($this->_setting->type)
		{
			case PlurkRealtimeSetting::TYPE_GET_USER_CHANNEL:	return $this->getUserChannel();
			case PlurkRealtimeSetting::TYPE_GET_COMET_CHANNEL:	return $this->getCometChannel();
			default:											return false;
		}		
	}

	// ------------------------------------------------------------------------------------------ //

	/**
	 * Get instant notifications when there are new plurks and responses on a user's timeline. This is much more
	 * efficient and faster than polling so please use it!
	 * P.S. requires login
	 *
	 * @return	mixed	Returns a PlurkChannelUserInfo object on success or FALSE on failure.
	 */
	private function getUserChannel()
	{
		$url = sprintf('%sRealtime/getUserChannel', self::HTTP_URL);

		$this->setResultType(PlurkResponseParser::RESULT_CHANNEL_USER);
		return $this->sendRequest($url);
	}

	/**
	 * You'll get an URL from getUserChannel() and you do GET requests to this URL to get new data. Your request
	 * will sleep for about 50 seconds before returning a response if there is no new data added to your channel.
	 * You won't get notifications on responses that the logged in user adds, but you will get notifications for
	 * new plurks.
	 *
	 * @return	mixed	Returns a PlurkChannelCometInfo object on success or FALSE on failure.
	 */
	private function getCometChannel()
	{
		$args = array(
			'channel'	=> $this->_setting->channel,
			'offset'	=> max((int)$this->_setting->offset, 0),
		);
		$url = sprintf('%s?%s', $this->_setting->serverUrl, http_build_query($args));

		$this->setResultType(PlurkResponseParser::RESULT_CHANNEL_COMET);
		return $this->sendRequest($url, $args, false);	//GET request
	}

	// ------------------------------------------------------------------------------------------ //
}
?>