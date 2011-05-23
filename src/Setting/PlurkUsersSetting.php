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

class PlurkUsersSetting extends PlurkSetting
{
	const TYPE_REGISTER = 1;
	const TYPE_LOGIN = 2;
	const TYPE_LOGOUT = 3;
	const TYPE_UPDATE = 4;
	const TYPE_UPDATE_PIC = 5;
	const TYPE_GET_KARMA_STATS = 6;
	
	public $nickName;
	public $fullName;
	public $password;
	public $gender;
	public $dob;
	public $email;
	public $username;
	public $newPassword;
	public $displayName;
	public $privacy;
	public $imgPath;
	
	/**
	 * If it's set to TRUE then the common data is not returned.
	 * 
	 * @var	bool
	 */
	public $noData;
	
	public function __construct()
	{
		$this->noData = false;
	}
}
?>