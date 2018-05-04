<?php

class Official extends MX_Controller
{
    var $dtable = 'eyeprofile_club_official';

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
        $this->load->model('official_model');
    }

    function save()
    {
        if($_POST)
        {
            $name = $this->input->post('name');
            $new_link = $this->library->seo_title($name);
            $upload = $this->official_model->__upload($new_link);

            $dt1 =  array(
                        'name' => addslashes($name),
                        'position' => $this->input->post('position'),
                        'license' => $this->input->post('license'),
                        'no_identity' => $this->input->post('no_identity'),
                        'nationality' => $this->input->post('nationality'),
                        'email' => $this->input->post('email'),
                        'phone' => $this->input->post('phone'),
                        'address' => addslashes($this->input->post('address')),
                        'birth_place' => $this->input->post('birth_place'),
                        'birth_date' => date('Y-m-d', strtotime($this->input->post('birth_date'))),
                        'id_club' => $this->input->post('team_a_id'),
                        'pic' => $upload['data'],
                        'date_create' => date('Y-m-d H:i:s')
                    );

            $option = $this->action->insert(array('table' => $this->dtable, 'insert' => $dt1));
            if ($option['state'] == 0) {
                $this->official_model->__unlink($upload['data']);

                $this->validation->error_message($option);
                return false;
            }

            $id = $this->db->insert_id();
            $option = $this->action->update(array('table' => $this->dtable, 'update' => array('slug' => $id.'-'.$new_link),
                                                  'where' => array('id_official' => $id)));
            if ($option['state'] == 0) {
                $this->official_model->__unlink($upload['data']);

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
            $name = $this->input->post('name');
            $new_link = $this->library->seo_title($name);
            $upload = $this->official_model->__upload($new_link);

            $dt1 =  array(
                'name' => addslashes($name),
                'position' => $this->input->post('position'),
                'license' => $this->input->post('license'),
                'no_identity' => $this->input->post('no_identity'),
                'nationality' => $this->input->post('nationality'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'address' => addslashes($this->input->post('address')),
                'birth_place' => $this->input->post('birth_place'),
                'birth_date' => date('Y-m-d', strtotime($this->input->post('birth_date'))),
                'id_club' => $this->input->post('team_a_id'),
                'pic' => $upload['data'],
                'date_create' => date('Y-m-d H:i:s')
            );

            $option = $this->action->update(array('table' => $this->dtable, 'update' => $dt1,
                                                  'where' => array('id_official' => $this->input->post('idx'))));
            if ($option['state'] == 0) {
                $this->official_model->__unlink($upload['data']);

                $this->validation->error_message($option);
                return false;
            }

            // Remove Old Pic If There is Upload Files
            if ($this->input->post('photo_pic') != '') {
                $this->official_model->__unlink($this->input->post('photo_pic'));
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
            $option = $this->official_model->__delete($this->input->post('idx'));
            
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
            $option = $this->official_model->__disable($this->input->post('idx'));
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
            $option = $this->official_model->__enable($this->input->post('idx'));
            $this->tools->__flashMessage($option);
        } else {
            $data = $this->__rest()->__getstatus('Data must be type post', 400);
            $status = $data['error']['status_code'];
        }

        $this->__rest()->__response($data, $status);
    }

}