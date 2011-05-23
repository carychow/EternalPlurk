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

require_once('Plurk/Setting/PlurkEmoticonsSetting.php');
require_once('PlurkBase.php');

/**
 * Emoticons resources of Plurk API.
 *
 * @link	http://www.plurk.com/API#emoticons
 */
class PlurkEmoticons extends PlurkBase
{
	// ------------------------------------------------------------------------------------------------------ //
	
	public function __construct(PlurkEmoticonsSetting $setting)
	{
		parent::__construct($setting);
	}
	
	public function execute()
	{
		switch($this->_setting->type)
		{
			case PlurkEmoticonsSetting::TYPE_GET:	return $this->get();
			default:								return false;
		}		
	}
	
	// ------------------------------------------------------------------------------------------------------ //

	/**
	 * Emoticons are a big part of Plurk since they make it easy to express feelings.
	 *
	 * @return	mixed	Returns a PlurkEmoticonsInfo object on success or FALSE on failure.
	 * @link	http://www.plurk.com/Help/extraSmilies
	 */
	public function get()
	{
		$url = sprintf('%sEmoticons/get', self::HTTP_URL);

		$this->setResultType(PlurkResponseParser::RESULT_EMOTICONS);
		return $this->sendRequest($url);
	}

	// ------------------------------------------------------------------------------------------------------ //
}
?>