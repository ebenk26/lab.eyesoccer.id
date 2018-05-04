<?php

class Store extends MX_Controller
{
    var $dtable = 'eyemarket_toko';
    // var $xtable = 'eyevent_link';

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
        $this->load->model('store_model');
    }

    function save()
    { var_dump($_POST,$_FILES);exit();
        if($_POST)
        { 
            $name_title = $this->input->post('name');

            $new_link = $this->library->seo_title($name_title);
            $upload = $this->event_model->__upload($new_link);

            // Event
            $dt1 = array(// General
                'jadwal_pertandingan' => date('Y-m-d H:i:s', strtotime($this->input->post('jadwal_pertandingan'))),
                'lokasi_pertandingan' => $this->input->post('lokasi_pertandingan'),
                'live_pertandingan' => $this->input->post('live_pertandingan'),
                'tim_a' => $this->input->post('team_a'),
                'score_a' => $this->input->post('score_a'),
                'score_b' => $this->input->post('score_b'),
                'tim_b' => $this->input->post('team_b'),
                'admin_id' => $this->input->post('ses_user_id')
            );

            $option = $this->action->insert(array('table' => $this->dtable, 'insert' => $dt1));
            $id_match = $this->db->insert_id();

            $event_id = $this->input->post('event_id');
            

            for ($i = 0; $i < count($event_id); $i++)
            {
                $dt_[$i] = array(
                    'id_match' => $id_match,
                    'id_event' => $event_id[$i],
                );
                $option99 = $this->action->insert(array('table' => $this->xtable, 'insert' => $dt_[$i]));
            }

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
            // Match
            $dt1 = array(// General
                    'jadwal_pertandingan' => date('Y-m-d H:i:s', strtotime($this->input->post('jadwal_pertandingan'))),
                    'lokasi_pertandingan' => $this->input->post('lokasi_pertandingan'),
                    'live_pertandingan' => $this->input->post('live_pertandingan'),
                    'tim_a' => $this->input->post('team_a'),
                    'score_a' => $this->input->post('score_a'),
                    'score_b' => $this->input->post('score_b'),
                    'tim_b' => $this->input->post('team_b'),
                    'admin_id' => $this->input->post('ses_user_id')
            );

            $option = $this->action->update(array('table' => $this->dtable, 'update' => $dt1,
                                                  'where' => array('id_jadwal_event' => $this->input->post('idx'))));

            $id_match = $this->input->post('idx');
            $id_event = $this->input->post('event_id');

            $hapus = $this->action->delete(array('table' => $this->xtable, 'where' => array('id_match' => $id_match)));

            for ($i = 0; $i < count($id_event); $i++)
            {
                $dt_[$i] = array(
                    'id_match' => $id_match,
                    'id_event' => $id_event[$i],
                );
                $option99 = $this->action->insert(array('table' => $this->xtable, 'insert' => $dt_[$i]));
            }

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