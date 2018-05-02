<?php

class Match_model extends CI_Model
{

    var $query_string = '';
    var $command = '';
    var $dtable = 'tbl_jadwal_event';

    function __construct()
    {
        parent::__construct();
    }

    function __delete($id = '')
    {
        $option = $this->excurl->reqAction('event/match/delete', array('idx' => $id));
        return $option;
    }

    function __disable($id = '')
    {
        if ($id != NULL) {
            $option = $this->excurl->reqAction('event/match/disable', array('idx' => $id));
            return $option;
        } else {
            redirect('news');
        }
    }

    function __enable($id = '')
    {
        if ($id != NULL) {
            $option = $this->excurl->reqAction('event/match/enable', array('idx' => $id));
            return $option;
        } else {
            redirect('news');
        }
    }

}
