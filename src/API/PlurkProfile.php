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
 * @version		1.0.1
 * @since		1.0
 */

require_once(dirname(__FILE__) . '/../Setting/PlurkProfileSetting.php');
require_once('PlurkBase.php');

/**
 * Profile resources of Plurk API.
 *
 * @link	http://www.plurk.com/API#profile
 */
class PlurkProfile extends PlurkBase
{
	// ------------------------------------------------------------------------------------------------------ //
	
	public function __construct(PlurkProfileSetting $setting)
	{
		parent::__construct($setting);
	}
	
	public function execute()
	{
		switch($this->_setting->type)
		{
			case PlurkProfileSetting::TYPE_GET_OWN_PROFILE:		return $this->getOwnProfile();
			case PlurkProfileSetting::TYPE_GET_PUBLIC_PROFILE:	return $this->getPublicProfile();
			default:											return false;
		}
	}
	
	// ------------------------------------------------------------------------------------------------------ //

	/**
	 * Returns data that's private for the currently logged in user. This can be used to construct a profile
	 * and render a timeline of the latest plurks.
	 * P.S. requires login
	 *
	 * @return	mixed	Returns a PlurkProfileInfo object on success or FALSE on failure.
	 */
	private function getOwnProfile()
	{
		$url = sprintf('%sProfile/getOwnProfile', self::HTTP_URL);

		$this->setResultType(PlurkResponseParser::RESULT_PROFILE);
		return $this->sendRequest($url);
	}

	/**
	 * Fetches public information such as a user's public plurks and basic information. Fetches also if the
	 * current logged in user is following the user, are friends with or is a fan.
	 *
	 * @return	mixed	Returns a PlurkProfileInfo object on success or FALSE on failure.
	 */
	private function getPublicProfile()
	{
		$url = sprintf('%sProfile/getPublicProfile', self::HTTP_URL);
		$args = array('user_id'=>$this->_setting->userId);

		$this->setResultType(PlurkResponseParser::RESULT_PROFILE);
		return $this->sendRequest($url, $args);
	}

	// ------------------------------------------------------------------------------------------------------ //
}
?>