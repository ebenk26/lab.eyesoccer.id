<?php

class Category_model extends CI_Model
{

    var $query_string = '';
    var $command = '';
    var $dtable = 'tbl_category_eyetube';

    function __construct()
    {
        parent::__construct();
    }

    function __delete($id = '')
    {
        if (isset($_GET['id'])) {
            $option = $this->action->delete(array('table' => $this->dtable, 'where' => array('category_eyetube_id' => $id)));
        } else {
            //$option = $this->action->delete(array('table' => $this->dtable, 'where' => array('parent_id' => $id)));
            $option = $this->action->delete(array('table' => $this->dtable, 'where' => array('category_eyetube_id' => $id)));
        }

        if ($option['state'] == 0) {
            $this->validation->error_message($option);
            return false;
        }

        return $option;
    }

    function __disable($id = '')
    {
        $dt = array('table' => $this->dtable, 'update' => array('is_active' => 0), 'where' => array('news_type_id' => $id));
        $option = $this->action->update($dt);

        return $option;
    }

    function __enable($id = '')
    {
        $dt = array('table' => $this->dtable, 'update' => array('is_active' => 1), 'where' => array('news_type_id' => $id));
        $option = $this->action->update($dt);

        return $option;
    }

}
