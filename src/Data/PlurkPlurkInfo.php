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

class PlurkPlurkInfo
{
	const TYPE_PUBLIC = 0;
	const TYPE_PRIVATE = 1;
	const TYPE_PUBLIC_RESPONDED = 2;
	const TYPE_PRIVATE_RESPONDED = 3;
	
	const READ_TYPE_READ = 0;
	const READ_TYPE_UNREAD = 1;
	const READ_TYPE_MUTED = 2;
	
	const KEY_CONTENT = 'content';
	const KEY_CONTENT_RAW = 'content_raw';
	const KEY_ENTRY_POSTED = 'entry_posted';
	const KEY_FAVORERS = 'favorers';
	const KEY_FAVORITE_COUNT = 'favorite_count';
	const KEY_IS_UNREAD = 'is_unread';
	const KEY_LANG = 'lang';
	const KEY_LIMITED_TO = 'limited_to';
	const KEY_NO_COMMENTS = 'no_comments';
	const KEY_OWNER_ID = 'owner_id';
	const KEY_PLURK = 'plurk';
	const KEY_PLURK_ID = 'plurk_id';
	const KEY_PLURK_TYPE = 'plurk_type';
	const KEY_POSTED = 'posted';
	const KEY_POSTER_UID = 'poster_uid';
	const KEY_QUALIFIER = 'qualifier';
	const KEY_QUALIFIER_TRANSLATED = 'qualifier_translated';
	const KEY_REPLURKERS = 'replurkers';
	const KEY_REPLURKERS_COUNT = 'replurkers_count';
	const KEY_RESPONSE_COUNT = 'response_count';
	const KEY_RESPONSES_SEEN = 'responses_seen';
	const KEY_SCORE = 'score';
	const KEY_USER_ID = 'user_id';
	const KEY_VOTE_DOWN = 'vote_down';
	const KEY_VOTE_UP = 'vote_up';
	const KEY_VOTE_USER = 'vote_user';
	
	// Response only
	const KEY_ID = 'id';
	
	public $content;
	public $contentRaw;
	public $entryPosted;
	public $favorers;
	public $favoriteCount;
	public $isUnread;
	public $lang;
	public $limitedTo;
	public $noComments;
	public $ownerId;
	public $plurkId;
	public $plurkType;
	public $posted;
	public $posterUid;
	public $qualifier;
	public $qualifierTranslated;
	public $replurkers;
	public $replurkersCount;
	public $responseCount;
	public $responsesSeen;
	public $score;
	public $userId;
	public $voteDown;
	public $voteUp;
	public $voteUser;
	
	/**
	 * Uses for response only. It is a response ID.
	 * 
	 * @var	float
	 */
	public $id;
}
?>