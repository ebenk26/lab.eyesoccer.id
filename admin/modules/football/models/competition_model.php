<?php

class Competition_model extends CI_Model
{

    var $query_string = '';
    var $command = '';
    var $dtable = 'tbl_event_Competition';

    function __construct()
    {
        parent::__construct();
    }

    function __delete($id = '')
    {
        $option = $this->action->delete(array('table' => $this->dtable, 'where' => array('id_event_Competition' => $id)));

        if ($option['state'] == 0) {
            $this->validation->error_message($option);
            return false;
        }

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
