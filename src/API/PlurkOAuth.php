<?php
/**
 * @file
 * The classes of Eternity SDK.\n
 * Copyright (C) 2011 Cary Chow\n
 * License: http://creativecommons.org/licenses/by-sa/3.0/\n
 * Website: http://www.carychow.idv.hk/
 *
 * @package		EternitySDK
 * @addtogroup	Plurk
 * @author		Cary Chow <carychowhk@gmail.com>
 * @version		2.0
 * @since		2.0
 */

require_once(dirname(__FILE__) . '/../../libs/OAuth.php');
require_once(dirname(__FILE__) . '/../Data/PlurkOAuthInfo.php');
require_once(dirname(__FILE__) . '/../Setting/PlurkOAuthSetting.php');
require_once('PlurkBase.php');

/**
 */
class PlurkOAuth extends PlurkBase
{
	// ------------------------------------------------------------------------------------------ //
	
	/**
	 * POST method.
	 *
	 * @var	string
	 */
	const REQUEST_POST = 'POST';

	const OAUTH_HOST = 'http://www.plurk.com';
	const REQUEST_TOKEN_URL = 'http://www.plurk.com/OAuth/request_token';
	const AUTHORIZE_URL = 'http://www.plurk.com/OAuth/authorize';
	const ACCESS_TOKEN_URL = 'http://www.plurk.com/OAuth/access_token';
	
	const SESSION_OATUTH_TOKEN	= 'oAuthToken';
	const SESSION_OAUTH_SECRET	= 'oAuthTokenSecret';
	
	// ------------------------------------------------------------------------------------------ //
	
	/**
	 * OAuth information.
	 *
	 * @var	PlurkOAuthInfo
	 */
	private $_oAuthInfo;
	
	private $_oAuthStore;

	// ------------------------------------------------------------------------------------------ //
	
	/**
	 * Creates a new PlurkOAuth object.
	 *
	 * @param	PlurkOAuthSetting	$setting
	 */
	public function __construct(PlurkOAuthSetting $setting)
	{
		parent::__construct($setting);
	}
	
	//TODO
	public function execute()
	{
		switch($this->_setting->type)
		{
			case PlurkOAuthSetting::TYPE_START_AUTH:		return $this->startAuth();
			case PlurkOAuthSetting::TYPE_PARSE_CALLBACK:	return $this->parseCallback();
			default:										return false;
		}
	}
	
	/**
	 * Send a request to Plurk by OAuth.
	 *
	 * @param	string	$url	URL to request from Plurk.
	 * @param	mixed	$args	Arguments in the POST. It can be a string or an array.
	 * @return	mixed			NULL on unknown type or different type of object.
	 */
	public function sendRequest($url, array $args = array(), $isPost = true, array $headers = array())
	{
		//TODO
		$consumer = new OAuthConsumer($this->_setting->consumerKey, $this->_setting->consumerSecret);
		$token = new OAuthToken($this->_setting->oAuthToken, $this->_setting->oAuthTokenSecret);
		
		// GEET/POST?
		$request = OAuthRequest::from_consumer_and_token($consumer, $token, self::REQUEST_POST, $url, $args);
		$request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, $token);
		
		return parent::sendRequest($request->get_normalized_http_url(), $request->get_parameters(), $isPost, array($request->to_header()));
	}

	// ------------------------------------------------------------------------------------------ //
	
	/**
	 * Start the authorization.
	 *
	 * @return	bool	Returns TRUE on success or false on failure.
	 */
	private function startAuth()
	{
		if(!session_start())
		{
			$this->_errMsg = 'Start session failed.';
			return false;
		}
		
		$consumer = new OAuthConsumer($this->_setting->consumerKey, $this->_setting->consumerSecret);
		$request = OAuthRequest::from_consumer_and_token($consumer, NULL, self::REQUEST_POST, self::REQUEST_TOKEN_URL);
		$request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, NULL);
		
		try
		{
			$requestToken = parent::sendRequest($request->to_url(), array(), true, array($request->to_header()));
		}
		catch(PlurkException $ex)
		{
			$this->_errMsg = $ex->getMessage();
			return false;
		}
		
		// Parse the requested token.
		parse_str($requestToken, $tokens);
		$oauthToken = $tokens['oauth_token'];
		$oauthTokenSecret = $tokens['oauth_token_secret'];
		
		if(empty($oauthToken) || empty($oauthTokenSecret))
		{
			$this->_errMsg = 'Token or Token Secret is empty.';
			return false;
		}
		
		$this->clearSession();
		$_SESSION[self::SESSION_OATUTH_TOKEN] = $oauthToken;
		$_SESSION[self::SESSION_OAUTH_SECRET] = $oauthTokenSecret;
		
		// Forward to Plurk
		$this->authorize($oauthToken);
		return true;
	}
	
	/**
	 * For web application, Twitter will re-direct to the callback URL which is in the setting.
	 *
	 * @return	mixed	FALSE on failure or the OAuth information of the Twitter user in this 
	 * 					authorization.
	 */
	private function parseCallback()
	{
		if(!session_start())
		{
			$this->_errMsg = 'Start session failed.';
			return false;
		}
		
		$responseToken = $_GET['oauth_token'];
		$verifier = $_GET['oauth_verifier'];
		$savedToken = $_SESSION[self::SESSION_OATUTH_TOKEN];
		$savedTokenSecret = $_SESSION[self::SESSION_OAUTH_SECRET];
		$isFailed = false;
		
		if(empty($responseToken) || empty($verifier))
		{
			$this->_errMsg = 'Response is invalid.';
			$isFailed = true;
		}
		else if(empty($savedToken) || empty($savedTokenSecret))
		{
			$this->_errMsg = 'Saved token is invalid.';
			$isFailed = true;
		}
		else if(strcmp($responseToken, $savedToken) != 0)
		{
			$this->_errMsg = 'Response token does not match saved token.';
			$isFailed = true;
		}
		
		if($isFailed)
		{
			$this->clearSession();
			return false;
		}
		
		$consumer = new OAuthConsumer($this->_setting->consumerKey, $this->_setting->consumerSecret);
		$token = new OAuthToken($savedToken, $savedTokenSecret);
		
		$request = OAuthRequest::from_consumer_and_token($consumer, $token, self::REQUEST_POST, self::ACCESS_TOKEN_URL, array('oauth_verifier'=>$verifier));
		$request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, $token);
		
		try
		{
			$accessToken = parent::sendRequest($request->to_url(), array(), true, array($request->to_header()));
		}
		catch(PlurkException $ex)
		{
			$this->_errMsg = $ex->getMessage();
			$this->clearSession();
			return false;
		}
		
		parse_str($accessToken, $tokens);
		$this->clearSession();
		
		$info = new PlurkOAuthInfo();
		$info->consumerKey = $this->_setting->consumerKey;
		$info->consumerSecret = $this->_setting->consumerSecret;
		$info->oAuthToken = $tokens['oauth_token'];
		$info->oAuthTokenSecret = $tokens['oauth_token_secret'];
		
		return $info;
	}

	/**
	 * Allows a Consumer application to use an OAuth Request Token to request user authorization.
	 *
	 * @param	string	$oAuthToken	The OAuth Request Token which received by requestToken().
	 * @see		requestToken()
	 */
	private function authorize($oAuthToken)
	{
		$url = sprintf('%s?oauth_token=%s', self::AUTHORIZE_URL, $oAuthToken);
		session_write_close();
		
		header("Location: $url");
	}
	
	private function clearSession()
	{
		unset($_SESSION[self::SESSION_OATUTH_TOKEN]);
		unset($_SESSION[self::SESSION_OAUTH_SECRET]);
	}

	// ------------------------------------------------------------------------------------------ //
}
?>