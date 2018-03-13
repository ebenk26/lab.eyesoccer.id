<?php

class News_model extends CI_Model
{

    var $query_string = '';
    var $command = '';
    var $dtable = 'tbl_eyenews';

    function __construct()
    {
        parent::__construct();
    }

    function __delete($id = '')
    {
        $option = $this->excurl->reqAction('news/delete', array('idx' => $id));
        return $option;
    }

    function __disable($id = '')
    {
        if ($id != NULL) {
            $option = $this->excurl->reqAction('news/disable', array('idx' => $id));
            return $option;
        } else {
            redirect('news');
        }
    }

    function __enable($id = '')
    {
        if ($id != NULL) {
            $option = $this->excurl->reqAction('news/enable', array('idx' => $id));
            return $option;
        } else {
            redirect('news');
        }
    }

}
