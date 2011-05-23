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

require_once('Plurk/Setting/PlurkUsersSetting.php');
require_once('PlurkBase.php');

/**
 * Users resources of Plurk API.
 *
 * @link	http://www.plurk.com/API#users
 */
class PlurkUsers extends PlurkBase
{
	// ------------------------------------------------------------------------------------------------------ //
	
	public function __construct(PlurkUsersSetting $setting)
	{
		parent::__construct($setting);
	}
	
	public function execute()
	{
		switch($this->_setting->type)
		{
			case PlurkUsersSetting::TYPE_REGISTER:			return $this->register();
			case PlurkUsersSetting::TYPE_LOGIN:				return $this->login();
			case PlurkUsersSetting::TYPE_LOGOUT:			return $this->logout();
			case PlurkUsersSetting::TYPE_UPDATE:			return $this->update();
			case PlurkUsersSetting::TYPE_UPDATE_PIC:		return $this->updatePicture();
			case PlurkUsersSetting::TYPE_GET_KARMA_STATS:	return $this->getKarmaStats();
			default:										return false;
		}		
	}
	
	// ------------------------------------------------------------------------------------------------------ //

	/**
	 * Register a new Plurk account.
	 * 
	 * @return	mixed	Returns a PlurkProfileInfo object or TRUE on success, or FALSE on failure.
	 */
	private function register()
	{
		$dob = $this->_setting->dob;
		$birth = ($dob instanceof DateTime) ? $dob : new DateTime((string)$dob);

		$url = sprintf('%sUsers/register', self::HTTPS_URL);
		$args = array(
			'nick_name'		=>	(string)$this->_setting->nickName,
			'full_name'		=>	(string)$this->_setting->fullName,
			'password'		=>	(string)$this->_setting->password,
			'gender'		=>	(string)$this->_setting->gender,
			'date_of_birth'	=>	$birth->format('Y-m-d')
		);

		if(!empty($this->_setting->email))
		{
			$args['email'] = $this->_setting->email;
		}

		$this->setResultType(PlurkResponseParser::RESULT_USER);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Login an already created user. Login creates a session cookie, which can be used to access the other
	 * methods. On success it returns the data returned by /API/Profile/getOwnProfile.
	 *
	 * @return	mixed	Returns a PlurkProfileInfo object or TRUE on success, or FALSE on failure.
	 */
	private function login()
	{
		$url = sprintf('%sUsers/login', self::HTTPS_URL);
		$args = array(
			'username'	=>	(string)$this->_setting->username,
			'password'	=>	(string)$this->_setting->password
		);
		$resultType = PlurkResponseParser::RESULT_PROFILE;

		if($this->_setting->noData)
		{
			$args['no_data'] = 1;
			$resultType = PlurkResponseParser::RESULT_SUCCESS_TEXT;
		}

		$this->setResultType($resultType);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Logout Plurk.
	 */
	private function logout()
	{
		$url = sprintf('%sUsers/logout', self::HTTP_URL);

		$this->setResultType(PlurkResponseParser::RESULT_SUCCESS_TEXT);
		return $this->sendRequest($url);
	}

	/**
	 * Update a user's information (such as email, password or privacy).
	 * P.S. requires login
	 *
	 * @return	PlurkUserInfo	Returns a PlurkUserInfo object on success, or FALSE on failure.
	 */
	private function update()
	{
		$url = sprintf('%sUsers/update', self::HTTPS_URL);
		$args = array('current_password' => (string)$this->_setting->password);

		if(!empty($this->_setting->fullName))
		{
			$args['full_name'] = (string)$this->_setting->fullName;
		}

		if(!empty($this->_setting->newPassword))
		{
			$args['new_password'] = (string)$this->_setting->newPassword;
		}

		if(!empty($this->_setting->email))
		{
			$args['email'] = $this->_setting->email;
		}

		if(!empty($this->_setting->displayName))
		{
			$args['display_name'] = (string)$this->_setting->displayName;
		}

		if(!empty($this->_setting->privacy))
		{
			$args['privacy'] = (string)$this->_setting->privacy;
		}

		if(!empty($this->_setting->dob))
		{
			$dob = $this->_setting->dob;
			$birth = ($dob instanceof DateTime) ? $dob : new DateTime((string)$dob);
			$args['date_of_birth'] = $birth->format('Y-m-d');
		}

		$this->setResultType(PlurkResponseParser::RESULT_USER);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Update a user's profile picture.
	 * P.S. requires login
	 *
	 * @return	PlurkUserInfo	Returns a PlurkUserInfo object on success, or FALSE on failure.
	 */
	private function updatePicture()
	{
		$url = sprintf('%sUsers/updatePicture', self::HTTP_URL);
		$args = array('profile_image' => "@$this->_setting->imgPath");

		$this->setResultType(PlurkResponseParser::RESULT_USER);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Returns info about a user's karma, including current karma, karma growth, karma graph and the latest
	 * reason why the karma has dropped. 
	 */
	private function getKarmaStats()
	{
		$url = sprintf('%sUsers/getKarmaStats', self::HTTP_URL);

		$this->setResultType(PlurkResponseParser::RESULT_KARMA);
		return $this->sendRequest($url);
	}

	// ------------------------------------------------------------------------------------------------------ //
}
?>