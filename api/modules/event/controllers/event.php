<?php

class Event extends MX_Controller
{
    var $dtable = 'tbl_event';

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
        $this->load->model('event_model');
    }

    function save()
    {
        if($_POST)
        {
            $text_title = $this->input->post('title');
            $text_desc = $this->input->post('description');

            $new_link = $this->library->seo_title($text_title);

            $upload = $this->event_model->__upload($new_link);
            $key = substr(md5($this->library->app_key()), 0, 7);

            // Event
            $dt1 = array(// General
                'title' => addslashes($text_title),
                'description' => addslashes($text_desc),
                'url' => $new_link.'-'.$key,
                'pic' => $upload['data'],
                'category' => $this->input->post('category'),
                'is_event' => $this->input->post('is_event'),
                'is_match' => $this->input->post('is_match'),
                // Data
                'publish_on' => date('Y-m-d H:i:s', strtotime($this->input->post('publish_date'))),
                'upload_date' => date('Y-m-d H:i:s'),
                'admin_id' => $this->input->post('ses_user_id')
            );

            $option = $this->action->insert(array('table' => $this->dtable, 'insert' => $dt1));
            if ($option['state'] == 0) {
                $this->event_model->__unlink($upload['data']);

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
            $text_desc = $this->input->post('description');

            $new_link = $this->library->seo_title($text_title);

            $upload = $this->event_model->__upload($new_link);
            $key = substr(md5($this->library->app_key()), 0, 7);

            // News
            $dt1 = array(// General
                'title' => addslashes($text_title),
                'description' => addslashes($text_desc),
                'url' => $new_link.'-'.$key,
                'pic' => $upload['data'],
                'category' => $this->input->post('category'),
                'is_event' => $this->input->post('is_event'),
                'is_match' => $this->input->post('is_match'),
                // Data
                'publish_on' => date('Y-m-d H:i:s', strtotime($this->input->post('publish_date'))),
                'updateon' => date('Y-m-d H:i:s')
            );

            $option = $this->action->update(array('table' => $this->dtable, 'update' => $dt1,
                                                  'where' => array('id_event' => $this->input->post('idx'))));
            if ($option['state'] == 0) {
                $this->event_model->__unlink($upload['data']);

                $this->validation->error_message($option);
                return false;
            }

            // Remove Old Pic If There is Upload Files
            if ($this->input->post('event_pic') != '') {
                $this->event_model->__unlink($this->input->post('event_pic'));
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
            $option = $this->event_model->__delete($this->input->post('idx'));
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
            $option = $this->event_model->__disable($this->input->post('idx'));
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
            $option = $this->event_model->__enable($this->input->post('idx'));
            $this->tools->__flashMessage($option);
        } else {
            $data = $this->__rest()->__getstatus('Data must be type post', 400);
            $status = $data['error']['status_code'];
        }

        $this->__rest()->__response($data, $status);
    }

}