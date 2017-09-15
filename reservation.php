<?php

include_once('main.php');
$tp = e107::getParser();  
 if(!USER) { exit; }

if(isset($_GET['make_reservation']))
{
	$week = $tp->toDB($_POST['week']);
	$day = $tp->toDB($_POST['day']);
	$time = $tp->toDB($_POST['time']);
	echo make_reservation($week, $day, $time);
}
elseif(isset($_GET['delete_reservation']))
{
	$week = $tp->toDB($_POST['week']);
	$day = $tp->toDB($_POST['day']);
	$time = $tp->toDB($_POST['time']);
	echo delete_reservation($week, $day, $time);
}
elseif(isset($_GET['read_reservation']))
{
	$week = $tp->toDB($_POST['week']);
	$day = $tp->toDB($_POST['day']);
	$time = $tp->toDB($_POST['time']);
	echo read_reservation($week, $day, $time);
}
elseif(isset($_GET['read_reservation_details']))
{
	$week = $tp->toDB($_POST['week']);
	$day = $tp->toDB($_POST['day']);
	$time = $tp->toDB($_POST['time']);
	echo read_reservation_details($week, $day, $time);
}
elseif(isset($_GET['week']))
{
	$week = $_GET['week'];

	echo '<table id="reservation_table"><colgroup span="1" id="reservation_time_colgroup"></colgroup><colgroup span="'.$daysnumber.'" id="reservation_day_colgroup"></colgroup>';

	$days_row = '<tr>
	<td id="reservation_corner_td"><input type="button" class="blue_button small_button" id="reservation_today_button" value="Today"></td>';
	foreach($global_days as $day)
	{
	$days_row .= '<th class="reservation_day_th">' . $day. '</th>';
	}
	$days_row .= '</tr>';

	if($week == global_week_number)
	{
		echo highlight_day($days_row);
	}
	else
	{
		echo $days_row;
	}

	foreach($global_times as $time)
	{
		echo '<tr><th class="reservation_time_th">' . $time . '</th>';

		$i = 0;

		while($i < $daysnumber)
		{
			$i++;

			// check blocked slots 
			$blocked = check_blocked_slot($i, $time);
			
			if ($blocked)
				{
				$display = e107::getPlugPref('phpmyreservation', 'blocked_text');
				echo '<td class="blocked"><div class="blocked_time_div"><div class="blocked_time_cell_div" id="div:' . $week . ':' . $i . ':' . $time . '"  >' . $display . '</div></div></td>';
				}
			else
				{
				echo '<td><div class="reservation_time_div"><div class="reservation_time_cell_div" id="div:' . $week . ':' . $i . ':' . $time . '" onclick="void(0)">' . read_reservation($week, $i, $time) . '</div></div></td>';
				}
		}

		echo '</tr>';
	}

	echo '</table>';
}
else
{
	echo '</div><div class="box_div" id="reservation_div"><div class="box_top_div" id="reservation_top_div">
	<div id="reservation_top_left_div"><a href="." id="previous_week_a">&lt; '.LAN_PHPRESER_PREVIOUS_WEEK.'</a></div>
	<div id="reservation_top_center_div">'.LAN_PHPRESER_FOR_WEEK.' <span id="week_number_span">' . global_week_number . '</span></div>
	<div id="reservation_top_right_div"><a href="." id="next_week_a">'.LAN_PHPRESER_NEXT_WEEK.' &gt;</a></div></div>
	<div class="box_body_div"><div id="reservation_table_div"></div></div></div><div id="reservation_details_div">';
}

?>
