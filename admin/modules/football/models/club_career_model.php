<?php

class Club_career_model extends CI_Model
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
        $option = $this->excurl->reqAction('football/clubcareer/delete', array('idx' => $id));
        return $option;
    }

    function __disable($id = '')
    {
        if ($id != NULL) {
            $option = $this->excurl->reqAction('football/clubcareer/disable', array('idx' => $id));
            return $option;
        } else {
            redirect('clubcareer');
        }
    }

    function __enable($id = '')
    {
        if ($id != NULL) {
            $option = $this->excurl->reqAction('football/clubcareer/enable', array('idx' => $id));
            return $option;
        } else {
            redirect('clubcareer');
        }
    }

}
