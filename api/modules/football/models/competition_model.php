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
            $option = $this->action->delete(array('table' => $this->xtable, 'where' => array('id_league' => $id)));
        } else {
            $option = $this->action->delete(array('table' => $this->dtable, 'where' => array('id_competition' => $id)));
            $option = $this->action->delete(array('table' => $this->xtable, 'where' => array('id_competition' => $id)));
        }

        if ($option['state'] == 0) {
            $this->validation->error_message($option);
            return false;
        }

        return $option;
    }

    function __disable($id = '')
    {
        $where = (isset($_GET['id'])) ? 'id_league' : 'id_competition';
        $dt = array('table' => $this->dtable, 'update' => array('is_active' => 0), 'where' => array($where => $id));
        $option = $this->action->update($dt);

        return $option;
    }

    function __enable($id = '')
    {
        $where = (isset($_GET['id'])) ? 'id_league' : 'id_competition';
        $dt = array('table' => $this->dtable, 'update' => array('is_active' => 1), 'where' => array($where => $id));
        $option = $this->action->update($dt);

        return $option;
    }

}
