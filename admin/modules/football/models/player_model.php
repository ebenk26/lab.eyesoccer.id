<?php

class Player_model extends CI_Model
{

    var $query_string = '';
    var $command = '';
    var $dtable = 'eyeprofile_player';

    function __construct()
    {
        parent::__construct();
    }

    function __delete($id = '')
    {
        if (isset($_GET['id'])) {
            $option = $this->excurl->reqAction('football/player/delete/?id=' . $_GET['id'], array('idx' => $id));
        } else {
            $option = $this->excurl->reqAction('football/player/delete', array('idx' => $id));
        }
        return $option;
    }

    function __disable($id = '')
    {
        if ($id != NULL) {
            $option = $this->excurl->reqAction('football/player/disable', array('idx' => $id));
            return $option;
        } else {
            redirect('football/player');
        }
    }

    function __enable($id = '')
    {
        if ($id != NULL) {
            $option = $this->excurl->reqAction('football/player/enable', array('idx' => $id));
            return $option;
        } else {
            redirect('football/player');
        }
    }

}
