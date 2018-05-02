<?php

class Event_model extends CI_Model
{

    var $query_string = '';
    var $command = '';
    var $dtable = 'tbl_event';

    function __construct()
    {
        parent::__construct();
    }

    function __delete($id = '')
    {
        $option = $this->excurl->reqAction('event/delete', array('idx' => $id));
        return $option;
    }

    function __disable($id = '')
    {
        if ($id != NULL) {
            $option = $this->excurl->reqAction('event/disable', array('idx' => $id));
            return $option;
        } else {
            redirect('news');
        }
    }

    function __enable($id = '')
    {
        if ($id != NULL) {
            $option = $this->excurl->reqAction('event/enable', array('idx' => $id));
            return $option;
        } else {
            redirect('news');
        }
    }

}
