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

class PlurkUserInfo
{
	// ------------------------------------------------------------------------------------------------------ //

	/**
	 * User's gender. (Male)
	 *
	 * @var	string
	 */
	const GENDER_MALE = 'male';

	/**
	 * User's gender. (Female)
	 *
	 * @var	string
	 */
	const GENDER_FEMALE = 'female';

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

	const KEY_AVATAR = 'avatar';
	const KEY_DATE_OF_BIRTH = 'date_of_birth';
	const KEY_DISPLAY_NAME = 'display_name';
	const KEY_EMAIL_CONFIRMED = 'email_confirmed';
	const KEY_FULL_NAME = 'full_name';
	const KEY_GENDER = 'gender';
	const KEY_HAS_PROFILE_IMAGE = 'has_profile_image';
	const KEY_ID = 'id';
	const KEY_IS_PREMIUM = 'is_premium';
	const KEY_KARMA = 'karma';
	const KEY_LOCATION = 'location';
	const KEY_NICK_NAME = 'nick_name';
	const KEY_RECRUITED = 'recruited';
	const KEY_RELATIONSHIP = 'relationship';
	const KEY_TIMEZONE = 'timezone';
	const KEY_UID = 'uid';

	public $avatar;
	public $dateOfBirth;
	public $displayName;
	public $emailConfirmed;
	public $fullName;
	public $gender;//1 is male, 0 is female.
	public $hasProfileImage;
	public $id;
	public $isPremium;
	public $karma;
	public $location;
	public $nickName;
	public $recruited;
	public $relationship;
	public $timezone;
	public $uid;
}
?>