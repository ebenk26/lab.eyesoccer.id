<?php

class Player extends MX_Controller
{
    var $dtable = 'eyeprofile_player';

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
        $this->load->model('player_model');
    }

    function save()
    {
        if($_POST)
        {
            $name = $this->input->post('name');
            $new_link = $this->library->seo_title($name);
            $upload = $this->player_model->__upload($new_link);

            $dt1 =  array(
                        'name' => addslashes($name),
                        'nickname' => $this->input->post('nickname'),
                        'gender' => $this->input->post('gender'),
                        'nationality' => $this->input->post('nationality'),
                        'height' => $this->input->post('height'),
                        'weight' => $this->input->post('weight'),
                        'birth_place' => $this->input->post('birth_place'),
                        'birth_date' => date('Y-m-d', strtotime($this->input->post('birth_date'))),
                        'father' => $this->input->post('father'),
                        'mother' => $this->input->post('mother'),
                        'fav_club' => $this->input->post('fav_club'),
                        'fav_player' => $this->input->post('fav_player'),
                        'fav_coach' => $this->input->post('fav_coach'),
                        'description' => addslashes($this->input->post('description')),
                        'id_club' => $this->input->post('team_a_id'),
                        'position_a' => $this->input->post('position_a'),
                        'position_b' => $this->input->post('position_b'),
                        'contract_start' => $this->input->post('contract_start'),
                        'contract_end' => $this->input->post('contract_end'),
                        'id_foot' => $this->input->post('id_foot'),
                        'back_number' => $this->input->post('back_number'),
                        'id_level' => $this->input->post('id_level'),
                        'phone' => $this->input->post('phone'),
                        'mobile' => $this->input->post('mobile'),
                        'email' => $this->input->post('email'),
                        'pic' => $upload['data'],
                        'is_verify' => $this->input->post('is_verify'),
                        'is_active' => $this->input->post('is_active'),
                        'date_create' => date('Y-m-d h:i:s'),
                        'id_admin' => $this->input->post('ses_user_id'),
                    );
            
            $option = $this->action->insert(array('table' => $this->dtable, 'insert' => $dt1));
            if ($option['state'] == 0) {
                $this->player_model->__unlink($upload['data']);

                $this->validation->error_message($option);
                return false;
            }

            $id = $this->db->insert_id();
            $option = $this->action->update(array('table' => $this->dtable, 'update' => array('slug' => $id.'-'.$new_link),
                                                  'where' => array('id_player' => $id)));
            if ($option['state'] == 0) {
                $this->player_model->__unlink($upload['data']);

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
            $upload = $this->player_model->__upload($new_link);

            $dt1 =  array(
                'name' => addslashes($name),
                'nickname' => $this->input->post('nickname'),
                'gender' => $this->input->post('gender'),
                'nationality' => $this->input->post('nationality'),
                'height' => $this->input->post('height'),
                'weight' => $this->input->post('weight'),
                'birth_place' => $this->input->post('birth_place'),
                'birth_date' => date('Y-m-d', strtotime($this->input->post('birth_date'))),
                'father' => $this->input->post('father'),
                'mother' => $this->input->post('mother'),
                'fav_club' => $this->input->post('fav_club'),
                'fav_player' => $this->input->post('fav_player'),
                'fav_coach' => $this->input->post('fav_coach'),
                'description' => addslashes($this->input->post('description')),
                'id_club' => $this->input->post('team_a_id'),
                'position_a' => $this->input->post('position_a'),
                'position_b' => $this->input->post('position_b'),
                'contract_start' => $this->input->post('contract_start'),
                'contract_end' => $this->input->post('contract_end'),
                'id_foot' => $this->input->post('id_foot'),
                'back_number' => $this->input->post('back_number'),
                'id_level' => $this->input->post('id_level'),
                'phone' => $this->input->post('phone'),
                'mobile' => $this->input->post('mobile'),
                'email' => $this->input->post('email'),
                'pic' => $upload['data'],
                'is_verify' => $this->input->post('is_verify'),
                'is_active' => $this->input->post('is_active')
                //'id_admin' => $this->input->post('ses_user_id'),
            );
            
            $option = $this->action->update(array('table' => $this->dtable, 'update' => $dt1, 
                                                  'where' => array('id_player' => $this->input->post('idx'))));
            if ($option['state'] == 0) {
                $this->player_model->__unlink($upload['data']);

                $this->validation->error_message($option);
                return false;
            }

            // Remove Old Pic If There is Upload Files
            if ($this->input->post('photo_pic') != '') $this->player_model->__unlink($this->input->post('photo_pic'));
            
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
            $option = $this->player_model->__delete($this->input->post('idx'));
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
            $option = $this->player_model->__delete($this->input->post('idx'));
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
            $option = $this->player_model->__enable($this->input->post('idx'));
            $this->tools->__flashMessage($option);
        } else {
            $data = $this->__rest()->__getstatus('Data must be type post', 400);
            $status = $data['error']['status_code'];
        }

        $this->__rest()->__response($data, $status);
    }

}