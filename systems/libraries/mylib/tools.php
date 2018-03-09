<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tools {
    
    var $query_string = '';
    var $command = '';
    
    const site_verify_url = 'https://www.google.com/recaptcha/api/siteverify';
    
    function __construct() {
        $this->ci = & get_instance();
    }
    
    function __flashMessage($xm = '', $ajax = '', $opt = '') {
	if(isset($ajax) AND is_array($xm))
	{
	    if($opt == '')
	    {
		header('Content-Type: application/json');
		echo json_encode($xm);
	    }
	    exit;
	} else {
	    $this->ci->session->set_userdata($xm);
	    redirect($this->ci->input->post('rdc'));
	}
    }
    
    function __validError($set = '', $ajax = '') {
	$xm = array('xCss' => 'boxfailed', 'xMsg' => validation_errors());
	$this->__flashMessage($xm, $ajax);
    }
    
    function __checkCaptcha($nofif = '', $ajax = '') {
	if($this->ci->session->userdata('capword') != $this->ci->input->post('capword'))
	{
	    $xm = array('xCss' => 'boxfailed', 'xMsg' => $nofif->captcha);
	    $this->__flashMessage($xm, $ajax);
	}
    }
    
    function __googleCaptcha($set = '', $nofif = '', $ajax = '')
    {
	if(isset($_POST['g-recaptcha-response']))
	{
	    $response = $_POST['g-recaptcha-response'];
	    $remoteIp = (!empty($remoteIp)) ? $remoteIp : $this->ci->input->ip_address();
	    
	    $cap = json_decode($set->google_captcha);
	    $secret = $cap->secret;
	    
	    $url = self::site_verify_url.'?secret='.$secret.'&remoteip='.$remoteIp.'&response='.$response;
	    $getResponse = file_get_contents($url);;
	    
	    $responses = json_decode($getResponse, true);
	    if ($responses["success"] == false) {
		$xm = array('xCss' => 'boxfailed', 'xMsg' => $nofif->wrong_captcha);
		$this->__flashMessage($xm, $ajax);
	    }
	    
	    /*$cap = json_decode($set->google_captcha);
	    $secret = $cap->secret;
	    $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER["REMOTE_ADDR"]), true);
	    
	    if ($response["success"] == false) {
		$xm = array('xCss' => 'boxfailed', 'xMsg' => $nofif->wrong_captcha);
		$this->__flashMessage($xm, $ajax);
	    }*/
	} else {
	    $xm = array('xCss' => 'boxfailed', 'xMsg' => $nofif->empty_captcha);
	    $this->__flashMessage($xm, $ajax);
	}
    }
    
    function __actError($opt = array(), $set = '', $ajax = '') {
	$xm = $this->ci->validation->error_message($opt);
	$this->__flashMessage($xm, $ajax, true);
    }
    
    function __email($opt = array(), $set = '')
    {
	if($set)
	{
	    $this->ci->library->config_email($set->smtp_host, $set->smtp_port, $set->smtp_user, $set->smtp_pass);
	    
	    $this->ci->email->from($set->web_mail_noreply, $set->web_name);
	    if(isset($opt['reply_to']))
	    {
		$this->ci->email->reply_to($opt['from'], $opt['name']);
	    }
	    $this->ci->email->to($opt['to']);	    
	    $this->ci->email->subject($set->web_name.' | '.$opt['subject']);
	    $this->ci->email->message($opt['message']);
	    $this->ci->email->send();
	}
    }
    
    function __enddate($dt)
    {
	$total_days = '';
	if($dt)
	{
	    $start_date = date('Y-m-d');
	    $end_date = date('Y-m-d', strtotime($dt));
	    $total_days = (round(abs(strtotime($end_date) - strtotime($start_date)) / 86400, 0) + 1) - 1;
	}
	
	return $total_days;
    }
    
}
