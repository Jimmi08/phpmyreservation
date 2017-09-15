 
<script type="text/javascript">

<?php
             
// Configuration
echo 'global_css_animations = ' . global_css_animations . ';';
echo 'global_weeks_forward = ' . global_weeks_forward . ';';
echo 'global_url_site = \'' .   global_url_site . '\';'; 
  
// Date
echo 'global_year = ' . global_year . ';';
echo 'global_week_number = ' . global_week_number . ';';
echo 'global_day_number = ' . global_day_number . ';';

// Login    replaced by e107 user
 

if(USER) {
 if(ADMIN) { $user_is_admin = 1; } else { $user_is_admin = 0; }
 $userData = e107::user(USERID);
 echo 'session_logged_in = 1;';
 echo 'session_user_id = \'' . USERID . '\';';
 echo 'session_user_name = \'' . $userData['user_name'] . '\';';
 echo 'session_user_is_admin = \'' . $user_is_admin . '\';'; 
}

?>

</script>
