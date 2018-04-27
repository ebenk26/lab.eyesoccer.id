<?php

class Club extends MX_Controller
{
    var $dtable = 'eyeprofile_club';
    var $xtable = 'tbl_member';

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

    function verifying()
    { 
        if($_POST)
        {
            $idx = explode(';', $this->input->post('idx'));
            $dt1 =  array(
                        'is_active' => '1',
                        'is_verify' => '1',
                    );

            $where = array('id_club' => $idx[0]);
            $option = $this->action->update(array('table' => $this->dtable, 'update' => $dt1, 'where' => $where));

            $dt2 = array('id_club' => $idx[0]);

            $where = array('id_member' => $idx[1]);
            $option = $this->action->update(array('table' => $this->xtable, 'update' => $dt2, 'where' => $where));

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

}