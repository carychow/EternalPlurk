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

require_once(dirname(__FILE__) . '/../Setting/PlurkTimelineSetting.php');
require_once('PlurkBase.php');

/**
 * Timeline resources of Plurk API.
 *
 * @link	http://www.plurk.com/API#timeline
 */
class PlurkTimeline extends PlurkBase
{	
	// ------------------------------------------------------------------------------------------ //
	
	public function __construct(PlurkTimelineSetting $setting)
	{
		parent::__construct($setting);
	}
	
	public function execute()
	{
		switch($this->_setting->type)
		{
			case PlurkTimelineSetting::TYPE_GET_PLURK:   		return $this->getPlurk();
			case PlurkTimelineSetting::TYPE_GET_PLURKS:  		return $this->getPlurks();
			case PlurkTimelineSetting::TYPE_GET_UNREAD_PLURKS:	return $this->getUnreadPlurks();
			case PlurkTimelineSetting::TYPE_PLURK_ADD:			return $this->plurkAdd();
			case PlurkTimelineSetting::TYPE_PLURK_DELETE:      	return $this->plurkDelete();
			case PlurkTimelineSetting::TYPE_PLURK_EDIT:			return $this->plurkEdit();
			case PlurkTimelineSetting::TYPE_MUTE_PLURKS:		return $this->mutePlurks();
			case PlurkTimelineSetting::TYPE_UNMUTE_PLURKS:		return $this->unmutePlurks();
			case PlurkTimelineSetting::TYPE_FAVORITE_PLURKS:	return $this->favoritePlurks();
			case PlurkTimelineSetting::TYPE_UNFAVORITE_PLURKS:	return $this->unfavoritePlurks();
			case PlurkTimelineSetting::TYPE_MARK_AS_READ:		return $this->markAsRead();
			case PlurkTimelineSetting::TYPE_UPLOAD_PICTURE:		return $this->uploadPicture();
			case PlurkTimelineSetting::TYPE_GET_PUBLIC_PLURKS:	return $this->getPublicPlurks();
			default:											return false;
		}		
	}

	// ------------------------------------------------------------------------------------------ //

	/**
	 * Gets a plurk.
	 * P.S. requires login
	 *
	 * @return	mixed	Returns a PlurkPlurkInfo object on success or FALSE on failure.
	 */
	private function getPlurk()
	{
		$url = sprintf('%sTimeline/getPlurk', self::HTTP_URL);
		$args = array('plurk_id' => (int)$this->_setting->plurkId);

		$this->setResultType(PlurkResponseParser::RESULT_PLURK);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Gets all the plurks and their owners' information.
	 * P.S. requires login
	 *
	 * @return	mixed	Returns a PlurkPlurksUsersInfo object on success or FALSE on failure.
	 */
	private function getPlurks()
	{
		$url = sprintf('%sTimeline/getPlurks', self::HTTP_URL);
		$offset = $this->_setting->offset;
		$time = ($offset instanceof DateTime) ? $offset : new DateTime($offset);
		$args = array(
			'offset'	=>	$time->format('Y-m-d\TH:i:s'),
			'limit'		=>	(int)$this->_setting->limit
		);

		if(!empty($this->_setting->filter))
		{
			$args['filter'] = $this->_setting->filter;
		}

		$this->setResultType(PlurkResponseParser::RESULT_PLURKS_USERS);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Gets all the unread plurks and their owners' information.
	 * P.S. requires login
	 *
	 * @return	mixed	Returns a PlurkPlurksUsersInfo object on success or FALSE on failure.
	 */
	private function getUnreadPlurks()
	{
		$url = sprintf('%sTimeline/getUnreadPlurks', self::HTTP_URL);
		$offset = $this->_setting->offset;
		$time = ($offset instanceof DateTime) ? $offset : new DateTime($offset);
		$args = array(
			'offset'	=> $time->format('Y-m-d\TH:i:s'),
			'limit'		=> $this->_setting->limit,
			'filter'	=> $this->_setting->filter
		);

		$this->setResultType(PlurkResponseParser::RESULT_PLURKS_USERS);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Adds a new plurk.
	 * P.S. requires login
	 *
	 * @return	mixed	Returns a PlurkPlurkInfo object on success or FALSE on failure.
	 */
	private function plurkAdd()
	{
		$url = sprintf('%sTimeline/plurkAdd', self::HTTP_URL);
		$args = array(
			'content'	=>	$this->_setting->content,
			'qualifier'	=>	$this->_setting->qualifier
		);

		if(!empty($this->_setting->limitedTo))
		{
			$args['limited_to'] = json_encode($this->_setting->limitedTo);
		}

		if($this->_setting->noComments != 0)
		{
			$args['no_comments'] = (int)$this->_setting->noComments;
		}

		if(!empty($this->_setting->lang))
		{
			$args['lang'] = (string)$this->_setting->lang;
		}

		$this->setResultType(PlurkResponseParser::RESULT_PLURK);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Deletes a plurk.
	 * P.S. requires login
	 *
	 * @return	bool	Returns TRUE on success or FALSE on failure.
	 */
	private function plurkDelete()
	{
		$url = sprintf('%sTimeline/plurkDelete', self::HTTP_URL);
		$args = array('plurk_id' => $this->_setting->plurkId);

		$this->setResultType(PlurkResponseParser::RESULT_SUCCESS_TEXT);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Edits a plurk.
	 * P.S. requires login
	 *
	 * @return	mixed	Returns a PlurkPlurkInfo object on success or FALSE on failure.
	 */
	private function plurkEdit()
	{
		$url = sprintf('%sTimeline/plurkEdit', self::HTTP_URL);
		$args = array(
			'plurk_id'	=>	$this->_setting->plurkId,
			'content'	=>	$this->_setting->content
		);

		$this->setResultType(PlurkResponseParser::RESULT_PLURK);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Mutes one or more plurks.
	 * P.S. requires login
	 *
	 * @return	bool	Returns TRUE on success or FALSE on failure.
	 */
	private function mutePlurks()
	{
		$url = sprintf('%sTimeline/mutePlurks', self::HTTP_URL);
		$args = array('ids' => json_encode($this->_setting->ids));

		$this->setResultType(PlurkResponseParser::RESULT_SUCCESS_TEXT);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Unmutes one or more plurks.
	 * P.S. requires login
	 *
	 * @return	bool	Returns TRUE on success or FALSE on failure.
	 */
	private function unmutePlurks()
	{
		$url = sprintf('%sTimeline/unmutePlurks', self::HTTP_URL);
		$args = array('ids' => json_encode($this->_setting->ids));

		$this->setResultType(PlurkResponseParser::RESULT_SUCCESS_TEXT);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Favorites one or more plurks.
	 * P.S. requires login
	 *
	 * @return	bool	Returns TRUE on success or FALSE on failure.
	 */
	private function favoritePlurks()
	{
		$url = sprintf('%sTimeline/favoritePlurks', self::HTTP_URL);
		$args = array('ids' => json_encode($this->_setting->ids));

		$this->setResultType(PlurkResponseParser::RESULT_SUCCESS_TEXT);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Unfavorites one or more plurks.
	 * P.S. requires login
	 *
	 * @return	bool	Returns TRUE on success or FALSE on failure.
	 */
	private function unfavoritePlurks()
	{
		$url = sprintf('%sTimeline/unfavoritePlurks', self::HTTP_URL);
		$args = array('ids' => json_encode($this->_setting->ids));

		$this->setResultType(PlurkResponseParser::RESULT_SUCCESS_TEXT);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Marks one or more plurks as read.
	 * P.S. requires login
	 *
	 * @return	bool	Returns TRUE on success or FALSE on failure.
	 */
	private function markAsRead()
	{
		$url = sprintf('%sTimeline/markAsRead', self::HTTP_URL);
		$args = array('ids' => json_encode($this->_setting->ids));

		$this->setResultType(PlurkResponseParser::RESULT_SUCCESS_TEXT);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Upload a picture.
	 * P.S. requires login
	 *
	 * @return	mixed	Returns a PlurkPictureInfo object on success or FALSE on failure.
	 */
	private function uploadPicture()
	{
		$url = sprintf('%sTimeline/uploadPicture', self::HTTP_URL);
		$args = array('image' => '@' . $this->_setting->imgPath);

		$this->setResultType(PlurkResponseParser::RESULT_PICTURE);
		return $this->sendRequest($url, $args);
	}
	
	/**
	 * Gets public plurks from a user.
	 */
	private function getPublicPlurks()
	{
		$url = sprintf('%sTimeline/getPublicPlurks', self::HTTP_URL);
		$offset = $this->_setting->offset;
		$time = ($offset instanceof DateTime) ? $offset : new DateTime($offset);
		$args = array(
			'user_id'	=> $this->_setting->userId,
			'offset'	=> $time->format('Y-m-d\TH:i:s'),
			'limit'		=> $this->_setting->limit
		);

		$this->setResultType(PlurkResponseParser::RESULT_PLURKS_USERS);
		return $this->sendRequest($url, $args);
	}

	// ------------------------------------------------------------------------------------------ //
}
?>