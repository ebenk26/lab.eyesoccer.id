<?php

class Language_model extends CI_Model {

    var $query_string = '';
    var $query_default = '';
    var $command = '';
    var $dtable = 'es_language';

    function __construct() {
        parent::__construct();
    }

    function __delete($id = '')
    {
        $dt = array('table' => $this->dtable,
                    'update' => array('is_delete' => 'yes'),
                    'where' => array('language_id' => $id));
        
        $option = $this->action->update($dt);
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
			'update' => array('is_active' => 'no'),
			'where' => array('language_id' => $id));
	    
	    $option = $this->action->update($dt);
	    
	    return $option;
	} else {
	    redirect('system/language');
	}
    }

    function __enable($id = '')
    {
	if($id != NULL)
	{
	    $dt = array('table' => $this->dtable,
			'update' => array('is_active' => 'yes'),
			'where' => array('language_id' => $id));
	    
	    $option = $this->action->update($dt);
	    
	    return $option;
	} else {
	    redirect('system/language');
	}
    }
    
    function __default_language($options = array())
    {
        if ($this->validation->required_field(array('language_id'), $options) == null) {
            return $this->validation->return_message(Validation::update, FALSE, array('xcss' => 'boxfailed', 'required' => Validation::required));
        }

        $this->query_string = 'UPDATE es_language SET ';
        $this->query_string.= 'is_default = "no" ';
        $this->query_string.= 'WHERE language_id NOT IN (' . $options['language_id'] . ')';
        $this->db->trans_begin();
        $this->db->query($this->query_string);
        
        $this->query_default = 'UPDATE es_language SET ';
        $this->query_default.= 'is_default = "yes" ';
        $this->query_default.= 'WHERE language_id=' . $options['language_id'];
        $this->db->query($this->query_default);
        
        if ($this->db->trans_status() == FALSE) {
            $this->db->trans_rollback();
            return $this->validation->return_message(Validation::update, FALSE, array('xcss' => 'boxfailed'));
        }
        
        try {
            $this->db->trans_commit();
        } catch (Exception $e) {
            return $this->validation->return_message(Validation::update, FALSE, array('xcss' => 'boxfailed'));
        }

        return $this->validation->return_message(Validation::update, TRUE, array('xcss' => 'boxsuccess', 'affected' => $this->db->affected_rows()));
    }
    
}
