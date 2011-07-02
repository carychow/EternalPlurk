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
 * @version		2.0
 * @since		1.0.1
 */

require_once(dirname(__FILE__) . '/../Setting/PlurkTopSetting.php');
require_once('PlurkOAuth.php');

/**
 * Profile resources of Plurk API.
 *
 * @link	http://www.plurk.com/API#plurk_top
 */
class PlurkTop extends PlurkOAuth
{
	// ------------------------------------------------------------------------------------------ //
	
	public function __construct(PlurkTopSetting $setting)
	{
		parent::__construct($setting);
	}
	
	public function execute()
	{
		switch($this->_setting->type)
		{
			case PlurkTopSetting::TYPE_GET_COLLECTIONS:			return $this->getCollections();
			case PlurkTopSetting::TYPE_GET_PLURKS:				return $this->getPlurks();
			default:											return false;
		}
	}
	
	// ------------------------------------------------------------------------------------------ //

	/**
	 * Gets a list of PlurkTop collections.
	 *
	 * @return	mixed	Returns an array of PlurkCollectionInfo on success or FALSE on failure.
	 */
	private function getCollections()
	{
		$url = sprintf('%sPlurkTop/getCollections', self::HTTP_URL);

		$this->setResultType(PlurkResponseParser::RESULT_COLLECTIONS);
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
		$args = array('collection_name'=>$this->_setting->collectionName);
		
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

	// ------------------------------------------------------------------------------------------ //
}
?>