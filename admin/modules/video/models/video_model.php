<?php

class Video_model extends CI_Model
{

    var $query_string = '';
    var $command = '';
    var $dtable = 'tbl_eyetube';

    function __construct()
    {
        parent::__construct();
    }

    function __delete($id = '')
    {
        $option = $this->excurl->reqAction('video/delete', array('idx' => $id));
        return $option;
    }

    function __disable($id = '')
    {
        if ($id != NULL) {
            $option = $this->excurl->reqAction('video/disable', array('idx' => $id));
            return $option;
        } else {
            redirect('video');
        }
    }

    function __enable($id = '')
    {
        if ($id != NULL) {
            $option = $this->excurl->reqAction('video/enable', array('idx' => $id));
            return $option;
        } else {
            redirect('video');
        }
    }

}
