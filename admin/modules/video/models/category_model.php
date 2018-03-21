<?php

class Category_model extends CI_Model
{

    var $query_string = '';
    var $command = '';
    var $dtable = 'tbl_news_types';
    var $xtable = 'tbl_sub_category_news';

    function __construct()
    {
        parent::__construct();
    }

    function __delete($id = '')
    {
        if (isset($_GET['id'])) {
            $option = $this->excurl->reqAction('video/category/delete/?id=' . $_GET['id'], array('idx' => $id));
        } else {
            $option = $this->excurl->reqAction('video/category/delete', array('idx' => $id));
        }
        return $option;
    }

    function __disable($id = '')
    {
        if ($id != NULL) {
            $option = $this->excurl->reqAction('video/category/disable', array('idx' => $id));
            return $option;
        } else {
            redirect('news/category');
        }
    }

    function __enable($id = '')
    {
        if ($id != NULL) {
            $option = $this->excurl->reqAction('video/category/enable', array('idx' => $id));
            return $option;
        } else {
            redirect('news/category');
        }
    }

}
