<?php

class Playergallery extends MX_Controller
{
    var $dtable = 'tbl_gallery';

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
        $this->load->model('playergallery_model');
    }

    function save()
    {
        if($_POST)
        {
            // FileStore Upload
            $path = ''; $filestore = '';
            if($this->input->post('filestore') != '')
            {
                $path = $this->playergallery_model->__path();
                $filestore = $this->uploader->__filestore('', $path, '');
            }

            if ($filestore)
            {
                foreach ($filestore as $f) {
                    $dt1 = array(// General
                        'id_player' => $this->input->post('id_player'),
                        'title' => 'Gallery Pemain',
                        'tags' => 'Pemain',
                        'pic' => $f['name'],
                        // Data
                        'upload_date' => date('Y-m-d H:i:s'),
                        'publish_by' => 'admin',
                        'publish_type' => 'public'
                        // 'id_admin' => $this->input->post('ses_user_id')
                    );

                    $option = $this->action->insert(array('table' => $this->dtable, 'insert' => $dt1));
                    if ($option['state'] == 0) {
                        $this->validation->error_message($option);
                        return false;
                    }
                }
            } else {
                $xm = array('xState' => false, 'xCss' => 'boxfailed', 'xMsg' => "Please insert images first");
                $this->tools->__flashMessage($xm, true);
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
            $option = $this->playergallery_model->__delete($this->input->post('idx'));
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
            $option = $this->playergallery_model->__disable($this->input->post('idx'));
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
            $option = $this->playergallery_model->__enable($this->input->post('idx'));
            $this->tools->__flashMessage($option);
        } else {
            $data = $this->__rest()->__getstatus('Data must be type post', 400);
            $status = $data['error']['status_code'];
        }

        $this->__rest()->__response($data, $status);
    }

}