<?php

if (!defined('e107_INIT'))
{
	require_once ("../../class2.php");

}

$sql = e107::getDB();
$path = e_PLUGIN . 'phpmyreservation/';
e107::lan('phpmyreservation', false, true);

// Include necessary files
          
require_once ($path . 'config.php');

require_once ($path . 'functions.php');
 
// MySQL

define('global_mysql_users_table', '#user');
define('global_mysql_reservations_table', '#phpmyreservation_reservations');

// Start session

session_start();

// Date

define('global_year', date('Y'));
define('global_week_number', ltrim(date('W') , '0'));
define('global_day_number', date('N'));
define('global_day_name', date('l'));

// User agent

if (isset($_SERVER['HTTP_USER_AGENT']))
{
	define('global_ua', $_SERVER['HTTP_USER_AGENT']);
}
else
{
	define('global_ua', 'CLI');
}

if (strstr(global_ua, 'iPhone') || strstr(global_ua, 'iPod') || strstr(global_ua, 'iPad') || strstr(global_ua, 'Android'))
{
	if (strstr(global_ua, 'AppleWebKit'))
	{
		if (strstr(global_ua, 'OS 5_') || strstr(global_ua, 'Android 2.3') || strstr(global_ua, 'Android 3') || strstr(global_ua, 'Android 4'))
		{
			define('global_css_animations', '1');
		}
	}
}
elseif (strstr(global_ua, 'Chrome') || strstr(global_ua, 'Safari') && strstr(global_ua, 'Macintosh') || strstr(global_ua, 'Safari') && strstr(global_ua, 'Windows') || strstr(global_ua, 'Firefox') || strstr(global_ua, 'Opera') || strstr(global_ua, 'MSIE 10'))
{
	define('global_css_animations', '1');
}
else
{
	define('global_css_animations', '0');
}

// Check stuff

if (isset($_GET['day_number']))
{
	echo date('N');
}

?>