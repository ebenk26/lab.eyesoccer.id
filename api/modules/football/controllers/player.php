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
            $key = substr(md5($this->library->app_key()), 0, 7);
            $upload = $this->player_model->__upload($new_link);

            $dt1 =  array(
                        'id_admin' => $this->input->post('ses_user_id'),
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
                        'description' => $this->input->post('description'),
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
                        'slug' => $new_link.'-'.$key,
                        'date_create' => date('Y-m-d h:i:s'),
                    );

            $table = $this->dtable;
            $option = $this->action->insert(array('table' => $table, 'insert' => $dt1));
            
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
            $option = $this->competition_model->__delete($this->input->post('idx'));
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
            $option = $this->competition_model->__delete($this->input->post('idx'));
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
            $option = $this->competition_model->__enable($this->input->post('idx'));
            $this->tools->__flashMessage($option);
        } else {
            $data = $this->__rest()->__getstatus('Data must be type post', 400);
            $status = $data['error']['status_code'];
        }

        $this->__rest()->__response($data, $status);
    }

}