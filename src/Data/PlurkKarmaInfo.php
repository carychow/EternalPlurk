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

class PlurkKarmaInfo
{
	const REASON_FD_REJECT = 'friends_rejections';
	const REASON_INACTIVITY = 'inactivity';
	const REASON_TOO_SHORT = 'too_short_responses';
	const REASON_VACATION = 'karma_vacation';
	
	const KEY_KARMA_FALL_REASON = 'karma_fall_reason';
	const KEY_CURRENT_KARMA = 'current_karma';
	const KEY_KARMA_GRAPH = 'karma_graph';
	const KEY_KARMA_TREND = 'karma_trend';
	
	public $karmaFallReason;
	public $currentKarma;
	public $karmaGraph;
	public $karmaTrend;
}
?>