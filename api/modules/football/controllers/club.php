<?php

class Club extends MX_Controller
{
    var $dtable = 'eyeprofile_club';

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
        $this->load->model('club_model');
    }

    function save()
    {
        if($_POST)
        {
            $name = $this->input->post('name');
            $description = $this->input->post('description');

            $new_link = $this->library->seo_title($name);
            $logo = $this->club_model->__upload('logo_pic', 'uploadfile', $new_link);
            $legalpt = $this->club_model->__upload('legalpt_pic', 'legal_pt', $new_link);
            $legalkemenham = $this->club_model->__upload('legalkemenham_pic', 'legal_kemenham', $new_link);
            $legalnpwp = $this->club_model->__upload('legalnpwp_pic', 'legal_npwp', $new_link);
            $legaldirut = $this->club_model->__upload('legaldirut_pic', 'legal_dirut', $new_link);

            // News
            $dt1 = array(// General
                'id_league' => $this->input->post('id_league'),
                'id_competition' => $this->input->post('id_competition'),
                'name' => addslashes($name),
                'nickname' => $this->input->post('nickname'),
                'description' => addslashes($description),
                'establish_date' => $this->input->post('establish_date'),
                'address' => addslashes($this->input->post('address')),
                'phone' => $this->input->post('phone'),
                'fax' => $this->input->post('fax'),
                'email' => $this->input->post('email'),
                'website' => $this->input->post('website'),
                'logo' => $logo['data'],
                'owner' => $this->input->post('owner'),
                'coach' => $this->input->post('coach'),
                'manager' => $this->input->post('manager'),
                'alumnus_name' => $this->input->post('alumnus_name'),
                'supporter_name' => $this->input->post('supporter_name'),
                'training_schedule' => $this->input->post('training_schedule'),
                'stadium' => $this->input->post('stadium'),
                'stadium_address' => $this->input->post('stadium_address'),
                'stadium_capacity' => $this->input->post('stadium_capacity'),
                'legalitas_pt' => $legalpt['data'],
                'legalitas_kemenham' => $legalkemenham['data'],
                'legalitas_npwp' => $legalnpwp['data'],
                'legalitas_dirut' => $legaldirut['data'],
                'id_provinsi' => $this->input->post('id_provinsi'),
                'id_kabupaten' => $this->input->post('id_kabupaten'),
                // Data
                'is_verify' => $this->input->post('is_verify'),
                'is_active' => $this->input->post('is_active'),
                'is_national' => $this->input->post('is_national'),
                'date_create' => date('Y-m-d H:i:s'),
                'id_admin' => $this->input->post('ses_user_id')
            );

            $option = $this->action->insert(array('table' => $this->dtable, 'insert' => $dt1));
            if ($option['state'] == 0) {
                $this->club_model->__unlink($logo['data']);
                $this->club_model->__unlink('legal_pt', $legalpt['data']);
                $this->club_model->__unlink('legal_kemenham', $legalkemenham['data']);
                $this->club_model->__unlink('legal_npwp', $legalnpwp['data']);
                $this->club_model->__unlink('legal_dirut', $legaldirut['data']);

                $this->validation->error_message($option);
                return false;
            }

            $id = $this->db->insert_id();
            $option = $this->action->update(array('table' => $this->dtable, 'update' => array('slug' => $id.'-'.$new_link),
                                                  'where' => array('id_club' => $id)));
            if ($option['state'] == 0) {
                $this->club_model->__unlink($logo['data']);
                $this->club_model->__unlink('legal_pt', $legalpt['data']);
                $this->club_model->__unlink('legal_kemenham', $legalkemenham['data']);
                $this->club_model->__unlink('legal_npwp', $legalnpwp['data']);
                $this->club_model->__unlink('legal_dirut', $legaldirut['data']);

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
            $description = $this->input->post('description');

            $new_link = $this->library->seo_title($name);
            $logo = $this->club_model->__upload('logo_pic', 'uploadfile', $new_link);
            $legalpt = $this->club_model->__upload('legalpt_pic', 'legal_pt', $new_link);
            $legalkemenham = $this->club_model->__upload('legalkemenham_pic', 'legal_kemenham', $new_link);
            $legalnpwp = $this->club_model->__upload('legalnpwp_pic', 'legal_npwp', $new_link);
            $legaldirut = $this->club_model->__upload('legaldirut_pic', 'legal_dirut', $new_link);

            // News
            $dt1 = array(// General
                'id_league' => $this->input->post('id_league'),
                'id_competition' => $this->input->post('id_competition'),
                'name' => addslashes($name),
                'nickname' => $this->input->post('nickname'),
                'description' => addslashes($description),
                'establish_date' => date('Y-m-d', strtotime($this->input->post('establish_date'))),
                'address' => addslashes($this->input->post('address')),
                'phone' => $this->input->post('phone'),
                'fax' => $this->input->post('fax'),
                'email' => $this->input->post('email'),
                'website' => $this->input->post('website'),
                'logo' => $logo['data'],
                'owner' => $this->input->post('owner'),
                'coach' => $this->input->post('coach'),
                'manager' => $this->input->post('manager'),
                'alumnus_name' => $this->input->post('alumnus_name'),
                'supporter_name' => $this->input->post('supporter_name'),
                'training_schedule' => $this->input->post('training_schedule'),
                'stadium' => $this->input->post('stadium'),
                'stadium_address' => $this->input->post('stadium_address'),
                'stadium_capacity' => $this->input->post('stadium_capacity'),
                'legalitas_pt' => $legalpt['data'],
                'legalitas_kemenham' => $legalkemenham['data'],
                'legalitas_npwp' => $legalnpwp['data'],
                'legalitas_dirut' => $legaldirut['data'],
                'id_provinsi' => $this->input->post('id_provinsi'),
                'id_kabupaten' => $this->input->post('id_kabupaten'),
                // Data
                'is_verify' => $this->input->post('is_verify'),
                'is_active' => $this->input->post('is_active'),
                'is_national' => $this->input->post('is_national')
                //'id_admin' => $this->input->post('ses_user_id')
            );

            $option = $this->action->update(array('table' => $this->dtable, 'update' => $dt1,
                                                  'where' => array('id_club' => $this->input->post('idx'))));
            if ($option['state'] == 0) {
                $this->club_model->__unlink($logo['data']);
                $this->club_model->__unlink('legal_pt', $legalpt['data']);
                $this->club_model->__unlink('legal_kemenham', $legalkemenham['data']);
                $this->club_model->__unlink('legal_npwp', $legalnpwp['data']);
                $this->club_model->__unlink('legal_dirut', $legaldirut['data']);

                $this->validation->error_message($option);
                return false;
            }

            // Remove Old Pic If There is Upload Files
            if ($this->input->post('logo_pic') != '') $this->club_model->__unlink($this->input->post('logo_pic'));
            if ($this->input->post('legalpt_pic') != '') $this->club_model->__unlink('legal_pt', $this->input->post('legalpt_pic'));
            if ($this->input->post('legalkemenham_pic') != '') $this->club_model->__unlink('legal_kemenham', $this->input->post('legalkemenham_pic'));
            if ($this->input->post('legalnpwp_pic') != '') $this->club_model->__unlink('legal_npwp', $this->input->post('legalnpwp_pic'));
            if ($this->input->post('legaldirut_pic') != '') $this->club_model->__unlink('legal_dirut', $this->input->post('legaldirut_pic'));


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
            $option = $this->club_model->__delete($this->input->post('idx'));
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
            $option = $this->club_model->__disable($this->input->post('idx'));
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
            $option = $this->club_model->__enable($this->input->post('idx'));
            $this->tools->__flashMessage($option);
        } else {
            $data = $this->__rest()->__getstatus('Data must be type post', 400);
            $status = $data['error']['status_code'];
        }

        $this->__rest()->__response($data, $status);
    }

}