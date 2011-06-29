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

require_once(dirname(__FILE__) . '/../Setting/PlurkSearchSetting.php');
require_once('PlurkBase.php');

/**
 * Search resources of Plurk API.
 *
 * @link	http://www.plurk.com/API#search
 */
class PlurkSearch extends PlurkBase
{
	// ------------------------------------------------------------------------------------------------------ //
	
	public function __construct(PlurkSearchSetting $setting)
	{
		parent::__construct($setting);
	}
	
	public function execute()
	{
		switch($this->_setting->type)
		{
			case PlurkSearchSetting::TYPE_SEARCH_PLURK:	return $this->searchPlurk();
			case PlurkSearchSetting::TYPE_SEARCH_USER:	return $this->searchUser();
			default:	return false;
		}
	}
	
	// ------------------------------------------------------------------------------------------------------ //

	/**
	 * Returns the latest 20 plurks on a search term.
	 *
	 * @return	mixed	Returns a PlurkPlurkSearchInfo object on success or FALSE on failure.
	 */
	public function searchPlurk()
	{
		$url = sprintf('%sPlurkSearch/search', self::HTTP_URL);
		$args = array(
			'query'		=>	$this->_setting->query,
			'offset'	=>	$this->_setting->offset
		);

		$this->setResultType(PlurkResponseParser::RESULT_SEARCH_PLURK);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Returns 10 users that match query, users are sorted by karma.
	 *
	 * @return	mixed	Returns a PlurkUserSearchInfo object on success or FALSE on failure.
	 */
	public function searchUser()
	{
		$url = sprintf('%sUserSearch/search', self::HTTP_URL);
		$args = array(
			'query'		=>	$query,
			'offset'	=>	$offset
		);

		$this->setResultType(PlurkResponseParser::RESULT_SEARCH_USER);
		return $this->sendRequest($url, $args);
	}

	// ------------------------------------------------------------------------------------------------------ //
}
?>