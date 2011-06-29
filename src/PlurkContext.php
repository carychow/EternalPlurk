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

require_once('PlurkStrategy.php');

/**
 * A context of Plurk API request.
 */
class PlurkContext
{
	// ------------------------------------------------------------------------------------------------------ //

	/**
	 * The Strategy is using.
	 *
	 * @var	PlurkStrategy
	 */
	private $_strategy;

	// ------------------------------------------------------------------------------------------------------ //

	/**
	 * Creates a new PlurkContext object.
	 *
	 * @param	PlurkStrategy	$strategy	The "strategy" of Plurk request.
	 */
	public function __construct(PlurkStrategy $strategy)
	{
		$this->_strategy = $strategy;
	}

	/**
	 * Use another strategy.
	 *
	 * @param	PlurkStrategy	$strategy	The "strategy" of Plurk request.
	 */
	public function updateContext(PlurkStrategy $strategy)
	{
		$this->_strategy = $strategy;
	}

	/**
	 * Execute the selected strategy.
	 *
	 * @return	mixed	Returns an object on success, or FALSE on failure.
	 * @throws PlurkException	If strategy does not exist.
	 */
	public function execute()
	{
		if(is_null($this->_strategy))
		{
			throw new PlurkException('Startegy does not exist.');
		}

		return $this->_strategy->execute();
	}

	// ------------------------------------------------------------------------------------------------------ //
}
?>