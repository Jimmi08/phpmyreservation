<?php

// MySQL details removed moved to e107

$rezpref = e107::getPlugConfig('phpmyreservation')->getPref();
 
// Title. Used in page title and header

define('global_title', $rezpref['global_title']);

// Organization. Used in page title and header, and as sender name in reservation reminder emails

define('global_organization', $rezpref['global_organization']);

// How many weeks forward in time to allow reservations

define('global_weeks_forward', $rezpref['global_weeks_forward']);

$path1 = e_PLUGIN_ABS.'phpmyreservation/';
$path1 = e107::getParser()->replaceConstants($path1, 'full');
// FULL URL because e_url, not working with e_PLUGINS, so it's in prefs

define('global_url_site', $path1);

// Possible reservation times. Use the same syntax as below (TimeFrom-TimeTo)
// $global_times = array('09-10', '10-11', '11-12', '12-13', '13-14', '14-15', '15-16', '16-17', '17-18', '18-19', '19-20', '20-21');

$global_times = explode(",", $rezpref['global_times']);

// this way you can start week any day, you can have 6 days week... different name for days Mon. Monday M, First day... etc

$global_days = explode(",", $rezpref['global_days']);
$daysnumber = count($global_days);

if (!isset($daysnumber))
	{
	$daysnumber = 7;
	}

?>