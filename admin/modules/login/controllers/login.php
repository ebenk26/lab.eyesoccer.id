<?php

class Login extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        if (isset($_COOKIE['email']) and isset($_COOKIE['password'])) {
            $email = $_COOKIE['email'];
            $pass = $_COOKIE['password'];

            $dt = $this->db->query("SELECT user_id, user_name, user_pass, user_fname, user_email, user_level, is_active 
                                    FROM es_users WHERE (user_name='$email' OR user_email='$email') AND user_pass='$pass'")->row();

            if ($dt) {
                if ($dt->is_active > 0) {
                    setcookie('email', $email, time() + (86400 * 30), "/");
                    setcookie('password', $pass, time() + (86400 * 30), "/");

                    $uname = $dt->user_fname;
                    $ulevel = $dt->user_level;

                    $session = array('user_id' => $dt->user_id,
                                    'user_fname' => $uname,
                                    'user_level' => $ulevel,
                                    'user_uid' => uniqid('sp_'),
                                    'login' => TRUE,
                                    'xsession' => $this->session->userdata('session_id'));
                    $this->session->set_userdata($session);

                    redirect('dashboard');
                } else {
                    setcookie('email', '', 0, "/");
                    setcookie('password', '', 0, "/");
                    $this->session->set_flashdata('message', 'Your account has not been activated');
                    redirect('login');
                }
            } else {
                setcookie('email', '', 0, "/");
                setcookie('password', '', 0, "/");
                $this->session->set_flashdata('message', 'Invalid Email or Password');
                redirect('login');
            }
        } else {
            $this->load->view($this->config->item('base_theme') . '/login');
        }
    }

    function check()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', validation_errors());
            redirect('login');
        } else {
            $email = $this->input->post('email');
            $pass = md5(base64_encode($this->input->post('password')));

            $dt = $this->db->query("SELECT user_id, user_name, user_pass, user_fname, user_email, user_level, is_active 
                                    FROM es_users WHERE (user_name='$email' OR user_email='$email') AND user_pass='$pass'")->row();

            if ($dt) {
                if ($dt->is_active > 0) {
                    if ($this->input->post('remember') != NULL) {
                        setcookie('email', $email, time() + (86400 * 30), "/");
                        setcookie('password', $pass, time() + (86400 * 30), "/");
                    }

                    $uname = $dt->user_fname;
                    $ulevel = $dt->user_level;

                    $session = array('user_id' => $dt->user_id,
                                    'user_fname' => $uname,
                                    'user_level' => $ulevel,
                                    'user_uid' => uniqid('sp_'),
                                    'login' => TRUE,
                                    'xsession' => $this->session->userdata('session_id'));
                    $this->session->set_userdata($session);

                    redirect('dashboard');
                } else {
                    $this->session->set_flashdata('message', 'Your account has not been activated');
                    redirect('login');
                }
            } else {
                $this->session->set_flashdata('message', 'Invalid Email or Password');
                redirect('login');
            }
        }
    }

    function forgot_password()
    {
        $this->load->view($this->config->item('base_theme') . '/password');
    }

    function check_email()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', validation_errors());
            redirect('login/forgot_password');
        } else {
            $email = $this->input->post('email');

            $dt = $this->db->query("SELECT user_id, user_name, user_pass, user_fname, user_email
				    FROM es_users WHERE user_email='$email'")->row();

            if ($dt) {
                // Update Password
                $newpass = substr(md5(uniqid(rand(), 1)), 3, 10);
                $this->db->query("UPDATE es_users SET user_pass='" . md5(base64_encode($newpass)) . "' WHERE user_id=$dt->user_id");

                // Setting
                $set = $this->db->query("SELECT web_mail_contact, web_name, smtp_host, smtp_port, smtp_user, smtp_pass FROM es_setting WHERE setting_id=1")->row();
                $this->library->config_email($set->smtp_host, $set->smtp_port, $set->smtp_user, $set->smtp_pass);

                //Sent Mail To New Member
                $this->email->from($set->web_mail_contact, $set->web_name);
                $this->email->to($email);
                $this->email->subject("$set->web_name | New Password");

                $this->email->message("New Password: $newpass");

                if (!$this->email->send()) {
                    $this->session->set_flashdata('message', 'New Password Failed Sent <br> Please Try Again');
                    redirect('login/forgot_password');
                } else {
                    $this->session->set_flashdata('message', 'New Password Successfully Sent <br> Please Check Your Email');
                    redirect('login');
                }
            } else {
                $this->session->set_flashdata('message', 'Email is not registered');
                redirect('login/forgot_password');
            }
        }
    }

    function session_checking()
    {
        //if($this->session->userdata('login') == TRUE)
        //{
        //    echo '1';
        //} else {
        //    echo '0';
        //    $this->session->sess_destroy();
        //}
    }

    function signout()
    {
        $this->session->sess_destroy();
        setcookie('email', '', 0, "/");
        setcookie('password', '', 0, "/");
        redirect('login');
    }
}