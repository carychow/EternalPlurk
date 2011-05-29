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

require_once('Data/main.php');

/**
 * A parser of Plurk response.
 */
class PlurkResponseParser
{
	// ------------------------------------------------------------------------------------------------------ //
	
	/**
	 * Result is string.
	 *
	 * @var	int
	 */
	const RESULT_STRING = 0;

	/**
	 * Result is info of alerts.
	 *
	 * @var	int
	 */
	const RESULT_ALERT = 1;

	/**
	 * Result is an array of alerts info.
	 *
	 * @var	int
	 */
	const RESULT_ALERTS = 2;

	/**
	 * Result is info of blocking.
	 *
	 * @var	int
	 */
	const RESULT_BLOCK = 3;

	/**
	 * Result is info of comet channel.
	 *
	 * @var	int
	 */
	const RESULT_CHANNEL_COMET = 4;

	/**
	 * Result is info of user channel.
	 *
	 * @var	int
	 */
	const RESULT_CHANNEL_USER = 5;

	/**
	 * Result is an array after decoded.
	 *
	 * @var	int
	 */
	const RESULT_DEFAULT = 6;

	/**
	 * Result is info of emoticons.
	 *
	 * @var	int
	 */
	const RESULT_EMOTICONS = 7;

	/**
	 * Result is info of picture.
	 *
	 * @var	int
	 */
	const RESULT_PICTURE = 8;

	/**
	 * Result is info of plurk.
	 *
	 * @var	int
	 */
	const RESULT_PLURK = 9;

	/**
	 * Result is an array of plurks.
	 *
	 * @var	int
	 */
	const RESULT_PLURKS = 10;

	/**
	 * Result is info of plurks and users.
	 *
	 * @var	int
	 */
	const RESULT_PLURKS_USERS = 11;

	/**
	 * Result is info of user profile.
	 *
	 * @var	int
	 */
	const RESULT_PROFILE = 12;

	/**
	 * Result is info of response.
	 *
	 * @var	int
	 */
	const RESULT_RESPONSE = 13;

	/**
	 * Result is info of plurk searching.
	 *
	 * @var	int
	 */
	const RESULT_SEARCH_PLURK = 14;

	/**
	 * Result is info of user searching.
	 *
	 * @var	int
	 */
	const RESULT_SEARCH_USER = 15;

	/**
	 * Result is BOOL type of success of fail.
	 *
	 * @var	int
	 */
	const RESULT_SUCCESS_TEXT = 16;

	/**
	 * Result is info of unread count by different type.
	 *
	 * @var	int
	 */
	const RESULT_UNREAD_COUNT = 17;

	/**
	 * Result is user info.
	 *
	 * @var	int
	 */
	const RESULT_USER = 18;

	/**
	 * Result is an array of user info.
	 *
	 * @var	int
	 */
	const RESULT_USERS = 19;

	/**
	 * Result is an info about a user's karma.
	 *
	 * @var	int
	 */
	const RESULT_KARMA = 20;
	
	/**
	 * Result is an info of Plurk Top collections.
	 *
	 * @var	int
	 */
	const RESULT_COLLECTIONS = 21;
	
	/**
	 * Result is a string of default name of collection for current user.
	 *
	 * @var	int
	 */
	const RESULT_DEF_COLLECTION = 22;
	
	/**
	 * Result is info of plurks, users and offset.
	 *
	 * @var	int
	 */
	const RESULT_PLURKS_USERS_OFFSET = 23;

	// ------------------------------------------------------------------------------------------------------ //

	/**
	 * Error message of the response.
	 *
	 * @var	string
	 */
	private $_errMsg;

	// ------------------------------------------------------------------------------------------------------ //

	/**
	 * Gets the error message.
	 *
	 * @return	string	Error message of the response.
	 */
	public function getErrMsg()
	{
		return $this->_errMsg;
	}

	/**
	 * Parse the response.
	 *
	 * @param	string	$response	The JSON string of the response.
	 * @param	int		$resultType	Type of result of the response.
	 * @return	mixed				NULL on unknown type or different type of object.
	 */
	public function parse($response, $resultType = NULL)
	{
		if($resultType == self::RESULT_STRING)
		{
			// Return the result directly.
			return $response;
		}
		
		$jsonAry = json_decode($response, true);
		
		if($resultType == self::RESULT_DEF_COLLECTION)
		{
			// /API/PlurkTop/getDefaultCollection returns a collection name only.
			if(!is_string($jsonAry))
			{
				$this->_errMsg = "Error response: $response";
				throw new PlurkException($this->_errMsg);
			}
			
			return $jsonAry;
		}

		if(!is_array($jsonAry))
		{
			$this->_errMsg = "Error response: $response";
			throw new PlurkException($this->_errMsg);
		}

		if(array_key_exists('error_text', $jsonAry))
		{
			$this->_errMsg = $jsonAry['error_text'];
			throw new PlurkException($this->_errMsg);
		}
		else
		{
			$this->_errMsg = '';
		}

		switch($resultType)
		{
			case self::RESULT_ALERT:				return $this->parseAlert($jsonAry);
			case self::RESULT_ALERTS:				return $this->parseAlerts($jsonAry);
			case self::RESULT_BLOCK:				return $this->parseBlock($jsonAry);
			case self::RESULT_CHANNEL_COMET:		return $this->parseChannelComet($jsonAry);
			case self::RESULT_CHANNEL_USER:			return $this->parseChannelUser($jsonAry);
			case self::RESULT_DEFAULT:				return json_decode($response, true);
			case self::RESULT_EMOTICONS:			return $this->parseEmoticons($jsonAry);
			case self::RESULT_PICTURE:				return $this->parsePicture($jsonAry);
			case self::RESULT_PLURK:				return $this->parsePlurk($jsonAry);
			case self::RESULT_PLURKS:				return $this->parsePlurks($jsonAry);
			case self::RESULT_PLURKS_USERS:			return $this->parsePlurksUsers($jsonAry);
			case self::RESULT_PLURKS_USERS_OFFSET:	return $this->parsePlurksUsersOffset($jsonAry);
			case self::RESULT_PROFILE:				return $this->parseProfile($jsonAry);
			case self::RESULT_RESPONSE:				return $this->parseResponse($jsonAry);
			case self::RESULT_SEARCH_PLURK:			return $this->parseSearchPlurk($jsonAry);
			case self::RESULT_SEARCH_USER:			return $this->parseSearchUser($jsonAry);
			case self::RESULT_SUCCESS_TEXT:			return $this->parseSuccessText($jsonAry);
			case self::RESULT_UNREAD_COUNT:			return $this->parseUnreadCount($jsonAry);
			case self::RESULT_USER:					return $this->parseUser($jsonAry);
			case self::RESULT_USERS:				return $this->parseUsers($jsonAry);
			case self::RESULT_KARMA:				return $this->parseKarma($jsonAry);
			case self::RESULT_COLLECTIONS:			return $this->parseCollections($jsonAry);
			default:
				$this->_errMsg = 'Unknow result type.';
				throw new PlurkException($this->_errMsg);
		}
	}

	// ------------------------------------------------------------------------------------------------------ //

	/**
	 * Parse an alert by JSON.
	 *
	 * @param	array	$jsonAry	A JSON decoded array.
	 * @return	array				Returns a PlurkAlertInfo object.
	 */
	protected function parseAlert(array $jsonAry)
	{
		$info = new PlurkAlertInfo();
		$info->type = (string)($jsonAry[PlurkAlertInfo::KEY_TYPE]);
		$info->posted = new DateTime($jsonAry[PlurkAlertInfo::KEY_POSTED]);

		switch($info->type)
		{
			case PlurkAlertInfo::TYPE_FRIENDSHIP_REQUEST:	$key = PlurkAlertInfo::KEY_FROM_USER;	break;
			case PlurkAlertInfo::TYPE_REIENDSHIP_PENDING:	$key = PlurkAlertInfo::KEY_TO_USER;		break;
			case PlurkAlertInfo::TYPE_NEW_FAN:				$key = PlurkAlertInfo::KEY_NEW_FAN;		break;
			case PlurkAlertInfo::TYPE_FRIENDSHIP_ACCEPTED:	$key = PlurkAlertInfo::KEY_FRIEND_INFO;	break;
			case PlurkAlertInfo::TYPE_NEW_FRIEND:			$key = PlurkAlertInfo::KEY_NEW_FRIEND;	break;
		}

		$info->user = $this->parseUser($jsonAry[$key]);

		return $info;
	}

	/**
	 * Parse all alerts by JSON.
	 *
	 * @param	array	$jsonAry	A JSON decoded array.
	 * @return	array				Returns an array of PlurkAlertInfo object.
	 */
	protected function parseAlerts(array $jsonAry)
	{
		$alerts = array();

		if(!empty($jsonAry))
		{
			foreach($jsonAry as $alert)
			{
				$alerts[] = $this->parseAlert($alert);
			}
		}

		return $alerts;
	}

	/**
	 * Parse blocked information by JSON.
	 *
	 * @param	array	$jsonAry	A JSON decoded array.
	 * @return	PlurkBlockInfo		Returns a PlurkBlockInfo object.
	 */
	protected function parseBlock(array $jsonAry)
	{
		$info = new PlurkBlockInfo();
		$info->total	= (int)$jsonAry[PlurkBlockInfo::KEY_TOTAL];
		$info->users	= $this->parseUsers($jsonAry[PlurkBlockInfo::KEY_TOTAL]);
		return $info;
	}

	/**
	 * Parse channel data by JSON.
	 *
	 * @param	array	$jsonAry	A JSON decoded array.
	 * @return	parseChannelData	Returns a parseChannelData object.
	 */
	protected function parseChannelData(array $jsonAry)
	{
		$info = new PlurkChannelDataInfo();
		$info->lang				= $jsonAry[PlurkChannelDataInfo::KEY_LANG];
		$info->content			= $jsonAry[PlurkChannelDataInfo::KEY_CONTENT];
		$info->content_raw		= $jsonAry[PlurkChannelDataInfo::KEY_CONTENT_RAW];
		$info->user_id			= $jsonAry[PlurkChannelDataInfo::KEY_USER_ID];
		$info->plurk_type		= $jsonAry[PlurkChannelDataInfo::KEY_PLURK_TYPE];
		$info->plurk_id			= $jsonAry[PlurkChannelDataInfo::KEY_PLURK_ID];
		$info->type				= $jsonAry[PlurkChannelDataInfo::KEY_TYPE];
		$info->response_count	= $jsonAry[PlurkChannelDataInfo::KEY_RESPONSE_COUNT];
		$info->favorite			= $jsonAry[PlurkChannelDataInfo::KEY_FAVORITE];
		$info->qualifier		= $jsonAry[PlurkChannelDataInfo::KEY_QUALIFIER];
		$info->id				= $jsonAry[PlurkChannelDataInfo::KEY_ID];
		$info->is_unread		= (bool)$jsonAry[PlurkChannelDataInfo::KEY_IS_UNREAD];
		$info->responses_seen	= $jsonAry[PlurkChannelDataInfo::KEY_RESPONSES_SEEN];
		$info->posted			= new DateTime($jsonAry[PlurkChannelDataInfo::KEY_POSTED]);
		$info->limited_to		= $jsonAry[PlurkChannelDataInfo::KEY_LIMITED_TO];
		$info->no_comments		= $jsonAry[PlurkChannelDataInfo::KEY_NO_COMMENTS];
		$info->favorite_count	= $jsonAry[PlurkChannelDataInfo::KEY_FAVORITE_COUNT];
		$info->owner_id			= $jsonAry[PlurkChannelDataInfo::KEY_OWNER_ID];
		$info->cid				= $jsonAry[PlurkChannelDataInfo::KEY_CID];
		$info->owner_id			= $jsonAry[PlurkChannelDataInfo::KEY_OWNER_ID];
		$info->response			= $this->parseResponse($jsonAry[PlurkChannelDataInfo::KEY_RESPONSE]);
		$info->user				= $this->parseUsers($jsonAry[PlurkChannelDataInfo::KEY_USER]);
		
		return $info;
	}

	/**
	 * Parse a channel of comet by JSON.
	 *
	 * @param	array	$jsonAry		A JSON decoded array.
	 */
	protected function parseChannel(array $jsonAry)
	{
		$data = array();

		if(!empty($jsonAry))
		{
			foreach($jsonAry as $channel)
			{
				$users[] = $this->parseChannelData($channel);
			}
		}

		return $data;
	}

	/**
	 * Parse a comet channel by JSON.
	 *
	 * @param	array	$jsonAry		A JSON decoded array.
	 * @return	PlurkChannelCometInfo	Returns a PlurkChannelCometInfo object.
	 */
	protected function parseChannelComet(array $jsonAry)
	{
		$data = $jsonAry[PlurkChannelCometInfo::KEY_DATA];

		$info = new PlurkChannelCometInfo();
		$info->newOffset = (int)$jsonAry[PlurkChannelCometInfo::KEY_NEW_OFFSET];
		$info->data = array();

		if(!empty($data))
		{
			foreach($data as $channel)
			{
				$info->data[] = $this->parseChannel($channel);
			}
		}

		return $info;
	}

	/**
	 * Parse a user channel by JSON.
	 *
	 * @param	array	$jsonAry		A JSON decoded array.
	 * @return	PlurkChannelUserInfo	Returns a PlurkChannelUserInfo object.
	 */
	protected function parseChannelUser(array $jsonAry)
	{
		$info = new PlurkChannelUserInfo();
		$info->channelName	= (string)$jsonAry[PlurkChannelUserInfo::KEY_CHANNEL_NAME];
		$info->cometServer	= (string)$jsonAry[PlurkChannelUserInfo::KEY_COMET_SERVER];
		return $info;
	}
	
	/**
	 * Parse the collections by JSON.
	 *
	 * @param	array	$jsonAry	A JSON decoded array.
	 * @return	PlurkCollectionInfo	Returns a PlurkCollectionInfo object.
	 */
	protected function parseCollections(array $jsonAry)
	{
		$collections = array();
		
		foreach($jsonAry as $collection)
		{
			$info = new PlurkCollectionInfo();
			$info->name = $collection[0];
			$info->langCodes = explode(',', $collection[1]);
			$info->displayName = $collection[2];
			$collections[] = $info;
		}
		
		return $collections;
	}

	/**
	 * Parse all emoticons by JSON.
	 *
	 * @param	array	$jsonAry	A JSON decoded array.
	 * @return	PlurkEmoticonsInfo	Returns a PlurkEmoticonsInfo object.
	 */
	protected function parseEmoticons(array $jsonAry)
	{
		$info = new PlurkEmoticonsInfo();
		$info->karma	= $this->parseEmoticon($jsonAry[PlurkEmoticonsInfo::KEY_KARMA]);
		$info->recuited	= $this->parseEmoticon($jsonAry[PlurkEmoticonsInfo::KEY_RECUITED]);
		return $info;
	}
	
	/**
	 * Parse all emoticons by JSON.
	 *
	 * @param	array	$jsonAry	A JSON decoded array.
	 * @return	PlurkKarmaInfo		Returns a PlurkKarmaInfo object.
	 */
	protected function parseKarma(array $jsonAry)
	{
		$info = new PlurkKarmaInfo();
		$info->karmaFallReason	= (string)$jsonAry[PlurkKarmaInfo::KEY_KARMA_FALL_REASON];
		$info->currentKarma		= (float)$jsonAry[PlurkKarmaInfo::KEY_CURRENT_KARMA];
		$info->karmaGraph		= (string)$jsonAry[PlurkKarmaInfo::KEY_KARMA_GRAPH];
		$info->karmaTrend		= $jsonAry[PlurkKarmaInfo::KEY_KARMA_TREND];
		return $info;
	}

	/**
	 * Parse a picture by JSON.
	 *
	 * @param	array	$jsonAry	A JSON decoded array.
	 * @return	PlurkPictureInfo	Returns a PlurkPictureInfo object.
	 */
	protected function parsePicture(array $jsonAry)
	{
		$info = new PlurkPictureInfo();
		$info->full			= (string)$jsonAry[PlurkPictureInfo::KEY_FULL];
		$info->thumbnail	= (string)$jsonAry[PlurkPictureInfo::KEY_THUMBNAIL];
		return $info;
	}

	/**
	 * Parse a plurk by JSON.
	 *
	 * @param	array	$jsonAry	A JSON decoded array.
	 * @return	PlurkPlurkInfo		Returns a PlurkPlurkInfo object.
	 */
	protected function parsePlurk(array $jsonAry)
	{
		$plurkAry	= (isset($jsonAry[PlurkPlurkInfo::KEY_PLURK]))
		? $jsonAry[PlurkPlurkInfo::KEY_PLURK] : $jsonAry;

		$info = new PlurkPlurkInfo();
		$info->content				= (string)$plurkAry[PlurkPlurkInfo::KEY_CONTENT];
		$info->contentRaw			= (int)$plurkAry[PlurkPlurkInfo::KEY_CONTENT_RAW];
		$info->entryPosted			= (string)$plurkAry[PlurkPlurkInfo::KEY_ENTRY_POSTED];
		$info->favorers				= $plurkAry[PlurkPlurkInfo::KEY_FAVORERS];
		$info->favoriteCount		= (int)$plurkAry[PlurkPlurkInfo::KEY_FAVORITE_COUNT];
		$info->isUnread				= (int)$plurkAry[PlurkPlurkInfo::KEY_IS_UNREAD];
		$info->lang					= (string)$plurkAry[PlurkPlurkInfo::KEY_LANG];
		$info->limitedTo			= (array)$plurkAry[PlurkPlurkInfo::KEY_LIMITED_TO];
		$info->noComments			= (int)$plurkAry[PlurkPlurkInfo::KEY_NO_COMMENTS];
		$info->ownerId				= (int)$plurkAry[PlurkPlurkInfo::KEY_OWNER_ID];
		$info->plurkId				= (int)$plurkAry[PlurkPlurkInfo::KEY_PLURK_ID];
		$info->plurkType			= (int)$plurkAry[PlurkPlurkInfo::KEY_PLURK_TYPE];
		$info->posted				= new DateTime($plurkAry[PlurkPlurkInfo::KEY_POSTED]);
		$info->posterUid			= (int)$plurkAry[PlurkPlurkInfo::KEY_POSTER_UID];
		$info->qualifier			= (string)$plurkAry[PlurkPlurkInfo::KEY_QUALIFIER];
		$info->qualifierTranslated	= (string)$plurkAry[PlurkPlurkInfo::KEY_QUALIFIER_TRANSLATED];
		$info->replurkers			= $plurkAry[PlurkPlurkInfo::KEY_REPLURKERS];
		$info->replurkersCount		= (int)$plurkAry[PlurkPlurkInfo::KEY_REPLURKERS_COUNT];
		$info->responseCount		= (int)$plurkAry[PlurkPlurkInfo::KEY_RESPONSE_COUNT];
		$info->responsesSeen		= (int)$plurkAry[PlurkPlurkInfo::KEY_RESPONSES_SEEN];
		$info->score				= (float)$plurkAry[PlurkPlurkInfo::KEY_SCORE];
		$info->userId				= (int)$plurkAry[PlurkPlurkInfo::KEY_USER_ID];
		$info->voteDown				= (int)$plurkAry[PlurkPlurkInfo::KEY_VOTE_DOWN];
		$info->voteUp				= (int)$plurkAry[PlurkPlurkInfo::KEY_VOTE_UP];
		$info->voteUser				= (int)$plurkAry[PlurkPlurkInfo::KEY_VOTE_USER];
		$info->id					= (int)$plurkAry[PlurkPlurkInfo::KEY_ID];
		return $info;
	}

	/**
	 * Parse plurks by JSON.
	 *
	 * @param	array	$jsonAry	A JSON decoded array.
	 * @return	array				Returns an array of PlurkPlurkInfo object.
	 */
	protected function parsePlurks(array $jsonAry)
	{
		$plurks = array();

		if(!empty($jsonAry))
		{
			foreach($jsonAry as $plurk)
			{
				$plurks[] = $this->parsePlurk($plurk);
			}
		}

		return $plurks;
	}

	/**
	 * Parse the relationship of plurks and users by JSON.
	 *
	 * @param	array	$jsonAry		A JSON decoded array.
	 * @return	PlurkPlurksUsersInfo	Returns a PlurkPlurksUsersInfo object.
	 */
	protected function parsePlurksUsers(array $jsonAry)
	{
		$info = new PlurkPlurksUsersInfo();
		$info->plurkUsers	= $this->parseUsers($jsonAry[PlurkPlurksUsersInfo::KEY_PLURK_USERS]);
		$info->plurks		= $this->parsePlurks($jsonAry[PlurkPlurksUsersInfo::KEY_PLURKS]);
		return $info;
	}
	
	/**
	 * Parse the relationship of plurks and users and offset by JSON.
	 *
	 * @param	array	$jsonAry			A JSON decoded array.
	 * @return	PlurkPlurksUsersOffsetInfo	Returns a PlurkPlurksUsersOffsetInfo object.
	 */
	protected function parsePlurksUsersOffset(array $jsonAry)
	{
		$info = new PlurkPlurksUsersOffsetInfo();
		$info->plurkUsers	= $this->parseUsers($jsonAry[PlurkPlurksUsersOffsetInfo::KEY_PLURK_USERS]);
		$info->plurks		= $this->parsePlurks($jsonAry[PlurkPlurksUsersOffsetInfo::KEY_PLURKS]);
		$info->offset		= $jsonAry[PlurkPlurksUsersOffsetInfo::KEY_OFFSET];
		return $info;
	}

	/**
	 * Parse a profile by JSON.
	 *
	 * @param	array	$jsonAry	A JSON decoded array.
	 * @return	PlurkProfileInfo	Returns a PlurkProfileInfo object.
	 */
	protected function parseProfile(array $jsonAry)
	{
		$info = new PlurkProfileInfo();
		$info->areFriends			= (bool)$jsonAry[PlurkProfileInfo::KEY_ARE_FRIENDS];
		$info->fansCount			= (int)$jsonAry[PlurkProfileInfo::KEY_FANS_COUNT];
		$info->friendsCount			= (int)$jsonAry[PlurkProfileInfo::KEY_FRIENDS_COUNT];
		$info->hasReadPermission	= (bool)$jsonAry[PlurkProfileInfo::KEY_HAS_READ_PERMISSION];
		$info->isFan				= (bool)$jsonAry[PlurkProfileInfo::KEY_IS_FAN];
		$info->isFollowing			= (bool)$jsonAry[PlurkProfileInfo::KEY_IS_FOLLOWING];
		$info->plurks				= $this->parsePlurks($jsonAry[PlurkProfileInfo::KEY_PLURKS]);
		$info->privacy				= (int)$jsonAry[PlurkProfileInfo::KEY_PRIVACY];
		$info->userInfo				= $this->parseUser($jsonAry[PlurkProfileInfo::KEY_USER_INFO]);
		return $info;
	}

	/**
	 * Parse a plurk response by JSON.
	 *
	 * @param	array	$jsonAry	A JSON decoded array.
	 * @return	PlurkResponseInfo	Returns a PlurkResponseInfo object.
	 */
	protected function parseResponse(array $jsonAry)
	{
		$info = new PlurkResponseInfo();
		$info->friends			= $this->parseUsers($jsonAry[PlurkResponseInfo::KEY_FRIENDS]);
		$info->responsesSeen	= (int)$jsonAry[PlurkResponseInfo::KEY_RESPONSES_SEEN];
		$info->responses		= $this->parsePlurks($jsonAry[PlurkResponseInfo::KEY_RESPONSES]);
		return $info;
	}

	/**
	 * Parse plurk search result by JSON.
	 *
	 * @param	array	$jsonAry		A JSON decoded array.
	 * @return	PlurkPlurkSearchInfo	Returns a PlurkPlurkSearchInfo object.
	 */
	protected function parseSearchPlurk(array $jsonAry)
	{
		$info = new PlurkPlurkSearchInfo();
		$info->hasMore		= (bool)$jsonAry[PlurkPlurkSearchInfo::KEY_HAS_MORE];
		$info->error		= $jsonAry[PlurkPlurkSearchInfo::KEY_ERROR];
		$info->lastOffset	= (int)$jsonAry[PlurkPlurkSearchInfo::KEY_LAST_OFFSET];
		$info->users		= $this->parseUsers($jsonAry[PlurkPlurkSearchInfo::KEY_USERS]);
		$info->plurks		= $this->parsePlurks($jsonAry[PlurkPlurkSearchInfo::KEY_PLURKS]);
		return $info;
	}

	/**
	 * Parse user search result by JSON.
	 *
	 * @param	array	$jsonAry	A JSON decoded array.
	 * @return	PlurkUserSearchInfo	Returns a PlurkUserSearchInfo object.
	 */
	protected function parseSearchUser(array $jsonAry)
	{
		$info = new PlurkUserSearchInfo();
		$info->counts	= (int)$jsonAry[PlurkUserSearchInfo::KEY_COUNTS];
		$info->users	= $this->parseUsers($jsonAry[PlurkUserSearchInfo::KEY_USERS]);
		return $info;
	}

	/**
	 * Parse the success text by JSON.
	 *
	 * @param	array	$jsonAry	A JSON decoded array.
	 * @return	bool				Returns TRUE on success or FALSE on failure.
	 */
	protected function parseSuccessText(array $jsonAry)
	{
		return (strcmp($jsonAry['success_text'], 'ok') == 0);
	}

	/**
	 * Parse the unread count by JSON.
	 *
	 * @param	array	$jsonAry		A JSON decoded array.
	 * @return	PlurkUnreadCountInfo	Returns a PlurkUnreadCountInfo object.
	 */
	protected function parseUnreadCount(array $jsonAry)
	{
		$info = new PlurkUnreadCountInfo();
		$info->all			= (int)$jsonAry[PlurkUnreadCountInfo::KEY_ALL];
		$info->my			= (int)$jsonAry[PlurkUnreadCountInfo::KEY_MY];
		$info->responded	= (int)$jsonAry[PlurkUnreadCountInfo::KEY_RESPONDED];
		$info->private		= (int)$jsonAry[PlurkUnreadCountInfo::KEY_PRIVATE];
		return $info;
	}

	/**
	 * Parse a user by JSON.
	 *
	 * @param	array	$jsonAry	A JSON decoded array.
	 * @return	PlurkUserInfo		Returns a PlurkUserInfo object.
	 */
	protected function parseUser(array $jsonAry)
	{
		$info = new PlurkUserInfo();
		$info->avatar			= (int)$jsonAry[PlurkUserInfo::KEY_AVATAR];
		$info->dateOfBirth		= new DateTime($jsonAry[PlurkUserInfo::KEY_DATE_OF_BIRTH]);
		$info->displayName		= (string)$jsonAry[PlurkUserInfo::KEY_DISPLAY_NAME];
		$info->emailConfirmed	= (boolean)$jsonAry[PlurkUserInfo::KEY_EMAIL_CONFIRMED];
		$info->fullName			= (string)$jsonAry[PlurkUserInfo::KEY_FULL_NAME];
		$info->gender			= (int)$jsonAry[PlurkUserInfo::KEY_GENDER];
		$info->hasProfileImage	= (int)$jsonAry[PlurkUserInfo::KEY_HAS_PROFILE_IMAGE];
		$info->id				= (int)$jsonAry[PlurkUserInfo::KEY_ID];
		$info->isPremium		= (boolean)$jsonAry[PlurkUserInfo::KEY_IS_PREMIUM];
		$info->karma			= (double)$jsonAry[PlurkUserInfo::KEY_KARMA];
		$info->location			= (string)$jsonAry[PlurkUserInfo::KEY_LOCATION];
		$info->nickName			= (string)$jsonAry[PlurkUserInfo::KEY_NICK_NAME];
		$info->recruited		= (int)$jsonAry[PlurkUserInfo::KEY_RECRUITED];
		$info->relationship		= (string)$jsonAry[PlurkUserInfo::KEY_RELATIONSHIP];
		$info->timezone			= (string)$jsonAry[PlurkUserInfo::KEY_TIMEZONE];
		$info->uid				= (int)$jsonAry[PlurkUserInfo::KEY_UID];
		return $info;
	}

	/**
	 * Parse users by JSON.
	 *
	 * @param	array	$jsonAry	A JSON decoded array.
	 * @return	array				Returns an array of PlurkUserInfo object.
	 */
	protected function parseUsers(array $jsonAry)
	{
		$users = array();

		if(!empty($jsonAry))
		{
			foreach($jsonAry as $user)
			{
				$users[] = $this->parseUser($user);
			}
		}

		return $users;
	}

	// ------------------------------------------------------------------------------------------------------ //
}
?>