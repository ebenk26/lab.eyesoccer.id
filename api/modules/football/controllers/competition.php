<?php

class Competition extends MX_Controller
{
    var $dtable = 'eyeprofile_competitions';
    var $xtable = 'eyeprofile_league';

    function __construct()
    {
        // PHP Version 5.4
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Authorization, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }

        $postdata = json_decode(file_get_contents("php://input"));
        if(is_object($postdata))
        {
            $this->restapi->__postdata($postdata);
        }

        $this->restapi->__auth();
        $this->load->model('competition_model');
    }

    function save()
    {
        if($_POST)
        {
            $text_title = $this->input->post('competition');
            $new_link = $this->library->seo_title($text_title);


            if (isset($_GET['id'])) {
                $dt1 = array('id_competition' => $_GET['id'], 'league' => addslashes($text_title));
            } else {
                $dt1 = array('competition' => addslashes($text_title));
            }

            $table = (isset($_GET['id'])) ? $this->xtable : $this->dtable;
            $option = $this->action->insert(array('table' => $table, 'insert' => $dt1));
            if ($option['state'] == 0) {
                $this->validation->error_message($option);
                return false;
            }

            $id = $this->db->insert_id();
            $key = substr(md5($id), 0, 7);
            $query = array('table' => $table, 'update' => array('slug' => $new_link.'-'.$key));
            if (isset($_GET['id'])) {
                $query = array_merge($query, array('where' => array('id_league' => $id)));
            } else {
                $query = array_merge($query, array('where' => array('id_competition' => $id)));
            }

            $option = $this->action->update($query);
            if ($option['state'] == 0) {
                $this->validation->error_message($option);
                return false;
            }

            $this->tools->__flashMessage($option);
        } else {
            $data = $this->__rest()->__getstatus('Data must be type post', 400);
            $status = $data['error']['status_code'];
        }

        $this->__rest()->__response($data, $status);
    }

    function update()
    {
        if($_POST)
        {
            $text_title = $this->input->post('title');
            $new_link = $this->library->seo_title($text_title);

            // Category
            if (isset($_GET['id'])) {
                $dt1 = array('news_type_id' => $_GET['id'], 'sub_category_name' => addslashes($text_title));
            } else {
                $dt1 = array('news_type' => addslashes($text_title));
            }

            $table = (isset($_GET['id'])) ? $this->xtable : $this->dtable;
            $where = (isset($_GET['id'])) ? ['sub_news_id' => $this->input->post('idx')] : ['news_type_id' => $this->input->post('idx')];
            $option = $this->action->update(array('table' => $table, 'update' => $dt1, 'where' => $where));
            if ($option['state'] == 0) {
                $this->validation->error_message($option);
                return false;
            }

            $id = $this->input->post('idx');
            $key = substr(md5($id), 0, 7);
            $query = array('table' => $table, 'update' => array('slug' => $new_link.'-'.$key));
            if (isset($_GET['id'])) {
                $query = array_merge($query, array('where' => array('sub_news_id' => $id)));
            } else {
                $query = array_merge($query, array('where' => array('news_type_id' => $id)));
            }

            $option = $this->action->update($query);
            if ($option['state'] == 0) {
                $this->validation->error_message($option);
                return false;
            }

            $this->tools->__flashMessage($option);
        } else {
            $data = $this->__rest()->__getstatus('Data must be type post', 400);
            $status = $data['error']['status_code'];
        }

        $this->__rest()->__response($data, $status);
    }

    function delete()
    {
        if($_POST)
        {
            $option = $this->category_model->__delete($this->input->post('idx'));
            $this->tools->__flashMessage($option);
        } else {
            $data = $this->__rest()->__getstatus('Data must be type post', 400);
            $status = $data['error']['status_code'];
        }

        $this->__rest()->__response($data, $status);
    }

    function disable()
    {
        if($_POST)
        {
            $option = $this->category_model->__disable($this->input->post('idx'));
            $this->tools->__flashMessage($option);
        } else {
            $data = $this->__rest()->__getstatus('Data must be type post', 400);
            $status = $data['error']['status_code'];
        }

        $this->__rest()->__response($data, $status);
    }

    function enable()
    {
        if($_POST)
        {
            $option = $this->category_model->__enable($this->input->post('idx'));
            $this->tools->__flashMessage($option);
        } else {
            $data = $this->__rest()->__getstatus('Data must be type post', 400);
            $status = $data['error']['status_code'];
        }

        $this->__rest()->__response($data, $status);
    }

}