<?php

// String manipulation

function modify_email($email)
	{
	$email = str_replace('@', '(at)', $email);
	$email = str_replace('.', '(dot)', $email);
	return ($email);
	}

// Reservations

function highlight_day($day)
	{
	$day = str_ireplace(global_day_name, '<span id="today_span">' . global_day_name . '</span>', $day);
	return $day;
	}

function read_reservation($week, $day, $time)
	{
	$sql = e107::getDB();
	$year = global_year;
	$query = $sql->gen("SELECT * FROM " . global_mysql_reservations_table . " WHERE reservation_year='$year' AND reservation_week='$week' AND reservation_day='$day' AND reservation_time='$time'");
 
	$reservation = $sql->fetch($query);
	if ($reservation['reservation_user_id'] == USERID)
		{
		return ($reservation['reservation_user_name']);
		}

	if (ADMIN)
		{
		return ($reservation['reservation_user_name']);
		}

	if ($reservation['reservation_user_name'])
		{
		return ('RESERVED');
		}

	return ('');
	}

// display only info that is reserved for not logged in user

function display_reservation($week, $day, $time)
	{
	$sql = e107::getDB();
	$year = global_year;
	$query = $sql->gen("SELECT * FROM " . global_mysql_reservations_table . " WHERE reservation_year='$year' AND reservation_week='$week' AND reservation_day='$day' AND reservation_time='$time'");
 
	$reservation = $sql->fetch($query);
	if ($reservation['reservation_user_name']) return 'RESERVED';
	  else return '';
	}

function read_reservation_details($week, $day, $time)
	{
	$sql = e107::getDB();
	$year = global_year;
	$query = $sql->gen("SELECT * FROM " . global_mysql_reservations_table . " WHERE reservation_year='$year' AND reservation_week='$week' AND reservation_day='$day' AND reservation_time='$time'") or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
	$reservation = $sql->fetch($query);
	if (empty($reservation))
		{
		return (0);
		}
	  else
		{
		$fullinfo = '<b>' . LAN_PHPRESER_RESERV_MADE . '</b> ' . $reservation['reservation_made_time'] . '<br /><b>' . LAN_PHPRESER_USER_NAME . '</b> ' . $reservation['reservation_user_name'] . '<br /><b>' . LAN_PHPRESER_USER_EMAIL . '</b> ' . $reservation['reservation_user_email'] . '<br /><b>' . LAN_PHPRESER_USER_ID . '</b> ' . $reservation['reservation_user_id'];
		$yourinfo = '<b>' . LAN_PHPRESER_RESERV_MADE . '</b> ' . $reservation['reservation_made_time'] . '<br /><b>' . LAN_PHPRESER_YOUR_NAME . '</b> ' . $reservation['reservation_user_name'] . '<br /><b>' . LAN_PHPRESER_YOUR_EMAIL . '</b> ' . $reservation['reservation_user_email'] . '<br /><b>' . LAN_PHPRESER_YOUR_ID . '</b> ' . $reservation['reservation_user_id'];
		if ($reservation['reservation_user_id'] == USERID)
			{
			return ($yourinfo);
			}

		//	if(false) { return('<b>'.LAN_PHPRESER_RESERV_MADE.'</b> ' . $reservation['reservation_made_time'] . '<br /><b>User\'s email:</b> ' . $reservation['reservation_user_email']); }
		//	if($reservation['reservation_user_name']) { return('<b>'.LAN_PHPRESER_RESERV_MADE.'</b> ' . $reservation['reservation_made_time']); }

		return ('<b>' . LAN_PHPRESER_RESERV_MADE . '</b> ' . $reservation['reservation_made_time'] . '<br />Warning. Something is wrong ');
		}
	}

function make_reservation($week, $day, $time)
	{
	$sql = e107::getDB();
	$userData = e107::user(USERID);
	$user_id = USERID;
	$user_email = $userData['user_email'];
	$user_name = $userData['user_name'];
	if (ADMIN)
		{
		$user_is_admin = 1;
		}
	  else
		{
		$user_is_admin = 0;
		}

	$price = global_price;
	if ($week == '0' && $day == '0' && $time == '0')
		{
		$sql->gen("INSERT INTO " . global_mysql_reservations_table . " (reservation_made_time,reservation_week,reservation_day,reservation_time,reservation_price,reservation_user_id,reservation_user_email,reservation_user_name) VALUES (now(),'$week','$day','$time','$price','$user_id','$user_email','$user_name')");
		return (1);
		}
	elseif ($week < global_week_number && $user_is_admin != '1' || $week == global_week_number && $day < global_day_number && $user_is_admin != '1')
		{
		return (LAN_PHPRESER_BACK_IN_TIME);
		}
	elseif ($week > global_week_number + global_weeks_forward && $user_is_admin != '1')
		{
		return (LAN_PHPRESER_FORWARD_1 . global_weeks_forward . LAN_PHPRESER_FORWARD_2);
		}
	  else
		{
		$year = global_year;
		$query = $sql->count("phpmyreservation_reservations", '(*)',  "  reservation_year='$year' AND reservation_week='$week' AND reservation_day='$day' AND reservation_time='$time'" );
		if ($query < 1)
			{
			$year = global_year;
			$sql->gen("INSERT INTO " . global_mysql_reservations_table . " (reservation_made_time,reservation_year,reservation_week,reservation_day,reservation_time,reservation_price,reservation_user_id,reservation_user_email,reservation_user_name) VALUES (now(),'$year','$week','$day','$time','$price','$user_id','$user_email','$user_name')");
			return (1);
			}
		  else
			{
			return (LAN_PHPRESER_SOMEONE_ELSE);
			}
		}
	}

function delete_reservation($week, $day, $time)
	{
	$sql = e107::getDB();
	$year = global_year;
	if (ADMIN)
		{
		$user_is_admin = 1;
		}
	  else
		{
		$user_is_admin = 0;
		}

	if ($week < global_week_number && $user_is_admin != '1' || $week == global_week_number && $day < global_day_number && $user_is_admin != '1')
		{
		return (LAN_PHPRESER_BACK_IN_TIME);
		}
	elseif ($week > global_week_number + global_weeks_forward && $user_is_admin != '1')
		{
		return (LAN_PHPRESER_FORWARD_1 . global_weeks_forward . LAN_PHPRESER_FORWARD_2);
		}
	  else
		{
		$query = $sql->gen("SELECT * FROM " . global_mysql_reservations_table . " WHERE reservation_year='$year' AND reservation_week='$week' AND reservation_day='$day' AND reservation_time='$time'");
		$user = $sql->fetch($query);
		if ($user['reservation_user_id'] == USERID || $user_is_admin == '1')
			{
			$sql->gen("DELETE FROM " . global_mysql_reservations_table . " WHERE reservation_year='$year' AND reservation_week='$week' AND reservation_day='$day' AND reservation_time='$time'");
			return (1);
			}
		  else
			{
			return (LAN_PHPRESER_OTHER_RESERV);
			}
		}
	}
	
	
function check_blocked_slot($day, $time)
	{
	$sql = e107::getDB();
	$where = " WHERE rscblocked_day='$day' AND rscblocked_time='$time'";
	$string = $sql->retrieve('phpmyreservation_blocked', 'rscblocked_id' , $where);
	if($string) { return TRUE; }
	else { return FALSE; }
	}	

?>