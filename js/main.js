// Show pages
 

function showreservations()
{
	page_load('reservation');
	div_hide('#content_div');
 
	$.get(global_url_site + 'reservation.php', function(data)
	{
		$('#content_div').html(data);
		div_fadein('#content_div');

		$.get(global_url_site + 'reservation.php?week='+global_week_number, function(data)
		{
			$('#reservation_table_div').html(data).slideDown('slow', function() { setTimeout(function() { div_fadein('#reservation_table_div'); }, 250); });
			page_loaded();
		});
	});
}        

function showdisplay()
{
	page_load('display');
	div_hide('#content_div');

	$.get(global_url_site + 'display.php', function(data)
	{
		$('#content_div').html(data);
		div_fadein('#content_div');

		$.get(global_url_site + 'display.php?week='+global_week_number, function(data)
		{
			$('#reservation_table_div').html(data).slideDown('slow', function() { setTimeout(function() { div_fadein('#reservation_table_div'); }, 250); });
			page_loaded();
		});
	});
}  


function showweek(week, option)
{
	if(week == 'next')
	{
		var week = parseInt($('#week_number_span').html()) + 1;
	}
	else if(week == 'previous')
	{
		var week = parseInt($('#week_number_span').html()) - 1;
	}
	else
	{
		var week = parseInt(week);
	}

	if(isNaN(week))
	{
		notify('Invalid week number', 4);
	}
	else
	{
		if(week < 1)
		{
			var week = 52;
		}
		else if(week > 52)
		{
			var week = 1;
		}

		page_load('week');
		div_hide('#reservation_table_div');

 		if(typeof session_logged_in != 'undefined')
		{
				$.get(global_url_site + 'reservation.php?week='+week, function(data)
				{
					$('#reservation_table_div').html(data);
					$('#week_number_span').html(week);
					div_fadein('#reservation_table_div');
					page_loaded('week');
		
					if(week != global_week_number)
					{
						$('#reservation_today_button').css('visibility', 'visible');
					}
		
					if(option == 'today')
					{
						setTimeout(function() { $('#today_span').animate({ opacity: 0 }, 250, function() { $('#today_span').animate({ opacity: 1 }, 250);  }); }, 500);
					}
				});
		}
		else
		{
			$.get(global_url_site + 'display.php?week='+week, function(data)
			{
				$('#reservation_table_div').html(data);
				$('#week_number_span').html(week);
				div_fadein('#reservation_table_div');
				page_loaded('week');
	
				if(week != global_week_number)
				{
					$('#reservation_today_button').css('visibility', 'visible');
				}
	
				if(option == 'today')
				{
					setTimeout(function() { $('#today_span').animate({ opacity: 0 }, 250, function() { $('#today_span').animate({ opacity: 1 }, 250);  }); }, 500);
				}
			});
		}
	}
}
 
 

// Page load

function page_load(page)
{  	
 
	setTimeout(function()
	{
		if($('#content_div').css('opacity') == 0)
		{                              
			notify('Loading...', 300);
		}
	}, 500);

	// Individual
	if(page == 'reservation')
	{  
		setTimeout(function()
		{
			if($('#reservation_table_div').is(':hidden'))
			{
				notify('Loading...', 300);
			}
		}, 500);
	}	
	else if(page == 'week')
	{
		setTimeout(function()
		{
			if($('#reservation_table_div').css('opacity') == 0)
			{
				notify('Loading...', 300);
			}
		}, 500);
	}
}

function page_loaded(page)
{
  
	// All
	$.get(global_url_site + 'main.php?day_number', function(data)
	{
		if(data != global_day_number)
		{
			notify('Day have changed. Refreshing...', '300');
			setTimeout(function() { window.location.replace('.'); }, 2000);
		}
	});

	setTimeout(function()
	{
		if($('#notification_inner_cell_div').is(':visible') && $('#notification_inner_cell_div').html() == 'Loading...')
		{
			notify();
		}
	}, 1000);

	read_reservation_details();
 
}
 
 

// Reservation

function toggle_reservation_time(id, week, day, time, from)
{   
	if(session_user_is_admin == '1')
	{
		if(week < global_week_number || week == global_week_number && day < global_day_number)
		{
			notify('You are reserving back in time. You can do that because you\'re an admin', 4);
		}
		else if(week > global_week_number + global_weeks_forward)
		{
			notify('You are reserving more than '+global_weeks_forward+' weeks forward in time. You can do that because you\'re an admin', 4);
		}
	}

	var user_name = $(id).html();

	if(user_name == '')
	{
		$(id).html('Wait...'); 

		$.post(global_url_site + 'reservation.php?make_reservation', { week: week, day: day, time: time }, function(data) 
		{
			if(data == 1)
			{
				setTimeout(function() { read_reservation(id, week, day, time); }, 1000);
			}
			else
			{
				notify(data, 4);
				setTimeout(function() { read_reservation(id, week, day, time); }, 2000);			
			}
		});
	}
	else
	{   
		if(offclick_event == 'mouseup' || from == 'details')
		{
			if(user_name == 'Wait...')
			{
				notify('One click is enough', 4);
			}
			else if(user_name == session_user_name || session_user_is_admin == '1')
			{
				if(user_name != session_user_name && session_user_is_admin == '1')
				{
					var delete_confirm = confirm('This is not your reservation, but because you\'re an admin you can remove other users\' reservations. Are you sure you want to do this?');
				}
				else
				{
					var delete_confirm = true;
				}

				if(delete_confirm)
				{
					$(id).html('Wait...');

					$.post(global_url_site + 'reservation.php?delete_reservation', { week: week, day: day, time: time }, function(data)
					{
						if(data == 1)
						{
							setTimeout(function() { read_reservation(id, week, day, time); }, 1000);
						}
						else
						{
							notify(data, 4);
							setTimeout(function() { read_reservation(id, week, day, time); }, 2000);
						}
					});
				}
			}
			else
			{
				notify('You can\'t remove other users\' reservations', 2);
			}

			if($('#reservation_details_div').is(':visible'))
			{
				read_reservation_details();
			}
		}
	}
}

function read_reservation(id, week, day, time)
{
	$.post(global_url_site + 'reservation.php?read_reservation', { week: week, day: day, time: time }, function(data) { $(id).html(data); });
}

function display_reservation(id, week, day, time)
{
	$.post(global_url_site + 'display.php?read_reservation', { week: week, day: day, time: time }, function(data) { $(id).html(data); });
}

function read_reservation_details(id, week, day, time)
{
	if(typeof id != 'undefined' && $(id).html() != '' && $(id).html() != 'Wait...')
	{
		if($('#reservation_details_div').is(':hidden'))
		{
			var position = $(id).position();
			var top = position.top + 50;
			var left = position.left - 100;

			$('#reservation_details_div').html('Getting details...');
			$('#reservation_details_div').css('top', top+'px').css('left', left+'px');
			$('#reservation_details_div').fadeIn('fast');

			reservation_details_id = id;
			reservation_details_week = week;
			reservation_details_day = day;
			reservation_details_time = time;

			$.post(global_url_site + 'reservation.php?read_reservation_details', { week: week, day: day, time: time }, function(data)
			{
				setTimeout(function()
				{
					if(data == 0)
					{
						$('#reservation_details_div').html('This reservation no longer exists. Wait...');
						
						setTimeout(function()
						{
							if($('#reservation_details_div').is(':visible') && $('#reservation_details_div').html() == 'This reservation no longer exists. Wait...')
							{
								read_reservation(reservation_details_id, reservation_details_week, reservation_details_day, reservation_details_time);
								read_reservation_details();
							}
						}, 2000);
					}
					else
					{
						$('#reservation_details_div').html(data);

						if(offclick_event == 'touchend')
						{
							if($(reservation_details_id).html() == session_user_name || session_user_is_admin == '1')
							{
								var delete_link_html = '<a href="." onclick="toggle_reservation_time(reservation_details_id, reservation_details_week, reservation_details_day, reservation_details_time, \'details\'); return false">Delete</a> | ';
							}
							else
							{
								var delete_link_html = '';
							}

							$('#reservation_details_div').append('<br><br>'+delete_link_html+'<a href="." onclick="read_reservation_details(); return false">Close this</a>');
						}
					}
				}, 500);
			});
		}
	}
	else
	{
		$('div#reservation_details_div').fadeOut('fast');
	}
}
 
// UI

function div_fadein(id)
{
	setTimeout(function()
	{
		if(global_css_animations == 1)
		{
			$(id).addClass('div_fadein');
		}
		else
		{
			$(id).animate({ opacity: 1 }, 250);
		}
	}, 1);
}

function div_hide(id)
{
	$(id).removeClass('div_fadein');
	$(id).css('opacity', '0');
}

function notify(text, time)
{
	if(typeof text != 'undefined')
	{
		if(typeof notify_timeout != 'undefined')
		{
			clearTimeout(notify_timeout);
		}

		$('#notification_inner_cell_div').css('opacity', '1');

		if($('#notification_div').is(':hidden'))
		{
			$('#notification_inner_cell_div').html(text);
			$('#notification_div').slideDown('fast');
		}
		else
		{
			$('#notification_inner_cell_div').animate({ opacity: 0 }, 250, function() { $('#notification_inner_cell_div').html(text); $('#notification_inner_cell_div').animate({ opacity: 1 }, 250); });
		}

		notify_timeout = setTimeout(function() { $('#notification_inner_cell_div').animate({ opacity: 0 }, 250, function() { $('#notification_div').slideUp('fast'); }); }, 1000 * time);
	}
	else
	{
		if($('#notification_div').is(':visible'))
		{
			$('#notification_inner_cell_div').animate({ opacity: 0 }, 250, function() { $('#notification_div').slideUp('fast'); });
		}
	}
}

function input_focus(id)
{
	if(offclick_event == 'touchend')
	{
		$('input').blur();
	}
	if(typeof id != 'undefined')
	{
		$(id).focus();
	}
}

// Document ready

$(document).ready( function()
{
	// Detect touch support
	if('ontouchstart' in document.documentElement)
	{
		onclick_event = 'touchstart';
		offclick_event = 'touchend';
	}
	else
	{
		onclick_event = 'mousedown';
		offclick_event = 'mouseup';
	}

	// Visual feedback on click
	$(document).on(onclick_event, 'input:submit, input:button, .reservation_time_div', function() { $(this).css('opacity', '0.5'); });
	$(document).on(offclick_event+ ' mouseout', 'input:submit, input:button, .reservation_time_div', function() { $(this).css('opacity', '1.0'); });

	// Buttons
	$(document).on('click', '#reservation_today_button', function() { showweek(global_week_number, 'today'); });
	$(document).on('click', '#reset_user_password_button', function() { reset_user_password(); });
	$(document).on('click', '#change_user_permissions_button', function() { change_user_permissions(); });
	$(document).on('click', '#delete_user_reservations_button', function() { delete_user_data('reservations'); });
	$(document).on('click', '#delete_user_button', function() { delete_user_data('user'); });
	$(document).on('click', '#delete_all_reservations_button', function() { delete_all('reservations'); });
	$(document).on('click', '#delete_all_users_button', function() { delete_all('users'); });
	$(document).on('click', '#delete_everything_button', function() { delete_all('everything'); });
	$(document).on('click', '#add_one_reservation_button', function() { add_one_reservation(); });

	// Checkboxes
	$(document).on('click', '#reservation_reminders_checkbox', function() { toggle_reservation_reminder(); });

	// Forms
	$(document).on('submit', '#login_form', function() { login(); return false; });
	$(document).on('submit', '#new_user_form', function() { create_user(); return false; });
	$(document).on('submit', '#system_configuration_form', function() { save_system_configuration(); return false; });
	$(document).on('submit', '#user_details_form', function() { change_user_details(); return false; });

	// Links
	$(document).on('click mouseover', '#user_secret_code_a', function() { div_fadein('#user_secret_code_div'); return false; });
	$(document).on('click', '#previous_week_a', function() { showweek('previous'); return false; });
	$(document).on('click', '#next_week_a', function() { showweek('next'); return false; });

	// Divisions
	$(document).on('mouseout', '.reservation_time_cell_div', function() { read_reservation_details(); });

	$(document).on('click', '.reservation_time_cell_div', function()
	{
		var array = this.id.split(':');
		toggle_reservation_time(this, array[1], array[2], array[3], array[0]);
	});

	$(document).on('mousemove', '.reservation_time_cell_div', function()
	{
		var array = this.id.split(':');
		read_reservation_details(this, array[1], array[2], array[3]);
	});

	// Mouse pointer
	$(document).on('mouseover', 'input:button, input:submit, .reservation_time_div', function() { this.style.cursor = 'pointer'; });
});

// Hash change

function hash()
{
	var hash = window.location.hash.slice(1);

	if(hash == '')
	{
		if(typeof session_logged_in != 'undefined')
		{
			showreservations();
		}
		else
		{
			showdisplay();
		}
	}
	else
	{
 
		if(hash == 'new_user')
		{
			shownew_user();
		}
		else if(hash == 'forgot_password')
		{
			showforgot_password();
		}
		else if(hash == 'help')
		{
			showhelp();
		}
 
		else if(hash == 'logout')
		{
			logout();
		}
		else
		{
			window.location.replace('.');
		}
	}
}

// Window load

$(window).load(function()
{
 
		hash();

		$(window).bind('hashchange', function ()
		{
			hash();
		});
 
});

// Settings

$(document).ready( function()
{
	$.ajaxSetup({ cache: false });
});
