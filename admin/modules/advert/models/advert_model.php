<?php

class Advert_model extends CI_Model
{

    var $query_string = '';
    var $command = '';
    var $dtable = 'tbl_ads';

    function __construct()
    {
        parent::__construct();
    }

    function __delete($id = '')
    {
        $option = $this->excurl->reqAction('advert/delete', array('idx' => $id));
        return $option;
    }

    function __disable($id = '')
    {
        if ($id != NULL) {
            $option = $this->excurl->reqAction('advert/disable', array('idx' => $id));
            return $option;
        } else {
            redirect('advert');
        }
    }

    function __enable($id = '')
    {
        if ($id != NULL) {
            $option = $this->excurl->reqAction('advert/enable', array('idx' => $id));
            return $option;
        } else {
            redirect('advert');
        }
    }

}
