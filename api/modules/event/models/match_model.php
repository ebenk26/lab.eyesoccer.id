<?php

class Match_model extends CI_Model
{

    var $query_string = '';
    var $command = '';
    var $dtable = 'tbl_jadwal_event';
    var $xtable = 'eyevent_link';

    function __construct()
    {
        parent::__construct();
    }

    function __delete($id = '')
    {
        $option = $this->action->delete(array('table' => $this->dtable, 'where' => array('id_jadwal_event' => $id)));
        if ($option['state'] == 0) {
            $this->validation->error_message($option);
            return false;
        }

        $option = $this->action->delete(array('table' => $this->xtable, 'where' => array('id_match' => $id)));
        if ($option['state'] == 0) {
            $this->validation->error_message($option);
            return false;
        }

        return $option;
    }

    function __disable($id = '')
    {
        $dt = array('table' => $this->dtable, 'update' => array('is_active' => 0), 'where' => array('id_jadwal_event' => $id));
        $option = $this->action->update($dt);

        return $option;
    }

    function __enable($id = '')
    {
        $dt = array('table' => $this->dtable, 'update' => array('is_active' => 1), 'where' => array('id_jadwal_event' => $id));
        $option = $this->action->update($dt);

        return $option;
    }

}
