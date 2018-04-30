<?php

class Clubcareer extends MX_Controller
{
    var $dtable = 'eyeprofile_club_career';

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
        $this->load->model('club_career_model');
    }

    function save()
    {
        if($_POST)
        {
            $id_club = $this->input->post('id_club');
            $month = $this->input->post('month');
            $year = $this->input->post('year');
            $tournament = $this->input->post('tournament');
            $coach = $this->input->post('coach');
            $rank = $this->input->post('rank');

            // $new_link = $this->library->seo_title($name);
            // $upload = $this->club_career_model->__upload($new_link);

            // News
            $dt1 = array(// General
                'id_club' => $id_club,
                'month' => $month,
                'year' => $year,
                'tournament' => $tournament,
                'coach' => $coach,
                'rank' => $rank,
                // Data
                'date_create' => date('Y-m-d h:i:s'),
                // 'id_admin' => $this->input->post('ses_user_id')
            );

            $option = $this->action->insert(array('table' => $this->dtable, 'insert' => $dt1));
            if ($option['state'] == 0) {
                $this->club_career_model->__unlink($upload['data']);

                $this->validation->error_message($option);
                return false;
            }

            // $id = $this->db->insert_id();
            // $key = substr(md5($id), 0, 7);
            // $option = $this->action->update(array('table' => $this->dtable, 'update' => array('slug' => $new_link.'-'.$key),
                                                  // 'where' => array('id_club' => $id)));
            // if ($option['state'] == 0) {
                // $this->club_career_model->__unlink($upload['data']);

                // $this->validation->error_message($option);
                // return false;
            // }

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
            $month = $this->input->post('month');
            $year = $this->input->post('year');
            $tournament = $this->input->post('tournament');
            $coach = $this->input->post('coach');
            $rank = $this->input->post('rank');
            $id_career = $this->input->post('id_career');

            // $new_link = $this->library->seo_title($name);
            // $upload = $this->club_career_model->__upload($new_link);

            // News
            $dt1 = array(// General
                'month' => $month,
                'year' => $year,
                'tournament' => $tournament,
                'coach' => $coach,
                'rank' => $rank,
                // Data
                'date_create' => date('Y-m-d h:i:s'),
                // 'id_admin' => $this->input->post('ses_user_id')
            );
            $option = $this->action->update(array('table' => $this->dtable, 'update' => $dt1,
                                                  'where' => array('id_career' => $this->input->post('id_career'))));
            if ($option['state'] == 0) {
                $this->club_career_model->__unlink($upload['data']);

                $this->validation->error_message($option);
                return false;
            }

            // Remove Old Pic If There is Upload Files
            // if ($this->input->post('news_pic') != '') {
                // $this->club_career_model->__unlink($this->input->post('news_pic'));
            // }

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
            $option = $this->club_career_model->__delete($this->input->post('idx'));
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
            $option = $this->club_career_model->__disable($this->input->post('idx'));
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
            $option = $this->club_career_model->__enable($this->input->post('idx'));
            $this->tools->__flashMessage($option);
        } else {
            $data = $this->__rest()->__getstatus('Data must be type post', 400);
            $status = $data['error']['status_code'];
        }

        $this->__rest()->__response($data, $status);
    }

}