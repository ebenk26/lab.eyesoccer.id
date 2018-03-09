<?php
class Notif extends MX_Controller 
{
    var $roles = 'admin';
    var $mparent = 'System';
    var $offset = 0;
    var $limit = 10;
    var $dtable = 'es_notif';
    
    function __construct()
    {
        parent::__construct();
	$this->load->model('notif_model');
	
	if($this->session->userdata('login') != TRUE AND $this->session->userdata('user_uid') == '')
	{
	    redirect('login');
	}
	
	$raccess = $this->library->role_access('system/notif');
	if(isset($raccess))
	{
	    $this->roles = $raccess;
	}
    }
    
    public function index()
    {
	$data['title'] = 'Notification';
	$data['parent'] = $this->mparent;
	$data['roles'] = $this->roles;
	$data['content'] = $this->config->item('base_theme').'/notif/notif';
	
	$session = array('xfield_'.$this->dtable => '', 'xsearch_'.$this->dtable => '', 'sortBy_'.$this->dtable => 'notif_id', 'sortDir_'.$this->dtable => 'asc',
			 'multi_search_'.$this->dtable => '', 'multi_data_'.$this->dtable => '', 'voffset_'.$this->dtable => '', 'xoffset_'.$this->dtable => '');
	$this->session->set_userdata($session);
	
	if($this->session->userdata('limit_'.$this->dtable) > 0)
	{
	    $limit = $this->session->userdata('limit_'.$this->dtable);
	} else {
	    $limit = $this->limit;
	}
	
	// Load Lang
	$lang = $this->library->load_lang();
	
	// Sort By
	if($this->session->userdata('sortDir_'.$this->dtable) == 'asc' OR
	   $this->session->userdata('sortDir_'.$this->dtable) == 'desc')
	{
	    $query = array(
			    'lang_code' => $lang[0],
			    'sortBy' 	=> $this->session->userdata('sortBy_'.$this->dtable),
			    'sortDir' 	=> $this->session->userdata('sortDir_'.$this->dtable),
			    'offset' 	=> $this->offset,
			    'limit' 	=> $limit
			    );
	} else {
	    $query = array(
			    'lang_code' => $lang[0],
			    'offset' 	=> $this->offset,
			    'limit' 	=> $limit
			    );
	}
	
	$data['dt'] = $this->catalog->get_notif($query);
	$data['count'] = $this->catalog->get_notif(array('is_count' => true, 'row' => true));
	$data['limit'] = $limit;
	$data['offset'] = $this->offset;
	$data['prefix'] = $this->dtable;
	$data['showpage'] = ceil($data['count']->cc/$limit);
	
	$this->load->view($this->config->item('base_theme').'/template', $data);
    }
    
    function view($option =  array())
    {
	if($this->input->post('val') == true)
	{
	    $data['title'] = 'Notification';
	    $data['roles'] = $this->roles;
	    
	    // Limit Session
	    if($this->input->post('val') > 0)
	    {
		$session = array('limit_'.$this->dtable => $this->input->post('val'));
	    } else {
		if($this->session->userdata('sortDir_'.$this->dtable) == 'asc' OR
		   $this->session->userdata('sortDir_'.$this->dtable) == 'desc')
		{
		    $session = array('xfield_'.$this->dtable => $this->session->userdata('xfield_'.$this->dtable), 'xsearch_'.$this->dtable => $this->session->userdata('xsearch_'.$this->dtable),
				     'sortBy_'.$this->dtable => $this->session->userdata('sortBy_'.$this->dtable), 'sortDir_'.$this->dtable => $this->session->userdata('sortDir_'.$this->dtable));
		} else {
		    $session = array('xfield_'.$this->dtable => $this->session->userdata('xfield_'.$this->dtable), 'xsearch_'.$this->dtable => $this->session->userdata('xsearch_'.$this->dtable),
				     'sortBy_'.$this->dtable => 'notif_id', 'sortDir_'.$this->dtable => 'asc');
		}
	    }
	    $this->session->set_userdata($session);
	    
	    if($this->session->userdata('limit_'.$this->dtable) > 0)
	    {
		$limit = $this->session->userdata('limit_'.$this->dtable);
	    } else {
		$limit = $this->limit;
	    }
	    
	    // Offset
	    if($this->session->userdata('xoffset_'.$this->dtable) > 0)
	    {
		$offset = $this->session->userdata('xoffset_'.$this->dtable);
	    } else {
		$offset = $this->offset;
	    }
	    
	    // Search
	    $xfield = $this->session->userdata('xfield_'.$this->dtable);
	    $xsearch = $this->session->userdata('xsearch_'.$this->dtable);
	    
	    // Load Lang
	    $lang = $this->library->load_lang();
	    
	    // Sort By   
	    if($this->session->userdata('sortDir_'.$this->dtable) == 'asc' OR
	       $this->session->userdata('sortDir_'.$this->dtable) == 'desc')
	    {
		$query = array(
				'lang_code' 	=> $lang[0],
				$xfield		=> $xsearch,
				'sortBy' 	=> $this->session->userdata('sortBy_'.$this->dtable),
				'sortDir' 	=> $this->session->userdata('sortDir_'.$this->dtable),
				'offset' 	=> $offset,
				'limit' 	=> $limit
				);
	    } else {
		$query = array(
				'lang_code' 	=> $lang[0],
				$xfield		=> $xsearch,
				'offset' 	=> $offset,
				'limit' 	=> $limit
				);
	    }
	    
	    $count = array('lang_code' => $lang[0], $xfield => $xsearch, 'is_count' => true, 'row' => true);
	    if($this->session->userdata('multi_search_'.$this->dtable) == true)
	    {
		$query = array_merge($query, $this->session->userdata('multi_data_'.$this->dtable));
		$count = array_merge($count, $this->session->userdata('multi_data_'.$this->dtable));
	    }
	    
	    $data['dt'] = $this->catalog->get_notif($query);
	    $data['count'] = $this->catalog->get_notif($count);
	    $data['limit'] = $limit;
	    $data['offset'] = $offset;
	    $data['prefix'] = $this->dtable;
	    $data['showpage'] = ceil($data['count']->cc/$limit);
	    
	    if($this->input->post('val') > 0 OR isset($option['is_check']))
	    {
		$html = $this->load->view($this->config->item('base_theme').'/notif/notif_jquery', $data, true);
	    } else {
		$html = $this->load->view($this->config->item('base_theme').'/notif/notif', $data, true);
	    }
	    
	    header('Content-Type: application/json');
	    
	    if($option)
	    {
		echo json_encode(array('vHtml' => $html,
					'sortDir' => $this->session->userdata('sortDir_'.$this->dtable),
					'xCss' => $option['xcss'],
					'xMsg' => $option['xmsg']));
	    } else {
		echo json_encode(array('vHtml' => $html,
					'sortDir' => $this->session->userdata('sortDir_'.$this->dtable)));
	    }
	} else {
	    redirect('system/notif');
	}
    }
    
    function search()
    {
	if($this->input->post('val') == true)
	{
	    $data['title'] = 'Notification';
	    
	    $split = explode(",", $this->input->post('val'));
	    
	    if($this->session->userdata('limit_'.$this->dtable) > 0)
	    {
		$limit = $this->session->userdata('limit_'.$this->dtable);
	    } else {
		$limit = $this->limit;
	    }
	    
	    if(count($split) > 1)
	    {
		$opt = array('offset' => $this->offset,
			     'limit' => $this->limit,
			     'value' => $this->input->post('val'));
		
		$query = $this->pagextable->search($opt, $this->dtable);
		
		unset($query['count']['count']);
		$query['count'] = array_merge($query['count'], array('is_count' => true, 'row' => true));
		
		$session = array_merge($query['session'], array('multi_search_'.$this->dtable => '', 'multi_data_'.$this->dtable => '', 'voffset_'.$this->dtable => '', 'xoffset_'.$this->dtable => ''));
	    } else {
		$session = array('multi_search_'.$this->dtable => true, 'multi_data_'.$this->dtable => array(), 'voffset_'.$this->dtable => '', 'xoffset_'.$this->dtable => '');
		$query = array('query' => array_merge($session['multi_data_'.$this->dtable], array('offset' => $this->offset, 'limit' => $limit,
										    'sortBy' => $this->session->userdata('sortBy_'.$this->dtable),
										    'sortDir' => $this->session->userdata('sortDir_'.$this->dtable))),
			       'count' => array_merge($session['multi_data_'.$this->dtable], array('is_count' => true, 'row' => true)));
	    }
	    
	    if(isset($session))
	    {
		$this->session->set_userdata($session);
	    }
	    
	    // Load Lang
	    $lang = $this->library->load_lang();
	    
	    $data['dt'] = $this->catalog->get_notif(array_merge($query['query'], array('lang_code' => $lang[0])));
	    $data['count'] = $this->catalog->get_notif(array_merge($query['count'], array('lang_code' => $lang[0])));
	    $data['limit'] = $limit;
	    $data['offset'] = $this->offset;
	    $data['prefix'] = $this->dtable;
	    $data['showpage'] = ceil($data['count']->cc/$query['query']['limit']);
	    
	    if(count($split) > 1)
	    {
		$html = $this->load->view($this->config->item('base_theme').'/notif/notif_jquery', $data, true);
	    } else {
		$html = $this->load->view($this->config->item('base_theme').'/notif/notif', $data, true);
	    }
	    
	    header('Content-Type: application/json');
	    echo json_encode(array('vHtml' => $html,
				   'sortDir' => $this->session->userdata('sortDir_'.$this->dtable)));
	} else {
	    redirect('system/notif');
	}
    }
    
    function pagetable()
    {
	if($this->input->post('val') == true)
	{
	    $opt = array('offset' => $this->offset,
			 'limit' => $this->limit,
			 'value' => $this->input->post('val'));
	    
	    $query = $this->pagextable->pagination($opt, $this->dtable);
	    
	    unset($query['count']['count']);
	    $query['count'] = array_merge($query['count'], array('is_count' => true, 'row' => true));
	    
	    if($this->session->userdata('multi_search_'.$this->dtable) == true)
	    {
		$query['query'] = array_merge($query['query'], $this->session->userdata('multi_data_'.$this->dtable));
		$query['count'] = array_merge($query['count'], $this->session->userdata('multi_data_'.$this->dtable));
	    }
	    
	    // Load Lang
	    $lang = $this->library->load_lang();
	    
	    // Query Page
	    $data['dt'] = $this->catalog->get_notif(array_merge($query['query'], array('lang_code' => $lang[0])));
	    $data['count'] = $this->catalog->get_notif(array_merge($query['count'], array('lang_code' => $lang[0])));
	    $data['offset'] = $query['query']['offset'];
	    
	    $html = $this->load->view($this->config->item('base_theme').'/notif/notif_table', $data, true);
	    
	    header('Content-Type: application/json');
	    echo json_encode(array('vHtml' => $html,
				    'sortDir' => $this->session->userdata('sortDir_'.$this->dtable)));
	} else {
	    redirect('system/notif');
	}
    }
    
    function add()
    {
	if($this->roles == 'admin' OR $this->roles->menu_created == 1)
	{
	    $data['title'] = 'Notification';
	    $data['parent'] = $this->mparent;
	    $data['content'] = $this->config->item('base_theme').'/notif/add_notif';
	    
	    // Language
	    $data['language'] = $this->catalog->get_language(array('sortBy' => 'is_default', 'sortDir' => 'asc'));
	    $data['numrows'] = count($data['language']);
	    
	    if ($this->input->post('val') == true) {
		$this->load->view($this->config->item('base_theme').'/notif/add_notif', $data);
	    } else {
		$this->load->view($this->config->item('base_theme').'/template', $data);
	    }
	} else {
	    if ($this->input->post('val') == true) {
		$this->library->role_failed();
	    } else {
		redirect('system/notif');
	    }
	}
    }

    function save()
    {
	if ($this->input->post('val') == true AND $this->roles == 'admin' OR $this->roles->menu_created == 1) {
	    
	    // Language Active
	    $countlang = $this->input->post('language_row');
	    if($countlang > 1)
	    {
		$text_title = $this->input->post('notif_name_0');
		$text_desc = $this->input->post('notif_desc_0');
	    } else {
		$text_title = $this->input->post('notif_name');
		$text_desc = $this->input->post('notif_desc');
	    }
	    
	    // Load Lang
	    $lang = $this->library->load_lang();
	    
	    $new_link = $this->library->seo_link(array('function' => 'get_notif', 'title' => $text_title,
						       'lgcode' => $lang[0], 'element_type' => 'notif_notif'));
	    
	    $dt = array('notif_name' => $text_title,
			'notif_desc' => str_replace("'", "~", $text_desc),
			'notif_type' => $this->input->post('notif_type'));
	    
	    $option = $this->action->insert(array('table' => $this->dtable, 'insert' => $dt));
	    if($option['state'] == 0)
	    {
		$this->validation->error_message($option);
		return false;
	    }
	    $notif_id = $this->db->insert_id();
	    
	    $this->load->library('mylib/translation');
	    $this->translation->__ins($notif_id, 'notif_notif', array('name' => 'notif_name', 'desc' => 'notif_desc'));
	    
	    $this->view(array('xcss' => $option['add_message']['xcss'], 'xmsg' => $option['message']));
	} else {
	    redirect('system/notif');
	}
    }

    function edit($id = '')
    {
	if($this->roles == 'admin' OR $this->roles->menu_updated == 1)
	{
	    if($id == '')
	    {
		redirect('system/notif');
	    } else {
		$data['title'] = 'Notification';
		$data['parent'] = $this->mparent;
		$data['content'] = $this->config->item('base_theme').'/notif/edit_notif';
		
		// Load Lang
		$lang = $this->library->load_lang();
		
		$data['dt1'] = $this->catalog->get_notif(array('notif_id' => $id, 'lang_code' => $lang[0], 'row' => true));
		
		// Language
		$data['language'] = $this->catalog->get_language(array('sortBy' => 'is_default', 'sortDir' => 'asc'));
		$data['numrows'] = count($data['language']);
		
		if ($this->input->post('val') == true) {
		    $this->load->view($this->config->item('base_theme').'/notif/edit_notif', $data);
		} else {
		    $this->load->view($this->config->item('base_theme').'/template', $data);
		}
	    }
	} else {
	    if ($this->input->post('val') == true) {
		$this->library->role_failed();
	    } else {
		redirect('system/notif');
	    }
	}
    }
    
    function update()
    {
	if ($this->input->post('val') == true AND $this->roles == 'admin' OR $this->roles->menu_updated == 1) {
	    
	    $idx = $this->input->post('idx');
	    
	    // Language Active
	    $countlang = $this->input->post('language_row');
	    if($countlang > 1)
	    {
		$text_title = $this->input->post('notif_name_0');
		$text_desc = $this->input->post('notif_desc_0');
	    } else {
		$text_title = $this->input->post('notif_name');
		$text_desc = $this->input->post('notif_desc');
	    }
	    
	    // Load Lang
	    $lang = $this->library->load_lang();
	    
	    $new_link = $this->input->post('link_seo')[0];
	    if($this->library->seo_title($text_title) != $new_link)
	    {
		$new_link = $this->library->seo_link(array('function' => 'get_notif', 'title' => $text_title,
							   'lgcode' => $lang[0], 'element_type' => 'notif_notif'));
	    }
	    
	    $dt = array('notif_name' => $text_title,
			'notif_desc' => str_replace("'", "~", $text_desc),
			'notif_type' => $this->input->post('notif_type'));
	    
	    $option = $this->action->update(array('table' => $this->dtable,
						  'update' => $dt,
						  'where' => array('notif_id' => $idx)));
	    if($option['state'] == 0)
	    {
		$this->validation->error_message($option);
		return false;
	    }
	    
	    $this->load->library('mylib/translation');
	    $this->translation->__ins($idx, 'notif_notif', array('name' => 'notif_name', 'desc' => 'notif_desc'));
	    
	    $this->view(array('xcss' => $option['add_message']['xcss'], 'xmsg' => $option['message']));
	} else {
	    redirect('system/notif');
	}
    }

    function delete($id = '', $multi = '')
    {
	if($this->roles == 'admin' OR $this->roles->menu_deleted == 1)
	{
	    if($id == '')
	    {
		redirect('system/notif');
	    } else {
		if ($this->input->post('val') == true) {
		    $option = $this->notif_model->__delete($id);
		    $this->view(array('is_check' => true, 'xcss' => $option['add_message']['xcss'], 'xmsg' => $option['message']));
		} else {
		    redirect('system/notif');
		}
	    }
	} else {
	    if ($this->input->post('val') == true) {
		$this->library->role_failed();
	    } else {
		redirect('system/notif');
	    }
	}
    }

    function checked($id = '')
    {
	if($this->input->post('checked') != NULL)
	{
	    $split = explode(",", $this->input->post('checked'));
	    $count = count($split);
	    
	    switch($id)
	    {
		case 1:
		    if($this->roles == 'admin' OR $this->roles->menu_deleted == 1)
		    {
			for($i=0;$i<$count;$i++)
			{
			    $option = $this->notif_model->__delete($split[$i]);
			}
		    } else {
			$this->library->role_failed();
		    }
		break;
	    }
	    
	    $this->view(array('is_check' => true, 'xcss' => $option['add_message']['xcss'], 'xmsg' => $option['message']));
	} else {
	    redirect('system/notif');
	}
    }
    
}