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
 * @since		1.0
 */

require_once('PlurkSetting.php');

class PlurkTimelineSetting extends PlurkOAuthSetting
{
	const TYPE_GET_PLURK = 1;
	const TYPE_GET_PLURKS = 2;
	const TYPE_GET_UNREAD_PLURKS = 3;
	const TYPE_PLURK_ADD = 4;
	const TYPE_PLURK_DELETE = 5;
	const TYPE_PLURK_EDIT = 6;
	const TYPE_MUTE_PLURKS = 7;
	const TYPE_UNMUTE_PLURKS = 8;
	const TYPE_FAVORITE_PLURKS = 9;
	const TYPE_UNFAVORITE_PLURKS = 10;
	const TYPE_MARK_AS_READ = 11;
	const TYPE_UPLOAD_PICTURE = 12;
	const TYPE_GET_PUBLIC_PLURKS = 13;
	const TYPE_REPLURK = 14;
	const TYPE_UNREPLURK = 15;
	
	const PLURK_TYPE_USER = 'only_user';
	const PLURK_TYPE_RESPONDED = 'only_responded';
	const PLURK_TYPE_PRIVATE = 'only_private';
	const PLURK_TYPE_FAVRITE = 'only_favorite';
	
	const FILTER_ALL = 'all';
	const FILTER_MY = 'my';
	const FILTER_RESPONDED = 'responded';
	const FILTER_PRIVATE = 'private';
	const FILTER_FAVORITE = 'favorite';
	
	const LANG_EN = 'en';
	const LANG_PT_BR = 'pt_BR';
	const LANG_CN = 'cn';
	const LANG_CA = 'ca';
	const LANG_EL = 'el';
	const LANG_DK = 'dk';
	const LANG_DE = 'de';
	const LANG_ES = 'es';
	const LANG_SV = 'sv';
	const LANG_NB = 'nb';
	const LANG_HI = 'hi';
	const LANG_RO = 'ro';
	const LANG_HR = 'hr';
	const LANG_FR = 'fr';
	const LANG_RU = 'ru';
	const LANG_IT = 'it';
	const LANG_JA = 'ja';
	const LANG_HE = 'he';
	const LANG_HU = 'hu';
	const LANG_NE = 'ne';
	const LANG_TH = 'th';
	const LANG_TA_FP = 'ta_fp';
	const LANG_IN = 'in';
	const LANG_PL = 'pl';
	const LANG_AR = 'ar';
	const LANG_FI = 'fi';
	const LANG_TR_CH = 'tr_ch';
	const LANG_TR = 'tr';
	const LANG_GA = 'ga';
	const LANG_SK = 'sk';
	const LANG_UK = 'uk';
	const LANG_FA = 'fa';

	public $plurkId;
	public $favorersDetail;
	public $limitedDetail;
	public $replurkersDetail;
	public $offset;
	public $limit;
	public $filter;
	public $content;
	public $qualifier;
	public $limitedTo;
	public $noComments;
	public $lang;
	public $ids;
	public $imgPath;
	public $userId;
	
	public function __construct()
	{
		$this->favorersDetail = false;
		$this->limitedDetail = false;
		$this->replurkersDetail = false;
		$this->offset = 'now';
		$this->limit = 20;
		$this->noComments = 0;
		$this->ids = array();
	}
}
?>