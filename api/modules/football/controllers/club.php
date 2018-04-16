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
            $id_league = $this->input->post('id_league');
            $id_competition = $this->input->post('id_competition');
            $name = $this->input->post('name');
            $nickname = $this->input->post('nickname');
            $description = $this->input->post('description');
            $establish_date = $this->input->post('establish_date');
            $address = $this->input->post('address');
            $phone = $this->input->post('phone');
            $fax = $this->input->post('fax');
            $email = $this->input->post('email');
            $website = $this->input->post('website');
            $owner = $this->input->post('owner');
            $coach = $this->input->post('coach');
            $manager = $this->input->post('manager');
            $alumnus_name = $this->input->post('alumnus_name');
            $supporter_name = $this->input->post('supporter_name');
            $training_schedule = $this->input->post('training_schedule');
            $stadium = $this->input->post('stadium');
            $stadium_address = $this->input->post('stadium_address');
            $stadium_capacity = $this->input->post('stadium_capacity');
            $legalitas_pt = $this->input->post('legalitas_pt');
            $legalitas_kemenham = $this->input->post('legalitas_kemenham');
            $legalitas_npwp = $this->input->post('legalitas_npwp');
            $legalitas_dirut = $this->input->post('legalitas_dirut');
            $id_provinsi = $this->input->post('id_provinsi');
            $id_kabupaten = $this->input->post('id_kabupaten');

            $new_link = $this->library->seo_title($name);
            $upload = $this->club_model->__upload($new_link);

            // News
            $dt1 = array(// General
                'description' => addslashes($description),
                'address' => addslashes($address),
                'id_competition' => $this->input->post('id_competition'),
                'id_league' => $this->input->post('meta_desc'),
                'name' => $this->input->post('name'),
                'nickname' => $this->input->post('nickname'),
                'establish_date' => $this->input->post('establish_date'),
                'phone' => $this->input->post('phone'),
                'fax' => $this->input->post('fax'),
                'email' => $this->input->post('email'),
                'website' => $this->input->post('website'),
                'owner' => $this->input->post('owner'),
                'coach' => $this->input->post('coach'),
                'manager' => $this->input->post('manager'),
                'alumnus_name' => $this->input->post('alumnus_name'),
                'supporter_name' => $this->input->post('supporter_name'),
                'training_schedule' => $this->input->post('training_schedule'),
                'stadium' => $this->input->post('stadium'),
                'stadium_address' => $this->input->post('stadium_address'),
                'stadium_capacity' => $this->input->post('stadium_capacity'),
                'legalitas_pt' => $this->input->post('legalitas_pt'),
                'legalitas_kemenham' => $this->input->post('legalitas_kemenham'),
                'legalitas_npwp' => $this->input->post('legalitas_npwp'),
                'legalitas_dirut' => $this->input->post('legalitas_dirut'),
                'id_provinsi' => $this->input->post('id_provinsi'),
                'id_kabupaten' => $this->input->post('id_kabupaten'),
                'logo' => $upload['data'],
                // Data
                'date_create' => date('Y-m-d h:i:s'),
                'id_admin' => $this->input->post('ses_user_id')
            );

            $option = $this->action->insert(array('table' => $this->dtable, 'insert' => $dt1));
            if ($option['state'] == 0) {
                $this->club_model->__unlink($upload['data']);

                $this->validation->error_message($option);
                return false;
            }

            $id = $this->db->insert_id();
            $key = substr(md5($id), 0, 7);
            $option = $this->action->update(array('table' => $this->dtable, 'update' => array('slug' => $new_link.'-'.$key),
                                                  'where' => array('id_club' => $id)));
            if ($option['state'] == 0) {
                $this->club_model->__unlink($upload['data']);

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
            $id_league = $this->input->post('id_league');
            $id_competition = $this->input->post('id_competition');
            $name = $this->input->post('name');
            $nickname = $this->input->post('nickname');
            $description = $this->input->post('description');
            $establish_date = $this->input->post('establish_date');
            $address = $this->input->post('address');
            $phone = $this->input->post('phone');
            $fax = $this->input->post('fax');
            $email = $this->input->post('email');
            $website = $this->input->post('website');
            $owner = $this->input->post('owner');
            $coach = $this->input->post('coach');
            $manager = $this->input->post('manager');
            $alumnus_name = $this->input->post('alumnus_name');
            $supporter_name = $this->input->post('supporter_name');
            $training_schedule = $this->input->post('training_schedule');
            $stadium = $this->input->post('stadium');
            $stadium_address = $this->input->post('stadium_address');
            $stadium_capacity = $this->input->post('stadium_capacity');
            $legalitas_pt = $this->input->post('legalitas_pt');
            $legalitas_kemenham = $this->input->post('legalitas_kemenham');
            $legalitas_npwp = $this->input->post('legalitas_npwp');
            $legalitas_dirut = $this->input->post('legalitas_dirut');
            $id_provinsi = $this->input->post('id_provinsi');
            $id_kabupaten = $this->input->post('id_kabupaten');

            $new_link = $this->library->seo_title($name);
            $upload = $this->club_model->__upload($new_link);

            // News
            $dt1 = array(// General
                'description' => addslashes($description),
                'address' => addslashes($address),
                'id_competition' => $this->input->post('id_competition'),
                'id_league' => $this->input->post('meta_desc'),
                'name' => $this->input->post('name'),
                'nickname' => $this->input->post('nickname'),
                'establish_date' => $this->input->post('establish_date'),
                'phone' => $this->input->post('phone'),
                'fax' => $this->input->post('fax'),
                'email' => $this->input->post('email'),
                'website' => $this->input->post('website'),
                'owner' => $this->input->post('owner'),
                'coach' => $this->input->post('coach'),
                'manager' => $this->input->post('manager'),
                'alumnus_name' => $this->input->post('alumnus_name'),
                'supporter_name' => $this->input->post('supporter_name'),
                'training_schedule' => $this->input->post('training_schedule'),
                'stadium' => $this->input->post('stadium'),
                'stadium_address' => $this->input->post('stadium_address'),
                'stadium_capacity' => $this->input->post('stadium_capacity'),
                'legalitas_pt' => $this->input->post('legalitas_pt'),
                'legalitas_kemenham' => $this->input->post('legalitas_kemenham'),
                'legalitas_npwp' => $this->input->post('legalitas_npwp'),
                'legalitas_dirut' => $this->input->post('legalitas_dirut'),
                'id_provinsi' => $this->input->post('id_provinsi'),
                'id_kabupaten' => $this->input->post('id_kabupaten'),
                'logo' => $upload['data'],
                // Data
                'date_create' => date('Y-m-d h:i:s'),
                'id_admin' => $this->input->post('ses_user_id')
            );

            $option = $this->action->update(array('table' => $this->dtable, 'update' => $dt1,
                                                  'where' => array('id_club' => $this->input->post('idx'))));
            if ($option['state'] == 0) {
                $this->club_model->__unlink($upload['data']);

                $this->validation->error_message($option);
                return false;
            }

            // Remove Old Pic If There is Upload Files
            if ($this->input->post('news_pic') != '') {
                $this->club_model->__unlink($this->input->post('news_pic'));
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