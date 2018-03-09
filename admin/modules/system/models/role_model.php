<?php

class Role_model extends CI_Model {

    var $query_string = '';
    var $command = '';
    var $dtable = 'es_menu_roles';

    function __construct() {
        parent::__construct();
    }

    function __delete($id = '')
    {
        $option = $this->action->delete(array('table' => $this->dtable,
                                              'where' => array('role_id' => $id)));
        if($option['state'] == 0)
        {
            $this->validation->error_message($option);
            return false;
        }
	
	$option = $this->action->delete(array('table' => 'es_menu_access',
                                              'where' => array('role_id' => $id)));
        if($option['state'] == 0)
        {
            $this->validation->error_message($option);
            return false;
        }
        
        return $option;
    }
    
    function __menu_access($id = '')
    {
	$option = '';
	$rcount = count($this->input->post('menu_id'));
	for($i=0;$i<$rcount;$i++)
	{
	    $cc = $this->catalog->get_menu_access(array('role_id' => $id, 'menu_id' => $this->input->post('menu_id')[$i], 'row' => true));
	    $m1 = (isset($this->input->post('menu_access')[$i])) ? $this->input->post('menu_access')[$i] : 0;
	    $m2 = (isset($this->input->post('menu_created')[$i])) ? $this->input->post('menu_created')[$i] : 0;
	    $m3 = (isset($this->input->post('menu_updated')[$i])) ? $this->input->post('menu_updated')[$i] : 0;
	    $m4 = (isset($this->input->post('menu_deleted')[$i])) ? $this->input->post('menu_deleted')[$i] : 0;
	    
	    if($cc)
	    {
		$rm = array('table' => 'es_menu_access',
			    'update' => array('menu_access' => $m1, 'menu_created' => $m2, 'menu_updated' => $m3, 'menu_deleted' => $m4),
			    'where' => array('role_id' => $id, 'menu_id' => $this->input->post('menu_id')[$i]));
		
		$option = $this->action->update($rm);
		if($option['state'] == 0)
		{
		    $this->validation->error_message($option);
		    return false;
		}
	    } else {
		$rm = array('table' => 'es_menu_access',
			    'insert' => array('role_id' => $id,
					      'menu_id' => $this->input->post('menu_id')[$i],
					      'menu_access' => $m1, 'menu_created' => $m2,
					      'menu_updated' => $m3, 'menu_deleted' => $m4));
		
		$option = $this->action->insert($rm);
		if($option['state'] == 0)
		{
		    $this->validation->error_message($option);
		    return false;
		}
	    }
	}
	
	return $option;
    }
    
}
