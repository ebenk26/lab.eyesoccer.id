<?php

class Notif_model extends CI_Model {

    var $query_string = '';
    var $command = '';
    var $dtable = 'es_notif';
    var $ttable = 'es_translation';

    function __construct() {
        parent::__construct();
    }

    function __delete($id = '')
    {
        $option = $this->action->delete(array('table' => $this->dtable,
                                              'where' => array('notif_id' => $id)));
        if($option['state'] == 0)
        {
            $this->validation->error_message($option);
            return false;
        }
        
	$this->load->library('mylib/translation');
	$this->translation->__del($id, 'notif_notif');
	
        return $option;
    }
    
}
