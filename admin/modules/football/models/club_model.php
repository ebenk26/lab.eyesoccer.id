<?php

class Club_model extends CI_Model
{

    var $query_string = '';
    var $command = '';
    var $dtable = 'eyeprofile_club';

    function __construct()
    {
        parent::__construct();
    }

    function __delete($id = '')
    {
        $option = $this->excurl->reqAction('football/club/delete', array('idx' => $id));
        return $option;
    }

    function __disable($id = '')
    {
        if ($id != NULL) {
            $option = $this->excurl->reqAction('football/club/disable', array('idx' => $id));
            return $option;
        } else {
            redirect('club');
        }
    }

    function __enable($id = '')
    {
        if ($id != NULL) {
            $option = $this->excurl->reqAction('football/club/enable', array('idx' => $id));
            return $option;
        } else {
            redirect('club');
        }
    }

}
