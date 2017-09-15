<?php  
if (!defined('e107_INIT'))
{
	  	require_once ("../../class2.php");
}

require_once (HEADERF);        
$path = e_PLUGIN.'phpmyreservation/';
require_once($path.'main.php');          
   
?>

<?php require_once($path.'js/header-js.php'); ?>

<div id="notification_div"><div id="notification_inner_div"><div id="notification_inner_cell_div"></div></div></div>

<div  class="container text-center"> 
<div id="header_inner_div">  <div id="header_inner_center_div">
<h1><?php echo global_title; ?></h1>
<h2><?php echo global_organization; ?></h2>
 
<?php echo '<b>Week ' . global_week_number . ' - ' . global_day_name . ' ' . date('jS F Y') . '</b>';  ?></div>
</div> 
</div> 
<div id="content_div"></div>

<div id="preload_div">
<img src="<?php echo $path; ?>img/loading.gif" alt="Loading">
</div>

<?php
 require_once (FOOTERF);
exit;
?>