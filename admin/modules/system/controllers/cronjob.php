<?php
class Cronjob extends MX_Controller 
{
 
    function __construct()
    {
       
    }
    
    function index()
    {
	
    }
    
    function single_cronjob()
    {
	$crontab = $this->crontab('127.0.0.1', '22', 'root', '');
	$crontab->append_cronjob('30 8 * * 6 home/path/to/command/the_command.sh >/dev/null 2>&1');
    }
    
    function remove_single_cronjob()
    {
	$crontab = $this->crontab('127.0.0.1', '22', 'my_username', 'my_password');
    
	$cron_regex = '/home\/path\/to\/command\/the_command\.sh\/';
    
	$crontab->remove_cronjob($cron_regex);
    }
    
    function array_cronjob()
    {
	$crontab = $this->crontab('127.0.0.1', '22', 'my_username', 'my_password');
	
	$new_cronjobs = array(
	   '0 0 1 * * home/path/to/command/the_command.sh',
	   '30 8 * * 6 home/path/to/command/the_command.sh >/dev/null 2>&1'
	);
	
	$crontab->append_cronjob($new_cronjobs);
    }
    
    function remove_array_cronjob()
    {
	$crontab = $this->crontab('127.0.0.1', '22', 'my_username', 'my_password');
	
	$cron_regex = array(
	    '/0 0 1 \* \*/',
	    '/home\/path\/to\/command\/the_command\.sh\/'
	);
	
	$crontab->remove_cronjob($cron_regex);
    }
}