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

require_once('API/main.php');
require_once('Setting/main.php');
require_once('PlurkContext.php');
require_once('PlurkException.php');

/**
 * An application of using Plurk API.
 */
class PlurkApp
{
	// ------------------------------------------------------------------------------------------------------ //
	
	/**
	 * API key for the Plurk API.
	 * 
	 * @var	string
	 */
	private $_apiKey;
	
	/**
	 * The path of cookie files.
	 * 
	 * @var	string
	 */
	private $_cookiePath;
	
	/**
	 * Error message of the response.
	 * 
	 * @var	string
	 */
	private $_errMsg;
	
	/**
	 * 
	 * @var	PlurkStrategy
	 */
	private $_strategy;
	
	// ------------------------------------------------------------------------------------------------------ //
	
	/**
	 * Sets the path Cookie file. It must be set if the method requires login.
	 * Note that it will overwirte the exist file with same name.
	 *
	 * @param	string	$cookiePath	The path of cookie files.
	 */
	public function setCookiePath($cookiePath)
	{
		$this->_cookiePath = $cookiePath;
	}
	
	/**
	 * Sets the Plurk API key.
	 *
	 * @param	string	$apiKey	Your Plurk API key.
	 */
	public function setApiKey($apiKey)
	{
		$this->_apiKey = $apiKey;
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
	
	// ------------------------------------------------------------------------------------------------------ //
	// Alerts
	
	/**
	 * Return a list of current active alerts.
	 * P.S. requires login
	 *
	 * @return	mixed	Returns an array of PlurkAlertInfo object on success or FALSE on failure.
	 */
	public function getActive()
	{
		$setting = new PlurkAlertsSetting();
		$setting->type = PlurkAlertsSetting::TYPE_GET_ACTIVE;
		
		$this->_strategy = new PlurkAlerts($setting);
		return $this->execute();
	}
	
	/**
	 * Return a list of past 30 alerts.
	 * P.S. requires login
	 *
	 * @return	mixed	Returns an array of PlurkAlertInfo object on success or FALSE on failure.
	 */
	public function getHistory()
	{
		$setting = new PlurkAlertsSetting();
		$setting->type = PlurkAlertsSetting::TYPE_GET_HISTORY;
		
		$this->_strategy = new PlurkAlerts($setting);
		return $this->execute();
	}
	
	/**
	 * Accept a user as fan.
	 * P.S. requires login
	 *
	 * @param	int	$userId	The user ID that has asked for friendship.
	 * @return	bool		Returns TRUE on success or FALSE on failure.
	 */
	public function addAsFan($userId)
	{
		$setting = new PlurkAlertsSetting();
		$setting->type = PlurkAlertsSetting::TYPE_ADD_AS_FAN;
		$setting->userId = $userId;
		
		$this->_strategy = new PlurkAlerts($setting);
		return $this->execute();
	}
	
	/**
	 * Accept all friendship requests as fans.
	 * P.S. requires login
	 *
	 * @return	bool	Returns TRUE on success or FALSE on failure.
	 */
	public function addAllAsFan()
	{
		$setting = new PlurkAlertsSetting();
		$setting->type = PlurkAlertsSetting::TYPE_ADD_ALL_AS_FAN;
		
		$this->_strategy = new PlurkAlerts($setting);
		return $this->execute();
	}
	
	/**
	 * Accept all friendship requests as friends.
	 * P.S. requires login
	 *
	 * @return	bool	Returns TRUE on success or FALSE on failure.
	 */
	public function addAllAsFriends()
	{
		$setting = new PlurkAlertsSetting();
		$setting->type = PlurkAlertsSetting::TYPE_ADD_ALL_AS_FRIENDS;
		
		$this->_strategy = new PlurkAlerts($setting);
		return $this->execute();
	}
	
	/**
	 * Accept a user as friend.
	 * P.S. requires login
	 *
	 * @param	int	$userId	The user ID that has asked for friendship.
	 * @return	bool		Returns TRUE on success or FALSE on failure.
	 */
	public function addAsFriend($userId)
	{
		$setting = new PlurkAlertsSetting();
		$setting->type = PlurkAlertsSetting::TYPE_ADD_AS_FRIEND;
		$setting->userId = $userId;
		
		$this->_strategy = new PlurkAlerts($setting);
		return $this->execute();
	}
	
	/**
	 * Deny friendship to user.
	 * P.S. requires login
	 *
	 * @param	int	$userId	The user ID that has asked for friendship.
	 * @return	bool		Returns TRUE on success or FALSE on failure.
	 */
	public function denyFriendship($userId)
	{
		$setting = new PlurkAlertsSetting();
		$setting->type = PlurkAlertsSetting::TYPE_DENY_FRIENDSHIP;
		$setting->userId = $userId;
		
		$this->_strategy = new PlurkAlerts($setting);
		return $this->execute();
	}
	
	/**
	 * Remove notification to user with id.
	 * P.S. requires login
	 *
	 * @param	int	$userId	The user ID that the current user has requested friendship for.
	 * @return	bool		Returns TRUE on success or FALSE on failure.
	 */
	public function removeNotification($userId)
	{
		$setting = new PlurkAlertsSetting();
		$setting->type = PlurkAlertsSetting::TYPE_REMOVE_NOTIFICATION;
		$setting->userId = $userId;
		
		$this->_strategy = new PlurkAlerts($setting);
		return $this->execute();
	}
	
	// ------------------------------------------------------------------------------------------------------ //
	// Blocks
	
	/**
	 * Gets a list of users that are blocked by the current user.
	 * P.S. requires login
	 *
	 * @param	int	offset	What page should be shown, e.g. 0, 10, 20.
	 * @return	mixed		Returns a PlurkBlockInfo object on success or FALSE on failure.
	 */
	public function get($offset = 0)
	{
		$setting = new PlurkBlocksSetting();
		$setting->type = PlurkBlocksSetting::TYPE_GET;
		$setting->offset = (int)$offset;
		
		$this->_strategy = new PlurkBlocks($setting);
		return $this->execute();
	}
	
	/**
	 * Blocks a user.
	 * P.S. requires login
	 *
	 * @param	int	$userId	The id of the user that should be blocked.
	 * @return	bool		Returns TRUE on success or FALSE on failure.
	 */
	public function block($userId)
	{
		$setting = new PlurkBlocksSetting();
		$setting->type = PlurkBlocksSetting::TYPE_BLOCK;
		$setting->userId = $userId;
		
		$this->_strategy = new PlurkBlocks($setting);
		return $this->execute();
	}
	
	/**
	 * Unblocks a user.
	 * P.S. requires login
	 *
	 * @param	int	$userId	The id of the user that should be unblocked.
	 * @return	bool		Returns TRUE on success or FALSE on failure.
	 */
	public function unblock($userId)
	{
		$setting = new PlurkBlocksSetting();
		$setting->type = PlurkBlocksSetting::TYPE_UNBLOCK;
		$setting->userId = $userId;
		
		$this->_strategy = new PlurkBlocks($setting);
		return $this->execute();
	}
	
	// ------------------------------------------------------------------------------------------------------ //
	// Cliques
	
	/**
	 * Gets user's current cliques.
	 * P.S. requires login
	 *
	 * @return	mixed	Returns an array of the name of users current cliques or FALSE on failure.
	 */
	public function getCliques()
	{
		$setting = new PlurkCliquesSetting();
		$setting->type = PlurkCliquesSetting::TYPE_GET_CLIQUES;
		
		$this->_strategy = new PlurkCliques($setting);
		return $this->execute();
	}
	
	/**
	 * Gets the users in the clique.
	 * P.S. requires login
	 *
	 * @param	string	$cliqueName	The name of the clique.
	 * @return	mixed	Returns an array of PlurkUserInfo object on success or FALSE on failure.
	 */
	public function getClique($cliqueName)
	{
		$setting = new PlurkCliquesSetting();
		$setting->type = PlurkCliquesSetting::TYPE_GET_CLIQUE;
		$setting->cliqueName = $cliqueName;
		
		$this->_strategy = new PlurkCliques($setting);
		return $this->execute();
	}
	
	/**
	 * Creates a new clique.
	 * P.S. requires login
	 *
	 * @param	string	$cliqueName	The name of the new clique.
	 * @return	bool				Returns TRUE on success or FALSE on failure.
	 */
	public function createClique($cliqueName)
	{
		$setting = new PlurkCliquesSetting();
		$setting->type = PlurkCliquesSetting::TYPE_CREATE_CLIQUE;
		$setting->cliqueName = $cliqueName;
		
		$this->_strategy = new PlurkCliques($setting);
		return $this->execute();
	}
	
	/**
	 * Renames a clique.
	 * P.S. requires login
	 *
	 * @param	string	$cliqueName	The name of the clique to rename.
	 * @param	string	$newName	The new name of the clique.
	 * @return	bool				Returns TRUE on success or FALSE on failure.
	 */
	public function renameClique($cliqueName, $newName)
	{
		$setting = new PlurkCliquesSetting();
		$setting->type = PlurkCliquesSetting::TYPE_RENAME_CLIQUE;
		$setting->cliqueName = $cliqueName;
		$setting->newName = $newName;
		
		$this->_strategy = new PlurkCliques($setting);
		return $this->execute();
	}
	
	/**
	 * Adds a user to the clique.
	 * P.S. requires login
	 *
	 * @param	string	$cliqueName	The name of the clique.
	 * @param	int		$userId		The user to add to the clique.
	 * @return	bool				Returns TRUE on success or FALSE on failure.
	 */
	public function add($cliqueName, $userId)
	{
		$setting = new PlurkCliquesSetting();
		$setting->type = PlurkCliquesSetting::TYPE_ADD;
		$setting->cliqueName = $cliqueName;
		$setting->userId = $userId;
		
		$this->_strategy = new PlurkCliques($setting);
		return $this->execute();
	}
	
	/**
	 * Removes a user from the clique.
	 * P.S. requires login
	 *
	 * @param	string	$cliqueName	The name of the clique.
	 * @param	int		$userId		The user to remove from the clique.
	 * @return	bool				Returns TRUE on success or FALSE on failure.
	 */
	public function remove($cliqueName, $userId)
	{
		$setting = new PlurkCliquesSetting();
		$setting->type = PlurkCliquesSetting::TYPE_REMOVE;
		$setting->cliqueName = $cliqueName;
		$setting->userId = $userId;
		
		$this->_strategy = new PlurkCliques($setting);
		return $this->execute();
	}
	
	// ------------------------------------------------------------------------------------------------------ //
	// Emoticons
	
	/**
	 * Emoticons are a big part of Plurk since they make it easy to express feelings.
	 *
	 * @return	mixed	Returns a PlurkEmoticonsInfo object on success or FALSE on failure.
	 * @link	http://www.plurk.com/Help/extraSmilies
	 */
	public function getEmoticons()
	{
		$setting = new PlurkEmoticonsSetting();
		$setting->type = PlurkEmoticonsSetting::TYPE_GET;
		
		$this->_strategy = new PlurkEmoticons($setting);
		return $this->execute();
	}
	
	// ------------------------------------------------------------------------------------------------------ //
	// Friends and fans
	
	/**
	 * Returns user's friend list in chucks of 10 friends at a time.
	 *
	 * @param	int		$userId	Must be integer (like 34), DO NOT use nick name (like amix).
	 * @param	int		$offset	The offset, can be 10, 20, 30 etc.
	 * @return	mixed	Returns an array of PlurkUserInfo object on success or FALSE on failure.
	 */
	public function getFriendsByOffset($userId, $offset = 0)
	{
		$setting = new PlurkFriendsFansSetting();
		$setting->type = PlurkFriendsFansSetting::TYPE_GET_FRIENDS_BY_OFFSET;
		$setting->userId = (int)$userId;
		$setting->offset = $offset;
		
		$this->_strategy = new PlurkFriendsFans($setting);
		return $this->execute();
	}
	
	/**
	 * Returns user's fans list in chucks of 10 fans at a time.
	 *
	 * @param	mixed	$userId	Must be integer (like 34), DO NOT use nick name (like amix).
	 * @param	int		$offset	The offset, can be 10, 20, 30 etc.
	 * @return	mixed	Returns an array of PlurkUserInfo object on success or FALSE on failure.
	 */
	public function getFansByOffset($userId, $offset = 0)
	{
		$setting = new PlurkFriendsFansSetting();
		$setting->type = PlurkFriendsFansSetting::TYPE_GET_FANS_BY_OFFSET;
		$setting->userId = $userId;
		$setting->offset = $offset;
		
		$this->_strategy = new PlurkFriendsFans($setting);
		return $this->execute();
	}
	
	/**
	 * Returns users that the current logged in user follows as fan - in chucks of 10 fans at a time.
	 * P.S. requires login
	 *
	 * @param	int		$offset	The offset, can be 10, 20, 30 etc.
	 * @return	mixed	Returns an array of PlurkUserInfo object on success or FALSE on failure.
	 */
	public function getFollowingByOffset($offset = 0)
	{
		$setting = new PlurkFriendsFansSetting();
		$setting->type = PlurkFriendsFansSetting::TYPE_GET_FOLLOWING_BY_OFFSET;
		$setting->offset = $offset;
		
		$this->_strategy = new PlurkFriendsFans($setting);
		return $this->execute();
	}
	
	/**
	 * Create a friend request to friend_id. User with friend_id has to accept a friendship.
	 * P.S. requires login
	 *
	 * @param	int		$friendId	The ID of the user you want to befriend.
	 * @return	bool				Returns TRUE on success or FALSE on failure.
	 */
	public function becomeFriend($friendId)
	{
		$setting = new PlurkFriendsFansSetting();
		$setting->type = PlurkFriendsFansSetting::TYPE_BECOME_FRIEND;
		$setting->friendId = $friendId;
		
		$this->_strategy = new PlurkFriendsFans($setting);
		return $this->execute();
	}
	
	/**
	 * Create a friend request to friend_id. User with friend_id has to accept a friendship.
	 * P.S. requires login
	 *
	 * @param	int		$friendId	The ID of the user you want to remove.
	 * @return	bool				Returns TRUE on success or FALSE on failure.
	 */
	public function removeAsFriend($friendId)
	{
		$setting = new PlurkFriendsFansSetting();
		$setting->type = PlurkFriendsFansSetting::TYPE_REMOVE_AS_FRIEND;
		$setting->friendId = $friendId;
		
		$this->_strategy = new PlurkFriendsFans($setting);
		return $this->execute();
	}
	
	/**
	 * Become fan. To stop being a fan of someone, use setFollowing().
	 * P.S. requires login
	 *
	 * @param	int		$fanId	The ID of the user you want to become fan of.
	 * @return	bool			Returns TRUE on success or FALSE on failure.
	 */
	public function becomeFan($fanId)
	{
		$setting = new PlurkFriendsFansSetting();
		$setting->type = PlurkFriendsFansSetting::TYPE_BECOME_FAN;
		$setting->fanId = $fanId;
		
		$this->_strategy = new PlurkFriendsFans($setting);
		return $this->execute();
	}
	
	/**
	 * Update following. A user can befriend someone, but can unfollow them. This request is also used to stop
	 * following someone as a fan.
	 * P.S. requires login
	 *
	 * @param	int		$userId	The ID of the user you want to follow/unfollow.
	 * @param	bool	$follow	TRUE if the user should be followed, and FALSE if the user should be unfollowed.
	 * @return	bool			Returns TRUE on success or FALSE on failure.
	 */
	public function setFollowing($userId, $follow)
	{
		$setting = new PlurkFriendsFansSetting();
		$setting->type = PlurkFriendsFansSetting::TYPE_SET_FOLLOWING;
		$setting->userId = $userId;
		$setting->follow = $follow;
		
		$this->_strategy = new PlurkFriendsFans($setting);
		return $this->execute();
	}
	
	/**
	 * Returns a JSON object of the logged in users friends (nick name and full name). This information can be
	 * used to construct auto-completion for private plurking. Notice that a friend list can be big, depending
	 * on how many friends a user has, so this list should be lazy-loaded in your application.
	 *
	 * @return	mixed	Returns an array of PlurkUserInfo object on success or FALSE on failure.
	 */
	public function getCompletion()
	{
		$setting = new PlurkFriendsFansSetting();
		$setting->type = PlurkFriendsFansSetting::TYPE_GET_COMPLETION;
		
		$this->_strategy = new PlurkFriendsFans($setting);
		return $this->execute();
	}
	
	// ------------------------------------------------------------------------------------------------------ //
	// Polling
	
	/**
	 * You should use this call to find out if there any new plurks posted to the user's timeline. It's much 
	 * more efficient than doing it with /API/Timeline/getPlurks, so please use it :)
	 * P.S. requires login
	 * 
	 * @param	mixed	$offset	Return plurks newer than $offset.  It can be a DataTime object or a string
	 * 							formatted as 2009-6-20T21:55:34.
	 * @param	int		$limit	How many plurks should be returned? Default is 50.
	 * @return	mixed			Returns a PlurkPlurksUsersInfo object on success or FALSE on failure.
	 */
	public function getPlurks($offset = 'now', $limit = 50)
	{
		$setting = new PlurkPollingSetting();
		$setting->type = PlurkPollingSetting::TYPE_GET_PLURKS;
		$setting->offset = $offset;
		$setting->limit = (int)$limit;
		
		$this->_strategy = new PlurkPolling($setting);
		return $this->execute();
	}
	
	/**
	 * Use this call to find out if there are unread plurks on a user's timeline.
	 * P.S. requires login
	 * 
	 * @return	mixed	Returns a PlurkUnreadCountInfo object on success or FALSE on failure.
	 */
	public function getUnreadCount()
	{
		$setting = new PlurkPollingSetting();
		$setting->type = PlurkPollingSetting::TYPE_GET_UNREAD_COUNT;
		
		$this->_strategy = new PlurkPolling($setting);
		return $this->execute();
	}
	
	// ------------------------------------------------------------------------------------------------------ //
	// Profile
	
	/**
	 * Returns data that's private for the currently logged in user. This can be used to construct a profile
	 * and render a timeline of the latest plurks.
	 * P.S. requires login
	 *
	 * @return	mixed	Returns a PlurkProfileInfo object on success or FALSE on failure.
	 */
	public function getOwnProfile()
	{
		$setting = new PlurkProfileSetting();
		$setting->type = PlurkProfileSetting::TYPE_GET_OWN_PROFILE;
		
		$this->_strategy = new PlurkProfile($setting);
		return $this->execute();
	}
	
	/**
	 * Fetches public information such as a user's public plurks and basic information. Fetches also if the
	 * current logged in user is following the user, are friends with or is a fan.
	 *
	 * @param	mixed	$userId	Can be integer (like 34) or nick name (like amix).
	 * @return	mixed	Returns a PlurkProfileInfo object on success or FALSE on failure.
	 */
	public function getPublicProfile($userId)
	{
		$setting = new PlurkProfileSetting();
		$setting->type = PlurkProfileSetting::TYPE_GET_PUBLIC_PROFILE;
		$setting->userId = $userId;
		
		$this->_strategy = new PlurkProfile($setting);
		return $this->execute();
	}
	
	// ------------------------------------------------------------------------------------------------------ //
	// Realtime
	
	/**
	 * Get instant notifications when there are new plurks and responses on a user's timeline. This is much more
	 * efficient and faster than polling so please use it!
	 * P.S. requires login
	 *
	 * @return	mixed	Returns a PlurkChannelUserInfo object on success or FALSE on failure.
	 */
	public function getUserChannel()
	{
		$setting = new PlurkRealtimeSetting();
		$setting->type = PlurkRealtimeSetting::TYPE_GET_USER_CHANNEL;
		
		$this->_strategy = new PlurkRealtime($setting);
		return $this->execute();
	}
	
	/**
	 * You'll get an URL from getUserChannel() and you do GET requests to this URL to get new data. Your request
	 * will sleep for about 50 seconds before returning a response if there is no new data added to your channel.
	 * You won't get notifications on responses that the logged in user adds, but you will get notifications for
	 * new plurks.
	 *
	 * @param	string	$serverUrl	You get this from PlurkChannelUserInfo::$_cometServer parameter.
	 * @param	string	$channel	You get this from PlurkChannelUserInfo::$_channelName parameter.
	 * @param	int		$offset		Only fetch new messages from a given offset. You'll get offset when a
	 * 								response is returned, it's returned as PlurkChannelCometInfo::$_newOffset.
	 * @return	mixed				Returns a PlurkChannelCometInfo object on success or FALSE on failure.
	 */
	public function getCometChannel($serverUrl, $channel, $offset = 0)
	{
		$setting = new PlurkRealtimeSetting();
		$setting->type = PlurkRealtimeSetting::TYPE_GET_COMET_CHANNEL;
		$setting->serverUrl = $serverUrl;
		$setting->channel = $channel;
		$setting->offset = $offset;
		
		$this->_strategy = new PlurkRealtime($setting);
		return $this->execute();
	}
	
	// ------------------------------------------------------------------------------------------------------ //
	// Responses
	
	/**
	 * Fetches responses for plurk with plurk id and some basic info about the users.
	 *  
	 * @param	int	$plurkId		The plurk that the responses belong to. 
	 * @param	int	$fromResponse	Only fetch responses from an offset - could be 5, 10 or 15.
	 * @return	mixed				Returns a PlurkResponseInfo object on success or FALSE on failure.
	 */
	public function getResponses($plurkId, $fromResponse = 0)
	{
		$setting = new PlurkResponsesSetting();
		$setting->type = PlurkResponsesSetting::TYPE_GET;
		$setting->plurkId = (int)$plurkId;
		$setting->fromResponse = (int)$fromResponse;
		
		$this->_strategy = new PlurkResponses($setting);
		return $this->execute();
	}
	
	/**
	 * Adds a response. Language is inherited from the plurk.
	 * P.S. requires login
	 * 
	 * @param	string	$plurkId	The plurk that the responses should be added to. 
	 * @param	string	$content	The response's text.
	 * @param	string	$qualifier	The Plurk's qualifier, e.g. PlurkQualifier::QUALIFIER_SAYS.
	 * @return	mixed				Returns a PlurkPlurkInfo object on success or FALSE on failure.
	 * @see	PlurkQualifier
	 */
	public function responseAdd($plurkId, $content, $qualifier)
	{
		$setting = new PlurkResponsesSetting();
		$setting->type = PlurkResponsesSetting::TYPE_RESPONSE_ADD;
		$setting->plurkId = (int)$plurkId;
		$setting->content = $content;
		$setting->qualifier = $qualifier;
		
		$this->_strategy = new PlurkResponses($setting);
		return $this->execute();
	}
	
	/**
	 * Deletes a response. A user can delete own responses or responses that are posted to own plurks.
	 * P.S. requires login
	 * 
	 * @param	int	$responseId	The id of the response to delete. 
	 * @param	int	$plurkId	The plurk that the response belongs to.
	 * @return	bool			Returns TRUE on success or FALSE on failure.
	 */
	public function responseDelete($responseId, $plurkId)
	{
		$setting = new PlurkResponsesSetting();
		$setting->type = PlurkResponsesSetting::TYPE_RESPONSE_DELETE;
		$setting->responseId = (int)$responseId;
		$setting->plurkId = (int)$plurkId;
		
		$this->_strategy = new PlurkResponses($setting);
		return $this->execute();
	}
	
	// ------------------------------------------------------------------------------------------------------ //
	// Search
	
	/**
	 * Returns the latest 20 plurks on a search term.
	 *
	 * @param	string	$query	The query after Plurks.
	 * @param	int		$offset	A plurk ID of the oldest Plurk in the last search result.
	 * @return	mixed			Returns a PlurkPlurkSearchInfo object on success or FALSE on failure.
	 */
	public function searchPlurk($query, $offset = 0)
	{
		$setting = new PlurkSearchSetting();
		$setting->type = PlurkSearchSetting::TYPE_SEARCH_PLURK;
		$setting->query = (string)$query;
		$setting->offset = (int)$offset;
		
		$this->_strategy = new PlurkResponses($setting);
		return $this->execute();
	}
	
	/**
	 * Returns 10 users that match query, users are sorted by karma.
	 *
	 * @param	string	$query	The query after users.
	 * @param	int		$offset	Page offset, like 10, 20, 30 etc.
	 * @return	mixed			Returns a PlurkUserSearchInfo object on success or FALSE on failure.
	 */
	public function searchUser($query, $offset = 0)
	{
		$setting = new PlurkSearchSetting();
		$setting->type = PlurkSearchSetting::TYPE_SEARCH_USER;
		$setting->query = (string)$query;
		$setting->offset = (int)$offset;
		
		$this->_strategy = new PlurkResponses($setting);
		return $this->execute();
	}
	
	// ------------------------------------------------------------------------------------------------------ //
	// Timeline
	
	/**
	 * Gets a plurk.
	 * P.S. requires login
	 *
	 * @param	int	$plurkId	The unique id of the plurk. Should be passed as a number, and not base 36
	 * 							encoded.
	 * @return	mixed			Returns a PlurkPlurkInfo object on success or FALSE on failure.
	 */
	public function getPlurk($plurkId)
	{
		$setting = new PlurkTimelineSetting();
		$setting->type = PlurkTimelineSetting::TYPE_GET_PLURK;
		$setting->plurkId = (int)$plurkId;
		
		$this->_strategy = new PlurkTimeline($setting);
		return $this->execute();
	}
	
	/**
	 * Gets all the plurks and their owners' information.
	 * P.S. requires login
	 *
	 * @param	mixed	$offset	Returns plurks older than $offset. It can be a DataTime object or a string
	 * 							formatted as 2009-6-20T21:55:34.
	 * @param	int		$limit	How many plurks should be returned? Default is 20.
	 * @param	string	$filter	Can be PlurkTimelineSetting::FILTER_USER,
	 * 							PlurkTimelineSetting::FILTER_RESPONDED, PlurkTimelineSetting::FILTER_PRIVATE
	 * 							or PlurkTimelineSetting::FILTER_FAVRITE.
	 * @return	mixed			Returns a PlurkPlurksUsersInfo object on success or FALSE on failure.
	 */
	public function getPlurksWithFilter($offset = 'now', $limit = 20, $filter = NULL)
	{
		$setting = new PlurkTimelineSetting();
		$setting->type = PlurkTimelineSetting::TYPE_GET_PLURKS;
		$setting->offset = $offset;
		$setting->limit = (int)$limit;
		$setting->filter = $filter;
		
		$this->_strategy = new PlurkTimeline($setting);
		return $this->execute();
	}
	
	/**
	 * Gets all the unread plurks and their owners' information.
	 * P.S. requires login
	 *
	 * @param	mixed	$offset	Returns plurks older than offset. It can be a DataTime object or a string
	 * 							formatted as 2009-6-20T21:55:34.
	 * @param	int		$limit	How many plurks should be returned? Default is 20.
	 * @return	mixed			Returns a PlurkPlurksUsersInfo object on success or FALSE on failure.
	 */
	public function getUnreadPlurks($offset = 'now', $limit = 20)
	{
		$setting = new PlurkTimelineSetting();
		$setting->type = PlurkTimelineSetting::TYPE_GET_UNREAD_PLURKS;
		$setting->offset = $offset;
		$setting->limit = (int)$limit;
		
		$this->_strategy = new PlurkTimeline($setting);
		return $this->execute();
	}
	
	/**
	 * Adds a new plurk.
	 * P.S. requires login
	 *
	 * @param	string	$content		The Plurk's text.
	 * @param	string	$qualifier		The Plurk's qualifier, e.g. PlurkQualifier::QUALIFIER_SAYS.
	 * @param	array	$limitedTo		Limit the plurk only to some users (also known as private plurking). It
	 * 									should be an array of friend ids, e.g. limited_to of array(3,4,66,34)
	 * 									will only be plurked to these user ids. If it is array(0) then the
	 * 									Plurk is privatley posted to the poster's friends.
	 * @param	int		$noComments		If set to 1, then responses are disabled for this plurk. If set to 2,
	 * 									then only friends can respond to this plurk.
	 * @param	string	$lang			The plurk's language. e.g. PlurkTimelineSetting::LANG_EN
	 * @return	mixed					Returns a PlurkPlurkInfo object on success or FALSE on failure.
	 * @see	PlurkQualifier
	 */
	public function plurkAdd($content, $qualifier, array $limitedTo = NULL, $noComments = 0, $lang = NULL)
	{
		$setting = new PlurkTimelineSetting();
		$setting->type = PlurkTimelineSetting::TYPE_PLURK_ADD;
		$setting->content = $content;
		$setting->qualifier = $qualifier;
		$setting->limitedTo = $limitedTo;
		$setting->noComments = (int)$noComments;
		$setting->lang = $lang;
		
		$this->_strategy = new PlurkTimeline($setting);
		return $this->execute();
	}
	
	/**
	 * Deletes a plurk.
	 * P.S. requires login
	 *
	 * @param	int	$plurkId	The id of the plurk.
	 * @return	bool			Returns TRUE on success or FALSE on failure.
	 */
	public function plurkDelete($plurkId)
	{
		$setting = new PlurkTimelineSetting();
		$setting->type = PlurkTimelineSetting::TYPE_PLURK_DELETE;
		$setting->plurkId = $plurkId;
		
		$this->_strategy = new PlurkTimeline($setting);
		return $this->execute();
	}
	
	/**
	 * Edits a plurk.
	 * P.S. requires login
	 *
	 * @param	int		$plurkId	The id of the plurk.
	 * @param	string	$content	The content of plurk.
	 * @return	mixed				Returns a PlurkPlurkInfo object on success or FALSE on failure.
	 */
	public function plurkEdit($plurkId, $content)
	{
		$setting = new PlurkTimelineSetting();
		$setting->type = PlurkTimelineSetting::TYPE_PLURK_EDIT;
		$setting->plurkId = $plurkId;
		$setting->content = $content;
		
		$this->_strategy = new PlurkTimeline($setting);
		return $this->execute();
	}
	
	/**
	 * Mutes one or more plurks.
	 * P.S. requires login
	 *
	 * @param	array	$ids	The plurk ids, e.g. array(342,23242,2323)
	 * @return	bool			Returns TRUE on success or FALSE on failure.
	 */
	public function mutePlurks(array $ids)
	{
		$setting = new PlurkTimelineSetting();
		$setting->type = PlurkTimelineSetting::TYPE_MUTE_PLURKS;
		$setting->ids = $ids;
		
		$this->_strategy = new PlurkTimeline($setting);
		return $this->execute();
	}
	
	/**
	 * Unmutes one or more plurks.
	 * P.S. requires login
	 *
	 * @param	array	$ids	The plurk ids, e.g. array(342,23242,2323)
	 * @return	bool			Returns TRUE on success or FALSE on failure.
	 */
	public function unmutePlurks(array $ids)
	{
		$setting = new PlurkTimelineSetting();
		$setting->type = PlurkTimelineSetting::TYPE_UNMUTE_PLURKS;
		$setting->ids = $ids;
		
		$this->_strategy = new PlurkTimeline($setting);
		return $this->execute();
	}
	
	/**
	 * Favorites one or more plurks.
	 * P.S. requires login
	 *
	 * @param	array	$ids	The plurk ids, e.g. array(342,23242,2323)
	 * @return	bool			Returns TRUE on success or FALSE on failure.
	 */
	public function favoritePlurks(array $ids)
	{
		$setting = new PlurkTimelineSetting();
		$setting->type = PlurkTimelineSetting::TYPE_FAVORITE_PLURKS;
		$setting->ids = $ids;
		
		$this->_strategy = new PlurkTimeline($setting);
		return $this->execute();
	}
	
	/**
	 * Unfavorites one or more plurks.
	 * P.S. requires login
	 *
	 * @param	array	$ids	The plurk ids, e.g. array(342,23242,2323)
	 * @return	bool			Returns TRUE on success or FALSE on failure.
	 */
	public function unfavoritePlurks(array $ids)
	{
		$setting = new PlurkTimelineSetting();
		$setting->type = PlurkTimelineSetting::TYPE_UNFAVORITE_PLURKS;
		$setting->ids = $ids;
		
		$this->_strategy = new PlurkTimeline($setting);
		return $this->execute();
	}
	
	/**
	 * Marks one or more plurks as read.
	 * P.S. requires login
	 *
	 * @param	array	$ids	The plurk ids, e.g. array(342,23242,2323)
	 * @return	bool			Returns TRUE on success or FALSE on failure.
	 */
	public function markAsRead(array $ids)
	{
		$setting = new PlurkTimelineSetting();
		$setting->type = PlurkTimelineSetting::TYPE_MARK_AS_READ;
		$setting->ids = $ids;
		
		$this->_strategy = new PlurkTimeline($setting);
		return $this->execute();
	}
	
	/**
	 * Upload a picture.
	 * P.S. requires login
	 *
	 * @param	string	$imgPath	Path of the picture.
	 * @return	mixed				Returns a PlurkPictureInfo object on success or FALSE on failure.
	 */
	public function uploadPicture($imgPath)
	{
		$setting = new PlurkTimelineSetting();
		$setting->type = PlurkTimelineSetting::TYPE_UPLOAD_PICTURE;
		$setting->imgPath = $imgPath;
		
		$this->_strategy = new PlurkTimeline($setting);
		return $this->execute();
	}
	
	// ------------------------------------------------------------------------------------------------------ //
	// Users
	
	/**
	 * Register a new Plurk account.
	 *
	 * @param	string	$nickName	The user's nick name. Should be longer than 3 characters. Should be ASCII.
	 * 								Nick name can only contain letters, numbers and _.
	 * @param	string	$fullName	Can't be empty.
	 * @param	string	$password	Should be longer than 3 characters.
	 * @param	string	$gender		Should be GENDER_MALE or GENDER_FEMALE.
	 * @param	mxied	$dob		A DateTime or a string with format: YYYY-MM-DD, example 1985-05-13.
	 * @param	string	$email		Must be a valid email. (Optional)
	 * @return	mixed				Returns a PlurkProfileInfo object or TRUE on success, or FALSE on failure.
	 */
	public function register($nickName, $fullName, $password, $gender, $dob, $email = NULL)
	{
		$setting = new PlurkUsersSetting();
		$setting->type = PlurkUsersSetting::TYPE_REGISTER;
		$setting->nickName = $nickName;
		$setting->fullName = $fullName;
		$setting->password = $password;
		$setting->gender = $gender;
		$setting->dob = $dob;
		$setting->email = $email;
		
		$this->_strategy = new PlurkUsers($setting);
		return $this->execute();
	}
	
	/**
	 * Login an already created user. Login creates a session cookie, which can be used to access the other
	 * methods. On success it returns the data returned by /API/Profile/getOwnProfile.
	 *
	 * @param	string	$username	The user's nick name or email.
	 * @param	string	$password	The user's password.
	 * @param	bool	$noData		If it's set to TRUE then the common data is not returned. Use this if you
	 * 								only want to login the user and don't plan to use the data that's supplied
	 * 								by PlurkProfile::getOwnProfile(). (Optional)
	 * @return	mixed				Returns a PlurkProfileInfo object or TRUE on success, or FALSE on failure.
	 */
	public function login($username, $password, $noData = false)
	{
		$setting = new PlurkUsersSetting();
		$setting->type = PlurkUsersSetting::TYPE_LOGIN;
		$setting->username = $username;
		$setting->password = $password;
		$setting->noData = $noData;
		
		$this->_strategy = new PlurkUsers($setting);
		return $this->execute();
	}
	
	/**
	 * Logout Plurk.
	 */
	public function logout()
	{
		$setting = new PlurkUsersSetting();
		$setting->type = PlurkUsersSetting::TYPE_LOGOUT;
		
		$this->_strategy = new PlurkUsers($setting);
		return $this->execute();
	}
	
	/**
	 * Update a user's information (such as email, password or privacy).
	 * P.S. requires login
	 *
	 * @param	string	$password		User's current password.
	 * @param	string	$fullName		Change full name.
	 * @param	string	$newPassword	Change password.
	 * @param	string	$email			Change email.
	 * @param	string	$displayName	User's display name, can be empty and full unicode. Must be shorter
	 * 									than 15 characters.
	 * @param	string	$privacy		User's privacy settings. The option can be PRIVACY_WORLD,
	 * 									PRIVACY_ONLY_FRIENDS or PRIVACY_ONLY_ME.
	 * @param	mxied	$dob			A DateTime or a string with format: YYYY-MM-DD, example 1985-05-13.
	 * @return	PlurkUserInfo			Returns a PlurkUserInfo object on success, or FALSE on failure.
	 */
	public function update($password, $fullName = NULL, $newPassword = NULL, $email = NULL, $displayName = NULL,
		$privacy = NULL, $dob = NULL)
	{
		$setting = new PlurkUsersSetting();
		$setting->type = PlurkUsersSetting::TYPE_UPDATE;
		$setting->password = $password;
		$setting->fullName = $fullName;
		$setting->newPassword = $newPassword;
		$setting->email = $email;
		$setting->displayName = $displayName;
		$setting->privacy = $privacy;
		$setting->dob = $dob;
		
		$this->_strategy = new PlurkUsers($setting);
		return $this->execute();
	}
	
	/**
	 * Update a user's profile picture.
	 * P.S. requires login
	 *
	 * @param	string	$imgPath	Path of the picture. The picture will be scaled down to 3 versions: big,
	 * 								medium and small. The optimal size of profile_image should be 195x195
	 * 								pixels.
	 * @return	PlurkUserInfo		Returns a PlurkUserInfo object on success, or FALSE on failure.
	 */
	public function updatePicture($imgPath)
	{
		$setting = new PlurkUsersSetting();
		$setting->type = PlurkUsersSetting::TYPE_UPDATE_PIC;
		$setting->imgPath = $imgPath;
		
		$this->_strategy = new PlurkUsers($setting);
		return $this->execute();
	}
	
	/**
	 * Returns info about a user's karma, including current karma, karma growth, karma graph and the latest
	 * reason why the karma has dropped. 
	 */
	public function getKarmaStats()
	{
		$setting = new PlurkUsersSetting();
		$setting->type = PlurkUsersSetting::TYPE_GET_KARMA_STATS;
		
		$this->_strategy = new PlurkUsers($setting);
		return $this->execute();
	}
	
	// ------------------------------------------------------------------------------------------------------ //
	
	/**
	 * Execute the selected strategy.
	 * 
	 * @return	mixed	Returns an object on success, or FALSE on failure.
	 * @throws PlurkException	
	 */
	private function execute()
	{
		if(!($this->_strategy instanceof PlurkBase))
		{
			throw new PlurkException('Invalid strategy object.');
		}
		
		$this->_strategy->setApiKey($this->_apiKey);
		$this->_strategy->setCookiePath($this->_cookiePath);
		$context = new PlurkContext($this->_strategy);
		
		try
		{
			$result = $context->execute();
			
			if($result === false)
			{
				$this->_errMsg = $this->_strategy->getErrMsg();
			}
			
			return $result;
		}
		catch(PlurkException $ex)
		{
			$this->_errMsg = $ex->getMessage();
			return false;
		}
	}
	
	// ------------------------------------------------------------------------------------------------------ //
}
?>