<?php

class Extend_model extends CI_Model {

    var $dtable = 'we_order';

    function __construct() {
        parent::__construct();
	$this->vlink = $this->config->item('aes_vlink');
    }
    
    function __tempdel()
    {
	$date = date('Y-m-d');
	$date = date('Y-m-d', strtotime("$date - 1 days"));
	$this->action->delete(array('table' => 'we_order_temp', 'where' => array('user_id' => 0, 'DATE(updated_at)' => $date)));
    }
    
    function __cartdel()
    {
	if($this->input->post('user_id') > 0)
	{
	    $temp = array('user_id' => $this->input->post('user_id'));
	} else {
	    $temp = array('user_session' => $this->session->userdata('session_id'));
	}
	
	$this->action->delete(array('table' => 'we_order_temp', 'where' => array_merge($temp, array('product_id' => $this->input->post('product_id')))));
    }
    
    function __path()
    {
        // Upload Path
        $path = UPLOAD.'temp/';
        
        // Upload Config
        $config = array(
                            'allowed_types' => 'gif|jpg|png',
                            'max_size' => '1000',
                            'resize' => true
                        );
        
        return array('path' => $path, 'resize' => true, 'config' => $config);
    }

}
