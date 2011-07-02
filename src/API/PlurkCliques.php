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
 * @since		1.0
 */

require_once(dirname(__FILE__) . '/../Setting/PlurkCliquesSetting.php');
require_once('PlurkOAuth.php');

/**
 * Cliques resources of Plurk API.
 *
 * @link	http://www.plurk.com/API#cliques
 */
class PlurkCliques extends PlurkOAuth
{
	// ------------------------------------------------------------------------------------------ //
	
	public function __construct(PlurkCliquesSetting $setting)
	{
		parent::__construct($setting);
	}
	
	public function execute()
	{
		switch($this->_setting->type)
		{
			case PlurkCliquesSetting::TYPE_GET_CLIQUES:		return $this->getCliques();
			case PlurkCliquesSetting::TYPE_GET_CLIQUE:		return $this->getClique();
			case PlurkCliquesSetting::TYPE_CREATE_CLIQUE:	return $this->createClique();
			case PlurkCliquesSetting::TYPE_RENAME_CLIQUE:	return $this->renameClique();
			case PlurkCliquesSetting::TYPE_ADD:				return $this->add();
			case PlurkCliquesSetting::TYPE_REMOVE:			return $this->remove();
			default:							return false;
		}		
	}
	// ------------------------------------------------------------------------------------------ //

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

	// ------------------------------------------------------------------------------------------ //
}
?>