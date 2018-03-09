<?php
class Setting extends MX_Controller 
{
    var $roles = 'admin';
    var $mparent = 'System';
    var $offset = 0;
    var $limit = 10;
    var $dtable = 'es_setting';
    
    function __construct()
    {
        parent::__construct();
	$this->load->model('setting_model');
	
	if($this->session->userdata('login') != TRUE AND $this->session->userdata('user_uid') == '')
	{
	    redirect('login');
	}
	
	$raccess = $this->library->role_access('system/setting');
	if(isset($raccess))
	{
	    $this->roles = $raccess;
	}
    }
    
    public function index()
    {
	$data['title'] = 'Setting';
	$data['parent'] = $this->mparent;
	$data['content'] = $this->config->item('base_theme').'/setting/edit_setting';
	
	$data['dt1'] = $this->catalog->get_setting(array('setting_id' => '1', 'row' => true));
	$data['captcha'] = json_decode($data['dt1']->google_captcha);
	$data['sosmed'] = json_decode($data['dt1']->social_api);
	$data['textcode'] = str_replace("~", "'", $data['dt1']->text_code);
	$data['textnotif'] = str_replace("~", "'", $data['dt1']->text_notif);
	
	// Language
	$data['language'] = $this->catalog->get_language(array('sortBy' => 'is_default', 'sortDir' => 'asc'));
	$data['numrows'] = count($data['language']);
	
	$this->load->view($this->config->item('base_theme').'/template', $data);
    }
    
    function edit($id = '1', $option =  array())
    {
	if($this->roles == 'admin' OR $this->roles->menu_updated == 1)
	{
	    if($id == '')
	    {
		redirect('system/setting');
	    } else {
		$data['title'] = 'Setting';
		$data['parent'] = $this->mparent;
		$data['content'] = $this->config->item('base_theme').'/setting/edit_setting';
		
		$data['dt1'] = $this->catalog->get_setting(array('setting_id' => $id, 'row' => true));
		$data['captcha'] = json_decode($data['dt1']->google_captcha);
		$data['sosmed'] = json_decode($data['dt1']->social_api);
		$data['textcode'] = str_replace("~", "'", $data['dt1']->text_code);
		$data['textnotif'] = str_replace("~", "'", $data['dt1']->text_notif);
		
		// Language
		$data['language'] = $this->catalog->get_language(array('sortBy' => 'is_default', 'sortDir' => 'asc'));
		$data['numrows'] = count($data['language']);
		
		if ($this->input->post('val') == true) {
		    if($option)
		    {
			$html = $this->load->view($this->config->item('base_theme').'/setting/edit_setting', $data, true);
			
			echo json_encode(array('vHtml' => $html,
						'xCss' => $option['xcss'],
						'xMsg' => $option['xmsg']));
		    } else {
			$this->load->view($this->config->item('base_theme').'/setting/edit_setting', $data);
		    }
		} else {
		    $this->load->view($this->config->item('base_theme').'/template', $data);
		}
	    }
	} else {
	    if ($this->input->post('val') == true) {
		$this->library->role_failed();
	    } else {
		redirect('system/setting');
	    }
	}
    }
    
    function update()
    {
	if ($this->input->post('val') == true AND $this->roles == 'admin' OR $this->roles->menu_updated == 1) {
	    
	    $upload = $this->setting_model->__upload();
	    
	    // Autotext
	    if($this->input->post('text_title') != '')
	    {
		$textcode = '';
		if($this->input->post('language_row') != '')
		{
		    $tcode = $this->input->post('text_title');
		    foreach($tcode as $f1 => $v1)
		    {
			foreach($v1 as $f2 => $v2)
			{
			    $text_seo = str_replace('-', '_' , $this->library->seo_title($this->input->post('text_title')[$f1][$f2]));
			    $textcode[] = array('lang_id' => $f1,
						'text_title' => $this->input->post('text_title')[$f1][$f2],
						$text_seo => $this->input->post('text_value')[$f1][$f2],
						'text_code' => $text_seo);
			}
		    }
		} else {
		    $count = count($this->input->post('rows_text'));
		    for($x=0;$x<$count;$x++)
		    {
			$text_seo = str_replace('-', '_' , $this->library->seo_title($this->input->post('text_title')[$x]));
			$textcode[] = array('text_title' => $this->input->post('text_title')[$x],
					    $text_seo => $this->input->post('text_value')[$x],
					    'text_code' => $text_seo);
		    }
		}
		
		$textcode = json_encode($textcode);
		$textcode = str_replace("'", "~", $textcode);
	    } else {
		$textcode = '';
	    }
	    
	    // Autonotif
	    if($this->input->post('notif_title') != '')
	    {
		$notifcode = '';
		if($this->input->post('language_row') != '')
		{
		    $tcode = $this->input->post('notif_title');
		    foreach($tcode as $f1 => $v1)
		    {
			foreach($v1 as $f2 => $v2)
			{
			    $notif_seo = str_replace('-', '_' , $this->library->seo_title($this->input->post('notif_title')[$f1][$f2]));
			    $notifcode[] = array('lang_id' => $f1,
						'notif_title' => $this->input->post('notif_title')[$f1][$f2],
						$notif_seo => $this->input->post('notif_value')[$f1][$f2],
						'notif_code' => $notif_seo);
			}
		    }
		} else {
		    $count = count($this->input->post('rows_notif'));
		    for($x=0;$x<$count;$x++)
		    {
			$notif_seo = str_replace('-', '_' , $this->library->seo_title($this->input->post('notif_title')[$x]));
			$notifcode[] = array('notif_title' => $this->input->post('notif_title')[$x],
					    $notif_seo => $this->input->post('notif_value')[$x],
					    'notif_code' => $notif_seo);
		    }
		}
		
		$notifcode = json_encode($notifcode);
		$notifcode = str_replace("'", "~", $notifcode);
	    } else {
		$notifcode = '';
	    }
	    
	    $dt = array('setting_id' => $this->input->post('idx'),
			// Store
			'web_name' => $this->input->post('web_name'),
			'web_tagline' => $this->input->post('web_tagline'),
			'web_keyword' => $this->input->post('web_keyword'),
			'web_desc' => $this->input->post('web_desc'),
			'web_mail_invoice' => $this->input->post('web_mail_invoice'),
			'web_mail_contact' => $this->input->post('web_mail_contact'),
			'web_mail_noreply' => $this->input->post('web_mail_noreply'),
			'web_contact' => $this->input->post('web_contact'),
			'web_address' => $this->input->post('web_address'),
			'web_logo' => $upload['data'][0],
			'web_favicon' => $upload['data'][1],
			// View Product
			'post_home' => $this->input->post('post_home'),
			'post_category' => $this->input->post('post_category'),
			// Google
			'google_captcha' => json_encode($this->input->post('google_captcha')),
			'google_verify' => str_replace("'", "~", $this->input->post('google_verify')),
			'google_analytics' => str_replace("'", "~", $this->input->post('google_analytics')),
			'google_maps' => str_replace("'", "~", $this->input->post('google_maps')),
			// SMTP Mail
			'smtp_host' => $this->input->post('smtp_host'),
			'smtp_port' => $this->input->post('smtp_port'),
			'smtp_user' => $this->input->post('smtp_user'),
			'smtp_pass' => $this->input->post('smtp_pass'),
			// Social API
			'social_api' => json_encode($this->input->post('sm_app')),
			// Textcode
			'text_code' => $textcode,
			'text_notif' => $notifcode);
	    
	    $option = $this->action->update(array('table' => $this->dtable,
						  'update' => $dt,
						  'where' => array('setting_id' => $this->input->post('idx'))));
	    if($option['state'] == 0)
	    {
		$this->setting_model->__unlink($upload['data']);
		
		$this->validation->error_message($option);
		return false;
	    }
	    
	    // Remove Old Pic If There is Upload Files 
	    if($this->input->post('temp_web_logo') != '')
	    {
	        $this->setting_model->__unlink($this->input->post('temp_web_logo'));
	    }
	    
	    $this->edit($this->input->post('idx'), array('xcss' => $option['add_message']['xcss'], 'xmsg' => $option['message']));
	} else {
	    redirect('system/setting');
	}
    }
    
}