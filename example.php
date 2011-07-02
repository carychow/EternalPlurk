<?php
// Include the main.php then all the files of EternalPlurk will be included.
require_once('src/main.php');

$consumerKey = 'Plurk App\'s key.';
$consumerSecret = 'The Plurk App\'s secret.';
$oAuthToken = null;
$oAuthTokenSecret = null;

if(empty($oAuthToken) && empty($oAuthTokenSecret))
{
	// Need to authorization
	
	// Create a PlurkApp instance.
	$app = new PlurkApp($consumerKey, $consumerSecret);
	
	if(empty($_GET['oauth_token']) && empty($_GET['oauth_verifier']))
	{
		// It's not a callback.
		
		// In the authorization, it will redirect to Plurk's authorization page.
		if(!$app->startAuth())
		{
			// If there is error, print the error message.
			echo $app->getErrMsg();
		}
	}
	else
	{
		$info = $app->parseCallback();
		
		if($info === false)
		{
			// Failed. Print the error message.
			echo $app->getErrMsg();
		}
		else
		{
			// Got a PlurkOAuthInfo object.
			// Please use $info->oAuthToken and $info->oAuthToken to accees Plurk API for the user(s).
			var_dump($info);
		}
	}
}
else
{
	// Create a PlurkApp instance.
	$app = new PlurkApp($consumerKey, $consumerSecret, $oAuthToken, $oAuthTokenSecret);
	
	// Try to get the public profile of me (carychow).
	$info = $app->getPublicProfile('carychow');
	
	if($info === false)
	{
		// Failed. Print the error message.
		echo $app->getErrMsg();
	}
	else
	{
		// Got a PlurkProfileInfo object.
		var_dump($info);
	}
}
?>