<?php

class Advert extends MX_Controller
{
    var $dtable = 'tbl_ads';

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
        $this->load->model('advert_model');
    }

    function save()
    {
        if($_POST)
        {
            $text_title = $this->input->post('title');
            $note = $this->input->post('note');

            $new_link = $this->library->seo_title($text_title);
            $upload = $this->advert_model->__upload($new_link);

            $cat = explode(';', $this->input->post('category'));

            // advert
            $dt1 = array(// General
                'category_ads_id' => $this->input->post('category_ads_id'),
                'title' => addslashes($text_title),
                'note' => $this->input->post('note'),
                'pic' => $upload['data'],
                // Data
                'admin_id' => $this->input->post('ses_user_id')
            );

            $option = $this->action->insert(array('table' => $this->dtable, 'insert' => $dt1));
            if ($option['state'] == 0) {
                $this->advert_model->__unlink($upload['data']);

                $this->validation->error_message($option);
                return false;
            }

            $id = $this->db->insert_id();
            $key = substr(md5($id), 0, 7);
            $option = $this->action->update(array('table' => $this->dtable, 'update' => array('url' => $new_link.'-'.$key),
                                                  'where' => array('ads_id' => $id)));
            if ($option['state'] == 0) {
                $this->advert_model->__unlink($upload['data']);

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
            $note = $this->input->post('note');

            $new_link = $this->library->seo_title($text_title);
            $upload = $this->advert_model->__upload($new_link);

            $cat = explode(';', $this->input->post('category'));

            // advert
            $dt1 = array(// General
                'category_ads_id' => $this->input->post('category_ads_id'),
                'title' => addslashes($text_title),
                'note' => $this->input->post('note'),
                'pic' => $upload['data'],
                // Data
                'admin_id' => $this->input->post('ses_user_id')
            );

            $option = $this->action->update(array('table' => $this->dtable, 'update' => $dt1,
                                                  'where' => array('ads_id' => $this->input->post('idx'))));
            if ($option['state'] == 0) {
                $this->advert_model->__unlink($upload['data']);

                $this->validation->error_message($option);
                return false;
            }

            $id = $this->input->post('idx');
            $key = substr(md5($id), 0, 7);
            $option = $this->action->update(array('table' => $this->dtable, 'update' => array('url' => $new_link.'-'.$key),
                                                  'where' => array('ads_id' => $id)));
            if ($option['state'] == 0) {
                $this->advert_model->__unlink($upload['data']);

                $this->validation->error_message($option);
                return false;
            }

            // Remove Old Pic If There is Upload Files
            if ($this->input->post('advert_pic') != '') {
                $this->advert_model->__unlink($this->input->post('advert_pic'));
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
            $option = $this->advert_model->__delete($this->input->post('idx'));
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
            $option = $this->advert_model->__disable($this->input->post('idx'));
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
            $option = $this->advert_model->__enable($this->input->post('idx'));
            $this->tools->__flashMessage($option);
        } else {
            $data = $this->__rest()->__getstatus('Data must be type post', 400);
            $status = $data['error']['status_code'];
        }

        $this->__rest()->__response($data, $status);
    }

}