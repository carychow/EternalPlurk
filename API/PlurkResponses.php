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

require_once('Plurk/Setting/PlurkResponsesSetting.php');
require_once('PlurkBase.php');

/**
 * Responses resources of Plurk API.
 *
 * @link	http://www.plurk.com/API#responses
 */
class PlurkResponses extends PlurkBase
{
	// ------------------------------------------------------------------------------------------------------ //
	
	public function __construct(PlurkResponsesSetting $setting)
	{
		parent::__construct($setting);
	}
	
	public function execute()
	{
		switch($this->_setting->type)
		{
			case PlurkResponsesSetting::TYPE_GET:				return $this->get();
			case PlurkResponsesSetting::TYPE_RESPONSE_ADD:		return $this->responseAdd();
			case PlurkResponsesSetting::TYPE_RESPONSE_DELETE:	return $this->get();
			default:	return false;
		}
	}
	
	// ------------------------------------------------------------------------------------------------------ //

	/**
	 * Fetches responses for plurk with plurk id and some basic info about the users.
	 * 
	 * @return	mixed	Returns a PlurkResponseInfo object on success or FALSE on failure.
	 */
	private function get()
	{
		$url = sprintf('%sResponses/get', self::HTTP_URL);
		$args = array(
			'plurk_id'		=>	$this->_setting->plurkId,
			'from_response'	=>	$this->_setting->fromResponse
		);

		$this->setResultType(PlurkResponseParser::RESULT_RESPONSE);
		return $this->sendRequest($url, $args);
	}
	
	/**
	 * Adds a response. Language is inherited from the plurk.
	 * P.S. requires login
	 * 
	 * @return	mixed	Returns a PlurkPlurkInfo object on success or FALSE on failure.
	 */
	private function responseAdd()
	{
		$url = sprintf('%sResponses/responseAdd', self::HTTP_URL);
		$args = array(
			'plurk_id'	=>	$this->_setting->plurkId,
			'content'	=>	$this->_setting->content,
			'qualifier'	=>	$this->_setting->qualifier
		);

		$this->setResultType(PlurkResponseParser::RESULT_PLURK);
		return $this->sendRequest($url, $args);
	}
	
	/**
	 * Deletes a response. A user can delete own responses or responses that are posted to own plurks.
	 * P.S. requires login
	 * 
	 * @return	bool	Returns TRUE on success or FALSE on failure.
	 */
	private function responseDelete()
	{
		$url = sprintf('%sResponses/responseDelete', self::HTTP_URL);
		$args = array(
			'response_id'	=>	$this->_setting->responseId,
			'plurk_id'		=>	$this->_setting->plurkId
		);

		$this->setResultType(PlurkResponseParser::RESULT_SUCCESS_TEXT);
		return $this->sendRequest($url, $args);
	}

	// ------------------------------------------------------------------------------------------------------ //
}
?>