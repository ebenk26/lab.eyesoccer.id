<?php

class Club_model extends CI_Model
{

    var $query_string = '';
    var $command = '';
    var $dtable = 'eyeprofile_club_register';

    function __construct()
    {
        parent::__construct();
    }

    function __verifying($id = '')
    {
        $option = $this->excurl->reqAction('verify/club/verifying', array('idx' => $id));
        return $option;
    }

    function __delete($id = '')
    {
        $option = $this->excurl->reqAction('verify/club/delete', array('idx' => $id));
        return $option;
    }

}
