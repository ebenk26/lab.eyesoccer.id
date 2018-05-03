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

            // Send Email to Club
            $res = $this->excurl->reqCurl('me', ['id_club' => $idx[0], 'detail' => true]);
            if ($res) {
                $v = $res->data[0];
                $subject = 'Registrasi Klub';
                $message = "Hi $v->name <br><br>Terima kasih untuk bergabung di EyeProfile. Klub / SSB anda sudah terverifikasi,
                            untuk mengisi data silahkan klik link berikut: <br><br><a href='https://www.eyesoccer.id/member' target='_blank'>https://www.eyesoccer.id/member</a>
                            <br><span style='color: red; font-size: 10px;'>*apabila link tidak bekerja, copy dan paste ke browser anda.</span><br><br>
                            Kemudian anda dapat melakukan pengisian data seperti info klub, pemain, ofisial, prestasi dan galeri.<br>
                            Untuk informasi lebih lanjut silahkan hubungi kami di email info@eyesoccer.id.<br><br>Terima Kasih<br><br>EyeProfile Team";
                $this->excurl->reqCurl('mailer', ['to' => $v->email, 'subject' => $subject, 'message' => $message]);
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

}