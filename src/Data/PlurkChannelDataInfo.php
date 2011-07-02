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

class PlurkChannelDataInfo
{
	const KEY_LANG = 'lang';
	const KEY_CONTENT = 'content';
	const KEY_CONTENT_RAW = 'content_raw';
	const KEY_USER_ID = 'user_id';
	const KEY_PLURK_TYPE = 'plurk_type';
	const KEY_PLURK_ID = 'plurk_id';
	const KEY_TYPE = 'type';
	const KEY_RESPONSE_COUNT = 'response_count';
	const KEY_FAVORITE = 'favorite';
	const KEY_QUALIFIER = 'qualifier';
	const KEY_ID = 'id';
	const KEY_IS_UNREAD = 'is_unread';
	const KEY_RESPONSES_SEEN = 'responses_seen';
	const KEY_POSTED = 'posted';
	const KEY_LIMITED_TO = 'limited_to';
	const KEY_NO_COMMENTS = 'no_comments';
	const KEY_FAVORITE_COUNT = 'favorite_count';
	const KEY_OWNER_ID = 'owner_id';
	const KEY_CID = '_cid';
	const KEY_RESPONSE = 'response';
	const KEY_USER = 'user';
	
	public $lang;
	public $content;
	public $content_raw;
	public $user_id;
	public $plurk_type;
	public $plurk_id;
	public $type;
	public $response_count;
	public $favorite;
	public $qualifier;
	public $id;
	public $is_unread;
	public $responses_seen;
	public $posted;
	public $limited_to;
	public $no_comments;
	public $favorite_count;
	public $owner_id;
	public $cid;
	public $response;
	public $user;
}
?>