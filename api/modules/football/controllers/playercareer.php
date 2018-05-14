<?php

class Playercareer extends MX_Controller
{
    var $dtable = 'eyeprofile_player_career';

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
        $this->load->model('playercareer_model');
    }

    function save()
    {
        if($_POST)
        {
            $dt1 = array(// General
                'id_player' => $this->input->post('id_player'),
                'month' => $this->input->post('month'),
                'year' => $this->input->post('year'),
                'club' => $this->input->post('club'),
                'tournament' => $this->input->post('tournament'),
                'country' => $this->input->post('country'),
                'coach' => $this->input->post('coach'),
                'number_of_play' => $this->input->post('number_of_play'),
                'back_number' => $this->input->post('back_number'),
                'is_timnas' => $this->input->post('is_timnas'),
                // Data
                'date_create' => date('Y-m-d H:i:s'),
                // 'id_admin' => $this->input->post('ses_user_id')
            );

            $option = $this->action->insert(array('table' => $this->dtable, 'insert' => $dt1));
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
            $dt1 = array(// General
                'month' => $this->input->post('month'),
                'year' => $this->input->post('year'),
                'club' => $this->input->post('club'),
                'tournament' => $this->input->post('tournament'),
                'country' => $this->input->post('country'),
                'coach' => $this->input->post('coach'),
                'number_of_play' => $this->input->post('number_of_play'),
                'back_number' => $this->input->post('back_number'),
                'is_timnas' => $this->input->post('is_timnas'),
                // Data
                // 'id_admin' => $this->input->post('ses_user_id')
            );
            $option = $this->action->update(array('table' => $this->dtable, 'update' => $dt1,
                                                  'where' => array('id_career' => $this->input->post('idx'))));
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
            $option = $this->playercareer_model->__delete($this->input->post('idx'));
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
            $option = $this->playercareer_model->__disable($this->input->post('idx'));
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
            $option = $this->playercareer_model->__enable($this->input->post('idx'));
            $this->tools->__flashMessage($option);
        } else {
            $data = $this->__rest()->__getstatus('Data must be type post', 400);
            $status = $data['error']['status_code'];
        }

        $this->__rest()->__response($data, $status);
    }

}