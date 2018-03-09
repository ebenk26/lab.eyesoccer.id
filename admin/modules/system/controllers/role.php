<?php
class Role extends MX_Controller 
{
    var $roles = 'admin';
    var $mparent = 'System';
    var $offset = 0;
    var $limit = 10;
    var $dtable = 'es_menu_roles';
    
    function __construct()
    {
        parent::__construct();
	$this->load->model('role_model');
	
	if($this->session->userdata('login') != TRUE AND $this->session->userdata('user_uid') == '')
	{
	    redirect('login');
	}
	
	$raccess = $this->library->role_access('system/role');
	if(isset($raccess))
	{
	    $this->roles = $raccess;
	}
    }
    
    public function index()
    {
	$data['title'] = 'Roles';
	$data['parent'] = $this->mparent;
	$data['roles'] = $this->roles;
	$data['content'] = $this->config->item('base_theme').'/role/role';
	
	$session = array('xfield_'.$this->dtable => '', 'xsearch_'.$this->dtable => '', 'sortBy_'.$this->dtable => '', 'sortDir_'.$this->dtable => '');
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
	
	$data['dt'] = $this->catalog->get_menu_roles($query);
	$data['count'] = $this->catalog->get_menu_roles(array('is_count' => true, 'row' => true));
	$data['offset'] = $this->offset;
	$data['prefix'] = $this->dtable;
	$data['showpage'] = ceil($data['count']->cc/$limit);
	
	$this->load->view($this->config->item('base_theme').'/template', $data);
    }
    
    function view($option =  array())
    {
	if($this->input->post('val') == true)
	{
	    $data['title'] = 'Roles';
	    $data['roles'] = $this->roles;
	    
	    // Limit Session
	    if($this->input->post('val') > 0)
	    {
		$session = array('limit_'.$this->dtable => $this->input->post('val'));
	    } else {
		$session = array('xfield_'.$this->dtable => '', 'xsearch_'.$this->dtable => '', 'sortBy_'.$this->dtable => '', 'sortDir_'.$this->dtable => '');
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
	    
	    $data['dt'] = $this->catalog->get_menu_roles($query);
	    $data['count'] = $this->catalog->get_menu_roles(array('is_count' => true, 'row' => true));
	    $data['offset'] = $this->offset;
	    $data['prefix'] = $this->dtable;
	    $data['showpage'] = ceil($data['count']->cc/$limit);
	    
	    if($this->input->post('val') > 0 OR isset($option['is_check']))
	    {
		$html = $this->load->view($this->config->item('base_theme').'/role/role_jquery', $data, true);
	    } else {
		$html = $this->load->view($this->config->item('base_theme').'/role/role', $data, true);
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
	    redirect('system/role');
	}
    }
    
    function search()
    {
	if($this->input->post('val') == true)
	{
	    $data['title'] = 'Roles';
	    
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
	    
	    $data['dt'] = $this->catalog->get_menu_roles($query['query']);
	    $data['count'] = $this->catalog->get_menu_roles($query['count']);
	    $data['offset'] = $this->offset;
	    $data['prefix'] = $this->dtable;
	    $data['showpage'] = ceil($data['count']->cc/$query['query']['limit']);
	    
	    $html = $this->load->view($this->config->item('base_theme').'/role/role_jquery', $data, true);
	    
	    header('Content-Type: application/json');
	    echo json_encode(array('vHtml' => $html,
				   'sortDir' => $this->session->userdata('sortDir_'.$this->dtable)));
	} else {
	    redirect('system/role');
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
	    $data['dt'] = $this->catalog->get_menu_roles($query['query']);
	    $data['count'] = $this->catalog->get_menu_roles($query['count']);
	    $data['offset'] = $query['query']['offset'];
	    
	    $html = $this->load->view($this->config->item('base_theme').'/role/role_table', $data, true);
	    
	    header('Content-Type: application/json');
	    echo json_encode(array('vHtml' => $html,
				    'sortDir' => $this->session->userdata('sortDir_'.$this->dtable)));
	} else {
	    redirect('system/role');
	}
    }
    
    function add()
    {
	if($this->roles == 'admin' OR $this->roles->menu_created == 1)
	{
	    $data['title'] = 'Roles';
	    $data['parent'] = $this->mparent;
	    $data['content'] = $this->config->item('base_theme').'/role/add_role';
	    
	    $data['dt'] = $this->catalog->get_menu(array('menu_parent' => 0, 'sortBy' => 'menu_order', 'sortDir' => 'asc'));
	    
	    if ($this->input->post('val') == true) {
		$this->load->view($this->config->item('base_theme').'/role/add_role', $data);
	    } else {
		$this->load->view($this->config->item('base_theme').'/template', $data);
	    }
	} else {
	    if ($this->input->post('val') == true) {
		$this->library->role_failed();
	    } else {
		redirect('system/role');
	    }
	}
    }

    function save()
    {
	if ($this->input->post('val') == true AND $this->roles == 'admin' OR $this->roles->menu_created == 1) {
	    
	    $dt = array('role_name' => $this->input->post('role_name'),
			'role_slug' => $this->library->seo_title($this->input->post('role_name')));
	    
	    $option = $this->action->insert(array('table' => $this->dtable, 'insert' => $dt));
	    if($option['state'] == 0)
	    {
		$this->validation->error_message($option);
		return false;
	    }
	    $idx = $this->db->insert_id();
	    
	    $option = $this->role_model->__menu_access($idx);
	    
	    $this->view(array('xcss' => $option['add_message']['xcss'], 'xmsg' => $option['message']));
	} else {
	    redirect('system/role');
	}
    }

    function edit($id = '')
    {
	if($this->roles == 'admin' OR $this->roles->menu_updated == 1)
	{
	    if($id == '')
	    {
		redirect('system/role');
	    } else {
		$data['title'] = 'Roles';
		$data['parent'] = $this->mparent;
		$data['content'] = $this->config->item('base_theme').'/role/edit_role';
		
		$data['dt1'] = $this->catalog->get_menu_roles(array('role_id' => $id, 'row' => true));
		$data['dt2'] = $this->catalog->get_menu(array('menu_parent' => 0, 'menu_access' => true, 'role_id' => $id,
							      'sortBy' => 'menu_order', 'sortDir' => 'asc'));
	     
		if ($this->input->post('val') == true) {
		    $this->load->view($this->config->item('base_theme').'/role/edit_role', $data);
		} else {
		    $this->load->view($this->config->item('base_theme').'/template', $data);
		}
	    }
	} else {
	    if ($this->input->post('val') == true) {
		$this->library->role_failed();
	    } else {
		redirect('system/role');
	    }
	}
    }
    
    function update()
    {
	if ($this->input->post('val') == true AND $this->roles == 'admin' OR $this->roles->menu_updated == 1) {
	    
	    $dt = array('role_id' => $this->input->post('idx'),
			'role_name' => $this->input->post('role_name'));
	    
	    $option = $this->action->update(array('table' => $this->dtable, 'update' => $dt,
						  'where' => array('role_id' => $this->input->post('idx'))));
	    if($option['state'] == 0)
	    {
		$this->validation->error_message($option);
		return false;
	    }
	    
	    $option = $this->role_model->__menu_access($this->input->post('idx'));
	    
	    $this->view(array('xcss' => $option['add_message']['xcss'], 'xmsg' => $option['message']));
	} else {
	    redirect('system/role');
	}
    }

    function delete($id = '', $multi = '')
    {
	if($this->roles == 'admin' OR $this->roles->menu_deleted == 1)
	{
	    if($id == '')
	    {
		redirect('system/role');
	    } else {
		if ($this->input->post('val') == true) {
		    $option = $this->role_model->__delete($id);
		    $this->view(array('is_check' => true, 'xcss' => $option['add_message']['xcss'], 'xmsg' => $option['message']));
		} else {
		    redirect('system/role');
		}
	    }
	} else {
	    if ($this->input->post('val') == true) {
		$this->library->role_failed();
	    } else {
		redirect('system/role');
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
			    $option = $this->role_model->__delete($split[$i]);
			}
		    } else {
			$this->library->role_failed();
		    }
		break;
	    }
	    
	    $this->view(array('is_check' => true, 'xcss' => $option['add_message']['xcss'], 'xmsg' => $option['message']));
	} else {
	    redirect('system/role');
	}
    }
    
}