<?php

class User_model extends CI_Model {

    var $dtable = 'we_users';

    function __construct() {
        parent::__construct();
	$this->vlink = $this->config->item('aes_vlink');
    }
    
    function __checkemail($forgot = '')
    {
	$acc = $this->catalog->get_pr_users(array('user_email' => $this->input->post('email'), 'row' => true));
	if($acc AND $acc->is_temp > 0 AND $forgot == '')
	{
	    $this->restapi->__error('Email already exists');
	} else {
	    if(empty($acc) AND $forgot == true)
	    {
		$this->restapi->__error('Invalid Email');
	    }
	}
	
	return $acc;
    }
    
    function __checkuser()
    {
	$uname = $this->library->seo_title($this->input->post('username'));
	$acc = $this->catalog->get_pr_users(array('user_name' => $uname, 'sortBy' => 'user_id', 'sortDir' => 'desc'));
	if($acc)
	{
	    $accnum = count($acc) + 1;
	    $uname = $uname.'-'.$accnum;
	}
	
	return $uname;
    }
    
    function __setuser($dt = '', $via = '', $email = '', $pass = '')
    {
	$uid = uniqid('sp_');
	ob_start();
	    setcookie('user_uid', $uid, time() + (86400 * 30), "/");
	    
	    if($via == 0 AND $this->input->post('remember') != NULL)
	    {
		setcookie('email_member', $email, time() + (86400 * 30), "/");
		setcookie('password_member', $pass, time() + (86400 * 30), "/");
	    }
	ob_end_flush();
	
	// Update Session Cart to ID
	$option = $this->action->update(array('table' => 'we_order_temp', 'update' => array('user_id' => $dt->user_id),
					      'where' => array('user_session' => $this->session->userdata('session_id'))));
	if($option['state'] == 0)
	{
	    $this->restapi->__error($option['message']);
	}
	
	$session = array('user_id' => $dt->user_id,
			 'user_fname' => $dt->user_fname,
			 'user_lname' => $dt->user_lname,
			 'user_uid' => $uid,
			 'user_fire' => md5($dt->user_id),
			 'login' => TRUE);
	$this->session->set_userdata($session);
	
	return $session;
    }
    
    function __path()
    {
        // Upload Path
        $path = UPLOAD.'user/';
        
        // Upload Config
        $config = array(
                            'allowed_types' => 'gif|jpg|png',
                            'max_size' => '1000',
                            'resize' => true
                        );
        
        return array('path' => $path, 'resize' => true, 'config' => $config);
    }

}
