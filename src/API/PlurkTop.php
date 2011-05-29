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
 * @since		1.0.1
 */

require_once('Plurk/Setting/PlurkTopSetting.php');
require_once('PlurkBase.php');

/**
 * Profile resources of Plurk API.
 *
 * @link	http://www.plurk.com/API#plurk_top
 */
class PlurkTop extends PlurkBase
{
	// ------------------------------------------------------------------------------------------------------ //
	
	public function __construct(PlurkTopSetting $setting)
	{
		parent::__construct($setting);
	}
	
	public function execute()
	{
		switch($this->_setting->type)
		{
			case PlurkTopSetting::TYPE_GET_COLLECTIONS:			return $this->getGetCollections();
			case PlurkTopSetting::TYPE_GET_DEFAULT_COLLECTION:	return $this->getDefaultCollection();
			case PlurkTopSetting::TYPE_GET_PLURKS:				return $this->getPlurks();
			default:											return false;
		}
	}
	
	// ------------------------------------------------------------------------------------------------------ //

	/**
	 * Gets a list of PlurkTop collections.
	 *
	 * @return	mixed	Returns a PlurkTopInfo object on success or FALSE on failure.
	 */
	private function getGetCollections()
	{
		$url = sprintf('%sPlurkTop/getCollections', self::HTTP_URL);

		$this->setResultType(PlurkResponseParser::RESULT_COLLECTIONS);
		return $this->sendRequest($url);
	}

	/**
	 * Gets default name of collection for current user.
	 *
	 * @return	mixed	Returns a string on success or FALSE on failure.
	 */
	private function getDefaultCollection()
	{
		$url = sprintf('%sPlurkTop/getDefaultCollection', self::HTTP_URL);

		$this->setResultType(PlurkResponseParser::RESULT_DEF_COLLECTION);
		return $this->sendRequest($url);
	}
	
	/**
	 * Gets plurks in PlurkTop
	 * 
	 * @return	mixed	Returns a PlurkPlurksUsersOffsetInfo object on success or FALSE on failure.
	 */
	private function getPlurks()
	{
		$url = sprintf('%sPlurkTop/getPlurks', self::HTTP_URL);
		$args = array();
		
		if(!is_null($this->_setting->offset))
		{
			$args['offset'] = (float)$this->_setting->offset;
		}
		
		if(!is_null($this->_setting->sorting))
		{
			$args['sorting'] = $this->_setting->sorting;
		}

		$this->setResultType(PlurkResponseParser::RESULT_PLURKS_USERS_OFFSET);
		return $this->sendRequest($url, $args);
	}

	// ------------------------------------------------------------------------------------------------------ //
}
?>