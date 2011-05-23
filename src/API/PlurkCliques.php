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

require_once('Plurk/Setting/PlurkCliquesSetting.php');
require_once('PlurkBase.php');

/**
 * Cliques resources of Plurk API.
 *
 * @link	http://www.plurk.com/API#cliques
 */
class PlurkCliques extends PlurkBase
{
	// ------------------------------------------------------------------------------------------------------ //
	
	public function __construct(PlurkCliquesSetting $setting)
	{
		parent::__construct($setting);
	}
	
	public function execute()
	{
		switch($this->_setting->type)
		{
			case PlurkCliquesSetting::TYPE_GET:	return $this->get();
			case PlurkCliquesSetting::TYPE_GET:	return $this->block();
			case PlurkCliquesSetting::TYPE_GET:	return $this->unblock();
			default:							return false;
		}		
	}
	// ------------------------------------------------------------------------------------------------------ //

	/**
	 * Gets user's current cliques.
	 * P.S. requires login
	 *
	 * @return	mixed	Returns an array of the name of users current cliques or FALSE on failure.
	 */
	public function getCliques()
	{
		$url = sprintf('%sCliques/getCliques', self::HTTP_URL);

		$this->setResultType(PlurkResponseParser::RESULT_DEFAULT);
		return $this->sendRequest($url);
	}

	/**
	 * Gets the users in the clique.
	 * P.S. requires login
	 *
	 * @return	mixed	Returns an array of PlurkUserInfo object on success or FALSE on failure.
	 */
	public function getClique()
	{
		$url = sprintf('%sCliques/getClique', self::HTTP_URL);
		$args = array('clique_name'	=> $this->_setting->cliqueName);

		$this->setResultType(PlurkResponseParser::RESULT_USERS);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Creates a new clique.
	 * P.S. requires login
	 *
	 * @return	bool	Returns TRUE on success or FALSE on failure.
	 */
	public function createClique()
	{
		$url = sprintf('%sCliques/createClique', self::HTTP_URL);
		$args = array('clique_name'	=> $this->_setting->cliqueName);

		$this->setResultType(PlurkResponseParser::RESULT_SUCCESS_TEXT);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Renames a clique.
	 * P.S. requires login
	 *
	 * @return	bool	Returns TRUE on success or FALSE on failure.
	 */
	public function renameClique()
	{
		$url = sprintf('%sCliques/renameClique', self::HTTP_URL);
		$args = array(
			'clique_name'	=> $this->_setting->cliqueName,
			'new_name'		=> $this->_setting->newName
		);

		$this->setResultType(PlurkResponseParser::RESULT_SUCCESS_TEXT);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Adds a user to the clique.
	 * P.S. requires login
	 *
	 * @return	bool	Returns TRUE on success or FALSE on failure.
	 */
	public function add()
	{
		$url = sprintf('%sCliques/add', self::HTTP_URL);
		$args = array(
			'clique_name'	=> $this->_setting->cliqueName,
			'user_id'		=> $this->_setting->userId
		);

		$this->setResultType(PlurkResponseParser::RESULT_SUCCESS_TEXT);
		return $this->sendRequest($url, $args);
	}

	/**
	 * Removes a user from the clique.
	 * P.S. requires login
	 *
	 * @return	bool	Returns TRUE on success or FALSE on failure.
	 */
	public function remove()
	{
		$url = sprintf('%sCliques/remove', self::HTTP_URL);
		$args = array(
			'clique_name'	=>	$this->_setting->cliqueName,
			'user_id'		=>	$this->_setting->userId
		);

		$this->setResultType(PlurkResponseParser::RESULT_SUCCESS_TEXT);
		return $this->sendRequest($url, $args);
	}

	// ------------------------------------------------------------------------------------------------------ //
}
?>