<?php
class Language extends MX_Controller 
{
    var $roles = 'admin';
    var $mparent = 'System';
    var $offset = 0;
    var $limit = 10;
    var $dtable = 'es_language';
    
    function __construct()
    {
        parent::__construct();
	$this->load->model('language_model');
	
	if($this->session->userdata('login') != TRUE AND $this->session->userdata('user_uid') == '')
	{
	    redirect('login');
	}
	
	$raccess = $this->library->role_access('system/language');
	if(isset($raccess))
	{
	    $this->roles = $raccess;
	}
    }
    
    public function index()
    {
	$data['title'] = 'Language';
	$data['parent'] = $this->mparent;
	$data['roles'] = $this->roles;
	$data['content'] = $this->config->item('base_theme').'/language/language';
	
	$session = array('xfield_'.$this->dtable => '', 'xsearch_'.$this->dtable => '', 'sortBy_'.$this->dtable => 'language_order', 'sortDir_'.$this->dtable => '');
	$this->session->set_userdata($session);
	
	if($this->session->userdata('limit_'.$this->dtable) > 0)
	{
	    $limit = $this->session->userdata('limit_'.$this->dtable);
	} else {
	    $limit = $this->limit;
	}
	
	// Sort By
	if($this->session->userdata('sortDir_'.$this->dtable) == 'asc' OR
	   $this->session->userdata('sortDir_'.$this->dtable) == 'desc')
	{
	    $query = array(
			    'sortBy' 	=> $this->session->userdata('sortBy_'.$this->dtable),
			    'sortDir' 	=> $this->session->userdata('sortDir_'.$this->dtable),
			    'offset' 	=> $this->offset,
			    'limit' 	=> $limit
			    );
	} else {
	    $query = array(
			    'offset' 	=> $this->offset,
			    'limit' 	=> $limit
			    );
	}
	
	$data['dt'] = $this->catalog->get_language($query);
	$data['count'] = $this->catalog->get_language(array('is_count' => true, 'row' => true));
	$data['offset'] = $this->offset;
	$data['prefix'] = $this->dtable;
	$data['showpage'] = ceil($data['count']->cc/$limit);
	
	$this->load->view($this->config->item('base_theme').'/template', $data);
    }
    
    function view($option =  array())
    {
	if($this->input->post('val') == true)
	{
	    $data['title'] = 'Language';
	    $data['roles'] = $this->roles;
	    
	    // Limit Session
	    if($this->input->post('val') > 0)
	    {
		$session = array('limit_'.$this->dtable => $this->input->post('val'));
	    } else {
		$session = array('xfield_'.$this->dtable => '', 'xsearch_'.$this->dtable => '', 'sortBy_'.$this->dtable => 'language_order', 'sortDir_'.$this->dtable => '');
	    }
	    $this->session->set_userdata($session);
	    
	    if($this->session->userdata('limit_'.$this->dtable) > 0)
	    {
		$limit = $this->session->userdata('limit_'.$this->dtable);
	    } else {
		$limit = $this->limit;
	    }
	    
	    // Sort By   
	    if($this->session->userdata('sortDir_'.$this->dtable) == 'asc' OR
	       $this->session->userdata('sortDir_'.$this->dtable) == 'desc')
	    {
		$query = array(
				'sortBy' 	=> $this->session->userdata('sortBy_'.$this->dtable),
				'sortDir' 	=> $this->session->userdata('sortDir_'.$this->dtable),
				'offset' 	=> $this->offset,
				'limit' 	=> $limit
				);
	    } else {
		$query = array(
				'offset' 	=> $this->offset,
				'limit' 	=> $limit
				);
	    }
	    
	    $data['dt'] = $this->catalog->get_language($query);
	    $data['count'] = $this->catalog->get_language(array('is_count' => true, 'row' => true));
	    $data['offset'] = $this->offset;
	    $data['prefix'] = $this->dtable;
	    $data['showpage'] = ceil($data['count']->cc/$limit);
	    
	    if($this->input->post('val') > 0 OR isset($option['is_check']))
	    {
		$html = $this->load->view($this->config->item('base_theme').'/language/language_jquery', $data, true);
	    } else {
		$html = $this->load->view($this->config->item('base_theme').'/language/language', $data, true);
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
	    redirect('system/language');
	}
    }
    
    function search()
    {
	if($this->input->post('val') == true)
	{
	    $data['title'] = 'Language';
	    
	    $opt = array('offset' => $this->offset,
			 'limit' => $this->limit,
			 'value' => $this->input->post('val'));
	    
	    $query = $this->pagextable->search($opt, $this->dtable);
	    
	    unset($query['count']['count']);
	    $query['count'] = array_merge($query['count'], array('is_count' => true, 'row' => true));
	    
	    if(isset($query['session']))
	    {
		$this->session->set_userdata($query['session']);
	    }
	    
	    $data['dt'] = $this->catalog->get_language($query['query']);
	    $data['count'] = $this->catalog->get_language($query['count']);
	    $data['offset'] = $this->offset;
	    $data['prefix'] = $this->dtable;
	    $data['showpage'] = ceil($data['count']->cc/$query['query']['limit']);
	    
	    $html = $this->load->view($this->config->item('base_theme').'/language/language_jquery', $data, true);
	    
	    header('Content-Type: application/json');
	    echo json_encode(array('vHtml' => $html,
				   'sortDir' => $this->session->userdata('sortDir_'.$this->dtable)));
	} else {
	    redirect('system/language');
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
	    
	    // Query Page
	    $data['dt'] = $this->catalog->get_language($query['query']);
	    $data['count'] = $this->catalog->get_language($query['count']);
	    $data['offset'] = $query['query']['offset'];
	    
	    $html = $this->load->view($this->config->item('base_theme').'/language/language_table', $data, true);
	    
	    header('Content-Type: application/json');
	    echo json_encode(array('vHtml' => $html,
				    'sortDir' => $this->session->userdata('sortDir_'.$this->dtable)));
	} else {
	    redirect('system/language');
	}
    }
    
    function add()
    {
	if($this->roles == 'admin' OR $this->roles->menu_created == 1)
	{
	    $data['title'] = 'Language';
	    $data['parent'] = $this->mparent;
	    $data['content'] = $this->config->item('base_theme').'/language/add_language';
	 
	    if ($this->input->post('val') == true) {
		$this->load->view($this->config->item('base_theme').'/language/add_language', $data);
	    } else {
		$this->load->view($this->config->item('base_theme').'/template', $data);
	    }
	} else {
	    if ($this->input->post('val') == true) {
		$this->library->role_failed();
	    } else {
		redirect('system/language');
	    }
	}
    }

    function edit($id = '')
    {
	if($this->roles == 'admin' OR $this->roles->menu_updated == 1)
	{
	    if($id == '')
	    {
		redirect('system/language');
	    } else {
		$data['title'] = 'Language';
		$data['parent'] = $this->mparent;
		$data['content'] = $this->config->item('base_theme').'/language/edit_language';
		
		$data['dt1'] = $this->catalog->get_language(array('language_id' => $id, 'row' => true));
	     
		if ($this->input->post('val') == true) {
		    $this->load->view($this->config->item('base_theme').'/language/edit_language', $data);
		} else {
		    $this->load->view($this->config->item('base_theme').'/template', $data);
		}
	    }
	} else {
	    if ($this->input->post('val') == true) {
		$this->library->role_failed();
	    } else {
		redirect('system/language');
	    }
	}
    }
    
    function update()
    {
	if ($this->input->post('val') == true AND $this->roles == 'admin' OR $this->roles->menu_updated == 1) {
	    
	    $dt = array('lang_code' => $this->input->post('lang_code'),
			'language_name' => $this->input->post('language_name'),
			'is_active' => $this->input->post('is_active'),
			'is_delete' => 'no');
	    
	    $option = $this->action->update(array('table' => $this->dtable,
						  'update' => $dt,
						  'where' => array('lang_code' => $this->input->post('lang_code'))));
	    if($option['state'] == 0)
	    {
		$this->validation->error_message($option);
		return false;
	    }
	    
	    $this->view(array('xcss' => $option['add_message']['xcss'], 'xmsg' => $option['message']));
	} else {
	    redirect('system/language');
	}
    }

    function delete($id = '', $multi = '')
    {
	if($this->roles == 'admin' OR $this->roles->menu_deleted == 1)
	{
	    if($id == '')
	    {
		redirect('system/language');
	    } else {
		if ($this->input->post('val') == true) {
		    $option = $this->language_model->__delete($id);
		    $this->view(array('is_check' => true, 'xcss' => $option['add_message']['xcss'], 'xmsg' => $option['message']));
		} else {
		    redirect('system/language');
		}
	    }
	} else {
	    if ($this->input->post('val') == true) {
		$this->library->role_failed();
	    } else {
		redirect('system/language');
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
			    $option = $this->language_model->__delete($split[$i]);
			}
		    } else {
			$this->library->role_failed();
		    }
		break;
	    
		case 2:
		    if($this->roles == 'admin' OR $this->roles->menu_updated == 1)
		    {
			if($count > 1)
			{
			    $option = array('add_message' => array('xcss' => 'boxfailed'),
					    'message' => 'Choose one for default language');
			} else {
			    $option = $this->language_model->__default_language(array('language_id' => $this->input->post('checked')));
			}
		    } else {
			$this->library->role_failed();
		    }
		break;
		
		case 3:
		    if($this->roles == 'admin' OR $this->roles->menu_updated == 1)
		    {
			for($i=0;$i<$count;$i++)
			{
			    $option = $this->language_model->__enable($split[$i]);
			}
		    } else {
			$this->library->role_failed();
		    }
		break;
		
		case 4:
		    if($this->roles == 'admin' OR $this->roles->menu_updated == 1)
		    {
			for($i=0;$i<$count;$i++)
			{
			    $option = $this->language_model->__disable($split[$i]);
			}
		    } else {
			$this->library->role_failed();
		    }
		break;
	    }
	    
	    $this->view(array('is_check' => true, 'xcss' => $option['add_message']['xcss'], 'xmsg' => $option['message']));
	} else {
	    redirect('system/language');
	}
    }
    
    function autocountry($idx = '')
    {
	$search = $this->input->post('val');
	
	$dt = $this->catalog->get_country(array('country_name' => $search));
	$numrows = $this->catalog->get_country(array('country_name' => $search, 'is_count' => true, 'row' => true));
	
	if($numrows->cc > 0)
	{
	    foreach($dt as $t)
	    {
		$bold_search = "<b>$search</b>";
		$country_name= str_ireplace($search, $bold_search, $t->country_name);
		
		echo "<div class='showauto' val='$t->country_id' idx='$idx' style='text-transform: uppercase;'>
			<span class='$t->country_id' val='$t->country_name'>$country_name</span>
		      </div>";
	    }
	} else {
	    echo "<div class='showauto'><span>No Result</span></div>";
	}
    }
    
    function autoiso($idx = '')
    {
	$search = $this->input->post('val');
	
	$dt = $this->catalog->get_language(array('lang_code' => $search, 'is_delete' => 'yes'));
	$numrows = $this->catalog->get_language(array('lang_code' => $search, 'is_delete' => 'yes', 'is_count' => true, 'row' => true));
	
	if($numrows->cc > 0)
	{
	    foreach($dt as $t)
	    {
		$bold_search = "<b>$search</b>";
		$lang_code = str_ireplace($search, $bold_search, $t->lang_code);
		
		echo "<div class='showauto' val='$t->language_id' idx='$idx' style='text-transform: uppercase;'>
			<span class='$t->language_id' val='$t->lang_code'><img src=" . base_url("../upload/flags/$t->lang_code.png") . "> $lang_code</span>
		      </div>";
	    }
	} else {
	    echo "<div class='showauto'><span>No Result</span></div>";
	}
    }
    
}