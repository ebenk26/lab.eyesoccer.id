<?php

class Playercareer_model extends CI_Model
{

    var $query_string = '';
    var $command = '';
    var $dtable = 'eyeprofile_club_career';

    function __construct()
    {
        parent::__construct();
    }

    function __delete($id = '')
    {
        if (isset($_GET['id'])) {
            $option = $this->excurl->reqAction('football/playercareer/delete/?id=' . $_GET['id'], array('idx' => $id));
        } else {
            $option = $this->excurl->reqAction('football/playercareer/delete', array('idx' => $id));
        }
        return $option;
    }

    function __disable($id = '')
    {
        if ($id != NULL) {
            $option = $this->excurl->reqAction('football/playercareer/disable', array('idx' => $id));
            return $option;
        } else {
            redirect('football/playercareer');
        }
    }

    function __enable($id = '')
    {
        if ($id != NULL) {
            $option = $this->excurl->reqAction('football/playercareer/enable', array('idx' => $id));
            return $option;
        } else {
            redirect('football/playercareer');
        }
    }

}
