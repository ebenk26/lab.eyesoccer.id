<?php
class User extends MX_Controller 
{
    var $roles = 'admin';
    var $mparent = 'System';
    var $offset = 0;
    var $limit = 10;
    var $dtable = 'es_users';
    
    function __construct()
    {
        parent::__construct();
	$this->load->model('user_model');
	
	if($this->session->userdata('login') != TRUE AND $this->session->userdata('user_uid') == '')
	{
	    redirect('login');
	}
	
	$raccess = $this->library->role_access('system/user');
	if(isset($raccess))
	{
	    $this->roles = $raccess;
	}
    }
    
    public function index()
    {
	$data['title'] = 'User Account';
	$data['parent'] = $this->mparent;
	$data['roles'] = $this->roles;
	$data['content'] = $this->config->item('base_theme').'/user/user';
	
	$session = array('xfield_'.$this->dtable => '', 'xsearch_'.$this->dtable => '', 'sortBy_'.$this->dtable => 'user_id', 'sortDir_'.$this->dtable => 'desc',
			 'multi_search_'.$this->dtable => '', 'multi_data_'.$this->dtable => '', 'voffset_'.$this->dtable => '', 'xoffset_'.$this->dtable => '');
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
	
	if($this->session->userdata('user_level') == 'admin')
	{
	    $query1 = $query;
	    $query2 = array('is_count' => true, 'row' => true);
	} else {
	    $query1 = array_merge($query, array('user_id' => $this->session->userdata('user_id')));
	    $query2 = array('is_count' => true, 'row' => true, 'user_id' => $this->session->userdata('user_id'));
	}
	
	$data['dt'] = $this->catalog->get_user($query1);
	$data['count'] = $this->catalog->get_user($query2);
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
	    $data['title'] = 'User Account';
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
				     'sortBy_'.$this->dtable => 'user_id', 'sortDir_'.$this->dtable => 'desc');
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
	    
	    // Sort By   
	    if($this->session->userdata('sortDir_'.$this->dtable) == 'asc' OR
	       $this->session->userdata('sortDir_'.$this->dtable) == 'desc')
	    {
		$query = array(
				$xfield		=> $xsearch,
				'sortBy' 	=> $this->session->userdata('sortBy_'.$this->dtable),
				'sortDir' 	=> $this->session->userdata('sortDir_'.$this->dtable),
				'offset' 	=> $this->offset,
				'limit' 	=> $limit
				);
	    } else {
		$query = array(
				$xfield		=> $xsearch,
				'offset' 	=> $this->offset,
				'limit' 	=> $limit
				);
	    }
	    
	    if($this->session->userdata('user_level') == 'admin')
	    {
		$query1 = $query;
		$query2 = array($xfield => $xsearch, 'is_count' => true, 'row' => true);
	    } else {
		$query1 = array_merge($query, array('user_id' => $this->session->userdata('user_id')));
		$query2 = array($xfield => $xsearch, 'is_count' => true, 'row' => true, 'user_id' => $this->session->userdata('user_id'));
	    }
	    
	    if($this->session->userdata('multi_search_'.$this->dtable) == true)
	    {
		$query1 = array_merge($query1, $this->session->userdata('multi_data_'.$this->dtable));
		$query2 = array_merge($query2, $this->session->userdata('multi_data_'.$this->dtable));
	    }
	    
	    $data['dt'] = $this->catalog->get_user($query1);
	    $data['count'] = $this->catalog->get_user($query2);
	    $data['limit'] = $limit;
	    $data['offset'] = $offset;
	    $data['prefix'] = $this->dtable;
	    $data['showpage'] = ceil($data['count']->cc/$limit);
	    
	    if($this->input->post('val') > 0 OR isset($option['is_check']))
	    {
		$html = $this->load->view($this->config->item('base_theme').'/user/user_jquery', $data, true);
	    } else {
		$html = $this->load->view($this->config->item('base_theme').'/user/user', $data, true);
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
	    redirect('system/user');
	}
    }
    
    function search()
    {
	if($this->input->post('val') == true)
	{
	    $data['title'] = 'User Account';
	    
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
	    
	    if($this->session->userdata('user_level') == 'admin')
	    {
		$query1 = $query['query'];
		$query2 = $query['count'];
	    } else {
		$query1 = array_merge($query['query'], array('user_id' => $this->session->userdata('user_id')));
		$query2 = array_merge($query['count'], array('user_id' => $this->session->userdata('user_id')));
	    }
	    
	    $data['dt'] = $this->catalog->get_user($query1);
	    $data['count'] = $this->catalog->get_user($query2);
	    $data['limit'] = $limit;
	    $data['offset'] = $this->offset;
	    $data['prefix'] = $this->dtable;
	    $data['showpage'] = ceil($data['count']->cc/$query['query']['limit']);
	    
	    if(count($split) > 1)
	    {
		$html = $this->load->view($this->config->item('base_theme').'/user/user_jquery', $data, true);
	    } else {
		$html = $this->load->view($this->config->item('base_theme').'/user/user', $data, true);
	    }
	    
	    header('Content-Type: application/json');
	    echo json_encode(array('vHtml' => $html,
				   'sortDir' => $this->session->userdata('sortDir_'.$this->dtable)));
	} else {
	    redirect('system/user');
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
	    
	    // Query Page
	    if($this->session->userdata('user_level') == 'admin')
	    {
		$query1 = $query['query'];
		$query2 = $query['count'];
	    } else {
		$query1 = array_merge($query['query'], array('user_id' => $this->session->userdata('user_id')));
		$query2 = array_merge($query['count'], array('user_id' => $this->session->userdata('user_id')));
	    }
	    
	    $data['dt'] = $this->catalog->get_user($query1);
	    $data['count'] = $this->catalog->get_user($query2);
	    $data['offset'] = $query['query']['offset'];
	    
	    $html = $this->load->view($this->config->item('base_theme').'/user/user_table', $data, true);
	    
	    header('Content-Type: application/json');
	    echo json_encode(array('vHtml' => $html,
				    'sortDir' => $this->session->userdata('sortDir_'.$this->dtable)));
	} else {
	    redirect('system/user');
	}
    }
    
    function add()
    {
	if($this->roles == 'admin' OR $this->roles->menu_created == 1)
	{
	    $data['title'] = 'User Account';
	    $data['parent'] = $this->mparent;
	    $data['content'] = $this->config->item('base_theme').'/user/add_user';
	 
	    if ($this->input->post('val') == true) {
		$this->load->view($this->config->item('base_theme').'/user/add_user', $data);
	    } else {
		$this->load->view($this->config->item('base_theme').'/template', $data);
	    }
	} else {
	    if ($this->input->post('val') == true) {
		$this->library->role_failed();
	    } else {
		redirect('system/user');
	    }
	}
    }

    function save()
    {
	if ($this->input->post('val') == true AND $this->roles == 'admin' OR $this->roles->menu_created == 1) {
	    
	    $this->user_model->__checkemail();
	    
	    $dt = array('user_name' => $this->input->post('user_name'),
			'user_pass' => md5(base64_encode($this->input->post('user_pass'))),
			'user_fname' => $this->input->post('user_fname'),
			'user_email' => $this->input->post('user_email'),
			'user_mobile' => $this->input->post('user_mobile'),
			'user_level' => $this->input->post('user_level'),
			'is_active' => $this->input->post('is_active'));
	    
	    $option = $this->action->insert(array('table' => $this->dtable, 'insert' => $dt));
	    if($option['state'] == 0)
	    {
		$this->validation->error_message($option);
		return false;
	    }
	    
	    $this->view(array('xcss' => $option['add_message']['xcss'], 'xmsg' => $option['message']));
	} else {
	    redirect('system/user');
	}
    }

    function edit($id = '')
    {
	if($this->roles == 'admin' OR $this->roles->menu_updated == 1)
	{
	    if($id == '')
	    {
		redirect('system/user');
	    } else {
		$data['title'] = 'User Account';
		$data['parent'] = $this->mparent;
		$data['content'] = $this->config->item('base_theme').'/user/edit_user';
		
		$data['dt1'] = $this->catalog->get_user(array('user_id' => $id, 'row' => true));
	     
		if ($this->input->post('val') == true) {
		    $this->load->view($this->config->item('base_theme').'/user/edit_user', $data);
		} else {
		    $this->load->view($this->config->item('base_theme').'/template', $data);
		}
	    }
	} else {
	    if ($this->input->post('val') == true) {
		$this->library->role_failed();
	    } else {
		redirect('system/user');
	    }
	}
    }
    
    function update()
    {
	if ($this->input->post('val') == true AND $this->roles == 'admin' OR $this->roles->menu_updated == 1) {
	    
	    $this->user_model->__checkemail();
	    
	    $dt = array('user_id' => $this->input->post('idx'),
			'user_name' => $this->input->post('user_name'),
			'user_fname' => $this->input->post('user_fname'),
			'user_email' => $this->input->post('user_email'),
			'user_mobile' => $this->input->post('user_mobile'),
			'user_level' => $this->input->post('user_level'),
			'is_active' => $this->input->post('is_active'));
	    
	    if($this->input->post('user_pass') != '')
	    {
		$dt = array_merge($dt, array('user_pass' => md5(base64_encode($this->input->post('user_pass')))));
	    }
	    
	    $option = $this->action->update(array('table' => $this->dtable,
						  'update' => $dt,
						  'where' => array('user_id' => $this->input->post('idx'))));
	    if($option['state'] == 0)
	    {
		$this->validation->error_message($option);
		return false;
	    }
	    
	    $this->view(array('xcss' => $option['add_message']['xcss'], 'xmsg' => $option['message']));
	} else {
	    redirect('system/user');
	}
    }

    function delete($id = '', $multi = '')
    {
	if($this->roles == 'admin' OR $this->roles->menu_deleted == 1)
	{
	    if($id == '')
	    {
		redirect('system/user');
	    } else {
		if ($this->input->post('val') == true) {
		    $option = $this->user_model->__delete($id);
		    $this->view(array('is_check' => true, 'xcss' => $option['add_message']['xcss'], 'xmsg' => $option['message']));
		} else {
		    redirect('system/user');
		}
	    }
	} else {
	    if ($this->input->post('val') == true) {
		$this->library->role_failed();
	    } else {
		redirect('system/user');
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
			    $option = $this->user_model->__delete($split[$i]);
			}
		    } else {
			$this->library->role_failed();
		    }
		break;
		
		case 2:
		    if($this->roles == 'admin' OR $this->roles->menu_updated == 1)
		    {
			for($i=0;$i<$count;$i++)
			{
			    $option = $this->user_model->__enable($split[$i]);
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
			    $option = $this->user_model->__disable($split[$i]);
			}
		    } else {
			$this->library->role_failed();
		    }
		break;
	    }
	    
	    $this->view(array('is_check' => true, 'xcss' => $option['add_message']['xcss'], 'xmsg' => $option['message']));
	} else {
	    redirect('system/user');
	}
    }
    
}