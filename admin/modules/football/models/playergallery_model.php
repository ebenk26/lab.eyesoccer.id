<?php

class Playergallery_model extends CI_Model
{

    var $query_string = '';
    var $command = '';
    var $dtable = 'es_gallery';

    function __construct()
    {
        parent::__construct();
    }

    function __delete($id = '')
    {
        if (isset($_GET['id'])) {
            $option = $this->excurl->reqAction('football/playergallery/delete/?id=' . $_GET['id'], array('idx' => $id));
        } else {
            $option = $this->excurl->reqAction('football/playergallery/delete', array('idx' => $id));
        }
        return $option;
    }

    function __disable($id = '')
    {
        if ($id != NULL) {
            $option = $this->excurl->reqAction('football/playergallery/disable', array('idx' => $id));
            return $option;
        } else {
            redirect('football/playergallery');
        }
    }

    function __enable($id = '')
    {
        if ($id != NULL) {
            $option = $this->excurl->reqAction('football/playergallery/enable', array('idx' => $id));
            return $option;
        } else {
            redirect('football/playergallery');
        }
    }

}
