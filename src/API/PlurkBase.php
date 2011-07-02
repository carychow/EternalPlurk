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

require_once(dirname(__FILE__) . '/../PlurkException.php');
require_once(dirname(__FILE__) . '/../PlurkResponseParser.php');
require_once(dirname(__FILE__) . '/../PlurkStrategy.php');

/**
 * The base class for Plurk API.
 */
abstract class PlurkBase implements PlurkStrategy
{
	// ------------------------------------------------------------------------------------------ //

	/**
	 * Setting (parameters) of the request.
	 *
	 * @var PlurkSetting
	 */
	protected $_setting;
	
	/**
	 * Error message of the response.
	 *
	 * @var	string
	 */
	protected $_errMsg;
	
	// ------------------------------------------------------------------------------------------ //

	/**
	 * Type of the result.
	 *
	 * @var	int
	 */
	private $_resultType;

	// ------------------------------------------------------------------------------------------ //

	/**
	 * Creates a new PlurkBase object.
	 *
	 * @param	PlurkSetting	$setting	Setting of request.
	 */
	public function __construct(PlurkSetting $setting)
	{
		$this->_setting = $setting;
	}

	/**
	 * Gets the error message
	 *
	 * @return	string	Error message of last response.
	 */
	public function getErrMsg()
	{
		return $this->_errMsg;
	}

	/**
	 * Sets up the type of result.
	 *
	 * @param	int	$resultType	Type of the result.
	 * @see	PlurkResponseParser
	 */
	public function setResultType($resultType)
	{
		$this->_resultType = (int)$resultType;
	}

	/**
	 *
	 * @param	string	$url	URL of the request.
	 * @param	array	$args	Arguments of the request.
	 * @param	bool	$isPost	TRUE on sending request by POST otherwise FALSE.
	 * @param	array	$header	Addtional HTTP header fields to set.
	 * @return	mixed			An object of different success result or FALSE on failure.
	 * @exception	PlurkException	If get error on response.
	 */
	public function sendRequest($url, array $args = array(), $isPost = true, array $headers = array())
	{
		$isHttp = (preg_match('|^(http://)|i', $url) > 0);

		// Options for cURL transfer
		$options = array(
			CURLOPT_USERAGENT		=>	'EternalPlurk',
			CURLOPT_URL				=>	$url,
			CURLOPT_HEADER			=>	false,		// Do not show the protocol header
			CURLOPT_NOBODY			=>	false,		// Show the body
			CURLOPT_RETURNTRANSFER	=>	true,		// Return the transfer as a string
			CURLOPT_VERBOSE			=>	true,
			CURLOPT_SSL_VERIFYPEER	=>	$isHttp,
			CURLOPT_CONNECTTIMEOUT	=>	120,		// timeout on connect
			CURLOPT_MAXREDIRS		=>	10,     	// stop after 10 redirects
			CURLOPT_TIMEOUT			=>	120,		// timeout on response
			CURLINFO_HEADER_OUT		=>	false,		// Do not track the handle's request string.
		);
		
		$openBaseDir = ini_get('open_basedir');
		
		if(empty($openBaseDir))
		{
			$options[CURLOPT_FOLLOWLOCATION] = true;	// Follow redirects
		}
		
		if(!empty($headers))
		{
			$options[CURLOPT_HTTPHEADER] = $headers;	// HTTP headers
		}
		
		if($isPost)
		{
			// Do a regular HTTP POST.
			$options[CURLOPT_POST] = true;
			$options[CURLOPT_POSTFIELDS] = $args;
		}

		// Initialize cURL
		$ch = curl_init();
		curl_setopt_array($ch, $options);

		// Execute the cURL call & get information about the response
		$response = curl_exec($ch);

		if($response === false)
		{
			// Execution failure.
			throw new PlurkException('Failed to execute cURL session.');
		}

		$responseInfo = curl_getinfo($ch);
			
		// Close the cURL connection
		curl_close($ch);

		$this->_httpCode = (int)$responseInfo['http_code'];

		// Make sure we received a response from Plurk
		if(empty($response))
		{
			throw new PlurkException('Empty response.');
		}
		else if($this->_httpCode >= 400)
		{
			$msg = sprintf('Error. Status code: %d. Request URL: %s. Args: %s. Response: %s',
				$this->_httpCode, $url, var_export($args, true), $response);
			throw new PlurkException($msg);
		}

		$parser = new PlurkResponseParser();
		$result = $parser->parse($response, $this->_resultType);
		$this->_errMsg = $parser->getErrMsg();

		return $result;
	}

	// ------------------------------------------------------------------------------------------ //
}
?>