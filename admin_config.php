<?php

// Generated e107 Plugin Admin Area 

require_once('../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

 e107::lan('phpmyreservation',true,true);


class phpmyreservation_adminArea extends e_admin_dispatcher
{

	protected $modes = array(	

		'main'	=> array(
			'controller' 	=> 'phpmyreservation_reservations_ui',
			'path' 			=> null,
			'ui' 			=> 'phpmyreservation_reservations_form_ui',
			'uipath' 		=> null
		),

		
		'blocked'	=> array(
			'controller' 	=> 'phpmyreservation_blocked_ui',
			'path' 			=> null,
			'ui' 			=> 'phpmyreservation_blocked_form_ui',
			'uipath' 		=> null
		),
		
	);		
	protected $adminMenu = array(

	'main/list'			=> array('caption'=> LAN_RESERVATION_ADMIN_33, 'perm' => 'P'),
	'blocked/list'			=> array('caption'=> LAN_PHPRESER_BLOCKED_SLOTS, 'perm' => 'P'),
	'blocked/create'		=> array('caption'=> LAN_PHPRESER_ADD_BLOCKED_SLOT, 'perm' => 'P'),
			
	'main/prefs' 		=> array('caption'=> LAN_RESERVATION_ADMIN_01, 'perm' => '0'),

		// 'main/custom'		=> array('caption'=> 'Custom Page', 'perm' => 'P')
	);

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list',
    'main/create'	=> 'main/list'				
	);	
	
	protected $menuTitle = 'phpMyReservation';
}
 
				
class phpmyreservation_reservations_ui extends e_admin_ui
{
			
		protected $pluginTitle		= LAN_PHPRESER_PLUGIN_TITLE;
		protected $pluginName		= 'phpmyreservation';
	//	protected $eventName		= 'phpmyreservation-phpmyreservation_reservations'; // remove comment to enable event triggers in admin. 		
		protected $table			= 'phpmyreservation_reservations';
		protected $pid				= 'reservation_id';
		protected $perPage			= 10; 
		protected $batchDelete		= true;
	//	protected $batchCopy		= true;		
	//	protected $sortField		= 'somefield_order';
	//	protected $orderStep		= 10;
	//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable. 
		
	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.
	
		protected $listOrder		= 'reservation_id DESC';
	
		protected $fields 		= array (  'checkboxes' =>   array ( 'title' => '', 'type' => null, 'data' => null, 'width' => '5%', 'thclass' => 'center', 'forced' => '1', 'class' => 'center', 'toggle' => 'e-multiselect',  ),
		  'reservation_id' =>   array ( 'title' => LAN_PHPRESER_ID, 'data' => 'int', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'reservation_made_time' =>   array ( 'title' => LAN_PHPRESER_MADE_TIME, 'type' => 'text', 'data' => 'str', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'reservation_year' =>   array ( 'title' => LAN_PHPRESER_YEAR, 'type' => 'text', 'data' => 'int', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'reservation_week' =>   array ( 'title' => LAN_PHPRESER_WEEK, 'type' => 'text', 'data' => 'int', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'reservation_day' =>   array ( 'title' => LAN_PHPRESER_DAY, 'type' => 'text', 'data' => 'int', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'reservation_time' =>   array ( 'title' => LAN_PHPRESER_SLOT, 'type' => 'text', 'data' => 'str', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		 // 'reservation_price' =>   array ( 'title' => 'Price', 'type' => 'number', 'data' => 'int', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'reservation_user_id' =>   array ( 'title' => LAN_PHPRESER_USER, 'type' => 'user', 'data' => 'int', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'reservation_user_email' =>   array ( 'title' => LAN_RESERVATION_ADMIN_64, 'type' => 'email', 'data' => 'str', 'width' => 'auto', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'reservation_user_name' =>   array ( 'title' => LAN_RESERVATION_ADMIN_63, 'type' => 'text', 'data' => 'str', 'width' => 'auto', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'options' =>   array ( 'title' => LAN_OPTIONS, 'type' => null, 'data' => null, 'width' => '10%', 'thclass' => 'center last', 'class' => 'center last', 'forced' => '1',  ),
		);		
		
		protected $fieldpref = array('reservation_made_time', 'reservation_user_name','reservation_year','reservation_week','reservation_day','reservation_user_id');
		
	//	protected $preftabs        = array('General', 'Other' );
		protected $prefs = array(
			'global_title'	   				=> array('title'=> LAN_PHPRESER_ADMIN_20, 'writeParms' => array('size'=>'block-level'),  'type'=>'text', 'data' => 'string', 'validate' => true),
			'global_organization' 		=> array('title'=> LAN_PHPRESER_ADMIN_21, 'type'=>'text', 'data' => 'string', 'validate' => true),
			'global_weeks_forward' 		=> array('title'=> LAN_PHPRESER_ADMIN_22, 'type'=>'text', 'data' => 'int', 
			'validate' => true, 'help'=>LAN_PHPRESER_ADMIN_23),
			'global_times'	   				=> array('title'=> LAN_PHPRESER_ADMIN_24, 'type'=>'text', 'data' => 'string', 'writeParms' => array('size'=>'block-level'), 'validate' => true),
      'global_days'	   				=> array('title'=> LAN_PHPRESER_ADMIN_26, 'type'=>'text', 'data' => 'string',   'writeParms' => array('size'=>'block-level'), 'validate' => true),
      'blocked_text'	   			=> array('title'=> 'Blocked text', 'type'=>'text', 'data' => 'string', 'writeParms' => array('size'=>'block-level')),
		); 

		public function init()
		{
			// Set drop-down values (if any). 
	
		}

		
		// ------- Customize Create --------
		
		public function beforeCreate($new_data,$old_data)
		{
			return $new_data;
		}
	
		public function afterCreate($new_data, $old_data, $id)
		{
			// do something
		}

		public function onCreateError($new_data, $old_data)
		{
			// do something		
		}		
		
		
		// ------- Customize Update --------
		
		public function beforeUpdate($new_data, $old_data, $id)
		{
			return $new_data;
		}

		public function afterUpdate($new_data, $old_data, $id)
		{
			// do something	
		}
		
		public function onUpdateError($new_data, $old_data, $id)
		{
			// do something		
		}		
		
			
	/*	
		// optional - a custom page.  
		public function customPage()
		{
			$text = 'Hello World!';
			$otherField  = $this->getController()->getFieldVar('other_field_name');
			return $text;
			
		}
	*/
			
}
				


class phpmyreservation_reservations_form_ui extends e_admin_form_ui
{

}	

 
				
class phpmyreservation_blocked_ui extends e_admin_ui
{
			
		protected $pluginTitle		= 'phpMyReservation';
		protected $pluginName		= 'phpmyreservation';
	//	protected $eventName		= 'phpmyreservation-phpmyreservation_blocked'; // remove comment to enable event triggers in admin. 		
		protected $table			= 'phpmyreservation_blocked';
		protected $pid				= 'rscblocked_id';
		protected $perPage			= 10; 
		protected $batchDelete		= true;
	  protected $batchCopy		= true;		
	//	protected $sortField		= 'somefield_order';
	//	protected $orderStep		= 10;
	//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable. 
		
	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.
	
		protected $listOrder		= 'rscblocked_id DESC';
	                                                     
		protected $fields 		= array (  'checkboxes' =>   array ( 'title' => '', 'type' => null, 'data' => null, 'width' => '5%', 'thclass' => 'center', 'forced' => '1', 'class' => 'center', 'toggle' => 'e-multiselect',  ),
		  'rscblocked_id' =>   array ( 'title' => LAN_ID, 'data' => 'int', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'rscblocked_day' =>   array ( 'title' => LAN_PHPRESER_DAY, 'type' => 'dropdown', 'data' => 'int', 'width' => 'auto', 
			'inline'=> true, 'batch'=>true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'rscblocked_time' =>   array ( 'title' => LAN_PHPRESER_SLOT, 'type' => 'dropdown', 'data' => 'str', 
			'inline'=> true, 'batch'=>true,  'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
	//	  'reservation_resource' =>   array ( 'title' => 'Resource', 'type' => 'dropdown', 'data' => 'int', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'options' =>   array ( 'title' => LAN_OPTIONS, 'type' => null, 'data' => null, 'width' => '10%', 'thclass' => 'center last', 'class' => 'center last', 'forced' => '1',  ),
		);		
		
		protected $fieldpref = array();
		
	
		public function init()
		{
			$rezpref = e107::getPlugPref('phpmyreservation');
	    $global_times = explode(",", $rezpref['global_times']);
	    foreach ($global_times as $global_time)
			{
				$this->rscblocked_time[$global_time] = $global_time;
			}
			$this->fields['rscblocked_time']['writeParms'] = $this->rscblocked_time;
			
	    $global_days = explode(",", $rezpref['global_days']);
	    $i = 0;
	    foreach ($global_days as $global_day)
			{
				$i++;
				$this->rscblocked_day[$i] = $global_day;
			}
			$this->fields['rscblocked_day']['writeParms']['optArray'] = $this->rscblocked_day;			
		}
		
		// ------- Customize Create --------
		
		public function beforeCreate($new_data,$old_data)
		{
			return $new_data;
		}
	
		public function afterCreate($new_data, $old_data, $id)
		{
			// do something
		}
		public function onCreateError($new_data, $old_data)
		{
			// do something		
		}		
		
		
		// ------- Customize Update --------
		
		public function beforeUpdate($new_data, $old_data, $id)
		{
			return $new_data;
		}
		public function afterUpdate($new_data, $old_data, $id)
		{
			// do something	
		}
		
		public function onUpdateError($new_data, $old_data, $id)
		{
			// do something		
		}		
		
			
	/*	
		// optional - a custom page.  
		public function customPage()
		{
			$text = 'Hello World!';
			$otherField  = $this->getController()->getFieldVar('other_field_name');
			return $text;
			
		}
	*/
			
}
				
class phpmyreservation_blocked_form_ui extends e_admin_form_ui
{
	
} 		
new phpmyreservation_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

?>