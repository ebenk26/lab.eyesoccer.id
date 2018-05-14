<?php

class Competition_model extends CI_Model
{

    var $query_string = '';
    var $command = '';
    var $dtable = 'eyeprofile_competitions';
    var $xtable = 'eyeprofile_league';

    function __construct()
    {
        parent::__construct();
    }

    function __delete($id = '')
    {
        if (isset($_GET['id'])) {
            $option = $this->excurl->reqAction('football/competition/delete/?id=' . $_GET['id'], array('idx' => $id));
        } else {
            $option = $this->excurl->reqAction('football/competition/delete', array('idx' => $id));
        }
        return $option;
    }

    function __disable($id = '')
    {
        if ($id != NULL) {
            $get = (isset($_GET['id'])) ? '/?id=' . $_GET['id'] : '';
            $option = $this->excurl->reqAction('football/competition/disable' . $get, array('idx' => $id));
            return $option;
        } else {
            redirect('football/competition');
        }
    }

    function __enable($id = '')
    {
        if ($id != NULL) {
            $get = (isset($_GET['id'])) ? '/?id=' . $_GET['id'] : '';
            $option = $this->excurl->reqAction('football/competition/enable' . $get, array('idx' => $id));
            return $option;
        } else {
            redirect('football/competition');
        }
    }

}
