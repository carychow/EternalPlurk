<?php
// Include the main.php then all the files of EternalPlurk will be included.
require_once('src/main.php');

$apiKey = 'Your API key';

// Create a PlurkApp instance.
$app = new PlurkApp();

// Setup the path of Cookie file.
$app->setCookiePath(dirname(__FILE__) . '/cookie.dat');

// Setup API key to access Plurk API
$app->setApiKey($apiKey);

// In this example, try to get the public profile of me (carychow).
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
?>