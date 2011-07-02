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

require_once(dirname(__FILE__) . '/../Setting/PlurkBlocksSetting.php');
require_once('PlurkBase.php');

/**
 * Blocks resources of Plurk API.
 *
 * @link	http://www.plurk.com/API#blocks
 */
class PlurkBlocks extends PlurkBase
{
	// ------------------------------------------------------------------------------------------ //
	
	public function __construct(PlurkBlocksSetting $setting)
	{
		parent::__construct($setting);
	}
	
	public function execute()
	{
		switch($this->_setting->type)
		{
			case PlurkBlocksSetting::TYPE_GET:		return $this->get();
			case PlurkBlocksSetting::TYPE_BLOCK:	return $this->block();
			case PlurkBlocksSetting::TYPE_UNBLOCK:	return $this->unblock();
			default:								return false;
		}		
	}
	
	// ------------------------------------------------------------------------------------------ //

	/**
	 * Gets a list of users that are blocked by the current user.
	 * P.S. requires login
	 *
	 * @return	mixed	Returns a PlurkBlockInfo object on success or FALSE on failure.
	 */
	private function get()
	{
		$url = sprintf('%sBlocks/get', self::HTTP_URL);
		$args = array('offset' => $this->_setting->offset);

		$this->setResultType(PlurkResponseParser::RESULT_BLOCK);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Blocks a user.
	 * P.S. requires login
	 *
	 * @return	bool	Returns TRUE on success or FALSE on failure.
	 */
	private function block()
	{
		$url = sprintf('%sBlocks/block', self::HTTP_URL);
		$args = array('user_id' => $this->_setting->userId);

		$this->setResultType(PlurkResponseParser::RESULT_SUCCESS_TEXT);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Unblocks a user.
	 * P.S. requires login
	 *
	 * @return	bool	Returns TRUE on success or FALSE on failure.
	 */
	private function unblock()
	{
		$url = sprintf('%sBlocks/unblock', self::HTTP_URL);
		$args = array('user_id' => $this->_setting->userId);

		$this->setResultType(PlurkResponseParser::RESULT_SUCCESS_TEXT);
		return $this->sendRequest($url, $args);
	}

	// ------------------------------------------------------------------------------------------ //
}
?>