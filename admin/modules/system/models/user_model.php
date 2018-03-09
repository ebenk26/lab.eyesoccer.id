<?php

class User_model extends CI_Model {

    var $query_string = '';
    var $command = '';
    var $dtable = 'es_users';

    function __construct() {
        parent::__construct();
    }

    function __delete($id = '')
    {
        $option = $this->action->delete(array('table' => $this->dtable,
                                              'where' => array('user_id' => $id)));
        if($option['state'] == 0)
        {
            $this->validation->error_message($option);
            return false;
        }
        
        return $option;
    }
    
    function __disable($id = '')
    {
	if($id != NULL)
	{
            $dt = array('table' => $this->dtable,
			'update' => array('is_active' => 0),
			'where' => array('user_id' => $id));
	    
	    $option = $this->action->update($dt);
	    
	    return $option;
	} else {
	    redirect('system/user');
	}
    }

    function __enable($id = '')
    {
	if($id != NULL)
	{
	    $dt = array('table' => $this->dtable,
			'update' => array('is_active' => 1),
			'where' => array('user_id' => $id));
	    
	    $option = $this->action->update($dt);
	    
	    return $option;
	} else {
	    redirect('system/user');
	}
    }
    
    function __checkemail()
    {
	$i = 0;
	if($this->input->post('idx') != '' && $this->input->post('user_email') != $this->input->post('temp_user_email'))
	{
	    $i = 1;
	} else {
	    if($this->input->post('idx') == '')
	    {
		$i = 1;
	    }
	}
	
	if($i > 0)
	{
	    $acc = $this->catalog->get_user(array('user_email' => $this->input->post('user_email'), 'row' => true));
	    if($acc)
	    {
		$xm = array('xState' => false, 'xCss' => 'boxfailed', 'xMsg' => 'Email already exists');
		$this->tools->__flashMessage($xm, true);
	    }
	}
    }
    
}
