<?php

class Foot_model extends CI_Model
{

    var $query_string = '';
    var $command = '';
    var $dtable = 'eyeprofile_player_foot';

    function __construct()
    {
        parent::__construct();
    }

    function __delete($id = '')
    {
        $option = $this->excurl->reqAction('football/foot/delete', array('idx' => $id));
        return $option;
    }

    function __disable($id = '')
    {
        if ($id != NULL) {
            $dt = array('table' => $this->dtable, 'update' => array('is_active' => 0), 'where' => array('id_event_Competition' => $id));
            $option = $this->action->update($dt);

            return $option;
        } else {
            redirect('event/Competition');
        }
    }

    function __enable($id = '')
    {
        if ($id != NULL) {
            $dt = array('table' => $this->dtable, 'update' => array('is_active' => 1), 'where' => array('id_event_Competition' => $id));

            $option = $this->action->update($dt);

            return $option;
        } else {
            redirect('event/Competition');
        }
    }

}
